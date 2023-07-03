<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\ProductModel;
use App\Models\StockInModel;
use App\Models\StockOutModel;
use App\Models\SupplierModel;

date_default_timezone_set('Asia/Singapore');
class Inventory extends BaseController
{
    public function index()
    {
        if (!$this->session->has("user_id")) {

            return redirect()->to("login");
        }
        $productModel = new ProductModel();
        $supplierModel = new SupplierModel();
        $inventoryModel = new InventoryModel();

        $productModel->select('*');
        $productModel->where('isInventory', 0);
        $query = $productModel->get();
        $result = $query->getResult();


        $supplierModel->select('*');
        $supplierModel->where('isSupplierArchived', 0);
        $query = $supplierModel->get();
        $resultSupplier = $query->getResult();

        $results = $inventoryModel->getProductsWithInventoryAndProducts();
        $data["result"] = $results;


        $permissionChecker = new \App\Libraries\PermissionChecker();
        $data['permissionChecker'] = $permissionChecker;
        $data['product'] = $result;
        $data['supplier'] = $resultSupplier;
        $data['supplierStockIn'] = $resultSupplier;
        $data['pageTitle'] = 'Inventory';
        return view('inventory', $data);
    }

    public function checkIfWillExpire()
    {
        $productId = $this->request->getPost('productId');

        // Fetch the willExpire value from the database based on the $productId

        // Assuming you have a model called 'ProductModel'
        $productModel = new ProductModel();
        $model = $productModel->where('productId like BINARY', $productId)->first();



        $product = $model['willExpire'];

        $response['willExpire'] = $product;

        return $this->response->setJSON($response);
    }

    public function insertDataInventory()
    {
        $inventoryModel = new InventoryModel();
        $productId = $this->request->getPost('productId');
        $quantity = $this->request->getPost('quantity');
        $expirationDate = $this->request->getPost('expirationDate');
        $supplierId = $this->request->getPost('supplierId');

        $inventoryModel->transStart();

        try {
            $db = db_connect();
            $fields = $db->getFieldNames($inventoryModel->table);

            $data = [
                'productID' => $productId,
                'totalQuantity' => $quantity,
                'expirationDate' => $expirationDate ?? '',
            ];

            foreach ($data as $field => $value) {
                if (!in_array($field, $fields)) {
                    echo 'Transaction failed.';
                    $inventoryModel->transRollback();
                    return;
                }
            }

            $inserted = $inventoryModel->insert($data);
            if (!$inserted) {
                throw new \Exception('Failed to insert inventory data.');
            }


            $productModel = new ProductModel();
            $updated = $productModel->where('productId', $productId)->set(['isInventory' => 1])->update();
            if (!$updated) {
                throw new \Exception('Failed to update product data.');
            }

            $stockInModel = new StockInModel();
            $data2 = [
                'productId' => $productId,
                'numberOfStockIn' => $quantity,
                'stockInExpirationDate' => $expirationDate ?? '',
                'stockInDate' => date('Y-m-d H:i:s'),
                'supplierID' => $supplierId,
                'stockToBeMinus' => $quantity
            ];
            $inserted2 = $stockInModel->insert($data2);

            if (!$inserted2) {
                throw new \Exception('Failed to insert stock in data.');
            }


            $inventoryModel->transCommit();
            echo 'Transaction success.';
        } catch (\Exception $e) {
            log_message('error', 'Exception: ' . $e->getMessage());
            $inventoryModel->transRollback();
            echo 'Transaction failed.';
            return;
        }
    }

    public function viewStockIn()
    {
        $model = new ProductModel();
        $model->select('*');
        $query = $model->get();
        $result = $query->getResultArray();
        return json_encode($result);
    }

    public function stockIn()
    {
        $productId = $this->request->getPost('productId');
        $quantity = $this->request->getPost('quantity');
        $expirationDate = $this->request->getPost('expirationDate');
        $supplierId = $this->request->getPost('supplierId');
        $inventoryId = $this->request->getPost('inventoryId');
        $stockInModel = new StockInModel();

        $stockInModel->transStart();
        $data = [
            'productId' => $productId,
            'numberOfStockIn' => $quantity,
            'stockInExpirationDate' => $expirationDate ?? '',
            'stockInDate' => date('Y-m-d H:i:s'),
            'supplierID' => $supplierId,
            'stockToBeMinus' => $quantity
        ];
        $inserted = $stockInModel->insert($data);
        $stockInModel->transCommit();

        $inventoryModel = new InventoryModel();

        // Update totalQuantity in InventoryModel
        $currentQuantity = $inventoryModel->where('inventoryId', $inventoryId)->select('totalQuantity')->first();
        if ($currentQuantity) {
            $newQuantity = $currentQuantity['totalQuantity'] + $quantity;
            $updated = $inventoryModel->update($inventoryId, ['totalQuantity' => $newQuantity]);
            if (!$updated) {
                echo 'Failed to update inventory data.';
                return;
            }
        } else {
            echo 'Inventory record not found.';
            return;
        }

        echo 'Transaction success.';

        if (!$inserted) {
            echo 'Transaction failed.';
            $stockInModel->transRollback();
            return;
        }
    }


    public function checkIfStockIsSufficient()
    {
        if ($this->request->isAJAX()) {
            $txtQuantity = trim($this->request->getVar('txtProductQuantityStockOut'));
            $txtProductId = trim($this->request->getVar('txtProductIdStockOut'));

            $model = new InventoryModel();
            $result = $model->checkStockSufficiency($txtProductId, $txtQuantity);

            return $this->response->setJSON($result);
        }
    }

    public function stockOut()
    {
        $productId = $this->request->getPost('productId');
        $quantity = $this->request->getPost('quantity');
        $expirationDate = $this->request->getPost('expirationDate');
        $supplierId = $this->request->getPost('supplierId');
        $inventoryId = $this->request->getPost('inventoryId');
        $reason = $this->request->getPost('reason');
        $stockOutModel = new StockOutModel();
        $inventoryModel = new InventoryModel();

        try {
            $stockOutModel->transStart();

            $data = [
                'productIdentification' => $productId,
                'stockOutQuantity' => $quantity,
                'stockOutDate' => date('Y-m-d H:i:s'),
                'reason' => $reason
            ];

            $inserted = $stockOutModel->insert($data);

            if ($inserted) {
                $inventory = $inventoryModel->find($inventoryId);

                if ($reason === 'Damaged') {
                    $damaged = $inventory['damaged'] + $quantity;
                    $inventoryModel->update($inventoryId, ['damaged' => $damaged]);
                } elseif ($reason === 'Lost') {
                    $lost = $inventory['lost'] + $quantity;
                    $inventoryModel->update($inventoryId, ['lost' => $lost]);
                } elseif ($reason === 'Expired') {
                    $expired = $inventory['expired'] + $quantity;
                    $inventoryModel->update($inventoryId, ['expired' => $expired]);
                } elseif ($reason === 'Sold') {
                    $sold = $inventory['sold'] + $quantity;
                    $inventoryModel->update($inventoryId, ['sold' => $sold]);
                }
                $stockOutModel->transCommit();
                echo 'Transaction success.';
            } else {
                echo 'Transaction failed.';
                $stockOutModel->transRollback();
            }
        } catch (\Exception $e) {
            echo 'Transaction failed. Error: ' . $e->getMessage();
            $stockOutModel->transRollback();
        }
    }

    public function viewHistoryStockIn()
    {
        $productId = $this->request->getVar('productId');
        $inventoryModel = new InventoryModel();
        $resultStockIn = $inventoryModel->getProductsWithStockIn($productId);
        $resultStockOut = $inventoryModel->getProductsWithStockOut($productId);
    
        $data["resultStockIn"] = $resultStockIn;
        $data["resultStockOut"] = $resultStockOut;
    
        return $this->response->setJSON($data);
    }

    public function archiveAllInventory(){
        $model = new InventoryModel();
        $inventoryIds = $this->request->getPost('inventoryId');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($inventoryIds as $id) {
                $data = [
                    'isInventoryArchived' => 1
                ];
                $model->update($id, $data);
            }

            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }
    


}
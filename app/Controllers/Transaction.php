<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\ReceiptModel;
use App\Models\StockInModel;
use App\Models\StockOutModel;
use App\Models\TransactionHolderModel;

class Transaction extends BaseController
{
    public function index()
    {

        $reportsModel = new TransactionHolderModel();
        $resultsProduct = $reportsModel->getProductReports();
        $resultsReceipts = $reportsModel->getReceipts();

        $permissionChecker = new \App\Libraries\PermissionChecker();
        $data['permissionChecker'] = $permissionChecker;
        $data['pageTitle'] = 'Reports';
        $data['result'] = $resultsProduct;
        $data['resultReceipts'] = $resultsReceipts;

        return view('transaction', $data);
    }

    public function viewHistoryProduct()
    {
        $productId = $this->request->getVar('productId');
        $reportsModel = new TransactionHolderModel();

        $productHistory = $reportsModel->getProductReportHistory($productId);
        $data["reportsProduct"] = $productHistory;

        return $this->response->setJSON($data);
    }

    public function viewProductReceipt()
    {
        $reportsModel = new TransactionHolderModel();
        $productId = $this->request->getVar('productId');
        $transactionId = $this->request->getVar('transactionId');
        $productHistory = $reportsModel->getProductReceipts($transactionId);


        $viewReceipt = $reportsModel->outputReceipt();
        $data["receiptProduct"] = $productHistory;

        $data["viewReceipt"] = $viewReceipt;

        return $this->response->setJSON($data);
    }

    public function voidProduct()
    {
        $receiptId = $this->request->getVar('receiptId');
        $transactionId = $this->request->getVar('transactionId');
        $reportsModel = new TransactionHolderModel();
        $stockOutHolderIds = $reportsModel->getAllTransactioIdHolder($transactionId);
    
        $stockOutModel = new StockOutModel();
        $stockInModel = new StockInModel();
        $inventoryModel = new InventoryModel();
        $receiptModel = new ReceiptModel();
    
        try {
            foreach ($stockOutHolderIds as $stockOutHolderId) {
                $stockOutModel->where('stockOutId', $stockOutHolderId);
                $stockOut = $stockOutModel->get()->getRow();
        
               
                if ($stockOut) {
                    $stockOutQuantity = $stockOut->stockOutQuantity;
                    $deductedStockInId = $stockOut->deductedStockInId;
        
                    // Update StockInModel based on deductedStockInId
                    $stockInModel->where('stockId', $deductedStockInId);
                    $stockIn = $stockInModel->get()->getRow();
                    print_r($stockIn);
                    if ($stockIn) {
                        $currentQuantity = $stockIn->stockToBeMinus;
                        $updatedQuantity = $currentQuantity + $stockOutQuantity;
                        $productId = $stockIn->productId;
                        echo "hello";

                        echo $updatedQuantity;
                        $data = [
                            'stockToBeMinus' => $updatedQuantity,
                            'status' => 'In Stock'
                        ];
        
                        $stockInModel->update($deductedStockInId, $data);
        
                        // Insert into StockOutModel
                        $stockOutModel->insert([
                            'productIdentification' => $productId,
                            'stockOutQuantity' => $stockOutQuantity,
                            'stockOutDate' => date('Y-m-d H:i:s'),
                            'reason' => 'Returned',
                            'deductedStockInId' => $deductedStockInId
                        ]);
        
                        // Update InventoryModel
                        $inventoryModel->where('productID', $productId);
                        $inventoryStorage = $inventoryModel->get()->getRow();
        
                        if ($inventoryStorage) {
                            $inventoryId = $inventoryStorage->inventoryId;
                            $currentQuantityInStorage = $inventoryStorage->returned;
                            $updatedQuantityStorage = $stockOutQuantity + $currentQuantityInStorage;
        
                            $data2 = [
                                'returned' => $updatedQuantityStorage
                            ];
        
                            $inventoryModel->update($inventoryId, $data2);


                        } else {
                            throw new \Exception("Inventory not found for product with ID: $productId");
                        }
                    } else {
                        throw new \Exception("StockIn not found for deductedStockInId: $deductedStockInId");
                    }
                } else {
                    throw new \Exception("StockOut not found for stockOutId: $stockOutHolderId");
                }
            }
            $receiptModel->delete($receiptId);
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            error_log($e->getMessage());
            // You can return an error response or redirect to an error page
            // depending on your application's requirements
            return;
        }
        
    }
    

}
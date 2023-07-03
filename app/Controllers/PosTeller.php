<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\ProductModel;
use App\Models\ReceiptModel;
use App\Models\StockInModel;
use App\Models\StockOutModel;
use App\Models\TransactionHolderModel;

date_default_timezone_set('Asia/Singapore');
class PosTeller extends BaseController
{
    public function index()
    {

        $inventoryModel = new InventoryModel();
        $results = $inventoryModel->getProductsWithInventoryAndProducts();
        $data["result"] = $results;


        $transactionModel = new TransactionHolderModel();
        $transactionModel->select('*');
        $query = $transactionModel->get();
        $transactionResult = $query->getResult();
        $data["resultTransaction"] = $transactionResult;




        $permissionChecker = new \App\Libraries\PermissionChecker();
        $data['permissionChecker'] = $permissionChecker;
        $data['pageTitle'] = 'POS Teller';
        return view('pos-teller', $data);
    }

    public function checkIfStockIsSufficientTeller()
    {
        $inventoryModel = new InventoryModel();
        $txtQuantity = $this->request->getVar('quantity');
        $txtProductId = $this->request->getVar('productId');
        $totalStock = $this->request->getVar('totalStock');
        // $resultQuantity = $inventoryModel->getInventoryTotalStock($txtProductId);
        // $totalQuantity = $resultQuantity['totalStockIn'];
        $result = $inventoryModel->checkStockSufficiency($txtProductId, $txtQuantity);

        if ($result) {
            $transactionHolder = new TransactionHolderModel();

            $productsModel = new ProductModel();
            $productsModel->select('*');
            $result = $productsModel->where('productId', $txtProductId)->first();

            if ($result) {
                $price = $result['sellPrice'];
                $productName = $result['productName'];
                $totalPrice = $price * $txtQuantity;
                $transactionHolder = new TransactionHolderModel();
                $transactionHolder->transStart();

                $data = [
                    'productID' => $txtProductId,
                    'price' => $price,
                    'quantity' => $txtQuantity,
                    'total' => $totalPrice,
                    'productName' => $productName,
                    'totalStock' => $totalStock
                    // 'totalQuantity' => $totalQuantity
                ];
                $response = [
                    'success' => true,
                    'message' => 'Transaction success.',
                    'data' => $data
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Transaction failed.',
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Transaction failed.',
            ];
        }

        // Convert the response to JSON and send it back to the client
        header('Content-Type: application/json');
        echo json_encode($response);
        exit(); // Add this line to stop the execution after sending the response
    }

    public function createTheOrder()
    {
        $transactionHolder = new TransactionHolderModel();
        $rowDataArray = $this->request->getPost('rowDataArray');
        $transactionHolder->transStart();
        $payment = $this->request->getPost('payment');
        $change = $this->request->getPost('change');
        $discount = $this->request->getPost('txtDiscount');
        $totalPrice = $this->request->getPost('totalPrice');

        try {
            // Get the last ID number from the table
            $lastId = $transactionHolder->getLastId();

            $transactionError = false;
            $transactionHolder->transBegin();
            // Add 1 to the last ID to get the new ID
            $newId = $lastId + 1;

            $receiptModel = new ReceiptModel();

            $data2 = [
                'transactionId' => $newId,
                'payment' => $payment,
                'totalPrice' => $totalPrice,
                'discount' => $discount,
                'paymentChange' => $change,
                'dateOfTransaction' => date('Y-m-d H:i:s'),
                'paymentType' => 'Cash',
                'receiptCode' => ''
            ];
            $receiptModel->insert($data2);
            $receiptId = $receiptModel->insertID();
    
            // Update the productCode field
            $productCode = 'RCT-' . str_pad($receiptId, 5, '0', STR_PAD_LEFT);
            $receiptModel->update($receiptId, ['receiptCode' => $productCode]);


            foreach ($rowDataArray as $rowData) {
                // Extract the data from the rowData array
                $productId = $rowData['productId'];
                $productName = $rowData['productName'];
                $price = $rowData['price'];
                $quantity = $rowData['quantity'];
                $total = $rowData['total'];
                $totalStocks = $rowData['totalStock'];
                $results = $transactionHolder->getLastStockInDate($productId);

                if ($quantity > $totalStocks) {
                    $transactionError = true;
                    break; // Exit the loop if any quantity exceeds total stock
                }


                if ($results) {
                   
                    $resultStockIn = $transactionHolder->getLastStockInDate($productId);
                    $stockInModel = new StockInModel();

                    $stockId = $resultStockIn['stockId']; // Retrieve the stockId from the current stockIn record
                    $stockQuantity = $resultStockIn['numberOfStockIn'];

                    $stockInModel = new StockInModel();

                    $stockItems = $stockInModel->where('productId', $productId)
                        ->orderBy('stockInExpirationDate IS NULL OR stockInExpirationDate	 = 0', '', false)
                        ->orderBy('stockInExpirationDate', 'ASC')
                        ->orderBy('stockInDate', 'ASC')
                        ->findAll();


                    $remainingQuantity = $quantity;
                    $stockId = null;
                    $stockOutModel = new StockOutModel();
                    foreach ($stockItems as $index => $stockItem) {
                        $availableQuantity = $stockItem['stockToBeMinus'];


                        if ($remainingQuantity > 0 && $availableQuantity >= $remainingQuantity) {
                            // Stock out the remaining quantity
                            $stockItems[$index]['stockToBeMinus'] -= $remainingQuantity;
                            $stockId = $stockItems[$index]['stockId'];
                            $availableQuantity = $remainingQuantity;
                            $remainingQuantity = 0;
                        } elseif ($remainingQuantity > 0) {
                            // Stock out the available quantity
                            $stockItems[$index]['stockToBeMinus'] = 0;
                            $stockItems[$index]['status'] = 'Out of Stock';
                            $remainingQuantity -= $availableQuantity;
                        }

                        // Save the updated stock item
                        $stockInModel->save($stockItems[$index]);

                        if ($availableQuantity > 0) {
                            // Mark the item as stock-out and insert a stock-out record
                            $stockOutModel->insert([
                                'productIdentification' => $productId,
                                'stockOutQuantity' => $availableQuantity,
                                'stockOutDate' => date('Y-m-d H:i:s'),
                                'reason' => 'Sold',
                                'deductedStockInId' => $stockItem['stockId'],
                            ]);
                            
                            $stockIdHolder = $stockOutModel->insertID();


                            $data = [
                                'transactionHolderId' => $newId,
                                'productID' => $productId,
                                'price' => $price,
                                'quantity' => $quantity,
                                'total' => $total,
                                'productName' => $productName,
                                'dateOfTransaction' => date('Y-m-d H:i:s'),
                                'stockOutIdHolder'=> $stockIdHolder
                            ];
        
                            $transactionHolder->insert($data);
                        }

                        if ($remainingQuantity == 0) {
                            break;
                        }
                    }
                    if($remainingQuantity == 0){

                        $newQuantity = $rowData['quantity'];
                        $inventoryModel = new InventoryModel();
                        $resultFound = $inventoryModel->where('productID', $productId)->first();
                        $resultTotal = $resultFound['sold'];
                        $inventoryId = $resultFound['inventoryId'];
                        $quantityFinal = $newQuantity + $resultTotal;
                        $dataUpdate = [
                            'sold' => $quantityFinal
                        ];
                        $inserted = $inventoryModel->update($inventoryId, $dataUpdate);
    
                        if ($inserted) {
                            $transactionHolder->transCommit();
                        } else {
                            $transactionHolder->transRollback();
                            return 'Transaction Error';
                        }
                    }

                    // Now you can use the $stockInId variable after the loop
                    // For example, you can store it in a separate variable if needed
                    // $deductedStockInId = $stockInId;

                

                } else {
                    $transactionError = true;
                    break; // Exit the loop if stock not found
                }


            }


            if ($transactionError) {
                $transactionHolder->transRollback();
                return 'Transaction Error: Quantity exceeds total stock';
            } else {
                $transactionHolder->transCommit();
            }


        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $transactionHolder->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }

}
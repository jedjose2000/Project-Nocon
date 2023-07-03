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

    // public function checkIfStockIsSufficientTeller()
    // {

    //     $inventoryModel = new InventoryModel();
    //     $txtQuantity = $this->request->getVar('quantity');
    //     $txtProductId = $this->request->getVar('productId');
    //     $result = $inventoryModel->checkStockSufficiency($txtProductId, $txtQuantity);

    //     if ($result) {
    //         $transactionHolder = new TransactionHolderModel();

    //         $productsModel = new ProductModel();
    //         $productsModel->select('*');
    //         $result = $productsModel->where('productId', $txtProductId)->first();

    //         if ($result) {
    //             $price = $result['sellPrice'];
    //             $productName = $result['productName'];
    //             $totalPrice = $price * $txtQuantity;
    //             $transactionHolder = new TransactionHolderModel();
    //             $transactionHolder->transStart();

    //             $data = [
    //                 'productID' => $txtProductId,
    //                 'price' => $price,
    //                 'quantity' => $txtQuantity,
    //                 'total' => $totalPrice,
    //                 'productName' => $productName
    //             ];
    //             $inserted = $transactionHolder->insert($data);
    //             if ($inserted === false) {
    //                 echo 'Transaction failed.';
    //                 $transactionHolder->transRollback();
    //             } else {
    //                 echo 'Transaction success.';
    //                 $transactionHolder->transCommit();
    //             }
    //         } else {
    //             echo 'Transaction failed.';
    //         }
    //     } else {
    //         echo 'Transaction failed.';
    //     }
    // }

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
                'paymentChange'=> $change,
                'dateOfTransaction' => date('Y-m-d H:i:s')
            ];
            $receiptModel->insert($data2);


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
                    $data = [
                        'transactionHolderId' => $newId,
                        'productID' => $productId,
                        'price' => $price,
                        'quantity' => $quantity,
                        'total' => $total,
                        'productName' => $productName,
                        'dateOfTransaction' => date('Y-m-d') // Set the current date as the date of transaction
                    ];
                    // ...



                    $transactionHolder->insert($data);
                    $transactionId = $transactionHolder->insertID();
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

                    foreach ($stockItems as $stockItem) {
                        if ($quantity > 0) {
                            $availableQuantity = $stockItem['stockToBeMinus'];

                            if ($availableQuantity >= $quantity) {
                                // Stock out the full quantity
                                $stockItem['stockToBeMinus'] -= $quantity;
                                $quantity = 0;
                            } else {
                                // Stock out the available quantity and continue
                                $quantity -= $availableQuantity;
                                $stockItem['stockToBeMinus'] = 0;
                            }

                            // Mark the item as stock-out if the quantity is zero
                            if ($stockItem['stockToBeMinus'] == 0) {
                                $stockItem['status'] = 'stock-out';
                            }

                            // Save the updated stock item
                            $stockInModel->save($stockItem);
                        } else {
                            break; // Exit the loop if the required quantity is stocked out
                        }

                        if ($quantity > 0 && $stockItem['stockToBeMinus'] == 0) {
                            // Deduct remaining quantity from the next stock-in row
                            continue;
                        } else {
                            break;
                        }
                    }

                    $newQuantity = $rowData['quantity'];
                    $inventoryModel = new InventoryModel();
                    $resultFound = $inventoryModel->where('productID', $productId)->first();
                    $resultTotal = $resultFound['sold'];
                    $inventoryId = $resultFound['inventoryId'];
                    $quantityFinal = $newQuantity + $resultTotal;
                    $dataUpdate = [
                        'sold' => $quantityFinal
                    ];
                    $inventoryModel->update($inventoryId, $dataUpdate);

                    $stockOutModel = new StockOutModel();

                    $data = [
                        'productIdentification' => $productId,
                        'stockOutQuantity' => $newQuantity,
                        'stockOutDate' => date('Y-m-d H:i:s'),
                        'reason' => 'Sold'
                    ];
                    $inserted = $stockOutModel->insert($data);



                    // $receiptModel = new ReceiptModel();

                    // $data2 = [
                    //     'transactionId' => $transactionId,
                    //     'payment' => $newQuantity,
                    //     'totalPrice' => $totalPrice,
                    //     'discount' => $discount,
                    //     'dateOfTransaction' => date('Y-m-d H:i:s')
                    // ];
                    // $receiptModel->insert($data2);

                    if ($inserted) {
                        $transactionHolder->transCommit();
                    } else {
                        $transactionHolder->transRollback();
                        return 'Transaction Error';
                    }
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


    //     public function createTheOrder()
//     {
//         $rowDataArray = $this->request->getPost('rowDataArray');

    //         $transactionHolder = new TransactionHolderModel();
//         foreach ($rowDataArray as $rowData) {
//             // Extract the data from the rowData array
//             $productId = $rowData['productId'];
//             $productName = $rowData['productName'];
//             $price = $rowData['price'];
//             $quantity = $rowData['quantity'];
//             $total = $rowData['total'];
//             $results = $transactionHolder->getLastStockInDate($productId);




    //             // $resultStockIn = $transactionHolder->getLastStockInDate($productId);
//             $stockInModel = new StockInModel();

    //             $stockItems = $stockInModel->where('productId', $productId)
//             ->orderBy('stockInExpirationDate IS NULL OR stockInExpirationDate	 = 0', '', false)
//             ->orderBy('stockInExpirationDate', 'ASC')
//             ->orderBy('stockInDate', 'ASC')
//             ->findAll();



    //             // $stockId = $resultStockIn['stockId']; // Retrieve the stockId from the current stockIn record
//             // $stockQuantity = $resultStockIn['numberOfStockIn'];


    //             // Retrieve stock items for the specific item in FIFO order

    //             foreach ($stockItems as $stockItem) {
//                 if ($quantity > 0) {
//                     $availableQuantity = $stockItem['numberOfStockIn'];

    //                     if ($availableQuantity >= $quantity) {
//                         // Stock out the full quantity
//                         $stockItem['numberOfStockIn'] -= $quantity;
//                         $quantity = 0;
//                     } else {
//                         // Stock out the available quantity and continue
//                         $quantity -= $availableQuantity;
//                         $stockItem['numberOfStockIn'] = 0;
//                     }

    //                     // Mark the item as stock-out if the quantity is zero
//                     if ($stockItem['numberOfStockIn'] == 0) {
//                         $stockItem['status'] = 'stock-out';
//                     }

    //                     // Save the updated stock item
//                     $stockInModel->save($stockItem);
//                 } else {
//                     break; // Exit the loop if the required quantity is stocked out
//                 }

    //                 if ($quantity > 0 && $stockItem['numberOfStockIn'] == 0) {
//                     // Deduct remaining quantity from the next stock-in row
//                     continue;
//                 } else {
//                     break;
//                 }
//             }
//         }
//     }
}
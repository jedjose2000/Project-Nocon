<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\ProductModel;
use App\Models\StockInModel;
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

    // public function createTheOrder()
    // {
    //     $transactionHolder = new TransactionHolderModel();
    //     $rowDataArray = $this->request->getPost('rowDataArray');
    //     $transactionHolder->transStart();

    //     try {
    //         // Get the last ID number from the table
    //         $lastId = $transactionHolder->getLastId();

    //         // Add 1 to the last ID to get the new ID
    //         $newId = $lastId + 1;

    //         foreach ($rowDataArray as $rowData) {
    //             // Extract the data from the rowData array
    //             $productId = $rowData['productId'];
    //             $productName = $rowData['productName'];
    //             $price = $rowData['price'];
    //             $quantity = $rowData['quantity'];
    //             $total = $rowData['total'];
    //             $results = $transactionHolder->getLastStockInDate($productId);

    //             if ($results) {
    //                 $data = [
    //                     'transactionHolderId' => $newId,
    //                     'productID' => $productId,
    //                     'price' => $price,
    //                     'quantity' => $quantity,
    //                     'total' => $total,
    //                     'productName' => $productName,
    //                     'dateOfTransaction' => date('Y-m-d') // Set the current date as the date of transaction
    //                 ];
    //                 // ...

    //                 $transactionHolder->insert($data);
    //                 $transactionId = $transactionHolder->insertID();
    //                 $resultStockIn = $transactionHolder->getLastStockInDate($productId);
    //                 $stockInModel = new StockInModel();

    //                 $stockId = $resultStockIn['stockId']; // Retrieve the stockId from the current stockIn record
    //                 $stockQuantity = $resultStockIn['numberOfStockIn'];

    //                 echo $stockId;
    //                 echo $stockQuantity;
    //                 echo $quantity;
    //                 for ($i = 0; $i < $quantity; $i++) {
    //                     // Fetch all the stock records with non-zero stock quantity
    //                     $existingStocks = $stockInModel->where('stockId', $stockId)
    //                         ->where('numberOfStockIn !=', 0)
    //                         ->orderBy('stockInExpirationDate', 'DESC')
    //                         ->orderBy('stockInDate', 'DESC')
    //                         ->findAll();

    //                     // Check if there are enough stock records to fulfill the quantity
    //                     if (count($existingStocks) >= $quantity) {
    //                         foreach ($existingStocks as $existingStock) {
    //                             // Calculate the updated stock quantity
    //                             $stockQuantity--;

    //                             // Update the stock quantity using the StockInModel
    //                             $stockInModel->update($existingStock['stockId'], ['numberOfStockIn' => $stockQuantity]);
    //                         }
    //                     } else {
    //                         // Handle the case where the stock quantity is insufficient
    //                         // You can throw an error or handle it according to your requirements
    //                     }
    //                 }

    //                 $transactionHolder->transCommit();

    //                 echo "Order created successfully";

    //                 // ...


    //                 // $resultFoundStockIn = $stockInModel->where('productId', $productId)->first();
    //                 // $totalStockInStockIn = $resultFoundStockIn['numberOfStockIn'];
    //                 // $inventoryId = $resultFoundStockIn['inventoryId'];



    //                 // $inventoryModel = new InventoryModel();
    //                 // $resultFound = $inventoryModel->where('productID', $productId)->first();
    //                 // $resultTotal = $resultFound['sold'];
    //                 // $inventoryId = $resultFound['inventoryId'];
    //                 // $quantityFinal = $quantity + $resultTotal;
    //                 // $dataUpdate = [
    //                 //     'sold' => $quantityFinal
    //                 // ];
    //                 // print_r($resultFound);
    //                 // $updated = $inventoryModel->update($inventoryId, $dataUpdate);

    //                 // $stockInModel = new StockInModel();


    //             } else {

    //             }

    //         }


    //     } catch (\Exception $e) {
    //         // Roll back the transaction if an error occurs
    //         $transactionHolder->transRollback();

    //         echo "Error: " . $e->getMessage();
    //     }
    // }


    public function createTheOrder()
    {
        $rowDataArray = $this->request->getPost('rowDataArray');

        $transactionHolder = new TransactionHolderModel();
        foreach ($rowDataArray as $rowData) {
            // Extract the data from the rowData array
            $productId = $rowData['productId'];
            $productName = $rowData['productName'];
            $price = $rowData['price'];
            $quantity = $rowData['quantity'];
            $total = $rowData['total'];
            $results = $transactionHolder->getLastStockInDate($productId);
        }

        $resultStockIn = $transactionHolder->getLastStockInDate($productId);
        $stockInModel = new StockInModel();

        $stockId = $resultStockIn['stockId']; // Retrieve the stockId from the current stockIn record
        $stockQuantity = $resultStockIn['numberOfStockIn'];

        echo $stockId;
        echo $stockQuantity;
        echo $quantity;
        for ($i = 0; $i < $quantity; $i++) {
            // Fetch all the stock records with non-zero stock quantity
            $existingStocks = $stockInModel->where('stockId', $stockId)
                ->where('numberOfStockIn !=', 0)
                ->orderBy('stockInExpirationDate', 'DESC')
                ->orderBy('stockInDate', 'DESC')
                ->findAll();

            // Check if there are enough stock records to fulfill the quantity
            if (count($existingStocks) >= $quantity) {
                foreach ($existingStocks as $existingStock) {
                    // Calculate the updated stock quantity
                    $stockQuantity--;

                    // Update the stock quantity using the StockInModel
                    $stockInModel->update($existingStock['stockId'], ['numberOfStockIn' => $stockQuantity]);
                }
            } else {
                // Handle the case where the stock quantity is insufficient
                // You can throw an error or handle it according to your requirements
            }
        }

    }



}
<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\ProductModel;
use App\Models\TransactionHolderModel;

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
    
}
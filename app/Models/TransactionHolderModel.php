<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionHolderModel extends Model
{
    protected $table = 'tbltransactionholder';
    protected $primaryKey = 'orderId';
    protected $allowedFields = ['orderId', 'productID', 'price', 'quantity', 'total', 'productName', 'dateOfTransaction', 'transactionHolderId'];


    public function getLastId()
    {
        $result = $this->selectMax('transactionHolderId')->first();

        if ($result) {
            return $result['transactionHolderId'];
        }
        return 0; // Return 0 if no records exist
    }
    
    public function getLastStockInDate($productId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblstockin');
        $builder->select('stockInDate, numberOfStockIn,stockId')
            ->where('productId', $productId)
            ->where('numberOfStockIn!=', 0)
            ->orderBy('stockInExpirationDate', 'DESC')
            ->orderBy('stockInDate', 'DESC')
            ->limit(1);
        $query = $builder->get();
        $result = $query->getRow();

        if ($result) {
            return array(
                'stockId' => $result->stockId,
                'numberOfStockIn' => $result->numberOfStockIn
            );
        } else {
            $db = \Config\Database::connect();
            $builder = $db->table('tblstockin');
            $builder->select('*')
                ->where('productId', $productId)
                ->where('numberOfStockIn!=', 0)
                ->orderBy('stockInDate', 'DESC')
                ->limit(1);
            $query = $builder->get();
            $result = $query->getRow();
            if ($result) {
                return array(
                    'stockId' => $result->stockId,
                    'numberOfStockIn' => $result->numberOfStockIn
                );
            } else {
                return array(
                    'stockInDate' => null,
                    'numberOfStockIn' => 0
                );
            }
        }
    }




    public function getStockInInventory($productId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblstockin');
        $builder->select('stockInDate, numberOfStockIn')
            ->where('productId', $productId)
            ->orderBy('stockInExpirationDate', 'DESC')
            ->orderBy('stockInDate', 'DESC')
            ->limit(1);
        $query = $builder->get();
        $result = $query->getRow();

        if ($result) {
            return $result->stockId;
        } else {
            $db = \Config\Database::connect();
            $builder = $db->table('tblstockin');
            $builder->select('*')
                ->where('productId', $productId)
                ->orderBy('stockInDate', 'DESC')
                ->limit(1);
            $query = $builder->get();
            $result = $query->getRow();
            if ($result) {
                return $result->stockId;
            } else {
                return 0;
            }
        }
    }

    public function updateStockQuantity($productId, $quantity)
    {
        $transactionHolder = new TransactionHolderModel();

        // Get the stock-in inventory for the product
        $resultStockIn = $transactionHolder->getStockInInventory($productId);

        $stockInModel = new StockInModel();
        $quantityRemaining = $quantity;

        foreach ($resultStockIn as $stockIn) {
            $stockId = $stockIn->stockId;
            $stockQuantity = $stockIn->numberOfStockIn;

            if ($stockQuantity > 0) {
                // Calculate the quantity to deduct from the current stock
                $deductQuantity = min($quantityRemaining, $stockQuantity);

                // Calculate the updated stock quantity
                $stockQuantityFinal = $stockQuantity - $deductQuantity;

                // Update the stock quantity using the StockInModel
                $stockInModel->update($stockId, ['numberOfStockIn' => $stockQuantityFinal]);

                // Deduct the quantity from the remaining required quantity
                $quantityRemaining -= $deductQuantity;

                // Break the loop if the required quantity has been fully deducted
                if ($quantityRemaining <= 0) {
                    break;
                }
            }
        }
    }







    // public function getInventory($productId)
    // {
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('tblinventory');
    //     $builder->select('*');
    //     $builder->where('productID', $productId);
    //     $query = $builder->get();
    //     $result = $query->getRow();

    //     if ($result) {
    //         return $result->sold;
    //     } else {
    //         return 0;
    //     }
    // }

    public function updateInventory($productId, $newResult)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblinventory');
        $builder->set('sold', $newResult);
        $builder->where('productID', $productId);
        $builder->update();
    }







}
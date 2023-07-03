<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionHolderModel extends Model
{
    protected $table = 'tbltransactionholder';
    protected $primaryKey = 'orderId';
    protected $allowedFields = ['orderId', 'productID', 'price', 'quantity', 'total', 'productName', 'dateOfTransaction', 'transactionHolderId', 'stockOutIdHolder'];

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


    public function updateInventory($productId, $newResult)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblinventory');
        $builder->set('sold', $newResult);
        $builder->where('productID', $productId);
        $builder->update();
    }



    public function getProductReports()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblproducts');
        $builder->select('*, tblproducts.productName, SUM(tbltransactionholder.total) AS totalPrice, SUM(tbltransactionholder.quantity) AS totalQuantity, MAX(tbltransactionholder.dateOfTransaction) AS highestSalesDate');
        $builder->join('tbltransactionholder', 'tbltransactionholder.productID = tblproducts.productId');
        $builder->groupBy('tblproducts.productId, tblproducts.productName');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }

    public function getProductReportHistory($productId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbltransactionholder');
        $builder->select('*');
        $builder->where('productId', $productId);
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }

    public function getReceipts()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblreceipt');
        $builder->select('*');
        $builder->join('tbltransactionholder', 'tbltransactionholder.transactionHolderId = tblreceipt.transactionId ');
        $builder->groupBy('tbltransactionholder.transactionHolderId, tblreceipt.transactionId');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }


    public function getProductReceipts($receiptId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblreceipt');
        $builder->select('*');
        $builder->join('tbltransactionholder', 'tbltransactionholder.transactionHolderId = tblreceipt.transactionId ');
        $builder->join('tblproducts', 'tblproducts.productId = tbltransactionholder.productID ');
        $builder->where('tbltransactionholder.transactionHolderId', $receiptId);
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }

    public function outputReceipt()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblreceipt');
        $builder->select('*');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }


    public function getAllTransactioIdHolder($transactionId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbltransactionholder');
        $builder->select('*');
        $builder->where('transactionHolderId', $transactionId);
        $query = $builder->get();
        $result = $query->getResult();
    
        $stockOutIdHolders = []; // Create an empty array to store the stockOutIdHolders
        $stockOutQuantity = [];
        foreach ($result as $row) {
            $stockOutIdHolders[] = $row->stockOutIdHolder; // Add stockOutIdHolder value to the array
            $stockOutQuantity[] = $row->quantity; // Add stockOutIdHolder value to the array
        }


        return $stockOutIdHolders;
    }
    








}
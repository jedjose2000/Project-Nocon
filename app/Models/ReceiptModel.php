<?php

namespace App\Models;

use CodeIgniter\Model;

class ReceiptModel extends Model
{
    protected $table = 'tblreceipt';
    protected $primaryKey = 'receiptId';
    protected $allowedFields = ['receiptId', 'transactionId', 'payment', 'totalPrice', 'discount', 'dateOfTransaction', 'paymentChange', 'receiptCode', 'paymentType'];


    public function getOverallSales()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblreceipt');
        $builder->selectSum('totalPrice');
        $query = $builder->get();
        $result = $query->getRow();
        return $result;
    }


    public function getOverallSalesGraph()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblreceipt');
        $builder->select("DATE_FORMAT(dateOfTransaction, '%Y-%m-%d') as transactionDate, COUNT(*) as transactionCount");
        $builder->groupBy("transactionDate");
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }


}
<?php

namespace App\Models;

use CodeIgniter\Model;

class ReceiptModel extends Model
{
    protected $table = 'tblreceipt';
    protected $primaryKey = 'receiptId';
    protected $allowedFields = ['receiptId', 'transactionId', 'payment','totalPrice','discount','dateOfTransaction','paymentChange'];
}
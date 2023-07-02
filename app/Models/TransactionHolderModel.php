<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionHolderModel extends Model
{
    protected $table = 'tbltransactionholder';
    protected $primaryKey = 'orderId';
    protected $allowedFields = ['orderId', 'productID', 'price','quantity','total','productName'];
}
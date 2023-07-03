<?php

namespace App\Models;

use CodeIgniter\Model;

class StockInModel extends Model
{
    protected $table = 'tblstockIn';
    protected $primaryKey = 'stockId';
    protected $allowedFields = ['stockId', 'productId', 'numberOfStockIn', 'stockInDate', 'stockInExpirationDate','supplierID','stockToBeMinus'];

    
}



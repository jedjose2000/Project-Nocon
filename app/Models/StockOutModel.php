<?php

namespace App\Models;

use CodeIgniter\Model;

class StockOutModel extends Model
{
    protected $table = 'tblstockout';
    protected $primaryKey = 'stockOutId ';
    protected $allowedFields = ['stockOutId ', 'stockOutQuantity', 'reason', 'stockOutDate','productIdentification'];

}
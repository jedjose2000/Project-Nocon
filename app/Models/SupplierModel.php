<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = 'tblsupplier';
    protected $primaryKey = 'supplierId';
    protected $allowedFields = ['supplierId', 'supplierName', 'phoneNumber','emailAddress','isSupplierArchived'];
}
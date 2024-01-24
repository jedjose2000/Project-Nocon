<?php

namespace App\Models;

use CodeIgniter\Model;

class Inventory extends Model
{
    protected $table = 'tblcategory';
    protected $primaryKey = 'categoryId';
    protected $allowedFields = ['categoryName', 'categoryDescription', 'categoryId','isCategoryArchived'];
}
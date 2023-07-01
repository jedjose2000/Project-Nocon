<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'tblproducts';
    protected $primaryKey = 'productID';
    protected $allowedFields = ['productID','isInventory', 'productName', 'productBrand', 'categoryID', 'supplierID', 'productDescription', 'unit', 'willExpire', 'buyPrice', 'sellPrice', 'clq','isProductArchived','expirationDate','productCode'];

    public function getProductsWithSupplierAndCategory()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblproducts');
        $builder->select('*');
        $builder->join('tblcategory', 'tblcategory.categoryId = tblproducts.categoryID');
        $builder->where('tblproducts.isProductArchived', 0);
        $query = $builder->get();
        $result = $query->getResult();
    
        return $result;
    }

}
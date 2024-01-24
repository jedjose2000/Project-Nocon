<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'tblproducts';
    protected $primaryKey = 'productID';
    protected $allowedFields = ['productID', 'isInventory', 'productName', 'productBrand', 'categoryID', 'supplierID', 'productDescription', 'unit', 'willExpire', 'buyPrice', 'sellPrice', 'clq', 'isProductArchived', 'expirationDate', 'productCode', 'totalQuantity'];

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
    
    public function getProductsNearCriticalLevel()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblproducts');
        $builder->selectCount('tblproducts.productId', 'totalRows');
        $builder->join('tblinventory', 'tblinventory.productID = tblproducts.productId');
        $builder->where('(tblinventory.totalQuantity - tblinventory.sold - tblinventory.damaged - tblinventory.lost - tblinventory.expired + tblinventory.returned) <= tblproducts.clq');
        $query = $builder->get();
        $result = $query->getRow();
        return $result->totalRows;
    }
     
    public function getTotalStockOnHand()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblinventory');
        $builder->selectSum('(totalQuantity - sold - damaged - lost - expired + returned)', 'totalStockIn');
        $query = $builder->get();
        $result = $query->getRow();
        return $result->totalStockIn;
    }
    

    public function getProductsWithSupplierAndCategoryRestore()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblproducts');
        $builder->select('*');
        $builder->join('tblcategory', 'tblcategory.categoryId = tblproducts.categoryID');
        $builder->where('tblproducts.isProductArchived', 1);
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
    
    
    
    



}
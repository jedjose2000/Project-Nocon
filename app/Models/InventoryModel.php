<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'tblinventory';
    protected $primaryKey = 'inventoryId';
    protected $allowedFields = ['inventoryId', 'productID', 'supplierID', 'totalQuantity', 'damaged', 'lost', 'expired', 'sold', 'available', 'expirationDate', 'isInventoryArchived', 'returned'];

    public function getProductsWithInventoryAndProducts()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblproducts');
        $builder->select('tblproducts.*, tblinventory.*,
        (tblinventory.totalQuantity - tblinventory.sold - tblinventory.damaged - tblinventory.lost - tblinventory.expired + tblinventory.returned) AS totalStockIn');
        $builder->join('tblinventory', 'tblinventory.productID = tblproducts.productId');
        $builder->where('tblproducts.isProductArchived', 0);
        $builder->where('tblinventory.isInventoryArchived', 0);
        $builder->groupBy('tblproducts.productId');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }

    public function getProductsWithInventoryAndProductsArchived()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblproducts');
        $builder->select('tblproducts.*, tblinventory.*,
        (tblinventory.totalQuantity - tblinventory.sold - tblinventory.damaged - tblinventory.lost - tblinventory.expired + tblinventory.returned) AS totalStockIn');
        $builder->join('tblinventory', 'tblinventory.productID = tblproducts.productId');
        $builder->where('tblproducts.isProductArchived', 0);
        $builder->where('tblinventory.isInventoryArchived', 1);
        $builder->groupBy('tblproducts.productId');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }



    public function getProductsWithStockIn($productId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblstockin');
        $builder->select('*');
        $builder->where('productId', $productId);
        $builder->join('tblsupplier', 'tblsupplier.supplierId = tblstockin.supplierID');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }


    public function getProductsWithStockOut($productId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblstockout');
        $builder->where('productIdentification', $productId);
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }


    public function checkStockSufficiency($productId, $quantity)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblproducts');
        $builder->select('tblproducts.productId, (tblinventory.totalQuantity - tblinventory.sold - tblinventory.damaged - tblinventory.lost - tblinventory.expired) AS totalStockIn');
        $builder->join('tblstockin', 'tblstockin.productId = tblproducts.productId');
        $builder->join('tblinventory', 'tblinventory.productID = tblproducts.productId');
        $builder->where('tblproducts.productId', $productId);
        $builder->groupBy('tblproducts.productId');
        $query = $builder->get();
        $result = $query->getRow();

        if ($result && $result->totalStockIn < $quantity) {
            return false;
        } else {
            return true;
        }
    }


    public function getInventoryTotalStock($productId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblinventory');
        $builder->select('*, (tblinventory.totalQuantity - tblinventory.sold - tblinventory.damaged - tblinventory.lost - tblinventory.expired) AS totalStockIn');
        $builder->where('tblinventory.productID', $productId);
        $query = $builder->get();
        $result = $query->getRow();
        return $result;
    }



}
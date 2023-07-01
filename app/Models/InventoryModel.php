<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'tblinventory';
    protected $primaryKey = 'inventoryId';
    protected $allowedFields = ['inventoryId', 'productID', 'supplierID', 'totalQuantity', 'damaged', 'lost', 'expired', 'sold', 'available', 'expirationDate'];

    public function getProductsWithInventoryAndProducts()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblproducts');
        $builder->select('tblproducts.*, tblinventory.*,
                         (tblinventory.totalQuantity - tblinventory.sold - tblinventory.damaged - tblinventory.lost - tblinventory.expired) AS totalStockIn');
        $builder->join('tblinventory', 'tblinventory.productID = tblproducts.productId');
        $builder->where('tblproducts.isProductArchived', 0);
        $builder->groupBy('tblproducts.productId');
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


}
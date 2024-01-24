<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\InventoryModel;
use App\Models\ProductModel;
use App\Models\ReceiptModel;
use App\Models\SupplierModel;

class Archive extends BaseController
{
    public function index()
    {
        if (!$this->session->has("user_id")) {
            return redirect()->to("login");
        }
        $categoryModel = new CategoryModel();
        $categoryModel->select('*');
        $categoryModel->where('isCategoryArchived', 1);
        $query = $categoryModel->get();
        $result = $query->getResult();


        $supplierModel = new SupplierModel();
        $supplierModel->select('*');
        $supplierModel->where('isSupplierArchived', 1);
        $query = $supplierModel->get();
        $resultSupplier = $query->getResult();

        $productModel = new ProductModel();
        $resultProducts = $productModel->getProductsWithSupplierAndCategoryRestore();
        $categoryModel->select('*');
        $categoryModel->where('isCategoryArchived', 0);
        $query = $categoryModel->get();
        $resultViewCategory = $query->getResult();


        $supplierModel->select('*');
        $supplierModel->where('isSupplierArchived', 0);
        $query = $supplierModel->get();
        $resultSupplier2 = $query->getResult();

        $inventoryModel = new InventoryModel();
        $resultInventory = $inventoryModel->getProductsWithInventoryAndProductsArchived();
        $data["resultInventory"] = $resultInventory;
        $userLevel = $this->session->user_level;
        $data['userLevel'] = $userLevel;
        $data["viewSupplier"] = $resultSupplier2;
        $data["viewCategory"] = $resultViewCategory;
        $data["resultProducts"] = $resultProducts;
        $data["resultSupplier"] = $resultSupplier;
        $data["resultCategory"] = $result;
        $data['pageTitle'] = 'Archive';
        return view('archive', $data);
    }

    public function restoreAllCategory()
    {
        $model = new CategoryModel();
        $categoryIDs = $this->request->getPost('categoryID');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($categoryIDs as $id) {
                $data = [
                    'isCategoryArchived' => 0
                ];
                $model->update($id, $data);
            }

            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }




    public function restoreAllSupplier()
    {
        $model = new SupplierModel();
        $suppliersIDs = $this->request->getPost('supplierID');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($suppliersIDs as $id) {
                $data = [
                    'isSupplierArchived' => 1
                ];
                $model->update($id, $data);
            }

            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }


    public function deleteAllCategory()
    {
        $model = new CategoryModel();
        $categoryIDs = $this->request->getPost('categoryID');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($categoryIDs as $id) {
                $model->delete($id);
            }

            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteAllSuppliers()
    {
        $model = new SupplierModel();
        $categoryIDs = $this->request->getPost('categoryID');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($categoryIDs as $id) {
                $model->delete($id);
            }

            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }

    public function restoreAllProducts()
    {
        $model = new ProductModel();
        $productIds = $this->request->getPost('productId');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($productIds as $id) {
                $data = [
                    'isProductArchived' => 0
                ];
                $model->update($id, $data);
            }

            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteAllProducts()
    {
        $model = new ProductModel();
        $productIds = $this->request->getPost('productId');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($productIds as $id) {
                $model->delete($id);
            }

            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }

    public function restoreAllInventory()
    {
        $model = new InventoryModel();
        $inventoryIds = $this->request->getPost('inventoryId');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($inventoryIds as $id) {
                $data = [
                    'isInventoryArchived' => 0
                ];
                $model->update($id, $data);
            }

            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteAllInventory()
    {
        $model = new InventoryModel();
        $inventoryIds = $this->request->getPost('inventoryId');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($inventoryIds as $id) {
                $model->delete($id);
            }

            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }


}
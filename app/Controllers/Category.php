<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{

    private $categoryIdForArchive;

    public function index()
    {
        if (!$this->session->has("user_id")) {

            return redirect()->to("login");
        }
        
        $model = new CategoryModel();
        $model->select('*');
        $model->where('isCategoryArchived', 0);
        $query = $model->get();
        $result = $query->getResult();
        $data["result"] = $result;
        $data['pageTitle'] = 'Category';
        $permissionChecker = new \App\Libraries\PermissionChecker();

        // Pass the permissionChecker object to the view
        $data['permissionChecker'] = $permissionChecker;
    

        return view('category', $data);
    }

    public function addCategory()
    {
        $model = new CategoryModel();
        $categoryName = $this->request->getPost('categoryName');
        $categoryDescription = $this->request->getPost('categoryDescription');

        $model->transStart();

        try {
            $db = db_connect();
            $fields = $db->getFieldNames($model->table);

            $data = [
                'categoryName' => $categoryName,
                'categoryDescription' => $categoryDescription,
            ];

            // Check if there is an existing categoryId
            $categoryId = $this->request->getPost('categoryId');
            if (!empty($categoryId)) {
                // Perform the update operation
                $updated = $model->update($categoryId, $data);
                if ($updated === false) {
                    echo 'Transaction failed.';
                    $model->transRollback();
                } else {
                    echo 'Transaction success.';
                    $model->transCommit();
                }
            } else {
                // Perform the insert operation
                foreach ($data as $field => $value) {
                    if (!in_array($field, $fields)) {
                        echo 'Transaction failed.';
                        $model->transRollback();
                        return;
                    }
                }
                $inserted = $model->insert($data);
                if ($inserted === false) {
                    echo 'Transaction failed.';
                    $model->transRollback();
                } else {
                    echo 'Transaction success.';
                    $model->transCommit();
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception: ' . $e->getMessage());
            $model->transRollback();
        }

    }


    public function viewCategory($categoryId)
    {
        $model = new CategoryModel();
        $model->select('*');
        $query = $model->get();
        $result = $query->getResultArray();
        return json_encode($result);
        // Fetch the category details based on the $categoryId and return the response
        // ...
    }

    public function checkCategoryNameExists()
    {
        if ($this->request->isAJAX()) {
            $txtCategory = $this->request->getVar('txtCategory');
            $model = new CategoryModel();
            $user = $model->where('categoryName', $txtCategory)->first();
            if ($user) {
                return $this->response->setJSON(false);
            } else {
                return $this->response->setJSON(true);
            }
        }
    }

    public function checkUpdateCategoryNameExists()
    {
        if ($this->request->isAJAX()) {
            $txtCategory = $this->request->getVar('txtUpdateCategory');
            $txtCategoryId = $this->request->getVar('txtUpdateCategoryId');

            $model = new CategoryModel();
            $category = $model->where('categoryName', $txtCategory)->first();

            if ($category && $category['categoryId'] != $txtCategoryId) {
                return $this->response->setJSON(false);
            } else {
                return $this->response->setJSON(true);
            }
        }
    }

    public function archiveAllCategory()
    {
        $model = new CategoryModel();
        $categoryIDs = $this->request->getPost('categoryID');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($categoryIDs as $id) {
                $data = [
                    'isCategoryArchived' => 1
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


    public function getID()
    {
        $model = new CategoryModel();
        $categoryID = $this->request->getPost('categoryID');
        $model->transStart();

        try {

            $data = [
                'isCategoryArchived' => 1
            ];
            $model->update($categoryID, $data);
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
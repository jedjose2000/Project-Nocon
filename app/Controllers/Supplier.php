<?php

namespace App\Controllers;
use App\Models\SupplierModel;


class Supplier extends BaseController
{
    public function index()
    {
        if (!$this->session->has("user_id")) {

            return redirect()->to("login");
        }
        $data['pageTitle'] = 'Supplier';
        $permissionChecker = new \App\Libraries\PermissionChecker();
        $model = new SupplierModel();
        $model->select('*');
        $model->where('isSupplierArchived', 0);
        $query = $model->get();
        $result = $query->getResult();
        $data["result"] = $result;
        $data['permissionChecker'] = $permissionChecker;
        $userLevel = $this->session->user_level;
        $data['userLevel'] = $userLevel;
        return view('supplier',$data);
    }

    public function insertSupplier(){
        $model = new SupplierModel();
        $supplierName = $this->request->getPost('supplierName');
        $phoneNumber = $this->request->getPost('phoneNumber');
        $emailAddress = $this->request->getPost('emailAddress');
        $model->transStart();
        try {
            $db = db_connect();
            $fields = $db->getFieldNames($model->table);

            $data = [
                'supplierName' => $supplierName,
                'phoneNumber' => $phoneNumber,
                'emailAddress' => $emailAddress,
            ];

            // Check if there is an existing categoryId
            $supplierId = $this->request->getPost('supplierId');
            if (!empty($supplierId)) {
                // Perform the update operation
                $updated = $model->update($supplierId, $data);
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

    public function viewSupplier(){
        $model = new SupplierModel();
        $model->select('*');
        $query = $model->get();
        $result = $query->getResultArray();
        return json_encode($result);
    }

    public function checkSupplierNameExists()
    {

        if ($this->request->isAJAX()) {
            $txtSupplier = $this->request->getVar('txtSupplier');
            $model = new SupplierModel();
    
            $user = $model->where("REPLACE(supplierName, ' ', '')", str_replace(' ', '', $txtSupplier))->first();
    
            if ($user) {
                return $this->response->setJSON(false);
            } else {
                return $this->response->setJSON(true);
            }
        }
    }

    public function checkUpdateSupplierNameExists()
    {



        if ($this->request->isAJAX()) {
            $txtUpdateSupplier = $this->request->getVar('txtUpdateSupplier');
            $txtUpdateSupplierId = $this->request->getVar('txtUpdateSupplierId');

            $model = new SupplierModel();
            $supplier = $model->where("REPLACE(supplierName, ' ', '')", str_replace(' ', '', $txtUpdateSupplier))->first();
    

            if ($supplier && $supplier['supplierId'] != $txtUpdateSupplierId) {
                return $this->response->setJSON(false);
            } else {
                return $this->response->setJSON(true);
            }
        }


    }

    public function archiveAllSupplier(){
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

    public function getIDSupplier(){
        $model = new SupplierModel();
        $supplierId = $this->request->getPost('supplierId');
        $model->transStart();

        try {

            $data = [
                'isSupplierArchived' => 1
            ];
            $model->update($supplierId, $data);
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
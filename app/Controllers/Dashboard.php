<?php

namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\ReceiptModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!$this->session->has("user_id")) {
            return redirect()->to("login");
        }
    
        $productsModel = new ProductModel();
        $totalProducts = $productsModel->countAllResults();
        $receiptModel = new ReceiptModel();
        $overAllSales = $receiptModel->selectSum('totalPrice')->get()->getRow()->totalPrice;
        $totalStocksOnHand = $productsModel->getTotalStockOnHand();
        $productsNearCriticalLevel = $productsModel->getProductsNearCriticalLevel(); // Invoke the function

        $overAllSalesGraph = $receiptModel->getOverallSalesGraph();
        $userLevel = $this->session->user_level;
        $data['userLevel'] = $userLevel;
        $data['totalStocksOnHand'] = $totalStocksOnHand;
        $data['productsNearCriticalLevel'] = $productsNearCriticalLevel;
        $data['salesData'] = $overAllSalesGraph;
        $data['overAllSales'] = $overAllSales;
        $data['totalProducts'] = $totalProducts;
        $data['pageTitle'] = 'Dashboard';
        return view('dashboard',$data);
    }
    

    public function logout()
    {
      $this->session->destroy();
      return redirect()->to("login");
    }
}
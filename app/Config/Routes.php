<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Login::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/inventory', 'Inventory::index');
$routes->get('/reports', 'Reports::index');
$routes->get('/transaction', 'Transaction::index');
$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Dashboard::logout');
$routes->get('/category', 'Category::index');
$routes->get('/forgot-password', 'ForgotPassword::index');
$routes->post('/login', 'Login::login');
$routes->get('/view-category/(:num)', 'Category::viewCategory/$1');
$routes->post('/addCategory', 'Category::addCategory');
$routes->post('/checkCategoryNameExists', 'Category::checkCategoryNameExists');
$routes->post('/checkUpdateCategoryNameExists', 'Category::checkUpdateCategoryNameExists');
$routes->post('/archiveAllCategory', 'Category::archiveAllCategory');
$routes->post('/getIDs', 'Category::getID');

$routes->get('/supplier', 'Supplier::index');
$routes->post('/insertSupplier', 'Supplier::insertSupplier');
$routes->get('/view-supplier/(:num)', 'Supplier::viewSupplier/$1');
$routes->post('/checkSupplierNameExists', 'Supplier::checkSupplierNameExists');
$routes->post('/checkUpdateSupplierNameExists', 'Supplier::checkUpdateSupplierNameExists');
$routes->post('/archiveAllSupplier', 'Supplier::archiveAllSupplier');
$routes->post('/getIDSupplier', 'Supplier::getIDSupplier');

$routes->get('/product', 'Products::index');
$routes->post('/checkProductNameExists', 'Products::checkProductNameExists');
$routes->post('/insertProduct', 'Products::insertProduct');
$routes->get('/view-product/(:num)', 'Products::viewProduct/$1');
$routes->post('/checkUpdateProductNameExists', 'Products::checkUpdateProductNameExists');
$routes->post('/archiveAllProducts', 'Products::archiveAllProducts');
$routes->post('/getIDProduct', 'Products::getIDProduct');

$routes->post('/checkIfWillExpire', 'Inventory::checkIfWillExpire');
$routes->post('/insertDataInventory', 'Inventory::insertDataInventory');
$routes->get('/view-stockIn/(:num)', 'Inventory::viewStockIn/$1');
$routes->post('/stockIn', 'Inventory::stockIn');
$routes->post('/stockOut', 'Inventory::stockOut');
$routes->post('/checkIfStockIsSufficient', 'Inventory::checkIfStockIsSufficient');
$routes->get('/view-stockInHistory', 'Inventory::viewHistoryStockIn');
$routes->post('/archiveAllInventory', 'Inventory::archiveAllInventory');

$routes->get('/pos', 'PosTeller::index');
$routes->post('/checkIfStockIsSufficientTeller', 'PosTeller::checkIfStockIsSufficientTeller');
$routes->post('/createTheOrder', 'PosTeller::createTheOrder');


$routes->get('/view-productHistory', 'Transaction::viewHistoryProduct');
$routes->get('/view-productReceipt', 'Transaction::viewProductReceipt');
$routes->post('/voidProduct', 'Transaction::voidProduct');

$routes->post('/checkEmail', 'ForgotPassword::checkEmail');
$routes->post('/sendOTPForgot', 'ForgotPassword::sendOTP');
$routes->post('/checkOTP', 'ForgotPassword::checkOTP');
$routes->post('/forChangePassword', 'ForgotPassword::changePassword');


$routes->get('/archive', 'Archive::index');
$routes->post('/restoreAllCategory', 'Archive::restoreAllCategory');
$routes->post('/deleteAllCategory', 'Archive::deleteAllCategory');
$routes->post('/restoreAllSupplier', 'Archive::restoreAllSupplier');
$routes->post('/deleteAllSuppliers', 'Archive::deleteAllSuppliers');
$routes->post('/restoreAllProducts', 'Archive::restoreAllProducts');
$routes->post('/deleteAllProducts', 'Archive::deleteAllProducts');
$routes->post('/restoreAllInventory', 'Archive::restoreAllInventory');
$routes->post('/deleteAllInventory', 'Archive::deleteAllInventory');

$routes->get('/forgot-password', 'ForgotPassword::index');
$routes->post('/checkEmail', 'ForgotPassword::checkEmail');
$routes->post('/checkOTP', 'ForgotPassword::checkOTP');
$routes->post('/sendOTPForgot', 'ForgotPassword::sendOTP');
$routes->post('/forChangePassword', 'ForgotPassword::changePassword');
$routes->post('/changePass', 'ChangePassword::changePassword');


$routes->post('/checkIfUsernameExists', 'CreateAccount::checkUsernameExists');
$routes->post('/checkUsernameExists', 'CreateAccount::checkUsername');
$routes->post('/checkEmailSendOTP', 'CreateAccount::sendOTP');
$routes->post('/checkOTPCorrect', 'CreateAccount::checkOTPCorrect');
$routes->post('/createAccount', 'CreateAccount::createAccount');
$routes->get('/firstTimeLogin', 'FirstTime::index');
$routes->post('/forFirstTimeChangePassword', 'FirstTime::forFirstTimeChangePassword');

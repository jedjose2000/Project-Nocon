<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/inventory', 'Inventory::index');
$routes->get('/reports', 'Reports::index');
$routes->get('/transaction', 'Transaction::index');
$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Dashboard::logout');
$routes->get('/category', 'Category::index');
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
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
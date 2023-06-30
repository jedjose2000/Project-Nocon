<?php include("shared/dashboard/head-dashboard.php"); ?>

<div class="wrapper">


    <?php include("shared/dashboard/navbar-dashboard.php"); ?>

    <?php include("shared/dashboard/sidenav-dashboard.php"); ?>


    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <?php echo $pageTitle; ?>
                        </h1>
                    </div>
                    <div class="rounded m-2 p-2">
                        <div>
                            <div class="bg-white m-4 p-4 rounded">
                                <div class="pb-3 mb-2">
                                    <?php if ($permissionChecker->hasPermission('productListAdd', 'Add Product')): ?>
                                        <button class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#productModal" id="btnCreateCat"><i
                                                class="fa-solid fa-person-circle-plus me-2"></i>Create Product</button>
                                    <?php endif; ?>

                                    <?php if ($permissionChecker->hasPermission('productListArchive', 'Archive Product')): ?>
                                        <button class="archiveAllData btn btn-danger flex-end" id="btnArchiveAll"
                                            data-bs-toggle="modal" data-bs-target="#archiveAllModal" disabled><i
                                                class="fa-solid fa-person-circle-minus me-2"></i>Archive
                                            Selected</button>
                                    <?php endif; ?>
                                </div>
                                <div class="border p-2 rounded">
                                    <table id="productTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-orderable="false">
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="selectAll">
                                                        <label for="selectAll"></label>
                                                    </span>
                                                </th>
                                                <th class="text-center">Product Code</th>
                                                <th class="text-center">Product Name</th>
                                                <th class="text-center">Brand</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center">Supplier</th>
                                                <th class="text-center">Unit</th>
                                                <th class="text-center">Buy Price</th>
                                                <th class="text-center">Sell Price</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($result as $row) {
                                                ?>
                                                <tr id="<?php echo $row->productId ?>">
                                                    <td class="text-center">
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" id="data_checkbox" class="data_checkbox"
                                                                value="<?php echo $row->productId; ?>" name="data_checkbox">
                                                            <label for="data_checkbox">
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->productCode ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->productName ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->productBrand ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->categoryName ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->supplierName ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->unit ?>
                                                    </td>
                                                    <td class="text-center">
                                                        &#8369;
                                                        <?php echo number_format($row->buyPrice, 2, '.', ',') ?>
                                                    </td>
                                                    <td class="text-center">
                                                        &#8369;
                                                        <?php echo number_format($row->sellPrice, 2, '.', ',') ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if (
                                                            $permissionChecker->hasPermission('productListUpdate', 'Update Product')
                                                            && $permissionChecker->hasPermission('productListArchive', 'Archive Product')
                                                            && $permissionChecker->hasPermission('productListView', 'View Product')
                                                        ): ?>
                                                            <button title="View Product" class="btn btn-outline-primary btnView"
                                                                data-bs-toggle="modal" data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#viewProductModal" id="btnViewProduct">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
                                                            <button title="Update Product"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#updateProductModal" id="btnUpdateProduct">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                            <button class="btn btn-outline-danger btnArchiveProduct"
                                                                title="Archive Product" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#archiveProductModal">
                                                                <i class="fa-solid fa-archive"></i>
                                                            </button>
                                                        <?php elseif (
                                                            $permissionChecker->hasPermission('productListUpdate', 'Update Product')
                                                            && $permissionChecker->hasPermission('productListArchive', 'Archive Product')
                                                        ): ?>
                                                            <button title="Update Product"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#updateProductModal" id="btnUpdateProduct">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                            <button class="btn btn-outline-danger btnArchiveProduct"
                                                                title="Archive Product" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#archiveProductModal">
                                                                <i class="fa-solid fa-archive"></i>
                                                            </button>
                                                        <?php elseif (
                                                            $permissionChecker->hasPermission('productListUpdate', 'Update Product')
                                                            && $permissionChecker->hasPermission('productListView', 'View Product')
                                                        ): ?>
                                                            <button title="Update Product"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#updateProductModal" id="btnUpdateProduct">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                            <button title="View Product" class="btn btn-outline-primary btnView"
                                                                data-bs-toggle="modal" data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#viewProductModal" id="btnViewProduct">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
                                                        <?php elseif (
                                                            $permissionChecker->hasPermission('productListArchive', 'Archive Product')
                                                            && $permissionChecker->hasPermission('productListView', 'View Product')
                                                        ): ?>
                                                            <button title="View Product" class="btn btn-outline-primary btnView"
                                                                data-bs-toggle="modal" data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#viewProductModal" id="btnViewProduct">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-outline-danger btnArchiveProduct"
                                                                title="Archive Product" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#archiveProductModal">
                                                                <i class="fa-solid fa-archive"></i>
                                                            </button>
                                                        <?php elseif ($permissionChecker->hasPermission('productListUpdate', 'Update Product')): ?>
                                                            <button title="Update Product"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#updateProductModal" id="btnUpdateProduct">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                        <?php elseif ($permissionChecker->hasPermission('productListArchive', 'Archive Product')): ?>
                                                            <button class="btn btn-outline-danger btnArchiveProduct"
                                                                title="Archive Product" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#archiveProductModal">
                                                                <i class="fa-solid fa-archive"></i>
                                                            </button>
                                                        <?php elseif ($permissionChecker->hasPermission('productListView', 'View Product')): ?>
                                                            <button title="View Product" class="btn btn-outline-primary btnView"
                                                                data-bs-toggle="modal" data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#viewProductModal" id="btnViewProduct">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
                                                        <?php else: ?>
                                                            No Action
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <section class="content">
            <div class="container-fluid">

            </div>
        </section>

    </div>


    <footer class="main-footer">

        <div class="float-right d-none d-sm-inline-block">

        </div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark">

    </aside>


    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="productModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-x1">
            <form id="formProduct">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="txtProduct" class="form-label">Name<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtProduct" name="txtProduct"
                                    placeholder="Enter Product Name" maxlength="40" required>
                                <div class="invalid-feedback product-error"></div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="txtBrand" class="form-label">Brand</label>
                                <input type="text" class="form-control" id="txtBrand" name="txtBrand"
                                    placeholder="Enter Brand Name" maxlength="40">
                                <div class="invalid-feedback product-brand-error"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="txtCategory">Category<span class="required"
                                        style="color:red">*</span></label>
                                <select class="form-select" name="txtCategory" id="txtCategory" aria-label="Category">
                                    <?php foreach ($category as $category): ?>
                                        <option value="<?php echo $category->categoryId; ?>"><?php echo $category->categoryName; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="txtSupplier">Supplier<span class="required"
                                        style="color:red">*</span></label>
                                <select class="form-select" name="txtSupplier" id="txtSupplier" aria-label="Supplier">
                                    <?php foreach ($supplier as $supplier): ?>
                                        <option value="<?php echo $supplier->supplierId; ?>"><?php echo $supplier->supplierName; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="txtDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="txtDescription" name="txtDescription" rows="8"
                                placeholder="Enter Description Here"></textarea>
                            <div class="invalid-feedback product-description-error"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="txtUnit" class="form-label">Unit<span class="required"
                                        style="color:red">*</span></label>
                                <select class="form-select" name="txtUnit" id="txtUnit" aria-label="Unit">
                                    <option value="pcs">Pieces</option>
                                    <option value="kg">Kilogram</option>
                                    <option value="ton">Ton</option>
                                    <option value="unit">Unit</option>
                                    <option value="pack">Pack</option>
                                    <option value="box">Box</option>
                                    <option value="pair">Pair</option>
                                    <option value="roll">Roll</option>
                                    <option value="ream">Ream</option>
                                    <option value="sack">Sack</option>
                                    <option value="set">Set</option>
                                    <option value="tube">Tube</option>
                                    <option value="bottle">Bottle</option>
                                </select>
                                <div class="invalid-feedback product-unit-error"></div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="txtBuyPrice" class="form-label">Buy Price<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtBuyPrice" name="txtBuyPrice"
                                    placeholder="Enter Buy Price" maxlength="7" required>
                                <div class="invalid-feedback product-buyprice-error"></div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="txtSellPrice" class="form-label">Sell Price<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtSellPrice" name="txtSellPrice"
                                    placeholder="Enter Sell Price" maxlength="7" required>
                                <div class="invalid-feedback product-sellprice-error"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label for="txtCLQ" class="form-label">Critical Level Quantity<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtCLQ" name="txtCLQ"
                                    placeholder="Enter Critical Level Quantity" maxlength="7" required>
                                <div class="invalid-feedback product-clq-error"></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="chkWillExpire"
                                    name="chkWillExpire">
                                <label class="form-check-label" for="chkWillExpire">Will Expire?</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnAddProduct">Add Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="updateProductModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-x1">
            <form id="formUpdateProduct">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <input type="hidden" class="form-control" id="txtUpdateProductId" name="txtUpdateProductId">
                    <div class="modal-body px-5">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="txtUpdateProductCode" class="form-label">Product Code<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtUpdateProductCode"
                                    name="txtUpdateProductCode" maxlength="40" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="txtUpdateProduct" class="form-label">Name<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtUpdateProduct" name="txtUpdateProduct"
                                    placeholder="Enter Product Name" maxlength="40" required>
                                <div class="invalid-feedback product-error"></div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="txtUpdateBrand" class="form-label">Brand</label>
                                <input type="text" class="form-control" id="txtUpdateBrand" name="txtUpdateBrand"
                                    placeholder="Enter Brand Name" maxlength="40">
                                <div class="invalid-feedback product-brand-error"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="txtUpdateCategory">Category<span class="required"
                                        style="color:red">*</span></label>
                                <select class="form-select" name="txtUpdateCategory" id="txtUpdateCategory"
                                    aria-label="Category">
                                    <?php foreach ($updateCategory as $updateCategory): ?>
                                        <option value="<?php echo $updateCategory->categoryId; ?>"><?php echo $updateCategory->categoryName; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="txtUpdateSupplier">Supplier<span class="required"
                                        style="color:red">*</span></label>
                                <select class="form-select" name="txtUpdateSupplier" id="txtUpdateSupplier"
                                    aria-label="Supplier">
                                    <?php foreach ($updateSupplier as $updateSupplier): ?>
                                        <option value="<?php echo $updateSupplier->supplierId; ?>"><?php echo $updateSupplier->supplierName; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="txtUpdateDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="txtUpdateDescription" name="txtUpdateDescription"
                                rows="8" placeholder="Enter Description Here"></textarea>
                            <div class="invalid-feedback product-description-error"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="txtUpdateUnit" class="form-label">Unit<span class="required"
                                        style="color:red">*</span></label>
                                <select class="form-select" name="txtUpdateUnit" id="txtUpdateUnit" aria-label="Unit">
                                    <option value="pcs">Pieces</option>
                                    <option value="kg">Kilogram</option>
                                    <option value="ton">Ton</option>
                                    <option value="unit">Unit</option>
                                    <option value="pack">Pack</option>
                                    <option value="box">Box</option>
                                    <option value="pair">Pair</option>
                                    <option value="roll">Roll</option>
                                    <option value="ream">Ream</option>
                                    <option value="sack">Sack</option>
                                    <option value="set">Set</option>
                                    <option value="tube">Tube</option>
                                    <option value="bottle">Bottle</option>
                                </select>
                                <div class="invalid-feedback product-unit-error"></div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="txtUpdateBuyPrice" class="form-label">Buy Price<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtUpdateBuyPrice" name="txtUpdateBuyPrice"
                                    placeholder="Enter Buy Price" maxlength="7" required>
                                <div class="invalid-feedback product-buyprice-error"></div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="txtUpdateSellPrice" class="form-label">Sell Price<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtUpdateSellPrice"
                                    name="txtUpdateSellPrice" placeholder="Enter Sell Price" maxlength="7" required>
                                <div class="invalid-feedback product-sellprice-error"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label for="txtUpdateCLQ" class="form-label">Critical Level Quantity<span
                                        class="required" style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtUpdateCLQ" name="txtUpdateCLQ"
                                    placeholder="Enter Critical Level Quantity" maxlength="7" required>
                                <div class="invalid-feedback product-clq-error"></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="chkUpdateWillExpire"
                                    name="chkUpdateWillExpire">
                                <label class="form-check-label" for="chkUpdateWillExpire">Will Expire?</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnUpdateProduct">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="archiveAllModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Archive Selected Products</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnAllProductId" id="hdnAllProductId" />
                    <p>Do you want to archive the selected products?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnArchiveAll">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="archiveProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Archive Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnId" id="hdnId" />
                    <p>Do you want to archive the selected product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnConfirmArchiveProduct">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="viewProductModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-x1">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Product</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <input type="hidden" class="form-control" id="txtViewProductId" name="txtViewProductId">
                    <div class="modal-body px-5">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="txtViewProductCode" class="form-label">Product Code<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtViewProductCode"
                                    name="txtViewProductCode" maxlength="40" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="txtViewProduct" class="form-label">Name<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtViewProduct" name="txtViewProduct"
                                    placeholder="Enter Product Name" maxlength="40" disabled>
                                <div class="invalid-feedback product-error"></div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="txtViewBrand" class="form-label">Brand</label>
                                <input type="text" class="form-control" id="txtViewBrand" name="txtViewBrand"
                                    placeholder="Enter Brand Name" maxlength="40" disabled>
                                <div class="invalid-feedback product-brand-error"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="txtViewCategory">Category<span class="required"
                                        style="color:red">*</span></label>
                                <select class="form-select" name="txtViewCategory" id="txtViewCategory"
                                    aria-label="Category" disabled>
                                    <?php foreach ($viewCategory as $viewCategory): ?>
                                        <option value="<?php echo $viewCategory->categoryId; ?>"><?php echo $viewCategory->categoryName; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="txtViewSupplier">Supplier<span class="required"
                                        style="color:red">*</span></label>
                                <select class="form-select" name="txtViewSupplier" id="txtViewSupplier"
                                    aria-label="Supplier" disabled>
                                    <?php foreach ($viewSupplier as $viewSupplier): ?>
                                        <option value="<?php echo $viewSupplier->supplierId; ?>"><?php echo $viewSupplier->supplierName; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="txtViewDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="txtViewDescription" name="txtViewDescription" rows="8"
                                placeholder="Enter Description Here" disabled></textarea>
                            <div class="invalid-feedback product-description-error"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="txtViewUnit" class="form-label">Unit<span class="required"
                                        style="color:red">*</span></label>
                                <select class="form-select" name="txtViewUnit" id="txtViewUnit" aria-label="Unit"
                                    disabled>
                                    <option value="pcs">Pieces</option>
                                    <option value="kg">Kilogram</option>
                                    <option value="ton">Ton</option>
                                    <option value="unit">Unit</option>
                                    <option value="pack">Pack</option>
                                    <option value="box">Box</option>
                                    <option value="pair">Pair</option>
                                    <option value="roll">Roll</option>
                                    <option value="ream">Ream</option>
                                    <option value="sack">Sack</option>
                                    <option value="set">Set</option>
                                    <option value="tube">Tube</option>
                                    <option value="bottle">Bottle</option>
                                </select>
                                <div class="invalid-feedback product-unit-error"></div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="txtViewBuyPrice" class="form-label">Buy Price<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtViewBuyPrice" name="txtViewBuyPrice"
                                    placeholder="Enter Buy Price" maxlength="7" disabled>
                                <div class="invalid-feedback product-buyprice-error"></div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="txtViewSellPrice" class="form-label">Sell Price<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtViewSellPrice" name="txtViewSellPrice"
                                    placeholder="Enter Sell Price" maxlength="7" disabled>
                                <div class="invalid-feedback product-sellprice-error"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label for="txtViewCLQ" class="form-label">Critical Level Quantity<span class="required"
                                        style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtViewCLQ" name="txtViewCLQ"
                                    placeholder="Enter Critical Level Quantity" maxlength="7" disabled>
                                <div class="invalid-feedback product-clq-error"></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="chkViewWillExpire"
                                    name="chkViewWillExpire" disabled>
                                <label class="form-check-label" for="chkViewWillExpire">Will Expire?</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



</div>

<script>
    $(document).ready(function () {
        $('#productTable').DataTable({
            "columnDefs": [
                // { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 8 }
            ],
            order: [[1, 'asc']]
        });


        $('#updateProductModal').on('hidden.bs.modal', function () {
            $('#formUpdateProduct')[0].reset(); // Reset the form fields
            $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
            $('.invalid-feedback').html(''); // Clear the error messages
        });

        $('#productModal').on('hidden.bs.modal', function () {
            $('#formProduct')[0].reset(); // Reset the form fields
            $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
            $('.invalid-feedback').html(''); // Clear the error messages
        });

        var table = $('#productTable').DataTable();
        if (table.rows().count() === 0) {
            $('#selectAll').prop('checked', false).prop('disabled', true);
        } else {
            $('#selectAll').prop('disabled', false);
        }
        window.localStorage.setItem('show_popup_update', 'false');
        window.localStorage.setItem('show_popup_add', 'false');
        window.localStorage.setItem('show_popup_failed', 'false');

    });

    jQuery.validator.addMethod("noSpace", function (value, element) {
        let newValue = value.trim();

        return (newValue) ? true : false;
    }, "This field is required");

    if (window.localStorage.getItem('show_popup_update') == 'true') {
        alertify.success('Product Updated');
        window.localStorage.setItem('show_popup_update', 'false');
    }

    if (window.localStorage.getItem('show_popup_add') == 'true') {
        alertify.success('Product Added');
        window.localStorage.setItem('show_popup_add', 'false');
    }

    if (window.localStorage.getItem('show_popup_failed') == 'true') {
        alertify.error('Error');
        window.localStorage.setItem('show_popup_failed', 'false');
    }


    $('#productTable tbody').on('change', 'input[type="checkbox"]', function () {
        var isChecked = $('input[type="checkbox"]:checked', '#productTable tbody').length > 0;
        if (isChecked) {
            $('#btnArchiveAll').prop('disabled', false);
        } else {
            $('#btnArchiveAll').prop('disabled', true);
        }

        // check or uncheck the header checkbox based on the state of the row checkboxes
        $('#selectAll').prop('checked', $('input[type="checkbox"]', '#productTable tbody').length === $('input[type="checkbox"]:checked', '#productTable tbody').length);

    });

    $('#selectAll').on('change', function () {
        var isChecked = $(this).is(':checked');
        var table = $('#productTable').DataTable();
        $('#btnArchiveAll').prop('disabled', !isChecked);
        // check or uncheck all row checkboxes based on the state of the header checkbox
        table.rows().every(function () {
            var rowNode = this.node();
            $('input[type="checkbox"]', rowNode).prop('checked', isChecked);
        });
    });

    $("#formProduct").validate({
        rules: {
            txtProduct: {
                required: true,
                remote: {
                    url: "checkProductNameExists",
                    type: "post",
                    data: {
                        txtProduct: function () {
                            return $("#txtProduct").val();
                        }
                    }
                },
                noSpace: true,
            },
            txtBuyPrice: {
                required: true,
            },
            txtSellPrice: {
                required: true,
            },
            txtCLQ: {
                required: true,
            }
        },
        messages: {
            txtProduct: {
                required: "Please enter a product name.",
                remote: "Product Name already exists.",
                noSpace: "Please enter a product name.",
            },
            txtBuyPrice: {
                required: "Please enter a product price.",
            },
            txtSellPrice: {
                required: "Please enter a sell price.",
            },
            txtCLQ: {
                required: "Please enter a critical level quantity.",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "txtProduct") {
                $(".product-error").html(error);
                $(".product-error");
            } else if (element.attr("name") === "txtBuyPrice") {
                $(".product-buyprice-error").html(error);
                $(".product-buyprice-error");
            }
            else if (element.attr("name") === "txtSellPrice") {
                $(".product-sellprice-error").html(error);
                $(".product-sellprice-error");
            }
            else if (element.attr("name") === "txtCLQ") {
                $(".product-clq-error").html(error);
                $(".product-clq-error");
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
            $(element).siblings(".error").empty();
        },
        success: function (label) {
            label.removeClass("error");
        },
        submitHandler: function (form) {
            var productName = $('#txtProduct').val();
            var brandName = $('#txtBrand').val();
            var categoryId = $('#txtCategory').val();
            var supplierId = $('#txtSupplier').val();
            var productDescription = $('#txtDescription').val();
            var unit = $('#txtUnit').val();
            var buyPrice = $('#txtBuyPrice').val();
            var sellPrice = $('#txtSellPrice').val();
            var clq = $('#txtCLQ').val();
            var willExpire = $('#chkWillExpire').prop('checked') ? 1 : 0;
            $.ajax({
                url: '/insertProduct',
                type: 'POST',
                data: { productName: productName, brandName: brandName, categoryId: categoryId, supplierId: supplierId, productDescription: productDescription, unit: unit, buyPrice: buyPrice, sellPrice: sellPrice, clq: clq, willExpire: willExpire },
                success: function (data) {
                    if (data === 'Transaction success.') {
                        window.localStorage.setItem('show_popup_add', 'true');
                        window.location.reload();
                    } else {
                        window.localStorage.setItem('show_popup_failed', 'true');
                        window.location.reload();
                    }

                    $('#productModal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
    });


    $('body').on('click', '.btnUpdate', function () {
        var productId = $(this).attr('data-id');
        $('#updateProductModal #txtUpdateProductId').val(productId);
        $.ajax({
            url: 'view-product/' + productId,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                let result = res.find(product => product.productId == productId);
                $('#updateProductModal #txtUpdateProductCode').val(result.productCode);
                $('#updateProductModal #txtUpdateProduct').val(result.productName);
                $('#updateProductModal #txtUpdateBrand').val(result.productBrand);
                $('#updateProductModal #txtUpdateCategory').val(result.categoryID);
                $('#updateProductModal #txtUpdateSupplier').val(result.supplierID);
                $('#updateProductModal #txtUpdateDescription').val(result.productDescription);
                $('#updateProductModal #txtUpdateUnit').val(result.unit);
                $('#updateProductModal #txtUpdateBuyPrice').val(result.buyPrice);
                $('#updateProductModal #txtUpdateSellPrice').val(result.sellPrice);
                $('#updateProductModal #txtUpdateCLQ').val(result.clq);
                $('#updateProductModal #chkUpdateWillExpire').prop('checked', result.willExpire == 1);
            },
            error: function (data) {
            }
        });
    });


    $('body').on('click', '.btnView', function () {
        var productId = $(this).attr('data-id');
        $('#viewProductModal #txtViewProductId').val(productId);
        $.ajax({
            url: 'view-product/' + productId,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                let result = res.find(product => product.productId == productId);
                $('#viewProductModal #txtViewProductCode').val(result.productCode);
                $('#viewProductModal #txtViewProduct').val(result.productName);
                $('#viewProductModal #txtViewBrand').val(result.productBrand);
                $('#viewProductModal #txtViewCategory').val(result.categoryID);
                $('#viewProductModal #txtViewSupplier').val(result.supplierID);
                $('#viewProductModal #txtViewDescription').val(result.productDescription);
                $('#viewProductModal #txtViewUnit').val(result.unit);
                $('#viewProductModal #txtViewBuyPrice').val(result.buyPrice);
                $('#viewProductModal #txtViewSellPrice').val(result.sellPrice);
                $('#viewProductModal #txtViewCLQ').val(result.clq);
                $('#viewProductModal #chkViewWillExpire').prop('checked', result.willExpire == 1);
            },
            error: function (data) {
            }
        });
    });

    $("#formUpdateProduct").validate({
        rules: {
            txtUpdateProduct: {
                required: true,
                remote: {
                    url: "checkUpdateProductNameExists",
                    type: "post",
                    data: {
                        txtUpdateProduct: function () {
                            return $("#txtUpdateProduct").val();
                        },
                        txtUpdateProductId: function () {
                            return $("#txtUpdateProductId").val();
                        }
                    }
                },
                noSpace: true,
            },
            txtUpdateBuyPrice: {
                required: true,
            },
            txtUpdateSellPrice: {
                required: true,
            },
            txtUpdateCLQ: {
                required: true,
            }
        },
        messages: {
            txtUpdateProduct: {
                required: "Please enter a product name.",
                remote: "Product Name already exists.",
                noSpace: "Please enter a product name.",
            },
            txtUpdateBuyPrice: {
                required: "Please enter a product price.",
            },
            txtUpdateSellPrice: {
                required: "Please enter a sell price.",
            },
            txtUpdateCLQ: {
                required: "Please enter a critical level quantity.",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "txtUpdateProduct") {
                $(".product-error").html(error);
                $(".product-error");
            } else if (element.attr("name") === "txtUpdateBuyPrice") {
                $(".product-buyprice-error").html(error);
                $(".product-buyprice-error");
            }
            else if (element.attr("name") === "txtUpdateSellPrice") {
                $(".product-sellprice-error").html(error);
                $(".product-sellprice-error");
            }
            else if (element.attr("name") === "txtUpdateCLQ") {
                $(".product-clq-error").html(error);
                $(".product-clq-error");
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
            $(element).siblings(".error").empty();
        },
        success: function (label) {
            label.removeClass("error");
        },
        submitHandler: function (form) {
            var productId = $('#txtUpdateProductId').val();
            var productName = $('#txtUpdateProduct').val();
            var brandName = $('#txtUpdateBrand').val();
            var categoryId = $('#txtUpdateCategory').val();
            var supplierId = $('#txtUpdateSupplier').val();
            var productDescription = $('#txtUpdateDescription').val();
            var unit = $('#txtUpdateUnit').val();
            var buyPrice = $('#txtUpdateBuyPrice').val();
            var sellPrice = $('#txtUpdateSellPrice').val();
            var clq = $('#txtUpdateCLQ').val();
            var willExpire = $('#chkUpdateWillExpire').prop('checked') ? 1 : 0;
            $.ajax({
                url: '/insertProduct',
                type: 'POST',
                data: { productId: productId, productName: productName, brandName: brandName, categoryId: categoryId, supplierId: supplierId, productDescription: productDescription, unit: unit, buyPrice: buyPrice, sellPrice: sellPrice, clq: clq, willExpire: willExpire },
                success: function (data) {
                    if (data === 'Transaction success.') {
                        window.localStorage.setItem('show_popup_update', 'true');
                        window.location.reload();
                    } else {
                        window.localStorage.setItem('show_popup_failed', 'true');
                        window.location.reload();
                    }
                    $('#updateProductModal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
    });

    document.getElementById("txtBuyPrice").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[0-9]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });

    document.getElementById("txtCLQ").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[0-9]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });

    document.getElementById("txtSellPrice").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[0-9]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });

    document.getElementById("txtProduct").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[a-zA-Z\s]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });

    document.getElementById("txtBrand").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[a-zA-Z\s]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });


    $(document).on('click', '.archiveAllData', function () {
        var checkboxes = $(".data_checkbox:checked");
        if (checkboxes.length > 0) {
            var productId = [];
            checkboxes.each(function () {
                productId.push($(this).val());
            })
            var productIdString = JSON.stringify(productId);
            $('#hdnAllProductId').val(productIdString);
        }
    })


    $(document).on('click', '.btnArchiveAll', function () {
        var productIdString = $('#hdnAllProductId').val();
        if (productIdString === "") {
            alertify.error('Please select rows to archive!');
            return;
        }
        var productId = JSON.parse(productIdString);
        var checkboxes = $(".data_checkbox:checked");
        $.ajax({
            url: '/archiveAllProducts',
            type: 'POST',
            data: { productId },
            success: function (data) {
                checkboxes.each(function () {
                    var row = $(this).closest('tr');
                    var table = $('#productTable').DataTable();
                    table.row(row).remove().draw(false);
                });
                $('#btnArchiveAll').prop('disabled', true);
                alertify.success('Suppliers Archived Successfully');
                var isChecked = $('input[type="checkbox"]:checked', '#productTable tbody').length > 0;
                if (isChecked) {
                    $('#btnArchiveAll').prop('disabled', false);
                } else {
                    $('#btnArchiveAll').prop('disabled', true);
                    $('#selectAll').prop('checked', false);
                }
            }
        });
        $('#archiveAllModal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    })

    $('body').on('click', '.btnArchiveProduct', function () {
        var productId = $(this).attr('data-id');
        console.log("product", productId);
        $('#archiveProductModal #hdnId').val(productId);
    });

    $('body').on('click', '.btnConfirmArchiveProduct', function () {
        var productId = $("#hdnId").val();
        var table = $('#productTable').DataTable();
        $.ajax({
            url: '/getIDProduct',
            type: 'POST',
            data: { productId },
            success: function (data) {
                console.log(data);
                table.row('#' + productId).remove().draw();
                // re-check the status of the checkboxes after the AJAX call
                var isChecked = $('input[type="checkbox"]:checked', '#productTable tbody').length > 0;
                if (isChecked) {
                    $('#btnArchiveAll').prop('disabled', false);
                } else {
                    $('#btnArchiveAll').prop('disabled', true);
                    if (table.rows().count() === 0) {
                        $('#selectAll').prop('checked', false).prop('disabled', true);
                    } else {
                        $('#selectAll').prop('disabled', false);
                    }
                }
                alertify.success('Product Archived Successfully');
                table.page.len(table.page.len()).draw();
            }
        });
        $('#archiveProductModal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

</script>



<?php include("shared/dashboard/footer-dashboard.php"); ?>
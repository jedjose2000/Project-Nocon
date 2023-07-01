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
                                <div class="invalid-feedback product-category-error"></div>
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
                                    <div class="invalid-feedback product-category-error"></div>
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


<script src="product.js"></script>


<?php include("shared/dashboard/footer-dashboard.php"); ?>
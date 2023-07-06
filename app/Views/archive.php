<?php include("shared/dashboard/head-dashboard.php"); ?>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



<div class="wrapper">


    <?php include("shared/dashboard/navbar-dashboard.php"); ?>

    <?php include("shared/dashboard/sidenav-dashboard.php"); ?>


    <div class="content-wrapper">

        <div class="rounded m-2 p-2">
            <div>
                <div class="bg-white rounded m-4 p-4">
                    <div class="pb-3 mb-2">
                        <div class="border p-2 rounded">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#employeeArchive"
                                        data-bs-toggle="tab">Category</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#patientArchive" data-bs-toggle="tab">Suppliers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#productsArchive" data-bs-toggle="tab">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#inventoryArchive" data-bs-toggle="tab">Inventory</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active mb-3" id="employeeArchive">
                                    <button class="archiveAllDataCategory btn btn-success my-3 flex-end"
                                        id="btnArchiveAllCategory" data-bs-toggle="modal"
                                        data-bs-target="#restoreAllModalCategory" disabled><i
                                            class="fas fa-sync-alt me-2"></i>Restore
                                        Selected</button>
                                    <button class="deleteAllDataCategory btn btn-danger my-3 flex-end"
                                        id="btnDeleteAllCategory" data-bs-toggle="modal"
                                        data-bs-target="#deleteAllModalCategory" disabled><i
                                            class="fas fa-trash-alt"></i>Delete
                                        Selected</button>
                                    <table id="categoryTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-orderable="false">
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="selectAllCategory">
                                                        <label for="selectAllCategory"></label>
                                                    </span>
                                                </th>
                                                <th class="text-center">Category Name</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($resultCategory as $row) {
                                                ?>
                                                <tr id="<?php echo $row->categoryId ?>">
                                                    <td class="text-center">
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" id="data_checkbox" class="data_checkbox"
                                                                value="<?php echo $row->categoryId; ?>"
                                                                name="data_checkbox">
                                                            <label for="data_checkbox">
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->categoryName ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->categoryDescription ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button title="View Category"
                                                            class="btn btn-outline-primary btnViewCategory"
                                                            data-bs-toggle="modal" data-id="<?php echo $row->categoryId ?>"
                                                            data-bs-target="#categoryModalView" id="btnViewCategory">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane mt-3" id="patientArchive">
                                    <button class="archiveAllDataSupplier btn btn-success my-3 flex-end"
                                        id="btnArchiveAllSupplier" data-bs-toggle="modal"
                                        data-bs-target="#restoreAllModalSupplier" disabled><i
                                            class="fas fa-sync-alt me-2"></i>Restore
                                        Selected</button>
                                    <button class="deleteAllDataSupplier btn btn-danger my-3 flex-end"
                                        id="btnDeleteAllSupplier" data-bs-toggle="modal"
                                        data-bs-target="#deleteAllModalSupplier" disabled><i
                                            class="fas fa-trash-alt"></i>Delete
                                        Selected</button>
                                    <table id="supplierTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-orderable="false">
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="selectAllSupplier">
                                                        <label for="selectAllSupplier"></label>
                                                    </span>
                                                </th>
                                                <th class="text-center">Supplier Name</th>
                                                <th class="text-center">Phone Number</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($resultSupplier as $row) {
                                                ?>
                                                <tr id="<?php echo $row->supplierId ?>">
                                                    <td class="text-center">
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" id="data_checkbox" class="data_checkbox"
                                                                value="<?php echo $row->supplierId; ?>"
                                                                name="data_checkbox">
                                                            <label for="data_checkbox">
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->supplierName ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->phoneNumber ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->emailAddress ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button title="View Supplier"
                                                            class="btn btn-outline-primary btnViewSupplier"
                                                            data-bs-toggle="modal" data-id="<?php echo $row->supplierId ?>"
                                                            data-bs-target="#supplierModalView" id="btnViewSupplier">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane mt-3" id="productsArchive">
                                    <button class="archiveAllDataProducts btn btn-success my-3 flex-end"
                                        id="btnArchiveAllProducts" data-bs-toggle="modal"
                                        data-bs-target="#restoreAllModalProducts" disabled><i
                                            class="fas fa-sync-alt me-2"></i>Restore
                                        Selected</button>
                                    <button class="deleteAllDataProducts btn btn-danger my-3 flex-end"
                                        id="btnDeleteAllProducts" data-bs-toggle="modal"
                                        data-bs-target="#deleteAllModalProducts" disabled><i
                                            class="fas fa-trash-alt"></i>Delete
                                        Selected</button>
                                    <table id="productTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-orderable="false">
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="selectAllProducts">
                                                        <label for="selectAllProducts"></label>
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
                                            foreach ($resultProducts as $row) {
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
                                                        <button title="View Product" class="btn btn-outline-primary btnView"
                                                            data-bs-toggle="modal" data-id="<?php echo $row->productId ?>"
                                                            data-bs-target="#viewProductModal" id="btnViewProduct">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane mt-3" id="inventoryArchive">
                                    <button class="archiveAllDataInventory btn btn-success my-3 flex-end"
                                        id="btnArchiveAllInventory" data-bs-toggle="modal"
                                        data-bs-target="#restoreAllModalInventory" disabled><i
                                            class="fas fa-sync-alt me-2"></i>Restore
                                        Selected</button>
                                    <button class="deleteAllDataInventory btn btn-danger my-3 flex-end"
                                        id="btnDeleteAllInventory" data-bs-toggle="modal"
                                        data-bs-target="#deleteAllModalInventory" disabled><i
                                            class="fas fa-trash-alt"></i>Delete
                                        Selected</button>
                                    <table id="inventoryTable" class="display" style="width:100%">
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
                                                <th class="text-center">Product Description</th>
                                                <th class="text-center">Damaged</th>
                                                <th class="text-center">Lost</th>
                                                <th class="text-center">Expired</th>
                                                <th class="text-center">Returns</th>
                                                <th class="text-center">Available</th>
                                                <th class="text-center">Total Quantity</th>
                                                <th class="text-center">Critical Level Quantity</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($resultInventory as $row) {
                                                $rowClass = ($row->totalStockIn <= $row->clq) ? 'text-danger' : '';
                                                ?>
                                                <tr id="<?php echo $row->inventoryId ?>" class="<?php echo $rowClass ?>">
                                                    <td class="text-center">
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" id="data_checkbox" class="data_checkbox"
                                                                value="<?php echo $row->inventoryId; ?>"
                                                                name="data_checkbox">
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
                                                        <?php echo $row->productDescription ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->damaged ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->lost ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->expired ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->returned ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->totalStockIn ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->totalQuantity ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->clq ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-outline-secondary btnViewHistory"
                                                            title="View Stock History" data-bs-toggle="modal"
                                                            data-id="<?php echo $row->inventoryId ?>"
                                                            product-id="<?php echo $row->productId ?>"
                                                            data-bs-target="#viewInventoryHistoryModal">
                                                            <i class="fas fa-history"></i>
                                                        </button>
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

    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="categoryModalView" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Category</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <input type="hidden" class="form-control" id="txtViewCategoryId" name="txtViewCategoryId"
                        placeholder="Enter Category Name" maxlength="40" disabled>
                    <div class="modal-body px-5">
                        <div class="mb-4">
                            <label for="txtViewCategory" class="form-label">Name<span class="required"
                                    style="color:red">*</span></label>
                            <input type="text" class="form-control" id="txtViewCategory" name="txtViewCategory"
                                placeholder="Enter Category Name" maxlength="40" disabled>
                            <div class="invalid-feedback category-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtViewDescription" class="form-label">Description<span class="required"
                                    style="color:red">*</span></label>
                            <textarea class="form-control" id="txtViewDescription" name="txtViewDescription" rows="8"
                                placeholder="Enter Description Here" disabled></textarea>
                            <div class="invalid-feedback category-description-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="restoreAllModalCategory" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Selected Categories</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnAllCategoryId" id="hdnAllCategoryId" />
                    <p>Do you want to restore the selected categories?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnRestoreAllCategory">Yes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteAllModalCategory" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Selected Categories</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnAllCategoryIdDelete" id="hdnAllCategoryIdDelete" />
                    <p>Do you want to delete the selected categories?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnDeleteAllCategory">Yes</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="supplierModalView" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form>
                <div class="modal-content">
                    <input type="hidden" class="form-control" id="txtViewSupplierId" name="txtViewSupplierId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Supplier</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5">
                        <div class="mb-4">
                            <label for="txtViewSupplier" class="form-label">Name<span class="required"
                                    style="color:red">*</span></label>
                            <input type="text" class="form-control" id="txtViewSupplier" name="txtViewSupplier"
                                placeholder="Enter Supplier Name" maxlength="40" disabled>
                            <div class="invalid-feedback supplier-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtViewPhoneNumber" class="form-label">Phone Number<span class="required"
                                    style="color:red">*</span></label>
                            <input type="text" class="form-control" id="txtViewPhoneNumber" name="txtViewPhoneNumber"
                                placeholder="Enter Supplier Number" maxlength="11" disabled>
                            <div class="invalid-feedback supplier-phone-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtViewEmail" class="form-label">Email Address<span class="required"
                                    style="color:red">*</span></label>
                            <input type="email" class="form-control" id="txtViewEmail" name="txtViewEmail"
                                placeholder="Enter Supplier Email" disabled>
                            <div class="invalid-feedback supplier-email-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="restoreAllModalSupplier" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Selected Suppliers</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnAllSupplierId" id="hdnAllSupplierId" />
                    <p>Do you want to restore the selected suppliers?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnRestoreAllSupplier">Yes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteAllModalSupplier" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Selected Suppliers</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="hdnAllSupplierIdDelete" id="hdnAllSupplierIdDelete" />
                    <p>Do you want to delete the selected suppliers?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnDeleteAllSupplier">Yes</button>
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


    <div class="modal fade" id="restoreAllModalProducts" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Selected Products</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnAllProductId" id="hdnAllProductId" />
                    <p>Do you want to restore the selected products?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnRestoreProducts">Yes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteAllModalProducts" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Selected Products</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnAllProductIdDelete" id="hdnAllProductIdDelete" />
                    <p>Do you want to delete the selected products?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnDeleteProducts">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="viewInventoryHistoryModal"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form>
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inventory History</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="container p-3">
                        <input type="hidden" class="form-control" id="txtHistoryInventoryIdStockOut"
                            name="txtHistoryInventoryIdStockOut">
                        <input type="hidden" class="form-control" id="txtHistoryProductIdStockOut"
                            name="txtHistoryProductIdStockOut">
                        <h4 class=" mt-3">Stock In History</h4> <!-- Add the title here -->
                        <div id="stockInTableContainer" class="border p-2 rounded">
                            <table id="stockInTableHistory" class="display" style="width:100%"></table>
                        </div>
                        <h4 class="mt-3">Stock Out History</h4> <!-- Add the title here -->
                        <div id="stockOutTableContainer" class="border p-2 rounded">
                            <table id="stockOutTableHistory" class="display" style="width:100%"></table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="restoreAllModalInventory" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Selected Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnAllInventoryId" id="hdnAllInventoryId" />
                    <p>Do you want to restore the selected item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnArchiveAllInventory">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAllModalInventory" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Selected Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnAllInventoryIdDelete" id="hdnAllInventoryIdDelete" />
                    <p>Do you want to delete the selected item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnDeleteAllInventory">Yes</button>
                </div>
            </div>
        </div>
    </div>




    <footer class="main-footer">

        <div class="float-right d-none d-sm-inline-block">

        </div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark">

    </aside>


    <script src="archive.js"></script>


</div>




<?php include("shared/dashboard/footer-dashboard.php"); ?>
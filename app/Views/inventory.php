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
                                    <?php if ($permissionChecker->hasPermission('orderListAdd', 'Add Order')): ?>
                                        <button class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#inventoryModal" id="btnCreateInv"><i
                                                class="fa-solid fa-person-circle-plus me-2"></i>Add Product</button>
                                    <?php endif; ?>

                                    <?php if ($permissionChecker->hasPermission('orderListArchive', 'Archive Order')): ?>
                                        <button class="archiveAllData btn btn-danger flex-end" id="btnArchiveAll"
                                            data-bs-toggle="modal" data-bs-target="#archiveAllModal" disabled><i
                                                class="fa-solid fa-person-circle-minus me-2"></i>Archive
                                            Selected</button>
                                    <?php endif; ?>
                                </div>
                                <div class="border p-2 rounded">
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
                                                <th class="text-center">Available</th>
                                                <th class="text-center">Total Quantity</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($result as $row) {
                                                ?>
                                                <tr id="<?php echo $row->inventoryId ?>">
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
                                                        <?php echo $row->totalStockIn ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->totalQuantity ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button title="Stock In" class="btn btn-outline-success btnStockIn"
                                                            data-bs-toggle="modal" data-id="<?php echo $row->inventoryId ?>"
                                                            product-id="<?php echo $row->productId ?>"
                                                            data-bs-target="#inventoryModalStockIn" id="btnStockIn">
                                                            <i class="fas fa-boxes"></i>
                                                        </button>
                                                        <button title="Stock Out" class="btn btn-outline-danger btnStockOut"
                                                            data-bs-toggle="modal" data-id="<?php echo $row->inventoryId ?>"
                                                            product-id="<?php echo $row->productId ?>"
                                                            data-bs-target="#inventoryModalStockOut" id="btnStockOut">
                                                            <i class="fas fa-box-open"></i>
                                                        </button>
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





    <footer class="main-footer">

        <div class="float-right d-none d-sm-inline-block">

        </div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark">

    </aside>


    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="inventoryModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formInventory">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add to Inventory</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5">
                        <div class="mb-4">
                            <label for="txtProductInventory">Product Name<span class="required"
                                    style="color:red">*</span></label>
                            <select class="form-select" name="txtProductInventory" id="txtProductInventory"
                                aria-label="Product">
                                <?php foreach ($product as $product): ?>
                                    <option value="<?php echo $product->productId; ?>"><?php echo $product->productName; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback inventory-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtSupplierInventory">Supplier<span class="required"
                                    style="color:red">*</span></label>
                            <select class="form-select" name="txtSupplierInventory" id="txtSupplierInventory"
                                aria-label="Supplier">
                                <?php foreach ($supplier as $supplier): ?>
                                    <option value="<?php echo $supplier->supplierId; ?>"><?php echo $supplier->supplierName; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback inventory-supplier-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtProductQuantity" class="form-label">Quantity<span class="required"
                                    style="color:red">*</span></label>
                            <input type="text" class="form-control" id="txtProductQuantity" name="txtProductQuantity"
                                placeholder="Enter Quantity" maxlength="5" required>
                            <div class="invalid-feedback inventory-quantity-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtExpirationDate" class="form-label expiration-date-label">Expiration Date<span
                                    class="required" style="color:red">*</span></label>
                            <input type="date" class="form-control will-expire-input" name="txtExpirationDate"
                                id="txtExpirationDate" placeholder="Expiration Date">
                            <div class="invalid-feedback inventory-expiration-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnAddToInventory">Add to Inventory</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="inventoryModalStockIn" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formInventoryStockIn">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Stock In</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <input type="hidden" class="form-control" id="txtInventoryId" name="txtInventoryId">
                    <input type="hidden" class="form-control" id="txtProductId" name="txtProductId">
                    <div class="modal-body px-5">
                        <div class="mb-4">
                            <label for="txtSupplierInventoryStockIn">Supplier<span class="required"
                                    style="color:red">*</span></label>
                            <select class="form-select" name="txtSupplierInventoryStockIn"
                                id="txtSupplierInventoryStockIn" aria-label="Supplier">
                                <?php foreach ($supplierStockIn as $supplierStockIn): ?>
                                    <option value="<?php echo $supplierStockIn->supplierId; ?>"><?php echo $supplierStockIn->supplierName; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback inventory-supplier-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtProductQuantityStockIn" class="form-label">Quantity<span class="required"
                                    style="color:red">*</span></label>
                            <input type="text" class="form-control" id="txtProductQuantityStockIn"
                                name="txtProductQuantityStockIn" placeholder="Enter Quantity" maxlength="5" required>
                            <div class="invalid-feedback inventory-quantity-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtExpirationDateStockIn" class="form-label expiration-date-label">Expiration
                                Date<span class="required" style="color:red">*</span></label>
                            <input type="date" class="form-control will-expire-input" name="txtExpirationDateStockIn"
                                id="txtExpirationDateStockIn" placeholder="Expiration Date">
                            <div class="invalid-feedback inventory-expiration-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnAddToInventoryStockIn">Stock In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="inventoryModalStockOut" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formInventoryStockOut">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Stock Out</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <input type="hidden" class="form-control" id="txtInventoryIdStockOut" name="txtInventoryIdStockOut">
                    <input type="hidden" class="form-control" id="txtProductIdStockOut" name="txtProductIdStockOut">
                    <div class="modal-body px-5">
                        <div class="mb-4">
                            <label for="txtProductQuantityStockOut" class="form-label">Quantity<span class="required"
                                    style="color:red">*</span></label>
                            <input type="text" class="form-control" id="txtProductQuantityStockOut"
                                name="txtProductQuantityStockOut" placeholder="Enter Quantity" maxlength="5" required>
                            <div class="invalid-feedback inventory-quantity-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtReasonStockOut">Reason<span class="required"
                                    style="color:red">*</span></label>
                            <select class="form-select" name="txtReasonStockOut" id="txtReasonStockOut"
                                aria-label="Supplier">
                                <option value="Damaged">Damaged</option>
                                <option value="Lost">Lost</option>
                                <option value="Expired">Expired</option>
                                <option value="Oversupply">Oversupply</option>
                            </select>
                            <div class="invalid-feedback inventory-reason-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnAddToInventoryStockOut">Stock Out</button>
                    </div>
                </div>
            </form>
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

    <div class="modal fade" id="archiveAllModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Archive Selected Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="hdnAllInventoryId" id="hdnAllInventoryId" />
                    <p>Do you want to archive the selected item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnArchiveAll">Yes</button>
                </div>
            </div>
        </div>
    </div>




</div>
</div>

<script src="inventory.js"></script>

<?php include("shared/dashboard/footer-dashboard.php"); ?>
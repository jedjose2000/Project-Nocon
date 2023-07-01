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


<script>
    $(document).ready(function () {
        $('#inventoryTable').DataTable({
            "columnDefs": [
                // { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 9 }
            ],
            order: [[1, 'asc']]
        });


        var table = $('#inventoryTable').DataTable();
        if (table.rows().count() === 0) {
            $('#selectAll').prop('checked', false).prop('disabled', true);
        } else {
            $('#selectAll').prop('disabled', false);
        }
        window.localStorage.setItem('show_popup_update', 'false');
        window.localStorage.setItem('show_popup_add', 'false');
        window.localStorage.setItem('show_popup_failed', 'false');


        $('#inventoryModal').on('hidden.bs.modal', function () {
            $('#formInventory')[0].reset(); // Reset the form fields
            $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
            $('.invalid-feedback').html(''); // Clear the error messages
        });

        $('#inventoryModalStockIn').on('hidden.bs.modal', function () {
            $('#formInventoryStockIn')[0].reset(); // Reset the form fields
            $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
            $('.invalid-feedback').html(''); // Clear the error messages
        });

        $('#inventoryModalStockOut').on('hidden.bs.modal', function () {
            $('#formInventoryStockOut')[0].reset(); // Reset the form fields
            $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
            $('.invalid-feedback').html(''); // Clear the error messages
        });

    });

    $('#inventoryTable tbody').on('change', 'input[type="checkbox"]', function () {
        var isChecked = $('input[type="checkbox"]:checked', '#inventoryTable tbody').length > 0;
        if (isChecked) {
            $('#btnArchiveAll').prop('disabled', false);
        } else {
            $('#btnArchiveAll').prop('disabled', true);
        }
        // check or uncheck the header checkbox based on the state of the row checkboxes
        $('#selectAll').prop('checked', $('input[type="checkbox"]', '#inventoryTable tbody').length === $('input[type="checkbox"]:checked', '#inventoryTable tbody').length);

    });

    $('#selectAll').on('change', function () {
        var isChecked = $(this).is(':checked');
        var table = $('#inventoryTable').DataTable();
        $('#btnArchiveAll').prop('disabled', !isChecked);
        // check or uncheck all row checkboxes based on the state of the header checkbox
        table.rows().every(function () {
            var rowNode = this.node();
            $('input[type="checkbox"]', rowNode).prop('checked', isChecked);
        });
    });


    $(document).on('click', '.archiveAllData', function () {
        var checkboxes = $(".data_checkbox:checked");
        if (checkboxes.length > 0) {
            var inventoryId = [];
            checkboxes.each(function () {
                inventoryId.push($(this).val());
            })
            var inventoryIdString = JSON.stringify(inventoryId);
            $('#hdnAllInventoryId').val(inventoryIdString);
        }
    })

    $(document).on('click', '.btnArchiveAll', function () {
        var inventoryIdString = $('#hdnAllInventoryId').val();
        if (inventoryIdString === "") {
            alertify.error('Please select rows to archive!');
            return;
        }
        var inventoryId = JSON.parse(inventoryIdString);
        var checkboxes = $(".data_checkbox:checked");
        $.ajax({
            url: '/archiveAllInventory',
            type: 'POST',
            data: { inventoryId },
            success: function (data) {
                checkboxes.each(function () {
                    var row = $(this).closest('tr');
                    var table = $('#inventoryTable').DataTable();
                    table.row(row).remove().draw(false);
                });
                $('#btnArchiveAll').prop('disabled', true);
                alertify.success('Items Archived Successfully');
                var isChecked = $('input[type="checkbox"]:checked', '#inventoryTable tbody').length > 0;
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













    $(document).ready(function () {
        $('#txtProductInventory').change(function () {
            var productId = $(this).val();

            $.ajax({
                url: '/checkIfWillExpire',
                type: 'POST',
                data: { productId: productId },
                dataType: 'json',
                success: function (response) {
                    if (response.willExpire === '1') {
                        $('.will-expire-input').show();
                        $('.expiration-date-label').show();
                    } else {
                        $('.will-expire-input').hide();
                        $('.expiration-date-label').hide();
                    }
                },
                error: function () {
                    console.log('Error occurred while fetching willExpire value.');
                }
            });
        });
    });

    if (window.localStorage.getItem('show_popup_update') == 'true') {
        alertify.success('Inventory Updated');
        window.localStorage.setItem('show_popup_update', 'false');
    }

    if (window.localStorage.getItem('show_popup_add') == 'true') {
        alertify.success('Inventory Added');
        window.localStorage.setItem('show_popup_add', 'false');
    }

    if (window.localStorage.getItem('show_popup_failed') == 'true') {
        alertify.error('Error');
        window.localStorage.setItem('show_popup_failed', 'false');
    }




    $("#formInventory").validate({
        rules: {
            txtProductInventory: {
                required: true,
            },
            txtProductQuantity: {
                required: true,
            },
            txtExpirationDate: {
                required: true,
            },
            txtSupplierInventory: {
                required: true
            }
        },
        messages: {
            txtProductInventory: {
                required: "Please enter a product.",
            },
            txtProductQuantity: {
                required: "Please enter a product quantity.",
            },
            txtExpirationDate: {
                required: "Please enter an expiration date.",
            },
            txtSupplierInventory: {
                required: "Please enter a supplier.",
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "txtProductInventory") {
                $(".inventory-error").html(error);
                $(".inventory-error");
            } else if (element.attr("name") === "txtProductQuantity") {
                $(".inventory-quantity-error").html(error);
                $(".inventory-quantity-error");
            }
            else if (element.attr("name") === "txtExpirationDate") {
                $(".inventory-expiration-error").html(error);
                $(".inventory-expiration-error");
            }
            else if (element.attr("name") === "txtSupplierInventory") {
                $(".inventory-supplier-error").html(error);
                $(".inventory-supplier-error");
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
            var productId = $('#txtProductInventory').val();
            var quantity = $('#txtProductQuantity').val();
            var expirationDate = $('#txtExpirationDate').val();
            var supplierId = $('#txtSupplierInventory').val();
            $.ajax({
                url: '/insertDataInventory',
                type: 'POST',
                data: { productId: productId, quantity: quantity, expirationDate: expirationDate, supplierId: supplierId },
                success: function (data) {
                    console.log(data);
                    if (data === 'Transaction success.') {
                        window.localStorage.setItem('show_popup_add', 'true');
                        window.location.reload();
                    } else {
                        window.localStorage.setItem('show_popup_failed', 'true');
                        window.location.reload();
                    }
                    // Handle the success response and perform necessary actions

                    $('#inventoryModal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    // Handle the error response and perform necessary actions
                }
            });
        }
    });

    document.getElementById("txtProductQuantity").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[0-9]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });


    $('body').on('click', '.btnStockIn', function () {
        var inventoryId = $(this).attr('data-id');
        var productId = $(this).attr('product-id');
        $('#inventoryModalStockIn #txtInventoryId').val(inventoryId);
        $('#inventoryModalStockIn #txtProductId').val(productId);
        $.ajax({
            url: 'view-stockIn/' + productId,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                let result = res.find(product => product.productId == productId);
                if (result.willExpire === '1') {
                    $('.will-expire-input').show();
                    $('.expiration-date-label').show();
                } else {
                    $('.will-expire-input').hide();
                    $('.expiration-date-label').hide();
                }
            },
            error: function (data) {
            }
        });
    });


    $("#formInventoryStockIn").validate({
        rules: {
            txtProductQuantityStockIn: {
                required: true,
            },
            txtExpirationDateStockIn: {
                required: true,
            },
            txtSupplierInventoryStockIn: {
                required: true
            }
        },
        messages: {
            txtProductQuantityStockIn: {
                required: "Please enter a product quantity.",
            },
            txtExpirationDateStockIn: {
                required: "Please enter an expiration date.",
            },
            txtSupplierInventoryStockIn: {
                required: "Please enter a supplier.",
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "txtProductQuantityStockIn") {
                $(".inventory-quantity-error").html(error);
                $(".inventory-quantity-error");
            }
            else if (element.attr("name") === "txtExpirationDateStockIn") {
                $(".inventory-expiration-error").html(error);
                $(".inventory-expiration-error");
            }
            else if (element.attr("name") === "txtSupplierInventoryStockIn") {
                $(".inventory-supplier-error").html(error);
                $(".inventory-supplier-error");
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
            var inventoryId = $('#txtInventoryId').val();
            var productId = $('#txtProductId').val();
            var quantity = $('#txtProductQuantityStockIn').val();
            var expirationDate = $('#txtExpirationDateStockIn').val();
            var supplierId = $('#txtSupplierInventoryStockIn').val();
            $.ajax({
                url: '/stockIn',
                type: 'POST',
                data: { productId: productId, quantity: quantity, expirationDate: expirationDate, supplierId: supplierId, inventoryId: inventoryId },
                success: function (data) {
                    console.log(data);
                    if (data === 'Transaction success.') {
                        window.localStorage.setItem('show_popup_add', 'true');
                        window.location.reload();
                    } else {
                        window.localStorage.setItem('show_popup_failed', 'true');
                        window.location.reload();
                    }
                    // Handle the success response and perform necessary actions
                    $('#inventoryModalStockIn').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    // Handle the error response and perform necessary actions
                }
            });
        }
    });





    $('body').on('click', '.btnStockOut', function () {
        var inventoryId = $(this).attr('data-id');
        var productId = $(this).attr('product-id');
        $('#inventoryModalStockOut #txtInventoryIdStockOut').val(inventoryId);
        $('#inventoryModalStockOut #txtProductIdStockOut').val(productId);
    });




    $("#formInventoryStockOut").validate({
        rules: {
            txtProductQuantityStockOut: {
                required: true,
                remote: {
                    url: "checkIfStockIsSufficient",
                    type: "post",
                    data: {
                        txtProductQuantityStockOut: function () {
                            return $("#txtProductQuantityStockOut").val();
                        },
                        txtProductIdStockOut: function () {
                            return $("#txtProductIdStockOut").val();
                        }
                    }
                },
            },
            txtReasonStockOut: {
                required: true,
            },
        },
        messages: {
            txtProductQuantityStockOut: {
                required: "Please enter a product quantity.",
                remote: "Quantity must not be greater than the available stocks"
            },
            txtReasonStockOut: {
                required: "Please enter an expiration date.",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "txtProductQuantityStockOut") {
                $(".inventory-quantity-error").html(error);
                $(".inventory-quantity-error");
            }
            else if (element.attr("name") === "txtReasonStockOut") {
                $(".inventory-expiration-error").html(error);
                $(".inventory-reason-error");
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
            var reason = $('#txtReasonStockOut').val();
            var inventoryId = $('#txtInventoryIdStockOut').val();
            var productId = $('#txtProductIdStockOut').val();
            var quantity = $('#txtProductQuantityStockOut').val();
            var expirationDate = $('#txtProductQuantityStockOut').val();
            var supplierId = $('#txtSupplierInventoryStockIn').val();
            $.ajax({
                url: '/stockOut',
                type: 'POST',
                data: { productId: productId, quantity: quantity, expirationDate: expirationDate, supplierId: supplierId, inventoryId: inventoryId, reason: reason },
                success: function (data) {
                    console.log(data);
                    if (data === 'Transaction success.') {
                        window.localStorage.setItem('show_popup_add', 'true');
                        window.location.reload();
                    } else {
                        window.localStorage.setItem('show_popup_failed', 'true');
                        window.location.reload();
                    }
                    // Handle the success response and perform necessary actions
                    $('#inventoryModalStockOut').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    // Handle the error response and perform necessary actions
                }
            });
        }
    });


    $('body').on('click', '.btnViewHistory', function () {
        var inventoryId = $(this).attr('data-id');
        var productId = $(this).attr('product-id');
        $('#viewInventoryHistoryModal #txtHistoryInventoryIdStockOut').val(inventoryId);
        $('#viewInventoryHistoryModal #txtHistoryProductIdStockOut').val(productId);
        $.ajax({
            url: 'view-stockInHistory',
            type: "GET",
            dataType: 'json',
            data: { productId: productId },
            success: function (res) {
                document.getElementById('stockInTableContainer').innerHTML = "";
                document.getElementById('stockInTableContainer').innerHTML = `<table id="stockInTableHistory" class="display" style="width:100%"></table>`;

                document.getElementById('stockOutTableContainer').innerHTML = "";
                document.getElementById('stockOutTableContainer').innerHTML = `<table id="stockOutTableHistory" class="display" style="width:100%"></table>`;





                let stockInDataSet = [];
                res.resultStockIn.forEach(element => {
                    let stockInDate = new Date(element.stockInDate).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                    let expirationDate = element.stockInExpirationDate !== '0000-00-00' ? new Date(element.stockInExpirationDate).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : 'Non-Perishable';
                    stockInDataSet.push([
                        element.numberOfStockIn,
                        stockInDate,
                        expirationDate,
                    ]);
                });

                const stockInTable = $('#stockInTableHistory').DataTable({
                    data: stockInDataSet,
                    columns: [
                        { title: 'Number of Stock In' },
                        { title: 'Stock In Date' },
                        { title: 'Stock In Expiration Date' },
                    ],
                    columnDefs: [
                        {
                            targets: [0, 1, 2], // the first column
                            className: 'text-center', // the CSS class to apply
                        },
                    ],
                    order: [[0, 'desc']]
                });




                let stockOutDataSet = [];
                res.resultStockOut.forEach(element => {
                    let stockOutDate = new Date(element.stockOutDate).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                    stockOutDataSet.push([
                        element.stockOutQuantity,
                        stockOutDate,
                        element.reason,
                    ]);
                });

                const stockOutTable = $('#stockOutTableHistory').DataTable({
                    data: stockOutDataSet,
                    columns: [
                        { title: 'Number of Stock Out' },
                        { title: 'Stock Out Date' },
                        { title: 'Reason' },
                    ],
                    columnDefs: [
                        {
                            targets: [0, 1, 2], // the first column
                            className: 'text-center', // the CSS class to apply
                        },
                    ],
                    order: [[0, 'desc']]
                });




            },
            error: function (data) {
            }
        });
    });




</script>

<?php include("shared/dashboard/footer-dashboard.php"); ?>
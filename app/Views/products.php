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
                                            data-bs-target="#productModal" id="btnCreateCat"><i
                                                class="fa-solid fa-person-circle-plus me-2"></i>Create Product</button>
                                    <?php endif; ?>

                                    <?php if ($permissionChecker->hasPermission('orderListArchive', 'Archive Order')): ?>
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
                                                        <?php echo $row->buyPrice ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->sellPrice ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if (
                                                            $permissionChecker->hasPermission('orderListUpdate', 'Update Order')
                                                            && $permissionChecker->hasPermission('orderListArchive', 'Archive Order')
                                                        ): ?>
                                                            <button title="Update Category"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#categoryModalUpdate" id="btnUpdateCategory">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                            <button class="btn btn-outline-danger btnArchiveCategory"
                                                                title="Archive Category" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#archiveCategoryModal">
                                                                <i class="fa-solid fa-archive"></i>
                                                            </button>
                                                        <?php elseif ($permissionChecker->hasPermission('orderListUpdate', 'Update Order')): ?>
                                                            <button title="Update Category"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#categoryModalUpdate" id="btnUpdateCategory">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                        <?php elseif ($permissionChecker->hasPermission('orderListArchive', 'Archive Order')): ?>
                                                            <button class="btn btn-outline-danger btnArchiveCategory"
                                                                title="Archive Category" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#archiveCategoryModal">
                                                                <i class="fa-solid fa-archive"></i>
                                                            </button>
                                                        <?php else: ?>
                                                            <button title="View Category"
                                                                class="btn btn-outline-primary btnView" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->productId ?>"
                                                                data-bs-target="#categoryModalView" id="btnViewCategory">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
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
        alertify.success('Category Updated');
        window.localStorage.setItem('show_popup_update', 'false');
    }

    if (window.localStorage.getItem('show_popup_add') == 'true') {
        alertify.success('Category Added');
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
            console.log(willExpire);
            // $.ajax({
            //     url: '/addCategory',
            //     type: 'POST',
            //     data: { categoryName: categoryName, categoryDescription: categoryDescription },
            //     success: function (data) {
            //         if (data === 'Transaction success.') {
            //             window.localStorage.setItem('show_popup_add', 'true');
            //             window.location.reload();
            //         } else {
            //             window.localStorage.setItem('show_popup_failed', 'true');
            //             window.location.reload();
            //         }
            //         // Handle the success response and perform necessary actions

            //         $('#categoryModal').modal('hide');
            //         $('body').removeClass('modal-open');
            //         $('.modal-backdrop').remove();
            //     },
            //     error: function (xhr, status, error) {
            //         console.log(xhr.responseText);
            //         // Handle the error response and perform necessary actions
            //     }
            // });
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
</script>



<?php include("shared/dashboard/footer-dashboard.php"); ?>
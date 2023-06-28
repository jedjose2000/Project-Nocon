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
                                    <?php if ($permissionChecker->hasPermission('supplierListAdd', 'Add Supplier')): ?>
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal"
                                            id="btnCreate"><i class="fa-solid fa-person-circle-plus me-2"></i>Create
                                            Supplier</button>
                                    <?php endif; ?>

                                    <?php if ($permissionChecker->hasPermission('supplierListArchive', 'Archive Supplier')): ?>
                                        <button class="archiveAllData btn btn-danger flex-end" id="btnArchiveAll"
                                            data-bs-toggle="modal" data-bs-target="#archiveAllModal" disabled><i
                                                class="fa-solid fa-person-circle-minus me-2"></i>Archive
                                            Selected</button>
                                    <?php endif; ?>
                                </div>
                                <div class="border p-2 rounded">
                                    <table id="supplierTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-orderable="false">
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="selectAll">
                                                        <label for="selectAll"></label>
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
                                            foreach ($result as $row) {
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
                                                        <?php if (
                                                            $permissionChecker->hasPermission('supplierListUpdate', 'Update Supplier')
                                                            && $permissionChecker->hasPermission('supplierListArchive', 'Archive Supplier')
                                                        ): ?>
                                                            <button title="Update Supplier"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->supplierId ?>"
                                                                data-bs-target="#supplierModalUpdate" id="btnUpdateSupplier">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                            <button class="btn btn-outline-danger btnArchiveSupplier"
                                                                title="Archive Supplier" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->supplierId ?>"
                                                                data-bs-target="#archiveSupplierModal">
                                                                <i class="fa-solid fa-archive"></i>
                                                            </button>
                                                        <?php elseif ($permissionChecker->hasPermission('supplierListUpdate', 'Update Supplier')): ?>
                                                            <button title="Update Supplier"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->supplierId ?>"
                                                                data-bs-target="#supplierModalUpdate" id="btnUpdateSupplier">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                        <?php elseif ($permissionChecker->hasPermission('supplierListArchive', 'Archive Supplier')): ?>
                                                            <button class="btn btn-outline-danger btnArchiveSupplier"
                                                                title="Archive Supplier" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->supplierId ?>"
                                                                data-bs-target="#archiveSupplierModal">
                                                                <i class="fa-solid fa-archive"></i>
                                                            </button>
                                                        <?php else: ?>
                                                            <button title="View Supplier"
                                                                class="btn btn-outline-primary btnView" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->supplierId ?>"
                                                                data-bs-target="#supplierModalView" id="btnViewSupplier">
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



        <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="createModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formSupplier">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Supplier</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-5">
                            <div class="mb-4">
                                <label for="txtSupplier" class="form-label">Name</label>
                                <input type="text" class="form-control" id="txtSupplier" name="txtSupplier"
                                    placeholder="Enter Supplier Name" maxlength="40" required>
                                <div class="invalid-feedback supplier-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtPhoneNumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="txtPhoneNumber" name="txtPhoneNumber"
                                    placeholder="Enter Supplier Number" maxlength="11" required>
                                <div class="invalid-feedback supplier-phone-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="txtEmail" name="txtEmail"
                                    placeholder="Enter Supplier Email" required>
                                <div class="invalid-feedback supplier-email-error"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btnAddSupplier">Add Supplier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="supplierModalUpdate"
            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formUpdateSupplier">
                    <div class="modal-content">
                        <input type="hidden" class="form-control" id="txtUpdateSupplierId" name="txtUpdateSupplierId">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Supplier</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-5">
                            <div class="mb-4">
                                <label for="txtUpdateSupplier" class="form-label">Name</label>
                                <input type="text" class="form-control" id="txtUpdateSupplier" name="txtUpdateSupplier"
                                    placeholder="Enter Supplier Name" maxlength="40" required>
                                <div class="invalid-feedback supplier-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtUpdatePhoneNumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="txtUpdatePhoneNumber"
                                    name="txtUpdatePhoneNumber" placeholder="Enter Supplier Number" maxlength="11"
                                    required>
                                <div class="invalid-feedback supplier-phone-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtUpdateEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="txtUpdateEmail" name="txtUpdateEmail"
                                    placeholder="Enter Supplier Email" required>
                                <div class="invalid-feedback supplier-email-error"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btnUpdateSupplier">Add Supplier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="archiveAllModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Archive Selected Suppliers</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="hdnAllCategoryId" id="hdnAllCategoryId" />
                        <p>Do you want to restore the selected supplier?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary btnArchiveAll">Yes</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="archiveSupplierModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Archive Supplier</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="hdnId" id="hdnId" />
                        <p>Do you want to archive the selected supplier?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary btnConfirmArchiveSupplier">Yes</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="supplierModalView"
            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <label for="txtViewSupplier" class="form-label">Name</label>
                                <input type="text" class="form-control" id="txtViewSupplier" name="txtViewSupplier"
                                    placeholder="Enter Supplier Name" maxlength="40" disabled>
                                <div class="invalid-feedback supplier-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtViewPhoneNumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="txtViewPhoneNumber"
                                    name="txtViewPhoneNumber" placeholder="Enter Supplier Number" maxlength="11"
                                    disabled>
                                <div class="invalid-feedback supplier-phone-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtViewEmail" class="form-label">Email Address</label>
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

</div>

<script>
    $(document).ready(function () {
        $('#supplierTable').DataTable({
            "columnDefs": [
                // { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 4 }
            ],
            order: [[1, 'asc']]
        });

        $('#supplierModalUpdate').on('hidden.bs.modal', function () {
            $('#formCategoryUpdate')[0].reset(); // Reset the form fields
            $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
            $('.invalid-feedback').html(''); // Clear the error messages
        });

        $('#createModal').on('hidden.bs.modal', function () {
            $('#formCategory')[0].reset(); // Reset the form fields
            $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
            $('.invalid-feedback').html(''); // Clear the error messages
        });


        var table = $('#supplierTable').DataTable();
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

    $.validator.addMethod('cellphonePH', function (value) {
        return /^09\d{9}$/.test(value);
    }, 'Please enter a valid cellphone number in the Philippine format (e.g., 09123456789)');


    if (window.localStorage.getItem('show_popup_update') == 'true') {
        alertify.success('Supplier Updated');
        window.localStorage.setItem('show_popup_update', 'false');
    }

    if (window.localStorage.getItem('show_popup_add') == 'true') {
        alertify.success('Supplier Added');
        window.localStorage.setItem('show_popup_add', 'false');
    }

    if (window.localStorage.getItem('show_popup_failed') == 'true') {
        alertify.error('Error');
        window.localStorage.setItem('show_popup_failed', 'false');
    }


    $("#formSupplier").validate({
        rules: {
            txtSupplier: {
                required: true,
                noSpace: true,
                remote: {
                    url: "checkSupplierNameExists",
                    type: "post",
                    data: {
                        txtSupplier: function () {
                            return $("#txtSupplier").val();
                        }
                    }
                },
            },
            txtPhoneNumber: {
                required: true,
                noSpace: true,
                cellphonePH: true
            },
            txtEmail: {
                required: true,
                noSpace: true,
            }
        },
        messages: {
            txtSupplier: {
                required: "Please enter a supplier name.",
                remote: "Supplier name already exists!",
                noSpace: "Please enter a supplier name.",
            },
            txtPhoneNumber: {
                required: "Please enter a phone number.",
                noSpace: "Please enter a phone number.",
                cellphonePH: "Please enter a valid cellphone number in the Philippine format (e.g., 09123456789)",
            },
            txtEmail: {
                required: "Please enter a valid email.",
                noSpace: "Please enter a valid email.",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "txtSupplier") {
                $(".supplier-error").html(error); // Set the error message inside the category-error element
                $(".supplier-error"); // Show the error message
            } else if (element.attr("name") === "txtPhoneNumber") {
                $(".supplier-phone-error").html(error); // Set the error message inside the category-description-error element
                $(".supplier-phone-error"); // Show the error message
            }
            else if (element.attr("name") === "txtEmail") {
                $(".supplier-email-error").html(error); // Set the error message inside the category-description-error element
                $(".supplier-email-error"); // Show the error message
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
            $(element).siblings(".error").empty(); // Remove the error message when unhighlighting the element
        },
        success: function (label) {
            label.removeClass("error"); // Remove the "error" class from the label
        },
        submitHandler: function (form) {
            var supplierName = $('#txtSupplier').val();
            var phoneNumber = $('#txtPhoneNumber').val();
            var emailAddress = $('#txtEmail').val();
            $.ajax({
                url: '/insertSupplier',
                type: 'POST',
                data: { supplierName: supplierName, phoneNumber: phoneNumber, emailAddress: emailAddress },
                success: function (data) {
                    if (data === 'Transaction success.') {
                        window.localStorage.setItem('show_popup_add', 'true');
                        window.location.reload();
                    } else {
                        window.localStorage.setItem('show_popup_failed', 'true');
                        window.location.reload();
                    }
                    // Handle the success response and perform necessary actions

                    $('#supplierModal').modal('hide');
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


    $('body').on('click', '.btnUpdate', function () {
        var supplierId = $(this).attr('data-id');
        $('#supplierModalUpdate #txtUpdateSupplierId').val(supplierId);
        $.ajax({
            url: 'view-supplier/' + supplierId,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                let result = res.find(supplier => supplier.supplierId == supplierId);
                $('#supplierModalUpdate #txtUpdateSupplier').val(result.supplierName);
                $('#supplierModalUpdate #txtUpdatePhoneNumber').val(result.phoneNumber);
                $('#supplierModalUpdate #txtUpdateEmail').val(result.emailAddress);
            },
            error: function (data) {
            }
        });
    });


    $('body').on('click', '.btnView', function () {
        var supplierId = $(this).attr('data-id');
        $('#supplierModalView #txtViewSupplierId').val(supplierId);
        $.ajax({
            url: 'view-supplier/' + supplierId,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                let result = res.find(supplier => supplier.supplierId == supplierId);
                $('#supplierModalView #txtViewSupplier').val(result.supplierName);
                $('#supplierModalView #txtViewPhoneNumber').val(result.phoneNumber);
                $('#supplierModalView #txtViewEmail').val(result.emailAddress);
            },
            error: function (data) {
            }
        });
    });


    $("#formUpdateSupplier").validate({
        rules: {
            txtUpdateSupplier: {
                required: true,
                noSpace: true,
                remote: {
                    url: "checkUpdateSupplierNameExists",
                    type: "post",
                    data: {
                        txtUpdateSupplier: function () {
                            return $("#txtUpdateSupplier").val();
                        },
                        txtUpdateSupplierId: function () {
                            return $("#txtUpdateSupplierId").val();
                        }
                    }
                },
            },
            txtUpdatePhoneNumber: {
                required: true,
                noSpace: true,
                cellphonePH: true
            },
            txtUpdateEmail: {
                required: true,
                noSpace: true,
            }
        },
        messages: {
            txtUpdateSupplier: {
                required: "Please enter a supplier name.",
                remote: "Supplier name already exists!",
                noSpace: "Please enter a supplier name.",
            },
            txtUpdatePhoneNumber: {
                required: "Please enter a phone number.",
                noSpace: "Please enter a phone number.",
                cellphonePH: "Please enter a valid cellphone number in the Philippine format (e.g., 09123456789)",
            },
            txtUpdateEmail: {
                required: "Please enter a valid email.",
                noSpace: "Please enter a valid email.",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "txtUpdateSupplier") {
                $(".supplier-error").html(error); // Set the error message inside the category-error element
                $(".supplier-error"); // Show the error message
            } else if (element.attr("name") === "txtUpdatePhoneNumber") {
                $(".supplier-phone-error").html(error); // Set the error message inside the category-description-error element
                $(".supplier-phone-error"); // Show the error message
            }
            else if (element.attr("name") === "txtUpdateEmail") {
                $(".supplier-email-error").html(error); // Set the error message inside the category-description-error element
                $(".supplier-email-error"); // Show the error message
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
            $(element).siblings(".error").empty(); // Remove the error message when unhighlighting the element
        },
        success: function (label) {
            label.removeClass("error"); // Remove the "error" class from the label
        },
        submitHandler: function (form) {
            var supplierId = $('#txtUpdateSupplierId').val();
            var supplierName = $('#txtUpdateSupplier').val();
            var phoneNumber = $('#txtUpdatePhoneNumber').val();
            var emailAddress = $('#txtUpdateEmail').val();
            $.ajax({
                url: '/insertSupplier',
                type: 'POST',
                data: { supplierName: supplierName, phoneNumber: phoneNumber, emailAddress: emailAddress, supplierId: supplierId },
                success: function (data) {
                    if (data === 'Transaction success.') {
                        window.localStorage.setItem('show_popup_update', 'true');
                        window.location.reload();
                    } else {
                        window.localStorage.setItem('show_popup_failed', 'true');
                        window.location.reload();
                    }
                    // Handle the success response and perform necessary actions

                    $('#supplierModal').modal('hide');
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

    $('#supplierTable tbody').on('change', 'input[type="checkbox"]', function () {
        var isChecked = $('input[type="checkbox"]:checked', '#supplierTable tbody').length > 0;
        if (isChecked) {
            $('#btnArchiveAll').prop('disabled', false);
        } else {
            $('#btnArchiveAll').prop('disabled', true);
        }
        // check or uncheck the header checkbox based on the state of the row checkboxes
        $('#selectAll').prop('checked', $('input[type="checkbox"]', '#supplierTable tbody').length === $('input[type="checkbox"]:checked', '#supplierTable tbody').length);

    });

    $('#selectAll').on('change', function () {
        var isChecked = $(this).is(':checked');
        var table = $('#supplierTable').DataTable();
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
            var categoryId = [];
            checkboxes.each(function () {
                categoryId.push($(this).val());
            })
            var categoryIdString = JSON.stringify(categoryId);
            $('#hdnAllCategoryId').val(categoryIdString);
        }
    })


    $(document).on('click', '.btnArchiveAll', function () {
        var supplierIdString = $('#hdnAllCategoryId').val();


        if (supplierIdString === "") {
            alertify.error('Please select rows to archive!');
            return;
        }
        var supplierID = JSON.parse(supplierIdString);
        var checkboxes = $(".data_checkbox:checked");
        $.ajax({
            url: '/archiveAllSupplier',
            type: 'POST',
            data: { supplierID },
            success: function (data) {
                checkboxes.each(function () {
                    var row = $(this).closest('tr');
                    var table = $('#supplierTable').DataTable();
                    table.row(row).remove().draw(false);
                });
                $('#btnArchiveAll').prop('disabled', true);
                alertify.success('Suppliers Archived Successfully');
                var isChecked = $('input[type="checkbox"]:checked', '#supplierTable tbody').length > 0;
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







    document.getElementById("txtSupplier").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[a-zA-Z\s]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });

    document.getElementById("txtUpdateSupplier").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[a-zA-Z\s]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });


    document.getElementById("txtPhoneNumber").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[0-9]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });

    document.getElementById("txtUpdatePhoneNumber").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[0-9]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });

    $('body').on('click', '.btnArchiveSupplier', function () {
        var supplierId = $(this).attr('data-id');
        $('#archiveSupplierModal #hdnId').val(supplierId);
    });

    $('body').on('click', '.btnConfirmArchiveSupplier', function () {
        var supplierId = $("#hdnId").val();
        var table = $('#supplierTable').DataTable();
        $.ajax({
            url: '/getIDSupplier',
            type: 'POST',
            data: { supplierId },
            success: function (data) {
                console.log(data);
                table.row('#' + supplierId).remove().draw();
                // re-check the status of the checkboxes after the AJAX call
                var isChecked = $('input[type="checkbox"]:checked', '#supplierTable tbody').length > 0;
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
                alertify.success('Supplier Archived Successfully');
                table.page.len(table.page.len()).draw();
            }
        });
        $('#archiveSupplierModal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

</script>




<?php include("shared/dashboard/footer-dashboard.php"); ?>
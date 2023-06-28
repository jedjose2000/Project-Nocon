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
                                            data-bs-target="#categoryModal" id="btnCreateCat"><i
                                                class="fa-solid fa-person-circle-plus me-2"></i>Create Category</button>
                                    <?php endif; ?>

                                    <?php if ($permissionChecker->hasPermission('orderListArchive', 'Archive Order')): ?>
                                        <button class="archiveAllData btn btn-danger flex-end" id="btnArchiveAll"
                                            data-bs-toggle="modal" data-bs-target="#archiveAllModal" disabled><i
                                                class="fa-solid fa-person-circle-minus me-2"></i>Archive
                                            Selected</button>
                                    <?php endif; ?>
                                </div>
                                <div class="border p-2 rounded">
                                    <table id="categoryTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-orderable="false">
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="selectAll">
                                                        <label for="selectAll"></label>
                                                    </span>
                                                </th>
                                                <th class="text-center">Category Name</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($result as $row) {
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
                                                        <?php if (
                                                            $permissionChecker->hasPermission('orderListUpdate', 'Update Order')
                                                            && $permissionChecker->hasPermission('orderListArchive', 'Archive Order')
                                                        ): ?>
                                                            <button title="Update Category"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->categoryId ?>"
                                                                data-bs-target="#categoryModalUpdate" id="btnUpdateCategory">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                            <button class="btn btn-outline-danger btnArchiveCategory"
                                                                title="Archive Category" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->categoryId ?>"
                                                                data-bs-target="#archiveCategoryModal">
                                                                <i class="fa-solid fa-archive"></i>
                                                            </button>
                                                        <?php elseif ($permissionChecker->hasPermission('orderListUpdate', 'Update Order')): ?>
                                                            <button title="Update Category"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->categoryId ?>"
                                                                data-bs-target="#categoryModalUpdate" id="btnUpdateCategory">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                        <?php elseif ($permissionChecker->hasPermission('orderListArchive', 'Archive Order')): ?>
                                                            <button class="btn btn-outline-danger btnArchiveCategory"
                                                                title="Archive Category" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->categoryId ?>"
                                                                data-bs-target="#archiveCategoryModal">
                                                                <i class="fa-solid fa-archive"></i>
                                                            </button>
                                                        <?php else: ?>
                                                            <button title="View Category"
                                                                class="btn btn-outline-primary btnView" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->categoryId ?>"
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


    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="categoryModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formCategory">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5">
                        <div class="mb-4">
                            <label for="txtCategory" class="form-label">Name</label>
                            <input type="text" class="form-control" id="txtCategory" name="txtCategory"
                                placeholder="Enter Category Name" maxlength="40" required>
                            <div class="invalid-feedback category-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="txtDescription" name="txtDescription" rows="8"
                                placeholder="Enter Description Here" required></textarea>
                            <div class="invalid-feedback category-description-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnAddCategory">Add Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>





    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="categoryModalUpdate" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formCategoryUpdate">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <input type="hidden" class="form-control" id="txtUpdateCategoryId" name="txtUpdateCategoryId"
                        placeholder="Enter Category Name" maxlength="40">
                    <div class="modal-body px-5">
                        <div class="mb-4">
                            <label for="txtUpdateCategory" class="form-label">Name</label>
                            <input type="text" class="form-control" id="txtUpdateCategory" name="txtUpdateCategory"
                                placeholder="Enter Category Name" maxlength="40" required>
                            <div class="invalid-feedback category-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtUpdateDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="txtUpdateDescription" name="txtUpdateDescription"
                                rows="8" placeholder="Enter Description Here" required></textarea>
                            <div class="invalid-feedback category-description-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnUpdateCategory">Update Category</button>
                    </div>
                </div>
            </form>
        </div>
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
                            <label for="txtViewCategory" class="form-label">Name</label>
                            <input type="text" class="form-control" id="txtViewCategory" name="txtViewCategory"
                                placeholder="Enter Category Name" maxlength="40" disabled>
                            <div class="invalid-feedback category-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtViewDescription" class="form-label">Description</label>
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


    <div class="modal fade" id="archiveAllModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Archive Selected Categories</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnAllCategoryId" id="hdnAllCategoryId" />
                    <p>Do you want to restore the selected categories?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnArchiveAll">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="archiveCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Archive Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="hdnCategoryId" id="hdnCategoryId" />
                    <p>Do you want to archive the selected category?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnConfirmArchiveCategory">Yes</button>
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

</div>



<script>





    $(document).ready(function () {
        $('#categoryTable').DataTable({
            "columnDefs": [
                // { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 3 }
            ],
            order: [[1, 'asc']]
        });

        $('#categoryModalUpdate').on('hidden.bs.modal', function () {
            $('#formCategoryUpdate')[0].reset(); // Reset the form fields
            $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
            $('.invalid-feedback').html(''); // Clear the error messages
        });

        $('#categoryModal').on('hidden.bs.modal', function () {
            $('#formCategory')[0].reset(); // Reset the form fields
            $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
            $('.invalid-feedback').html(''); // Clear the error messages
        });

        var table = $('#categoryTable').DataTable();
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
        alertify.success('Position Updated');
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

    $('#categoryTable tbody').on('change', 'input[type="checkbox"]', function () {
        var isChecked = $('input[type="checkbox"]:checked', '#categoryTable tbody').length > 0;
        if (isChecked) {
            $('#btnArchiveAll').prop('disabled', false);
        } else {
            $('#btnArchiveAll').prop('disabled', true);
        }

        // check or uncheck the header checkbox based on the state of the row checkboxes
        $('#selectAll').prop('checked', $('input[type="checkbox"]', '#categoryTable tbody').length === $('input[type="checkbox"]:checked', '#categoryTable tbody').length);

    });

    $('#selectAll').on('change', function () {
        var isChecked = $(this).is(':checked');
        var table = $('#categoryTable').DataTable();
        $('#btnArchiveAll').prop('disabled', !isChecked);
        // check or uncheck all row checkboxes based on the state of the header checkbox
        table.rows().every(function () {
            var rowNode = this.node();
            $('input[type="checkbox"]', rowNode).prop('checked', isChecked);
        });
    });

    $("#formCategory").validate({
        rules: {
            txtCategory: {
                required: true,
                remote: {
                    url: "checkCategoryNameExists",
                    type: "post",
                    data: {
                        txtCategory: function () {
                            return $("#txtCategory").val();
                        }
                    }
                },
                noSpace: true,
            },
            txtDescription: {
                required: true,
                noSpace: true,
            },
        },
        messages: {
            txtCategory: {
                required: "Please enter a category name.",
                remote: "Category Name exists.",
                noSpace: "Please enter a category name.",
            },
            txtDescription: {
                required: "Please enter a description.",
                noSpace: "Please enter a description.",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "txtCategory") {
                $(".category-error").html(error); // Set the error message inside the category-error element
                $(".category-error"); // Show the error message
            } else if (element.attr("name") === "txtDescription") {
                $(".category-description-error").html(error); // Set the error message inside the category-description-error element
                $(".category-description-error"); // Show the error message
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
            // Form is valid, you can proceed with submitting the form via AJAX
            var categoryName = $('#txtCategory').val();
            var categoryDescription = $('#txtDescription').val();
            $.ajax({
                url: '/addCategory',
                type: 'POST',
                data: { categoryName: categoryName, categoryDescription: categoryDescription },
                success: function (data) {
                    if (data === 'Transaction success.') {
                        window.localStorage.setItem('show_popup_add', 'true');
                        window.location.reload();
                    } else {
                        window.localStorage.setItem('show_popup_failed', 'true');
                        window.location.reload();
                    }
                    // Handle the success response and perform necessary actions

                    $('#categoryModal').modal('hide');
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





    $("#formCategoryUpdate").validate({
        rules: {
            txtUpdateCategory: {
                required: true,
                remote: {
                    url: "checkUpdateCategoryNameExists",
                    type: "post",
                    data: {
                        txtUpdateCategory: function () {
                            return $("#txtUpdateCategory").val();
                        },
                        txtUpdateCategoryId: function () {
                            return $("#txtUpdateCategoryId").val();
                        }
                    }
                },
                noSpace: true,
            },
            txtUpdateDescription: {
                required: true,
                noSpace: true,
            },
        },
        messages: {
            txtUpdateCategory: {
                required: "Please enter a category name.",
                remote: "Category name already exists.",
                noSpace: "Please enter a category name.",
            },
            txtUpdateDescription: {
                required: "Please enter a description.",
                noSpace: "Please enter a category name.",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "txtUpdateCategory") {
                $(".category-error").html(error); // Set the error message inside the category-error element
                $(".category-error"); // Show the error message
            } else if (element.attr("name") === "txtUpdateDescription") {
                $(".category-description-error").html(error); // Set the error message inside the category-description-error element
                $(".category-description-error"); // Show the error message
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
            // Form is valid, you can proceed with submitting the form via AJAX
            var categoryId = $('#txtUpdateCategoryId').val();
            var categoryName = $('#txtUpdateCategory').val();
            var categoryDescription = $('#txtUpdateDescription').val();
            $.ajax({
                url: '/addCategory',
                type: 'POST',
                data: { categoryName: categoryName, categoryDescription: categoryDescription, categoryId: categoryId },
                success: function (data) {
                    if (data === 'Transaction success.') {
                        window.localStorage.setItem('show_popup_update', 'true');
                        window.location.reload();
                    } else {
                        window.localStorage.setItem('show_popup_failed', 'true');
                        window.location.reload();
                    }
                    // Handle the success response and perform necessary actions

                    $('#categoryModalUpdate').modal('hide');
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
        var categoryId = $(this).attr('data-id');
        $('#categoryModalUpdate #txtUpdateCategoryId').val(categoryId);
        $.ajax({
            url: 'view-category/' + categoryId,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                let result = res.find(category => category.categoryId == categoryId);
                $('#categoryModalUpdate #txtUpdateCategory').val(result.categoryName);
                $('#categoryModalUpdate #txtUpdateDescription').val(result.categoryDescription);
            },
            error: function (data) {
            }
        });
    });

    $('body').on('click', '.btnView', function () {
        var categoryId = $(this).attr('data-id');
        $('#categoryModalView #txtViewCategoryId').val(categoryId);
        $.ajax({
            url: 'view-category/' + categoryId,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                let result = res.find(category => category.categoryId == categoryId);
                $('#categoryModalView #txtViewCategory').val(result.categoryName);
                $('#categoryModalView #txtViewDescription').val(result.categoryDescription);
            },
            error: function (data) {
            }
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
        var categoryIdString = $('#hdnAllCategoryId').val();


        if (categoryIdString === "") {
            alertify.error('Please select rows to archive!');
            return;
        }
        var categoryID = JSON.parse(categoryIdString);
        var checkboxes = $(".data_checkbox:checked");
        $.ajax({
            url: '/archiveAllCategory',
            type: 'POST',
            data: { categoryID },
            success: function (data) {
                checkboxes.each(function () {
                    var row = $(this).closest('tr');
                    var table = $('#categoryTable').DataTable();
                    table.row(row).remove().draw(false);
                });
                $('#btnArchiveAll').prop('disabled', true);
                alertify.success('Categories Archived Successfully');
                var isChecked = $('input[type="checkbox"]:checked', '#categoryTable tbody').length > 0;
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




    $('body').on('click', '.btnArchiveCategory', function () {
        var categoryID = $(this).attr('data-id');
        $('#archiveCategoryModal #hdnCategoryId').val(categoryID);
    });



    $('body').on('click', '.btnConfirmArchiveCategory', function () {
        var categoryID = $("#hdnCategoryId").val();
        var table = $('#categoryTable').DataTable();
        $.ajax({
            url: '/getIDs',
            type: 'POST',
            data: { categoryID },
            success: function (data) {

                console.log(data);
                table.row('#' + categoryID).remove().draw();
                // re-check the status of the checkboxes after the AJAX call
                var isChecked = $('input[type="checkbox"]:checked', '#categoryTable tbody').length > 0;
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
                alertify.success('Category Archived Successfully');
                table.page.len(table.page.len()).draw();


            }
        });
        $('#archiveCategoryModal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });


    document.getElementById("txtUpdateCategory").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[a-zA-Z\s]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });

    document.getElementById("txtUpdateDescription").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[a-zA-Z0-9\s]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });

    document.getElementById("txtCategory").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[a-zA-Z\s]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });

    document.getElementById("txtDescription").addEventListener("keypress", function (event) {
        var key = event.keyCode || event.which;
        var keychar = String.fromCharCode(key);
        var regex = /[a-zA-Z0-9\s]/;

        if (!regex.test(keychar)) {
            event.preventDefault();
            return false;
        }
    });



</script>

<?php include("shared/dashboard/footer-dashboard.php"); ?>
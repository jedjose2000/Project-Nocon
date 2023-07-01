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
            <form id="formCategory">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5">
                        <div class="mb-4">
                            <label for="txtProductInventory" class="form-label">Product Name<span class="required"
                                    style="color:red">*</span></label>
                            <input type="text" class="form-control" id="txtProductInventory" name="txtProductInventory"
                                placeholder="Enter Category Name" maxlength="40" required>
                            <div class="invalid-feedback inventory-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtProductQuantity" class="form-label">Quantity<span class="required"
                                    style="color:red">*</span></label>
                            <input type="text" class="form-control" id="txtProductQuantity" name="txtProductQuantity"
                                placeholder="Enter Category Name" maxlength="40" required>
                            <div class="invalid-feedback inventory-quantity-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtDescription" class="form-label">Description<span class="required"
                                    style="color:red">*</span></label>
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

    });


</script>

<?php include("shared/dashboard/footer-dashboard.php"); ?>
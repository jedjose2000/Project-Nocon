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
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Expiration Date</th>
                                                <th class="text-center">Buy Price</th>
                                                <th class="text-center">Sell Price</th>
                                                <th class="text-center">Critical Level Quantity</th>
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
                                                        <?php echo $row->productDescription ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->unit ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->willExpire ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->buyPrice ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->sellPrice ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->clq ?>
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

</div>

<script>
$(document).ready(function () {
    $('#productTable').DataTable({
        "columnDefs": [
            // { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 11 }
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
</script>



<?php include("shared/dashboard/footer-dashboard.php"); ?>
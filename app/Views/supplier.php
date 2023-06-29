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
                                <label for="txtSupplier" class="form-label">Name<span class="required" style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtSupplier" name="txtSupplier"
                                    placeholder="Enter Supplier Name" maxlength="40" required>
                                <div class="invalid-feedback supplier-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtPhoneNumber" class="form-label">Phone Number<span class="required" style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtPhoneNumber" name="txtPhoneNumber"
                                    placeholder="Enter Supplier Number" maxlength="11" required>
                                <div class="invalid-feedback supplier-phone-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtEmail" class="form-label">Email Address<span class="required" style="color:red">*</span></label>
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
                                <label for="txtUpdateSupplier" class="form-label">Name<span class="required" style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtUpdateSupplier" name="txtUpdateSupplier"
                                    placeholder="Enter Supplier Name" maxlength="40" required>
                                <div class="invalid-feedback supplier-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtUpdatePhoneNumber" class="form-label">Phone Number<span class="required" style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtUpdatePhoneNumber"
                                    name="txtUpdatePhoneNumber" placeholder="Enter Supplier Number" maxlength="11"
                                    required>
                                <div class="invalid-feedback supplier-phone-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtUpdateEmail" class="form-label">Email Address<span class="required" style="color:red">*</span></label>
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
                                <label for="txtViewSupplier" class="form-label">Name<span class="required" style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtViewSupplier" name="txtViewSupplier"
                                    placeholder="Enter Supplier Name" maxlength="40" disabled>
                                <div class="invalid-feedback supplier-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtViewPhoneNumber" class="form-label">Phone Number<span class="required" style="color:red">*</span></label>
                                <input type="text" class="form-control" id="txtViewPhoneNumber"
                                    name="txtViewPhoneNumber" placeholder="Enter Supplier Number" maxlength="11"
                                    disabled>
                                <div class="invalid-feedback supplier-phone-error"></div>
                            </div>
                            <div class="mb-4">
                                <label for="txtViewEmail" class="form-label">Email Address<span class="required" style="color:red">*</span></label>
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


<script src="supplier.js"></script>



<?php include("shared/dashboard/footer-dashboard.php"); ?>
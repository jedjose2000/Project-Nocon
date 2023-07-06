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
                                                            && $permissionChecker->hasPermission('orderListView', 'View Order')
                                                        ): ?>
                                                            <button title="View Category"
                                                                class="btn btn-outline-primary btnView" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->categoryId ?>"
                                                                data-bs-target="#categoryModalView" id="btnViewCategory">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
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
                                                        <?php elseif (
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
                                                        <?php elseif (
                                                            $permissionChecker->hasPermission('orderListUpdate', 'Update Order')
                                                            && $permissionChecker->hasPermission('orderListView', 'View Order')
                                                        ): ?>
                                                            <button title="Update Category"
                                                                class="btn btn-outline-primary btnUpdate" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->categoryId ?>"
                                                                data-bs-target="#categoryModalUpdate" id="btnUpdateCategory">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                            <button title="View Category"
                                                                class="btn btn-outline-primary btnView" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->categoryId ?>"
                                                                data-bs-target="#categoryModalView" id="btnViewCategory">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
                                                        <?php elseif (
                                                            $permissionChecker->hasPermission('orderListArchive', 'Archive Order')
                                                            && $permissionChecker->hasPermission('orderListView', 'View Order')
                                                        ): ?>
                                                            <button title="View Category"
                                                                class="btn btn-outline-primary btnView" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->categoryId ?>"
                                                                data-bs-target="#categoryModalView" id="btnViewCategory">
                                                                <i class="fa-solid fa-eye"></i>
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
                                                        <?php elseif ($permissionChecker->hasPermission('orderListView', 'View Order')): ?>
                                                            <button title="View Category"
                                                                class="btn btn-outline-primary btnView" data-bs-toggle="modal"
                                                                data-id="<?php echo $row->categoryId ?>"
                                                                data-bs-target="#categoryModalView" id="btnViewCategory">
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
                            <label for="txtCategory" class="form-label">Name<span class="required"
                                    style="color:red">*</span></label>
                            <input type="text" class="form-control" id="txtCategory" name="txtCategory"
                                placeholder="Enter Category Name" maxlength="40" required>
                            <div class="invalid-feedback category-error"></div>
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
                            <label for="txtUpdateCategory" class="form-label">Name<span class="required"
                                    style="color:red">*</span></label>
                            <input type="text" class="form-control" id="txtUpdateCategory" name="txtUpdateCategory"
                                placeholder="Enter Category Name" maxlength="40" required>
                            <div class="invalid-feedback category-error"></div>
                        </div>
                        <div class="mb-4">
                            <label for="txtUpdateDescription" class="form-label">Description<span class="required"
                                    style="color:red">*</span></label>
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
                    <p>Do you want to archive the selected categories?</p>
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
                    <input type="hidden" name="hdnCategoryId" id="hdnCategoryId" />
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



<script src="category.js"></script>

<?php include("shared/dashboard/footer-dashboard.php"); ?>
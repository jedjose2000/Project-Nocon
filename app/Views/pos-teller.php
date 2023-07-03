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
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">First Table</h5>
                                <table id="posTable" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Product Code</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Stock</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($result as $row) {
                                            ?>
                                            <tr id="<?php echo $row->productId ?>">
                                                <td class="text-center">
                                                    <?php echo $row->productCode ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $row->productName ?>
                                                </td>
                                                <td class="text-center">
                                                    &#8369;
                                                    <?php echo number_format($row->sellPrice, 2, '.', ',') ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $row->totalStockIn ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="editable-input text-center">
                                                        <input type="text" id="itemQuantity" name="itemQuantity"
                                                            maxlength="5" size="4" class="text-center item-quantity"
                                                            value="1">
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button title="Add Item" class="btn btn-outline-primary btnAddItem"
                                                        data-id="<?php echo $row->productId ?>"
                                                        product-id="<?php echo $row->productId ?>"
                                                        total-stock="<?php echo $row->totalStockIn ?>" id="btnAddItem">
                                                        + Add
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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <h5 class="card-title">Second Table</h5>
                                </div>
                                <?php if ($permissionChecker->hasPermission('orderListAdd', 'Add Order')): ?>
                                    <div class="text-end mb-2">
                                        <button disabled class="btn btn-success createOrder" id="btnCreateOrder">
                                            <i class="fas fa-money-bill-wave"></i> Pay
                                        </button>
                                        <button disabled class="cancelOrder btn btn-danger flex-end" id="btnCancel"><i
                                                class="fa-solid fa-person-circle-minus me-2"></i>Cancel</button>
                                    </div>
                                <?php endif; ?>
                                <hr> <!-- Horizontal line -->
                                <form id="makePayment">
                                    <div class="mb-3">
                                        <label for="txtPayment" class="form-label">Payment<span class="required"
                                                style="color:red">*</span></label>
                                        <input type="text" class="form-control" id="txtPayment" name="txtPayment"
                                            placeholder="Enter Payment" maxlength="5" size="2" required disabled>
                                        <div class="invalid-feedback payment-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtDiscount" class="form-label">Discount(%)</label>
                                        <input type="text" class="form-control" id="txtDiscount" name="txtDiscount"
                                            maxlength="3" size="2" disabled value="0" max="100">
                                        <div class="invalid-feedback change-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtChange" class="form-label">Change<span class="required"
                                                style="color:red">*</span></label>
                                        <input type="text" class="form-control" id="txtChange" name="txtChange"
                                            maxlength="40" size="2" disabled>
                                        <div class="invalid-feedback change-error"></div>
                                    </div>
                                </form>

                                <table id="transactionTable" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">Total:</th>
                                            <th class="text-center" id="totalPriceFooter">&#8369; 0.00</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
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

    <script src="posteller.js"></script>

</div>




<?php include("shared/dashboard/footer-dashboard.php"); ?>
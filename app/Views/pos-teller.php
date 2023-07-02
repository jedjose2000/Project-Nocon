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
                                            <i class="fas fa-money-bill-wave"></i> Proceed
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
                                            placeholder="Enter Payment" maxlength="40" size="2" required disabled>
                                        <div class="invalid-feedback payment-error"></div>
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

    <script>

        $(document).ready(function () {
            $('#posTable').DataTable({
                "columnDefs": [
                    // { "orderable": false, "targets": 0 },
                    { "orderable": false, "targets": 5 }
                ],
            });



            var someTableDT = $("#transactionTable").on("draw.dt", function () {
                $(this).find(".dataTables_empty").parents('tbody').empty();
                var elements = document.getElementsByClassName('dataTables_empty');

                for (var i = 0; i < elements.length; i++) {
                    var element = elements[i];
                    element.classList.add('hide');
                }
            }).DataTable(/*init object*/);


            var rowCount = $('#transactionTable tbody tr').length;

            // Enable or disable the txtPayment input field based on the row count
            if (rowCount > 0) {
                $('#btnCreateOrder').prop('disabled', false);
                $('#btnCancel').prop('disabled', false);
                $('#txtPayment').prop('disabled', false);
            } else {
                $('#btnCreateOrder').prop('disabled', true);
                $('#btnCancel').prop('disabled', true);
                $('#txtPayment').prop('disabled', true);
            }

            window.localStorage.setItem('show_popup_update', 'false');
            window.localStorage.setItem('show_popup_add', 'false');
            window.localStorage.setItem('show_popup_failed', 'false');
        });

        if (window.localStorage.getItem('show_popup_update') == 'true') {
            alertify.success('Inventory Updated');
            window.localStorage.setItem('show_popup_update', 'false');
        }

        if (window.localStorage.getItem('show_popup_add') == 'true') {
            alertify.success('Product Added!');
            window.localStorage.setItem('show_popup_add', 'false');
        }

        if (window.localStorage.getItem('show_popup_failed') == 'true') {
            alertify.error('Quantity exceeds the available stocks!');
            window.localStorage.setItem('show_popup_failed', 'false');
        }






        $('#posTable').on('click', '.btnAddItem', function () {
            var quantity = $(this).closest('tr').find('input[name="itemQuantity"]').val();
            var productId = $(this).attr('data-id');
            var totalStock = $(this).attr('total-stock');
            var addButton = $(this);
            $.ajax({
                url: '/checkIfStockIsSufficientTeller',
                type: 'POST',
                data: { productId: productId, quantity: quantity },
                success: function (data) {
                    if (data.message === 'Transaction success.') {
                        var productId = data.data.productID;
                        var itemQuantity = data.data.quantity;
                        var productName = data.data.productName;
                        var price = data.data.price;
                        var totalPrice = price * itemQuantity;
                        var existingRow = $('#transactionTable tbody').find('#' + productId);

                        if (existingRow.length > 0) {
                            var existingQuantityInput = existingRow.find('.item-quantity-input input');
                            if (existingQuantityInput.length > 0) {
                                var existingQuantity = parseInt(existingQuantityInput.val().trim() || '0', 10);
                                var newQuantity = existingQuantity + parseInt(itemQuantity, 10);
                                // var newProductId = addButton.attr('data-id');

                                if (newQuantity <= totalStock) {
                                    var newTotalPrice = price * newQuantity;
                                    existingQuantityInput.val(newQuantity);
                                    existingRow.find('.total-price').html('&#8369;' + newTotalPrice.toFixed(2));
                                    alertify.success('Product Added!');
                                    var totalPrice = 0;
                                    $('#transactionTable tbody tr').each(function () {
                                        var rowTotal = parseFloat($(this).find('.total-price').text().replace(/[^\d.-]/g, ''));
                                        totalPrice += rowTotal;
                                    });
                                    $('#totalPriceFooter').html('&#8369; ' + totalPrice.toFixed(2));
                                } else {
                                    alertify.error('Quantity exceeds the available stocks! san');
                                }
                            } else {
                                console.log("existingQuantity Input not found.");
                            }
                        } else {
                            var rowCount = $('#transactionTable tbody tr').length;
                            if (rowCount >= 0) {
                                $('#btnCreateOrder').prop('disabled', false);
                                $('#btnCancel').prop('disabled', false);
                                $('#txtPayment').prop('disabled', false);
                            } else {
                                $('#btnCreateOrder').prop('disabled', true);
                                $('#btnCancel').prop('disabled', true);
                                $('#txtPayment').prop('disabled', true);
                            }
                            var newRow = '<tr id="' + productId + '" class="transaction-row">' +
                                '<td class="text-center">' + productName + '</td>' +
                                '<td class="text-center">&#8369;' + price + '</td>' +
                                '<td class="text-center item-quantity-input"><input type="text" class="text-center" id="itemNewQuantity" name="itemNewQuantity" maxlength="5" size="4" newProductId="' + productId + '" newTotalStock="' + totalStock + '"value=' + itemQuantity + '></td>' +
                                '<td class="text-center total-price">&#8369;' + totalPrice.toFixed(2) + '</td>' +
                                '<td class="text-center">' +
                                '<button title="Remove Item" class="btn btn-outline-danger btnRemoveItem" data-idNew="' + productId + '">- Remove</button>' +
                                '</td>' +
                                '</tr>';
                            $('#transactionTable tbody').append(newRow);
                            alertify.success('Product Added!');
                            var transactionTable = $('#transactionTable').DataTable();
                            transactionTable.rows.add($(newRow)).draw();
                            var totalPrice = 0;
                            $('#transactionTable tbody tr').each(function () {
                                var rowTotal = parseFloat($(this).find('.total-price').text().replace(/[^\d.-]/g, ''));
                                totalPrice += rowTotal;
                            });
                            $('#totalPriceFooter').html('&#8369; ' + totalPrice.toFixed(2));
                        }
                    } else {
                        alertify.error('Quantity exceeds the available stocks! dito');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        $(document).on('input', '#transactionTable input[name="itemNewQuantity"]', function () {
            var quantity = $(this).val().trim();
            var productId = $(this).attr('newProductId');
            var totalStock = $(this).attr('newTotalStock');

            if (!quantity) {
                quantity = '1';
                $(this).val(quantity);
            }

            $(this).val(quantity);
            $.ajax({
                url: '/checkIfStockIsSufficientTeller',
                type: 'POST',
                data: { productId: productId, quantity: quantity },
                success: function (data) {
                    if (data.message === 'Transaction success.') {
                        var productId = data.data.productID;
                        var itemQuantity = data.data.quantity;
                        var productName = data.data.productName;
                        var price = data.data.price;
                        var totalPrice = price * itemQuantity;
                        var existingRow = $('#transactionTable tbody').find('#' + productId);
                        if (existingRow.length > 0) {
                            var existingQuantityInput = existingRow.find('.item-quantity-input input');
                            if (existingQuantityInput.length > 0) {
                                var existingQuantity = parseInt(existingQuantityInput.val().trim() || '0', 10);
                                var newQuantity = parseInt(quantity || '0', 10);
                                if (totalStock >= newQuantity) {
                                    var newTotalPrice = price * newQuantity;

                                    existingRow.find('.total-price').html('&#8369;' + newTotalPrice.toFixed(2));

                                    var totalPrice = 0;
                                    $('#transactionTable tbody tr').each(function () {
                                        var rowTotal = parseFloat($(this).find('.total-price').text().replace(/[^\d.-]/g, ''));
                                        totalPrice += rowTotal;
                                    });
                                    $('#totalPriceFooter').html('&#8369; ' + totalPrice.toFixed(2));
                                } else {
                                    alertify.error('Quantity exceeds the available stocks!');
                                }
                            } else {
                                console.log("existingQuantity Input not found.");
                            }
                        } else {
                            alertify.error('Quantity exceeds the available stocks!');
                        }
                    } else {
                        alertify.error('Quantity exceeds the available stocks!');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

        });


        $('#transactionTable').on('click', '.btnRemoveItem', function () {
            var productId = $(this).attr('data-idNew');
            $('#' + productId + '.transaction-row').remove();
            var transactionTable = $('#transactionTable').DataTable();
            transactionTable.row('#' + productId).remove().draw();
            alertify.success('Product Removed!');
            var totalPrice = 0;
            $('#transactionTable tbody tr').each(function () {
                var rowTotal = parseFloat($(this).find('.total-price').text().replace(/[^\d.-]/g, ''));
                totalPrice += rowTotal;
            });
            $('#totalPriceFooter').html('&#8369; ' + totalPrice.toFixed(2));
        });


        $(document).on('click', '.cancelOrder', function () {
            var transactionTable = $('#transactionTable').DataTable();
            transactionTable.rows().remove().draw();

            var totalPrice = 0;
            $('#totalPriceFooter').html('&#8369; ' + totalPrice.toFixed(2));
            var rowCount = $('#transactionTable tbody tr').length;

            // Enable or disable the txtPayment input field based on the row count
            if (rowCount > 0) {
                $('#btnCreateOrder').prop('disabled', false);
                $('#btnCancel').prop('disabled', false);
                $('#txtPayment').prop('disabled', false);
            } else {
                $('#btnCreateOrder').prop('disabled', true);
                $('#btnCancel').prop('disabled', true);
                $('#txtPayment').prop('disabled', true);
            }
        });


        // Remove Item button click event
        $(document).on('click', '.btnRemoveItem', function () {
            var productId = $(this).attr('data-id');
            $('#' + productId).remove();

            var rowCount = $('#transactionTable tbody tr').length;

            // Enable or disable the txtPayment input field based on the row count
            if (rowCount > 0) {
                $('#btnCreateOrder').prop('disabled', false);
                $('#btnCancel').prop('disabled', false);
                $('#txtPayment').prop('disabled', false);
            } else {
                $('#btnCreateOrder').prop('disabled', true);
                $('#btnCancel').prop('disabled', true);
                $('#txtPayment').prop('disabled', true);
            }
        });

        $(document).on("keypress", "#itemNewQuantity", function (event) {
            var key = event.keyCode || event.which;
            var keychar = String.fromCharCode(key);
            var regex = /[0-9]/;

            if (!regex.test(keychar)) {
                event.preventDefault();
                return false;
            }
        });


        document.getElementById("itemQuantity").addEventListener("keypress", function (event) {
            var key = event.keyCode || event.which;
            var keychar = String.fromCharCode(key);
            var regex = /[0-9]/;

            if (!regex.test(keychar)) {
                event.preventDefault();
                return false;
            }
        });


        $(document).on('click', '.createOrder', function () {
            var rows = $('#transactionTable tbody').find('tr');
            var rowDataArray = [];
            rows.each(function () {
                var row = $(this);
                var productId = row.attr('id');
                var productName = row.find('td:first-child').text().trim();
                var price = row.find('td:nth-child(2)').text().trim().replace(/[^\d.-]/g, '');
                var quantityInput = row.find('input[name="itemNewQuantity"]');
                var quantity = quantityInput.val().trim();
                var total = row.find('.total-price').text().trim().replace(/[^\d.-]/g, '');

                // Create an object with row data and push it into the array
                var rowData = {
                    productId: productId,
                    productName: productName,
                    price: price,
                    quantity: quantity,
                    total: total
                };
                rowDataArray.push(rowData);
            });
            $.ajax({
                url: '/createTheOrder',
                type: 'POST',
                data: { rowDataArray: rowDataArray },
                success: function (data) {
                    console.log(data);
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });






    </script>


</div>




<?php include("shared/dashboard/footer-dashboard.php"); ?>
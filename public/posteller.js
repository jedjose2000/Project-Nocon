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
        $('#txtDiscount').prop('disabled', false);
        $('#btnCancel').prop('disabled', false);
        $('#txtPayment').prop('disabled', false);
    } else {
        $('#txtDiscount').prop('disabled', true);
        $('#btnCancel').prop('disabled', true);
        $('#txtPayment').prop('disabled', true);
    }

    window.localStorage.setItem('show_popup_update', 'false');
    window.localStorage.setItem('show_popup_add', 'false');
    window.localStorage.setItem('show_popup_failed', 'false');
    window.localStorage.setItem('show_popup_transactionSuccess', 'false');

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

if (window.localStorage.getItem('show_popup_transactionSuccess') == 'true') {
    alertify.success('Transaction Success!');
    window.localStorage.setItem('show_popup_transactionSuccess', 'false');
}






$('#posTable').on('click', '.btnAddItem', function () {
    var quantity = $(this).closest('tr').find('input[name="itemQuantity"]').val();
    var productId = $(this).attr('data-id');
    var totalStock = $(this).attr('total-stock');
    var addButton = $(this);
    $.ajax({
        url: '/checkIfStockIsSufficientTeller',
        type: 'POST',
        data: { productId: productId, quantity: quantity, totalStock: totalStock },
        success: function (data) {
            if (data.message === 'Transaction success.') {
                var productId = data.data.productID;
                var itemQuantity = data.data.quantity;
                var productName = data.data.productName;
                var price = data.data.price;
                var totalStock = data.data.totalStock;
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
                        $('#txtDiscount').prop('disabled', false);
                        $('#btnCancel').prop('disabled', false);
                        $('#txtPayment').prop('disabled', false);
                    } else {
                        $('#txtDiscount').prop('disabled', true);
                        $('#btnCancel').prop('disabled', true);
                        $('#txtPayment').prop('disabled', true);
                    }
                    var newRow = '<tr id="' + productId + '" class="transaction-row">' +
                        '<td class="text-center">' + productName + '</td>' +
                        '<td class="text-center">&#8369;' + price + '</td>' +
                        '<td class="text-center item-quantity-input"><input type="text" class="text-center" id="itemNewQuantity" name="itemNewQuantity" maxlength="5" size="4" newProductId="' + productId + '" newTotalStock="' + totalStock + '"value=' + itemQuantity + '></td>' +
                        '<td class="text-center total-price">&#8369;' + totalPrice.toFixed(2) + '</td>' +
                        '<td class="text-center">' +
                        '<button title="Remove Item" class="btn btn-outline-danger btnRemoveItem" data-idNew="' + productId + '" data-totalStocks="' + totalStock + '">- Remove</button>' +
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
        data: { productId: productId, quantity: quantity, totalStock: totalStock },
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
    $('#txtDiscount').val('');
    $('#txtPayment').val('');
    $('#txtChange').val('');

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
        $('#txtDiscount').prop('disabled', false).val('');
        $('#btnCancel').prop('disabled', false);
        $('#txtPayment').prop('disabled', false).val('');
        $('#txtChange').val('');
    } else {
        $('#txtDiscount').prop('disabled', true).val('');
        $('#btnCancel').prop('disabled', true);
        $('#txtPayment').prop('disabled', true).val('');
        $('#txtChange').val('');
    }

});


// Remove Item button click event
$(document).on('click', '.btnRemoveItem', function () {
    var productId = $(this).attr('data-id');
    $('#' + productId).remove();

    var rowCount = $('#transactionTable tbody tr').length;

    // Enable or disable the txtPayment input field based on the row count
    if (rowCount > 0) {
        $('#txtDiscount').prop('disabled', false);
        $('#btnCancel').prop('disabled', false);
        $('#txtPayment').prop('disabled', false);
    } else {
        $('#txtDiscount').prop('disabled', true);
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
    var payment = $('#txtPayment').val();
    var change = $('#txtChange').val();
    var txtDiscount = $('#txtDiscount').val();
    var totalPrice = parseFloat($('#totalPriceFooter').text().replace(/[^0-9.-]+/g, ""));
    var rowDataArray = [];
    rows.each(function () {
        var row = $(this);
        var productId = row.attr('id');
        var productName = row.find('td:first-child').text().trim();
        var price = row.find('td:nth-child(2)').text().trim().replace(/[^\d.-]/g, '');
        var quantityInput = row.find('input[name="itemNewQuantity"]');
        var quantity = quantityInput.val().trim();
        var total = row.find('.total-price').text().trim().replace(/[^\d.-]/g, '');
        var totalStockIn = row.find('.btnRemoveItem').attr('data-totalStocks');
        // Create an object with row data and push it into the array
        var rowData = {
            productId: productId,
            productName: productName,
            price: price,
            quantity: quantity,
            total: total,
            totalStock: totalStockIn
        };
        rowDataArray.push(rowData);
    });
    console.log(rowDataArray);
    $.ajax({
        url: '/createTheOrder',
        type: 'POST',
        data: { rowDataArray: rowDataArray, payment: payment, change: change, txtDiscount: txtDiscount, totalPrice: totalPrice },
        success: function (data) {
            window.localStorage.setItem('show_popup_transactionSuccess', 'true');
            window.location.reload();
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
});

$(document).on('input', 'input[name="txtPayment"]', function () {
    var totalPrice = parseFloat($('#totalPriceFooter').text().replace(/[^0-9.-]+/g, ""));
    var payment = parseFloat($(this).val()) || 0; // Use default value of 0 if payment is null or empty
    var txtDiscount = $('#txtDiscount').val();
    var discount = parseFloat(txtDiscount) / 100;

    var discountedTotal = totalPrice - (totalPrice * discount);
    var change = payment - discountedTotal;

    if (isNaN(change)) {
        change = 0; // Set change to 0 if it is NaN
    }

    if (payment < totalPrice || txtDiscount > 100) {
        $('#btnCreateOrder').prop('disabled', true);
    } else {
        $('#btnCreateOrder').prop('disabled', false);
    }

    $('#txtChange').val(change.toFixed(2));
});

$(document).on('input', 'input[name="txtDiscount"]', function () {
    var totalPrice = parseFloat($('#totalPriceFooter').text().replace(/[^0-9.-]+/g, ""));
    var txtDiscount = parseFloat($(this).val()) || 0; // Use default value of 0 if discount is null or empty
    var payment = parseFloat($('#txtPayment').val()) || 0; // Use default value of 0 if payment is null or empty

    // Adjust the discount calculation
    var discount = (totalPrice * txtDiscount) / 100;

    var discountedTotal = totalPrice - discount;
    var change = payment - discountedTotal;

    if (isNaN(change)) {
        change = 0; // Set change to 0 if it is NaN
    }

    if (payment < totalPrice || txtDiscount > 100) {
        $('#btnCreateOrder').prop('disabled', true);
    } else {
        $('#btnCreateOrder').prop('disabled', false);
    }

    $('#txtChange').val(change.toFixed(2));
});

document.getElementById("txtPayment").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[0-9]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});


document.getElementById("txtDiscount").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[0-9]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});

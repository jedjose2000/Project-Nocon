$(document).ready(function () {
    $('#inventoryTable').DataTable({
        "columnDefs": [
            // { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 11 }
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


    $('#inventoryModal').on('hidden.bs.modal', function () {
        $('#formInventory')[0].reset(); // Reset the form fields
        $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
        $('.invalid-feedback').html(''); // Clear the error messages
    });

    $('#inventoryModalStockIn').on('hidden.bs.modal', function () {
        $('#formInventoryStockIn')[0].reset(); // Reset the form fields
        $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
        $('.invalid-feedback').html(''); // Clear the error messages
    });

    $('#inventoryModalStockOut').on('hidden.bs.modal', function () {
        $('#formInventoryStockOut')[0].reset(); // Reset the form fields
        $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
        $('.invalid-feedback').html(''); // Clear the error messages
    });

});

$('#inventoryTable tbody').on('change', 'input[type="checkbox"]', function () {
    var isChecked = $('input[type="checkbox"]:checked', '#inventoryTable tbody').length > 0;
    if (isChecked) {
        $('#btnArchiveAll').prop('disabled', false);
    } else {
        $('#btnArchiveAll').prop('disabled', true);
    }
    // check or uncheck the header checkbox based on the state of the row checkboxes
    $('#selectAll').prop('checked', $('input[type="checkbox"]', '#inventoryTable tbody').length === $('input[type="checkbox"]:checked', '#inventoryTable tbody').length);

});

$('#selectAll').on('change', function () {
    var isChecked = $(this).is(':checked');
    var table = $('#inventoryTable').DataTable();
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
        var inventoryId = [];
        checkboxes.each(function () {
            inventoryId.push($(this).val());
        })
        var inventoryIdString = JSON.stringify(inventoryId);
        $('#hdnAllInventoryId').val(inventoryIdString);
    }
})

$(document).on('click', '.btnArchiveAll', function () {
    var inventoryIdString = $('#hdnAllInventoryId').val();
    if (inventoryIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var inventoryId = JSON.parse(inventoryIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/archiveAllInventory',
        type: 'POST',
        data: { inventoryId },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#inventoryTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAll').prop('disabled', true);
            alertify.success('Items Archived Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#inventoryTable tbody').length > 0;
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

$(document).ready(function () {
    $('#txtProductInventory').change(function () {
        var productId = $(this).val();
        $.ajax({
            url: '/checkIfWillExpire',
            type: 'POST',
            data: { productId: productId },
            dataType: 'json',
            success: function (response) {
                if (response.willExpire === '1') {
                    $('.will-expire-input').show();
                    $('.expiration-date-label').show();
                } else {
                    $('.will-expire-input').hide();
                    $('.expiration-date-label').hide();
                }
            },
            error: function () {
                console.log('Error occurred while fetching willExpire value.');
            }
        });
    });
});

if (window.localStorage.getItem('show_popup_update') == 'true') {
    alertify.success('Inventory Updated');
    window.localStorage.setItem('show_popup_update', 'false');
}

if (window.localStorage.getItem('show_popup_add') == 'true') {
    alertify.success('Inventory Added');
    window.localStorage.setItem('show_popup_add', 'false');
}

if (window.localStorage.getItem('show_popup_failed') == 'true') {
    alertify.error('Error');
    window.localStorage.setItem('show_popup_failed', 'false');
}




$("#formInventory").validate({
    rules: {
        txtProductInventory: {
            required: true,
        },
        txtProductQuantity: {
            required: true,
        },
        txtExpirationDate: {
            required: true,
        },
        txtSupplierInventory: {
            required: true
        }
    },
    messages: {
        txtProductInventory: {
            required: "Please enter a product.",
        },
        txtProductQuantity: {
            required: "Please enter a product quantity.",
        },
        txtExpirationDate: {
            required: "Please enter an expiration date.",
        },
        txtSupplierInventory: {
            required: "Please enter a supplier.",
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") === "txtProductInventory") {
            $(".inventory-error").html(error);
            $(".inventory-error");
        } else if (element.attr("name") === "txtProductQuantity") {
            $(".inventory-quantity-error").html(error);
            $(".inventory-quantity-error");
        }
        else if (element.attr("name") === "txtExpirationDate") {
            $(".inventory-expiration-error").html(error);
            $(".inventory-expiration-error");
        }
        else if (element.attr("name") === "txtSupplierInventory") {
            $(".inventory-supplier-error").html(error);
            $(".inventory-supplier-error");
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
        var productId = $('#txtProductInventory').val();
        var quantity = $('#txtProductQuantity').val();
        var expirationDate = $('#txtExpirationDate').val();
        var supplierId = $('#txtSupplierInventory').val();
        $.ajax({
            url: '/insertDataInventory',
            type: 'POST',
            data: { productId: productId, quantity: quantity, expirationDate: expirationDate, supplierId: supplierId },
            success: function (data) {
                console.log(data);
                if (data === 'Transaction success.') {
                    window.localStorage.setItem('show_popup_add', 'true');
                    window.location.reload();
                } else {
                    window.localStorage.setItem('show_popup_failed', 'true');
                    window.location.reload();
                }
                // Handle the success response and perform necessary actions

                $('#inventoryModal').modal('hide');
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

document.getElementById("txtProductQuantity").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[0-9]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});


document.getElementById("txtProductQuantityStockIn").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[0-9]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});

document.getElementById("txtProductQuantityStockOut").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[0-9]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});





$('body').on('click', '.btnStockIn', function () {
    var inventoryId = $(this).attr('data-id');
    var productId = $(this).attr('product-id');
    $('#inventoryModalStockIn #txtInventoryId').val(inventoryId);
    $('#inventoryModalStockIn #txtProductId').val(productId);
    $.ajax({
        url: 'view-stockIn/' + productId,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            let result = res.find(product => product.productId == productId);
            if (result.willExpire === '1') {
                $('.will-expire-input').show();
                $('.expiration-date-label').show();
            } else {
                $('.will-expire-input').hide();
                $('.expiration-date-label').hide();
            }
        },
        error: function (data) {
        }
    });
});


$("#formInventoryStockIn").validate({
    rules: {
        txtProductQuantityStockIn: {
            required: true,
        },
        txtExpirationDateStockIn: {
            required: true,
        },
        txtSupplierInventoryStockIn: {
            required: true
        }
    },
    messages: {
        txtProductQuantityStockIn: {
            required: "Please enter a product quantity.",
        },
        txtExpirationDateStockIn: {
            required: "Please enter an expiration date.",
        },
        txtSupplierInventoryStockIn: {
            required: "Please enter a supplier.",
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") === "txtProductQuantityStockIn") {
            $(".inventory-quantity-error").html(error);
            $(".inventory-quantity-error");
        }
        else if (element.attr("name") === "txtExpirationDateStockIn") {
            $(".inventory-expiration-error").html(error);
            $(".inventory-expiration-error");
        }
        else if (element.attr("name") === "txtSupplierInventoryStockIn") {
            $(".inventory-supplier-error").html(error);
            $(".inventory-supplier-error");
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
        var inventoryId = $('#txtInventoryId').val();
        var productId = $('#txtProductId').val();
        var quantity = $('#txtProductQuantityStockIn').val();
        var expirationDate = $('#txtExpirationDateStockIn').val();
        var supplierId = $('#txtSupplierInventoryStockIn').val();
        $.ajax({
            url: '/stockIn',
            type: 'POST',
            data: { productId: productId, quantity: quantity, expirationDate: expirationDate, supplierId: supplierId, inventoryId: inventoryId },
            success: function (data) {
                console.log(data);
                if (data === 'Transaction success.') {
                    window.localStorage.setItem('show_popup_add', 'true');
                    window.location.reload();
                } else {
                    window.localStorage.setItem('show_popup_failed', 'true');
                    window.location.reload();
                }
                // Handle the success response and perform necessary actions
                $('#inventoryModalStockIn').modal('hide');
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





$('body').on('click', '.btnStockOut', function () {
    var inventoryId = $(this).attr('data-id');
    var productId = $(this).attr('product-id');
    $('#inventoryModalStockOut #txtInventoryIdStockOut').val(inventoryId);
    $('#inventoryModalStockOut #txtProductIdStockOut').val(productId);
});




$("#formInventoryStockOut").validate({
    rules: {
        txtProductQuantityStockOut: {
            required: true,
            remote: {
                url: "checkIfStockIsSufficient",
                type: "post",
                data: {
                    txtProductQuantityStockOut: function () {
                        return $("#txtProductQuantityStockOut").val();
                    },
                    txtProductIdStockOut: function () {
                        return $("#txtProductIdStockOut").val();
                    }
                }
            },
        },
        txtReasonStockOut: {
            required: true,
        },
    },
    messages: {
        txtProductQuantityStockOut: {
            required: "Please enter a product quantity.",
            remote: "Quantity must not be greater than the available stocks"
        },
        txtReasonStockOut: {
            required: "Please enter an expiration date.",
        },
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") === "txtProductQuantityStockOut") {
            $(".inventory-quantity-error").html(error);
            $(".inventory-quantity-error");
        }
        else if (element.attr("name") === "txtReasonStockOut") {
            $(".inventory-expiration-error").html(error);
            $(".inventory-reason-error");
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
        var reason = $('#txtReasonStockOut').val();
        var inventoryId = $('#txtInventoryIdStockOut').val();
        var productId = $('#txtProductIdStockOut').val();
        var quantity = $('#txtProductQuantityStockOut').val();
        var expirationDate = $('#txtProductQuantityStockOut').val();
        var supplierId = $('#txtSupplierInventoryStockIn').val();
        $.ajax({
            url: '/stockOut',
            type: 'POST',
            data: { productId: productId, quantity: quantity, expirationDate: expirationDate, supplierId: supplierId, inventoryId: inventoryId, reason: reason },
            success: function (data) {
                console.log(data);
                if (data === 'Transaction success.') {
                    window.localStorage.setItem('show_popup_update', 'true');
                    window.location.reload();
                } else {
                    window.localStorage.setItem('show_popup_failed', 'true');
                    window.location.reload();
                }
                // Handle the success response and perform necessary actions
                $('#inventoryModalStockOut').modal('hide');
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


$('body').on('click', '.btnViewHistory', function () {
    var inventoryId = $(this).attr('data-id');
    var productId = $(this).attr('product-id');
    $('#viewInventoryHistoryModal #txtHistoryInventoryIdStockOut').val(inventoryId);
    $('#viewInventoryHistoryModal #txtHistoryProductIdStockOut').val(productId);
    $.ajax({
        url: 'view-stockInHistory',
        type: "GET",
        dataType: 'json',
        data: { productId: productId },
        success: function (res) {
            document.getElementById('stockInTableContainer').innerHTML = "";
            document.getElementById('stockInTableContainer').innerHTML = `<table id="stockInTableHistory" class="display" style="width:100%"></table>`;

            document.getElementById('stockOutTableContainer').innerHTML = "";
            document.getElementById('stockOutTableContainer').innerHTML = `<table id="stockOutTableHistory" class="display" style="width:100%"></table>`;





            let stockInDataSet = [];
            res.resultStockIn.forEach(element => {
                let stockInDate = new Date(element.stockInDate).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                let expirationDate = element.stockInExpirationDate !== '0000-00-00' ? new Date(element.stockInExpirationDate).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : 'Non-Perishable';
                stockInDataSet.push([
                    element.numberOfStockIn,
                    element.supplierName,
                    stockInDate,
                    expirationDate,
                    element.status,
                ]);
            });

            const stockInTable = $('#stockInTableHistory').DataTable({
                data: stockInDataSet,
                columns: [
                    { title: 'Number of Stock In' },
                    { title: 'Supplier' },
                    { title: 'Stock In Date' },
                    { title: 'Stock In Expiration Date' },
                    { title: 'Status' },
                ],
                columnDefs: [
                    {
                        targets: [0, 1, 2], // the first column
                        className: 'text-center', // the CSS class to apply
                    },
                ],
                order: [[0, 'desc']]
            });

            let stockOutDataSet = [];
            res.resultStockOut.forEach(element => {
                let stockOutDate = new Date(element.stockOutDate).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                stockOutDataSet.push([
                    element.stockOutQuantity,
                    stockOutDate,
                    element.reason,
                ]);
            });

            const stockOutTable = $('#stockOutTableHistory').DataTable({
                data: stockOutDataSet,
                columns: [
                    { title: 'Number of Stock Out' },
                    { title: 'Stock Out Date' },
                    { title: 'Reason' },
                ],
                columnDefs: [
                    {
                        targets: [0, 1, 2], // the first column
                        className: 'text-center', // the CSS class to apply
                    },
                ],
                order: [[0, 'desc']]
            });




        },
        error: function (data) {
        }
    });
});

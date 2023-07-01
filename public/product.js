$(document).ready(function () {
    $('#productTable').DataTable({
        "columnDefs": [
            // { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 8 }
        ],
        order: [[1, 'asc']]
    });


    $('#updateProductModal').on('hidden.bs.modal', function () {
        $('#formUpdateProduct')[0].reset(); // Reset the form fields
        $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
        $('.invalid-feedback').html(''); // Clear the error messages
    });

    $('#productModal').on('hidden.bs.modal', function () {
        $('#formProduct')[0].reset(); // Reset the form fields
        $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
        $('.invalid-feedback').html(''); // Clear the error messages
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

jQuery.validator.addMethod("noSpace", function (value, element) {
    let newValue = value.trim();

    return (newValue) ? true : false;
}, "This field is required");

if (window.localStorage.getItem('show_popup_update') == 'true') {
    alertify.success('Product Updated');
    window.localStorage.setItem('show_popup_update', 'false');
}

if (window.localStorage.getItem('show_popup_add') == 'true') {
    alertify.success('Product Added');
    window.localStorage.setItem('show_popup_add', 'false');
}

if (window.localStorage.getItem('show_popup_failed') == 'true') {
    alertify.error('Error');
    window.localStorage.setItem('show_popup_failed', 'false');
}


$('#productTable tbody').on('change', 'input[type="checkbox"]', function () {
    var isChecked = $('input[type="checkbox"]:checked', '#productTable tbody').length > 0;
    if (isChecked) {
        $('#btnArchiveAll').prop('disabled', false);
    } else {
        $('#btnArchiveAll').prop('disabled', true);
    }

    // check or uncheck the header checkbox based on the state of the row checkboxes
    $('#selectAll').prop('checked', $('input[type="checkbox"]', '#productTable tbody').length === $('input[type="checkbox"]:checked', '#productTable tbody').length);

});

$('#selectAll').on('change', function () {
    var isChecked = $(this).is(':checked');
    var table = $('#productTable').DataTable();
    $('#btnArchiveAll').prop('disabled', !isChecked);
    // check or uncheck all row checkboxes based on the state of the header checkbox
    table.rows().every(function () {
        var rowNode = this.node();
        $('input[type="checkbox"]', rowNode).prop('checked', isChecked);
    });
});

$("#formProduct").validate({
    rules: {
        txtProduct: {
            required: true,
            remote: {
                url: "checkProductNameExists",
                type: "post",
                data: {
                    txtProduct: function () {
                        return $("#txtProduct").val();
                    }
                }
            },
            noSpace: true,
        },
        txtBuyPrice: {
            required: true,
        },
        txtSellPrice: {
            required: true,
        },
        txtCLQ: {
            required: true,
        },
        txtCategory:{
            required:true
        }
    },
    messages: {
        txtProduct: {
            required: "Please enter a product name.",
            remote: "Product Name already exists.",
            noSpace: "Please enter a product name.",
        },
        txtBuyPrice: {
            required: "Please enter a product price.",
        },
        txtSellPrice: {
            required: "Please enter a sell price.",
        },
        txtCLQ: {
            required: "Please enter a critical level quantity.",
        },
        txtCategory:{
            required:"Please input a category"
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") === "txtProduct") {
            $(".product-error").html(error);
            $(".product-error");
        } else if (element.attr("name") === "txtBuyPrice") {
            $(".product-buyprice-error").html(error);
            $(".product-buyprice-error");
        }
        else if (element.attr("name") === "txtSellPrice") {
            $(".product-sellprice-error").html(error);
            $(".product-sellprice-error");
        }
        else if (element.attr("name") === "txtCLQ") {
            $(".product-clq-error").html(error);
            $(".product-clq-error");
        }
        else if (element.attr("name") === "txtCategory") {
            $(".product-category-error").html(error);
            $(".product-category-error");
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
        var productName = $('#txtProduct').val();
        var brandName = $('#txtBrand').val();
        var categoryId = $('#txtCategory').val();
        var supplierId = $('#txtSupplier').val();
        var productDescription = $('#txtDescription').val();
        var unit = $('#txtUnit').val();
        var buyPrice = $('#txtBuyPrice').val();
        var sellPrice = $('#txtSellPrice').val();
        var clq = $('#txtCLQ').val();
        var willExpire = $('#chkWillExpire').prop('checked') ? 1 : 0;
        $.ajax({
            url: '/insertProduct',
            type: 'POST',
            data: { productName: productName, brandName: brandName, categoryId: categoryId, supplierId: supplierId, productDescription: productDescription, unit: unit, buyPrice: buyPrice, sellPrice: sellPrice, clq: clq, willExpire: willExpire },
            success: function (data) {
                if (data === 'Transaction success.') {
                    window.localStorage.setItem('show_popup_add', 'true');
                    window.location.reload();
                } else {
                    window.localStorage.setItem('show_popup_failed', 'true');
                    window.location.reload();
                }

                $('#productModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
});


$('body').on('click', '.btnUpdate', function () {
    var productId = $(this).attr('data-id');
    $('#updateProductModal #txtUpdateProductId').val(productId);
    $.ajax({
        url: 'view-product/' + productId,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            let result = res.find(product => product.productId == productId);
            $('#updateProductModal #txtUpdateProductCode').val(result.productCode);
            $('#updateProductModal #txtUpdateProduct').val(result.productName);
            $('#updateProductModal #txtUpdateBrand').val(result.productBrand);
            $('#updateProductModal #txtUpdateCategory').val(result.categoryID);
            $('#updateProductModal #txtUpdateSupplier').val(result.supplierID);
            $('#updateProductModal #txtUpdateDescription').val(result.productDescription);
            $('#updateProductModal #txtUpdateUnit').val(result.unit);
            $('#updateProductModal #txtUpdateBuyPrice').val(result.buyPrice);
            $('#updateProductModal #txtUpdateSellPrice').val(result.sellPrice);
            $('#updateProductModal #txtUpdateCLQ').val(result.clq);
            $('#updateProductModal #chkUpdateWillExpire').prop('checked', result.willExpire == 1);
        },
        error: function (data) {
        }
    });
});


$('body').on('click', '.btnView', function () {
    var productId = $(this).attr('data-id');
    $('#viewProductModal #txtViewProductId').val(productId);
    $.ajax({
        url: 'view-product/' + productId,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            let result = res.find(product => product.productId == productId);
            $('#viewProductModal #txtViewProductCode').val(result.productCode);
            $('#viewProductModal #txtViewProduct').val(result.productName);
            $('#viewProductModal #txtViewBrand').val(result.productBrand);
            $('#viewProductModal #txtViewCategory').val(result.categoryID);
            $('#viewProductModal #txtViewSupplier').val(result.supplierID);
            $('#viewProductModal #txtViewDescription').val(result.productDescription);
            $('#viewProductModal #txtViewUnit').val(result.unit);
            $('#viewProductModal #txtViewBuyPrice').val(result.buyPrice);
            $('#viewProductModal #txtViewSellPrice').val(result.sellPrice);
            $('#viewProductModal #txtViewCLQ').val(result.clq);
            $('#viewProductModal #chkViewWillExpire').prop('checked', result.willExpire == 1);
        },
        error: function (data) {
        }
    });
});

$("#formUpdateProduct").validate({
    rules: {
        txtUpdateProduct: {
            required: true,
            remote: {
                url: "checkUpdateProductNameExists",
                type: "post",
                data: {
                    txtUpdateProduct: function () {
                        return $("#txtUpdateProduct").val();
                    },
                    txtUpdateProductId: function () {
                        return $("#txtUpdateProductId").val();
                    }
                }
            },
            noSpace: true,
        },
        txtUpdateBuyPrice: {
            required: true,
        },
        txtUpdateSellPrice: {
            required: true,
        },
        txtUpdateCLQ: {
            required: true,
        },
        txtUpdateCategory:{
            required:true
        }
    },
    messages: {
        txtUpdateProduct: {
            required: "Please enter a product name.",
            remote: "Product Name already exists.",
            noSpace: "Please enter a product name.",
        },
        txtUpdateBuyPrice: {
            required: "Please enter a product price.",
        },
        txtUpdateSellPrice: {
            required: "Please enter a sell price.",
        },
        txtUpdateCLQ: {
            required: "Please enter a critical level quantity.",
        },
        txtUpdateCategory:{
            required: "Please enter a category.",
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") === "txtUpdateProduct") {
            $(".product-error").html(error);
            $(".product-error");
        } else if (element.attr("name") === "txtUpdateBuyPrice") {
            $(".product-buyprice-error").html(error);
            $(".product-buyprice-error");
        }
        else if (element.attr("name") === "txtUpdateSellPrice") {
            $(".product-sellprice-error").html(error);
            $(".product-sellprice-error");
        }
        else if (element.attr("name") === "txtUpdateCLQ") {
            $(".product-clq-error").html(error);
            $(".product-clq-error");
        }
        else if (element.attr("name") === "txtUpdateCategory") {
            $(".product-category-error").html(error);
            $(".product-category-error");
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
        var productId = $('#txtUpdateProductId').val();
        var productName = $('#txtUpdateProduct').val();
        var brandName = $('#txtUpdateBrand').val();
        var categoryId = $('#txtUpdateCategory').val();
        var supplierId = $('#txtUpdateSupplier').val();
        var productDescription = $('#txtUpdateDescription').val();
        var unit = $('#txtUpdateUnit').val();
        var buyPrice = $('#txtUpdateBuyPrice').val();
        var sellPrice = $('#txtUpdateSellPrice').val();
        var clq = $('#txtUpdateCLQ').val();
        var willExpire = $('#chkUpdateWillExpire').prop('checked') ? 1 : 0;
        $.ajax({
            url: '/insertProduct',
            type: 'POST',
            data: { productId: productId, productName: productName, brandName: brandName, categoryId: categoryId, supplierId: supplierId, productDescription: productDescription, unit: unit, buyPrice: buyPrice, sellPrice: sellPrice, clq: clq, willExpire: willExpire },
            success: function (data) {
                if (data === 'Transaction success.') {
                    window.localStorage.setItem('show_popup_update', 'true');
                    window.location.reload();
                } else {
                    window.localStorage.setItem('show_popup_failed', 'true');
                    window.location.reload();
                }
                $('#updateProductModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
});

document.getElementById("txtBuyPrice").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[0-9]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});

document.getElementById("txtCLQ").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[0-9]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});

document.getElementById("txtSellPrice").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[0-9]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});

document.getElementById("txtProduct").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[a-zA-Z\s]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});

document.getElementById("txtBrand").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[a-zA-Z\s]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});


$(document).on('click', '.archiveAllData', function () {
    var checkboxes = $(".data_checkbox:checked");
    if (checkboxes.length > 0) {
        var productId = [];
        checkboxes.each(function () {
            productId.push($(this).val());
        })
        var productIdString = JSON.stringify(productId);
        $('#hdnAllProductId').val(productIdString);
    }
})


$(document).on('click', '.btnArchiveAll', function () {
    var productIdString = $('#hdnAllProductId').val();
    if (productIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var productId = JSON.parse(productIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/archiveAllProducts',
        type: 'POST',
        data: { productId },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#productTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAll').prop('disabled', true);
            alertify.success('Suppliers Archived Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#productTable tbody').length > 0;
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

$('body').on('click', '.btnArchiveProduct', function () {
    var productId = $(this).attr('data-id');
    console.log("product", productId);
    $('#archiveProductModal #hdnId').val(productId);
});

$('body').on('click', '.btnConfirmArchiveProduct', function () {
    var productId = $("#hdnId").val();
    var table = $('#productTable').DataTable();
    $.ajax({
        url: '/getIDProduct',
        type: 'POST',
        data: { productId },
        success: function (data) {
            console.log(data);
            table.row('#' + productId).remove().draw();
            // re-check the status of the checkboxes after the AJAX call
            var isChecked = $('input[type="checkbox"]:checked', '#productTable tbody').length > 0;
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
            alertify.success('Product Archived Successfully');
            table.page.len(table.page.len()).draw();
        }
    });
    $('#archiveProductModal').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
});
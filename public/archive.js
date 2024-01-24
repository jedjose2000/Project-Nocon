$(document).ready(function () {
    $('#categoryTable').DataTable({
        "columnDefs": [
            // { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 3 }
        ],
        order: [[1, 'asc']]
    });

    var table = $('#categoryTable').DataTable();
    if (table.rows().count() === 0) {
        $('#selectAllCategory').prop('checked', false).prop('disabled', true);
    } else {
        $('#selectAllCategory').prop('disabled', false);
    }

    $('#supplierTable').DataTable({
        "columnDefs": [
            // { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 4 }
        ],
        order: [[1, 'asc']]
    });

    var supplierTable = $('#supplierTable').DataTable();
    if (supplierTable.rows().count() === 0) {
        $('#selectAllSupplier').prop('checked', false).prop('disabled', true);
    } else {
        $('#selectAllSupplier').prop('disabled', false);
    }


    $('#productTable').DataTable({
        "columnDefs": [
            // { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 8 }
        ],
        order: [[1, 'asc']]
    });

    var productTable = $('#productTable').DataTable();
    if (productTable.rows().count() === 0) {
        $('#selectAllProducts').prop('checked', false).prop('disabled', true);
    } else {
        $('#selectAllProducts').prop('disabled', false);
    }


    $('#inventoryTable').DataTable({
        "columnDefs": [
            // { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 11 }
        ],
        order: [[1, 'asc']]
    });

    var inventoryTable = $('#inventoryTable').DataTable();
    if (inventoryTable.rows().count() === 0) {
        $('#selectAll').prop('checked', false).prop('disabled', true);
    } else {
        $('#selectAll').prop('disabled', false);
    }



});


$('#inventoryTable tbody').on('change', 'input[type="checkbox"]', function () {
    var isChecked = $('input[type="checkbox"]:checked', '#inventoryTable tbody').length > 0;
    if (isChecked) {
        $('#btnArchiveAllInventory').prop('disabled', false);
        $('#btnDeleteAllInventory').prop('disabled', false);
    } else {
        $('#btnArchiveAllInventory').prop('disabled', true);
        $('#btnDeleteAllInventory').prop('disabled', true);
    }
    // check or uncheck the header checkbox based on the state of the row checkboxes
    $('#selectAll').prop('checked', $('input[type="checkbox"]', '#inventoryTable tbody').length === $('input[type="checkbox"]:checked', '#inventoryTable tbody').length);
});

$('#selectAll').on('change', function () {
    var isChecked = $(this).is(':checked');
    var table = $('#inventoryTable').DataTable();
    $('#btnArchiveAllInventory').prop('disabled', !isChecked);
    $('#btnDeleteAllInventory').prop('disabled', !isChecked);
    // check or uncheck all row checkboxes based on the state of the header checkbox
    table.rows().every(function () {
        var rowNode = this.node();
        $('input[type="checkbox"]', rowNode).prop('checked', isChecked);
    });
});

$(document).on('click', '.archiveAllDataInventory', function () {
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

$(document).on('click', '.btnArchiveAllInventory', function () {
    var inventoryIdString = $('#hdnAllInventoryId').val();
    if (inventoryIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var inventoryId = JSON.parse(inventoryIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/restoreAllInventory',
        type: 'POST',
        data: { inventoryId },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#inventoryTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAllInventory').prop('disabled', true);
            $('#btnDeleteAllInventory').prop('disabled', true);
            alertify.success('Inventories Restored Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#inventoryTable tbody').length > 0;
            if (isChecked) {
                $('#btnArchiveAllInventory').prop('disabled', false);
                $('#btnDeleteAllInventory').prop('disabled', false);
            } else {
                $('#btnArchiveAllInventory').prop('disabled', true);
                $('#selectAll').prop('checked', false);
                $('#btnDeleteAllInventory').prop('disabled', true);
            }
        }
    });
    $('#restoreAllModalInventory').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
})


$(document).on('click', '.deleteAllDataInventory', function () {
    var checkboxes = $(".data_checkbox:checked");
    if (checkboxes.length > 0) {
        var inventoryId = [];
        checkboxes.each(function () {
            inventoryId.push($(this).val());
        })
        var inventoryIdString = JSON.stringify(inventoryId);
        $('#hdnAllInventoryIdDelete').val(inventoryIdString);
    }
})

$(document).on('click', '.btnDeleteAllInventory', function () {
    var inventoryIdString = $('#hdnAllInventoryIdDelete').val();
    if (inventoryIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var inventoryId = JSON.parse(inventoryIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/deleteAllInventory',
        type: 'POST',
        data: { inventoryId },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#inventoryTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAllInventory').prop('disabled', true);
            $('#btnDeleteAllInventory').prop('disabled', true);
            alertify.success('Inventories Deleted Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#inventoryTable tbody').length > 0;
            if (isChecked) {
                $('#btnArchiveAllInventory').prop('disabled', false);
                $('#btnDeleteAllInventory').prop('disabled', false);
            } else {
                $('#btnArchiveAllInventory').prop('disabled', true);
                $('#selectAll').prop('checked', false);
                $('#btnDeleteAllInventory').prop('disabled', true);
            }
        }
    });
    $('#deleteAllModalInventory').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
})

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

$('#productTable tbody').on('change', 'input[type="checkbox"]', function () {
    var isChecked = $('input[type="checkbox"]:checked', '#productTable tbody').length > 0;
    if (isChecked) {
        $('#btnArchiveAllProducts').prop('disabled', false);
        $('#btnDeleteAllProducts').prop('disabled', false);
    } else {
        $('#btnArchiveAllProducts').prop('disabled', true);
        $('#btnDeleteAllProducts').prop('disabled', true);
    }
    // check or uncheck the header checkbox based on the state of the row checkboxes
    $('#selectAllProducts').prop('checked', $('input[type="checkbox"]', '#productTable tbody').length === $('input[type="checkbox"]:checked', '#productTable tbody').length);
});

$('#selectAllProducts').on('change', function () {
    var isChecked = $(this).is(':checked');
    var table = $('#productTable').DataTable();
    $('#btnArchiveAllProducts').prop('disabled', !isChecked);
    $('#btnDeleteAllProducts').prop('disabled', !isChecked);
    // check or uncheck all row checkboxes based on the state of the header checkbox
    table.rows().every(function () {
        var rowNode = this.node();
        $('input[type="checkbox"]', rowNode).prop('checked', isChecked);
    });
});


$('#categoryTable tbody').on('change', 'input[type="checkbox"]', function () {
    var isChecked = $('input[type="checkbox"]:checked', '#categoryTable tbody').length > 0;
    if (isChecked) {
        $('#btnArchiveAllCategory').prop('disabled', false);
        $('#btnDeleteAllCategory').prop('disabled', false);
    } else {
        $('#btnArchiveAllCategory').prop('disabled', true);
        $('#btnDeleteAllCategory').prop('disabled', true);
    }
    // check or uncheck the header checkbox based on the state of the row checkboxes
    $('#selectAllCategory').prop('checked', $('input[type="checkbox"]', '#categoryTable tbody').length === $('input[type="checkbox"]:checked', '#categoryTable tbody').length);
});

$('#selectAllCategory').on('change', function () {
    var isChecked = $(this).is(':checked');
    var table = $('#categoryTable').DataTable();
    $('#btnArchiveAllCategory').prop('disabled', !isChecked);
    $('#btnDeleteAllCategory').prop('disabled', !isChecked);
    // check or uncheck all row checkboxes based on the state of the header checkbox
    table.rows().every(function () {
        var rowNode = this.node();
        $('input[type="checkbox"]', rowNode).prop('checked', isChecked);
    });
});

$('body').on('click', '.btnViewCategory', function () {
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

$(document).on('click', '.archiveAllDataCategory', function () {
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

$(document).on('click', '.btnRestoreAllCategory', function () {
    var categoryIdString = $('#hdnAllCategoryId').val();
    if (categoryIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var categoryID = JSON.parse(categoryIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/restoreAllCategory',
        type: 'POST',
        data: { categoryID },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#categoryTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAllCategory').prop('disabled', true);
            $('#btnDeleteAllCategory').prop('disabled', true);
            alertify.success('Categories Restored Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#categoryTable tbody').length > 0;
            if (isChecked) {
                $('#btnArchiveAllCategory').prop('disabled', false);
                $('#btnDeleteAllCategory').prop('disabled', false);
            } else {
                $('#btnArchiveAllCategory').prop('disabled', true);
                $('#selectAllCategory').prop('checked', false);
                $('#btnDeleteAllCategory').prop('disabled', true);
            }
        }
    });
    $('#restoreAllModalCategory').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
})


$(document).on('click', '.deleteAllDataCategory', function () {
    var checkboxes = $(".data_checkbox:checked");
    if (checkboxes.length > 0) {
        var categoryId = [];
        checkboxes.each(function () {
            categoryId.push($(this).val());
        })
        var categoryIdString = JSON.stringify(categoryId);
        $('#hdnAllCategoryIdDelete').val(categoryIdString);
    }
})


$(document).on('click', '.btnDeleteAllCategory', function () {
    var categoryIdString = $('#hdnAllCategoryIdDelete').val();
    if (categoryIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var categoryID = JSON.parse(categoryIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/deleteAllCategory',
        type: 'POST',
        data: { categoryID },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#categoryTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAllCategory').prop('disabled', true);
            $('#btnDeleteAllCategory').prop('disabled', true);
            alertify.success('Categories Deleted Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#categoryTable tbody').length > 0;
            if (isChecked) {
                $('#btnArchiveAllCategory').prop('disabled', false);
                $('#btnDeleteAllCategory').prop('disabled', false);
            } else {
                $('#btnArchiveAllCategory').prop('disabled', true);
                $('#selectAllCategory').prop('checked', false);
                $('#btnDeleteAllCategory').prop('disabled', true);
            }
        }
    });
    $('#deleteAllModalCategory').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
})



$('body').on('click', '.btnViewSupplier', function () {
    var supplierId = $(this).attr('data-id');
    $('#supplierModalView #txtViewSupplierId').val(supplierId);
    $.ajax({
        url: 'view-supplier/' + supplierId,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            let result = res.find(supplier => supplier.supplierId == supplierId);
            $('#supplierModalView #txtViewSupplier').val(result.supplierName);
            $('#supplierModalView #txtViewPhoneNumber').val(result.phoneNumber);
            $('#supplierModalView #txtViewEmail').val(result.emailAddress);
        },
        error: function (data) {
        }
    });
});


$('#supplierTable tbody').on('change', 'input[type="checkbox"]', function () {
    var isChecked = $('input[type="checkbox"]:checked', '#supplierTable tbody').length > 0;
    if (isChecked) {
        $('#btnArchiveAllSupplier').prop('disabled', false);
        $('#btnDeleteAllSupplier').prop('disabled', false);
    } else {
        $('#btnArchiveAllSupplier').prop('disabled', true);
        $('#btnDeleteAllSupplier').prop('disabled', true);
    }
    // check or uncheck the header checkbox based on the state of the row checkboxes
    $('#selectAllSupplier').prop('checked', $('input[type="checkbox"]', '#supplierTable tbody').length === $('input[type="checkbox"]:checked', '#supplierTable tbody').length);
});

$('#selectAllSupplier').on('change', function () {
    var isChecked = $(this).is(':checked');
    var table = $('#supplierTable').DataTable();
    $('#btnArchiveAllSupplier').prop('disabled', !isChecked);
    $('#btnDeleteAllSupplier').prop('disabled', !isChecked);
    // check or uncheck all row checkboxes based on the state of the header checkbox
    table.rows().every(function () {
        var rowNode = this.node();
        $('input[type="checkbox"]', rowNode).prop('checked', isChecked);
    });
});



$(document).on('click', '.archiveAllDataSupplier', function () {
    var checkboxes = $(".data_checkbox:checked");
    if (checkboxes.length > 0) {
        var categoryId = [];
        checkboxes.each(function () {
            categoryId.push($(this).val());
        })
        var categoryIdString = JSON.stringify(categoryId);
        $('#hdnAllSupplierId').val(categoryIdString);
    }
})

$(document).on('click', '.btnRestoreAllSupplier', function () {
    var categoryIdString = $('#hdnAllSupplierId').val();
    if (categoryIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var supplierID = JSON.parse(categoryIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/restoreAllSupplier',
        type: 'POST',
        data: { supplierID },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#supplierTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAllSupplier').prop('disabled', true);
            alertify.success('Suppliers Restored Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#supplierTable tbody').length > 0;
            if (isChecked) {
                $('#btnArchiveAllSupplier').prop('disabled', false);
                $('#btnDeleteAllSupplier').prop('disabled', false);
            } else {
                $('#btnArchiveAllSupplier').prop('disabled', true);
                $('#selectAllSupplier').prop('checked', false);
                $('#btnDeleteAllSupplier').prop('disabled', true);
            }
        }
    });
    $('#restoreAllModalSupplier').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
})



$(document).on('click', '.deleteAllDataSupplier', function () {
    var checkboxes = $(".data_checkbox:checked");
    if (checkboxes.length > 0) {
        var categoryId = [];
        checkboxes.each(function () {
            categoryId.push($(this).val());
        })
        var categoryIdString = JSON.stringify(categoryId);
        $('#hdnAllSupplierIdDelete').val(categoryIdString);
    }
})


$(document).on('click', '.btnDeleteAllSupplier', function () {
    var categoryIdString = $('#hdnAllSupplierIdDelete').val();
    if (categoryIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var categoryID = JSON.parse(categoryIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/deleteAllSuppliers',
        type: 'POST',
        data: { categoryID },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#supplierTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAllSupplier').prop('disabled', true);
            $('#btnDeleteAllSupplier').prop('disabled', true);
            alertify.success('Suppliers Deleted Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#supplierTable tbody').length > 0;
            if (isChecked) {
                $('#btnArchiveAllSupplier').prop('disabled', false);
                $('#btnDeleteAllSupplier').prop('disabled', false);
            } else {
                $('#btnArchiveAllSupplier').prop('disabled', true);
                $('#selectAllSupplier').prop('checked', false);
                $('#btnDeleteAllSupplier').prop('disabled', true);
            }
        }
    });
    $('#deleteAllModalSupplier').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
})

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


$(document).on('click', '.archiveAllDataProducts', function () {
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


$(document).on('click', '.btnRestoreProducts', function () {
    var productIdString = $('#hdnAllProductId').val();
    if (productIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var productId = JSON.parse(productIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/restoreAllProducts',
        type: 'POST',
        data: { productId },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#productTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAllProducts').prop('disabled', true);
            $('#btnDeleteAllProducts').prop('disabled', true);
            alertify.success('Products Restored Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#productTable tbody').length > 0;
            if (isChecked) {
                $('#btnArchiveAllProducts').prop('disabled', false);
                $('#btnDeleteAllProducts').prop('disabled', false);
            } else {
                $('#btnArchiveAllProducts').prop('disabled', true);
                $('#selectAllSupplier').prop('checked', false);
                $('#btnDeleteAllProducts').prop('disabled', true);
            }
        }
    });
    $('#restoreAllModalProducts').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
})


$(document).on('click', '.deleteAllDataProducts', function () {
    var checkboxes = $(".data_checkbox:checked");
    if (checkboxes.length > 0) {
        var productId = [];
        checkboxes.each(function () {
            productId.push($(this).val());
        })
        var productIdString = JSON.stringify(productId);
        $('#hdnAllProductIdDelete').val(productIdString);
    }
})



$(document).on('click', '.btnDeleteProducts', function () {
    var productIdString = $('#hdnAllProductIdDelete').val();
    if (productIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var productId = JSON.parse(productIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/deleteAllProducts',
        type: 'POST',
        data: { productId },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#productTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAllProducts').prop('disabled', true);
            $('#btnDeleteAllProducts').prop('disabled', true);
            alertify.success('Products Deleted Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#productTable tbody').length > 0;
            if (isChecked) {
                $('#btnArchiveAllProducts').prop('disabled', false);
                $('#btnDeleteAllProducts').prop('disabled', false);
            } else {
                $('#btnArchiveAllProducts').prop('disabled', true);
                $('#selectAllSupplier').prop('checked', false);
                $('#btnDeleteAllProducts').prop('disabled', true);
            }
        }
    });
    $('#deleteAllModalProducts').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
})
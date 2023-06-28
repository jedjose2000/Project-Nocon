$(document).ready(function () {
    $('#supplierTable').DataTable({
        "columnDefs": [
            // { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 4 }
        ],
        order: [[1, 'asc']]
    });

    $('#supplierModalUpdate').on('hidden.bs.modal', function () {
        $('#formCategoryUpdate')[0].reset(); // Reset the form fields
        $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
        $('.invalid-feedback').html(''); // Clear the error messages
    });

    $('#createModal').on('hidden.bs.modal', function () {
        $('#formCategory')[0].reset(); // Reset the form fields
        $('.is-invalid').removeClass('is-invalid'); // Remove the validation error styling
        $('.invalid-feedback').html(''); // Clear the error messages
    });


    var table = $('#supplierTable').DataTable();
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

$.validator.addMethod('cellphonePH', function (value) {
    return /^09\d{9}$/.test(value);
}, 'Please enter a valid cellphone number in the Philippine format (e.g., 09123456789)');


if (window.localStorage.getItem('show_popup_update') == 'true') {
    alertify.success('Supplier Updated');
    window.localStorage.setItem('show_popup_update', 'false');
}

if (window.localStorage.getItem('show_popup_add') == 'true') {
    alertify.success('Supplier Added');
    window.localStorage.setItem('show_popup_add', 'false');
}

if (window.localStorage.getItem('show_popup_failed') == 'true') {
    alertify.error('Error');
    window.localStorage.setItem('show_popup_failed', 'false');
}


$("#formSupplier").validate({
    rules: {
        txtSupplier: {
            required: true,
            noSpace: true,
            remote: {
                url: "checkSupplierNameExists",
                type: "post",
                data: {
                    txtSupplier: function () {
                        return $("#txtSupplier").val();
                    }
                }
            },
        },
        txtPhoneNumber: {
            required: true,
            noSpace: true,
            cellphonePH: true
        },
        txtEmail: {
            required: true,
            noSpace: true,
        }
    },
    messages: {
        txtSupplier: {
            required: "Please enter a supplier name.",
            remote: "Supplier name already exists!",
            noSpace: "Please enter a supplier name.",
        },
        txtPhoneNumber: {
            required: "Please enter a phone number.",
            noSpace: "Please enter a phone number.",
            cellphonePH: "Please enter a valid cellphone number in the Philippine format (e.g., 09123456789)",
        },
        txtEmail: {
            required: "Please enter a valid email.",
            noSpace: "Please enter a valid email.",
        },
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") === "txtSupplier") {
            $(".supplier-error").html(error); // Set the error message inside the category-error element
            $(".supplier-error"); // Show the error message
        } else if (element.attr("name") === "txtPhoneNumber") {
            $(".supplier-phone-error").html(error); // Set the error message inside the category-description-error element
            $(".supplier-phone-error"); // Show the error message
        }
        else if (element.attr("name") === "txtEmail") {
            $(".supplier-email-error").html(error); // Set the error message inside the category-description-error element
            $(".supplier-email-error"); // Show the error message
        }
    },
    highlight: function (element) {
        $(element).addClass("is-invalid");
    },
    unhighlight: function (element) {
        $(element).removeClass("is-invalid");
        $(element).siblings(".error").empty(); // Remove the error message when unhighlighting the element
    },
    success: function (label) {
        label.removeClass("error"); // Remove the "error" class from the label
    },
    submitHandler: function (form) {
        var supplierName = $('#txtSupplier').val();
        var phoneNumber = $('#txtPhoneNumber').val();
        var emailAddress = $('#txtEmail').val();
        $.ajax({
            url: '/insertSupplier',
            type: 'POST',
            data: { supplierName: supplierName, phoneNumber: phoneNumber, emailAddress: emailAddress },
            success: function (data) {
                if (data === 'Transaction success.') {
                    window.localStorage.setItem('show_popup_add', 'true');
                    window.location.reload();
                } else {
                    window.localStorage.setItem('show_popup_failed', 'true');
                    window.location.reload();
                }
                // Handle the success response and perform necessary actions

                $('#supplierModal').modal('hide');
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


$('body').on('click', '.btnUpdate', function () {
    var supplierId = $(this).attr('data-id');
    $('#supplierModalUpdate #txtUpdateSupplierId').val(supplierId);
    $.ajax({
        url: 'view-supplier/' + supplierId,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            let result = res.find(supplier => supplier.supplierId == supplierId);
            $('#supplierModalUpdate #txtUpdateSupplier').val(result.supplierName);
            $('#supplierModalUpdate #txtUpdatePhoneNumber').val(result.phoneNumber);
            $('#supplierModalUpdate #txtUpdateEmail').val(result.emailAddress);
        },
        error: function (data) {
        }
    });
});


$('body').on('click', '.btnView', function () {
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


$("#formUpdateSupplier").validate({
    rules: {
        txtUpdateSupplier: {
            required: true,
            noSpace: true,
            remote: {
                url: "checkUpdateSupplierNameExists",
                type: "post",
                data: {
                    txtUpdateSupplier: function () {
                        return $("#txtUpdateSupplier").val();
                    },
                    txtUpdateSupplierId: function () {
                        return $("#txtUpdateSupplierId").val();
                    }
                }
            },
        },
        txtUpdatePhoneNumber: {
            required: true,
            noSpace: true,
            cellphonePH: true
        },
        txtUpdateEmail: {
            required: true,
            noSpace: true,
        }
    },
    messages: {
        txtUpdateSupplier: {
            required: "Please enter a supplier name.",
            remote: "Supplier name already exists!",
            noSpace: "Please enter a supplier name.",
        },
        txtUpdatePhoneNumber: {
            required: "Please enter a phone number.",
            noSpace: "Please enter a phone number.",
            cellphonePH: "Please enter a valid cellphone number in the Philippine format (e.g., 09123456789)",
        },
        txtUpdateEmail: {
            required: "Please enter a valid email.",
            noSpace: "Please enter a valid email.",
        },
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") === "txtUpdateSupplier") {
            $(".supplier-error").html(error); // Set the error message inside the category-error element
            $(".supplier-error"); // Show the error message
        } else if (element.attr("name") === "txtUpdatePhoneNumber") {
            $(".supplier-phone-error").html(error); // Set the error message inside the category-description-error element
            $(".supplier-phone-error"); // Show the error message
        }
        else if (element.attr("name") === "txtUpdateEmail") {
            $(".supplier-email-error").html(error); // Set the error message inside the category-description-error element
            $(".supplier-email-error"); // Show the error message
        }
    },
    highlight: function (element) {
        $(element).addClass("is-invalid");
    },
    unhighlight: function (element) {
        $(element).removeClass("is-invalid");
        $(element).siblings(".error").empty(); // Remove the error message when unhighlighting the element
    },
    success: function (label) {
        label.removeClass("error"); // Remove the "error" class from the label
    },
    submitHandler: function (form) {
        var supplierId = $('#txtUpdateSupplierId').val();
        var supplierName = $('#txtUpdateSupplier').val();
        var phoneNumber = $('#txtUpdatePhoneNumber').val();
        var emailAddress = $('#txtUpdateEmail').val();
        $.ajax({
            url: '/insertSupplier',
            type: 'POST',
            data: { supplierName: supplierName, phoneNumber: phoneNumber, emailAddress: emailAddress, supplierId: supplierId },
            success: function (data) {
                if (data === 'Transaction success.') {
                    window.localStorage.setItem('show_popup_update', 'true');
                    window.location.reload();
                } else {
                    window.localStorage.setItem('show_popup_failed', 'true');
                    window.location.reload();
                }
                // Handle the success response and perform necessary actions

                $('#supplierModal').modal('hide');
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

$('#supplierTable tbody').on('change', 'input[type="checkbox"]', function () {
    var isChecked = $('input[type="checkbox"]:checked', '#supplierTable tbody').length > 0;
    if (isChecked) {
        $('#btnArchiveAll').prop('disabled', false);
    } else {
        $('#btnArchiveAll').prop('disabled', true);
    }
    // check or uncheck the header checkbox based on the state of the row checkboxes
    $('#selectAll').prop('checked', $('input[type="checkbox"]', '#supplierTable tbody').length === $('input[type="checkbox"]:checked', '#supplierTable tbody').length);

});

$('#selectAll').on('change', function () {
    var isChecked = $(this).is(':checked');
    var table = $('#supplierTable').DataTable();
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
        var categoryId = [];
        checkboxes.each(function () {
            categoryId.push($(this).val());
        })
        var categoryIdString = JSON.stringify(categoryId);
        $('#hdnAllCategoryId').val(categoryIdString);
    }
})


$(document).on('click', '.btnArchiveAll', function () {
    var supplierIdString = $('#hdnAllCategoryId').val();


    if (supplierIdString === "") {
        alertify.error('Please select rows to archive!');
        return;
    }
    var supplierID = JSON.parse(supplierIdString);
    var checkboxes = $(".data_checkbox:checked");
    $.ajax({
        url: '/archiveAllSupplier',
        type: 'POST',
        data: { supplierID },
        success: function (data) {
            checkboxes.each(function () {
                var row = $(this).closest('tr');
                var table = $('#supplierTable').DataTable();
                table.row(row).remove().draw(false);
            });
            $('#btnArchiveAll').prop('disabled', true);
            alertify.success('Suppliers Archived Successfully');
            var isChecked = $('input[type="checkbox"]:checked', '#supplierTable tbody').length > 0;
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







document.getElementById("txtSupplier").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[a-zA-Z\s]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});

document.getElementById("txtUpdateSupplier").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[a-zA-Z\s]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});


document.getElementById("txtPhoneNumber").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[0-9]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});

document.getElementById("txtUpdatePhoneNumber").addEventListener("keypress", function (event) {
    var key = event.keyCode || event.which;
    var keychar = String.fromCharCode(key);
    var regex = /[0-9]/;

    if (!regex.test(keychar)) {
        event.preventDefault();
        return false;
    }
});

$('body').on('click', '.btnArchiveSupplier', function () {
    var supplierId = $(this).attr('data-id');
    $('#archiveSupplierModal #hdnId').val(supplierId);
});

$('body').on('click', '.btnConfirmArchiveSupplier', function () {
    var supplierId = $("#hdnId").val();
    var table = $('#supplierTable').DataTable();
    $.ajax({
        url: '/getIDSupplier',
        type: 'POST',
        data: { supplierId },
        success: function (data) {
            console.log(data);
            table.row('#' + supplierId).remove().draw();
            // re-check the status of the checkboxes after the AJAX call
            var isChecked = $('input[type="checkbox"]:checked', '#supplierTable tbody').length > 0;
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
            alertify.success('Supplier Archived Successfully');
            table.page.len(table.page.len()).draw();
        }
    });
    $('#archiveSupplierModal').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
});
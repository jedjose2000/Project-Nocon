
$(document).ready(function () {
    let reportsTable = $('#reportsTable').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": 6 },
        ],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copy', exportOptions: { columns: [0, 1, 2, 3, 4] } },
            { extend: 'csv', exportOptions: { columns: [0, 1, 2, 3, 4] } },
            { extend: 'excel', exportOptions: { columns: [0, 1, 2, 3, 4] } },
            { extend: 'pdf', exportOptions: { columns: [0, 1, 2, 3, 4] } },
            { extend: 'print', exportOptions: { columns: [0, 1, 2, 3, 4] } }
        ]
    });


    $('#transactionTable').DataTable({
        "columnDefs": [
            // { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 7 }
        ],
        order: [[1, 'asc']]
    });



    $(function () {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY hh:mm:ss A') + ' - ' + end.format('MMMM D, YYYY hh:mm:ss A'));
            minDate = new Date(start);
            maxDate = new Date(end);
            reportsTable.draw();
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            "timePicker": true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });



    var minDate, maxDate;

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable !== reportsTable.table().node()) {
            return true;
        }

        var min = minDate;
        var max = maxDate;
        var date = new Date(data[5].replace(/,/g, '').replace(/(\d{1,2})(?:st|nd|rd|th)/g, '$1'));

        if ((min === null && max === null) ||
            (min === null && date <= max) ||
            (min <= date && max === null) ||
            (min <= date && date <= max)) {
            return true;
        }

        return false;

    });

    window.localStorage.setItem('show_popup_update', 'false');
});


if (window.localStorage.getItem('show_popup_update') == 'true') {
    alertify.success('Transaction Deleted');
    window.localStorage.setItem('show_popup_update', 'false');
}




$(document).on('click', '.btnViewProductHistory', function () {
    var productId = $(this).attr('data-id');
    $('#viewProductHistory #txtHistoryProductIdStockOut').val(productId);
    $.ajax({
        url: 'view-productHistory',
        type: "GET",
        dataType: 'json',
        data: { productId: productId },
        success: function (res) {
            document.getElementById('productHistoryTableContainer').innerHTML = "";
            document.getElementById('productHistoryTableContainer').innerHTML = `<table id="productTableHistory" class="display" style="width:100%"></table>`;
            let productHistoryDataSet = [];
            res.reportsProduct.forEach(element => {
                let formattedDate = new Date(element.dateOfTransaction);
                let month = formattedDate.toLocaleString('default', { month: 'long' });
                let day = formattedDate.getDate();
                let year = formattedDate.getFullYear();
                let hour = formattedDate.getHours();
                let minute = formattedDate.getMinutes();
                let period = hour >= 12 ? 'PM' : 'AM';

                // Adjust hour to 12-hour format
                hour = hour % 12 || 12;

                let formattedDateString = `${month} ${day}, ${year} ${hour}:${minute.toString().padStart(2, '0')} ${period}`;

                let formattedTotal = new Intl.NumberFormat('en-PH', {
                    style: 'currency',
                    currency: 'PHP',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(element.total);

                productHistoryDataSet.push([
                    formattedDateString,
                    element.quantity,
                    formattedTotal,
                ]);
            });


            const stockInTable = $('#productTableHistory').DataTable({
                data: productHistoryDataSet,
                columns: [
                    { title: 'Date of Transaction' },
                    { title: 'Total Quantity Sold' },
                    { title: 'Total Price' },
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
})



$(document).on('click', '.btnViewReceipt', function () {
    var receiptId = $(this).attr('data-id');
    $('#viewReceipt #txtReceiptId').val(receiptId);
    var transactionId = $(this).attr('transaction-id');
    $.ajax({
        url: 'view-productReceipt',
        type: "GET",
        dataType: 'json',
        data: { receiptId: receiptId, transactionId: transactionId },
        success: function (res) {
            let result = res.viewReceipt.find(receipt => receipt.receiptId == receiptId);
            document.getElementById('productReceiptContainer').innerHTML = "";
            document.getElementById('productReceiptContainer').innerHTML = `<table id="productReceiptTable" class="display" style="width:100%"></table>`;

            var formattedPayment = result.payment.toLocaleString();
            formattedPayment = formattedPayment.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#viewReceipt #txtTotalAmount').val(formattedPayment);

            var formattedTotalPrice = result.totalPrice.toLocaleString();
            formattedTotalPrice = formattedTotalPrice.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#viewReceipt #txtTotalPrice').val(formattedTotalPrice);

            var formattedChange = result.paymentChange.toLocaleString();
            formattedChange = formattedChange.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#viewReceipt #txtChange').val(formattedChange);
            $('#viewReceipt #txtDiscount').val(result.discount);
            $('#viewReceipt #txtReceiptCode').val(result.receiptCode);


            let productHistoryDataSet = [];
            res.receiptProduct.forEach(element => {

                let formattedTotal = new Intl.NumberFormat('en-PH', {
                    style: 'currency',
                    currency: 'PHP',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(element.total);

                formattedTotal = formattedTotal.replace(/PHP/, '').trim();

                let formattedPrice = new Intl.NumberFormat('en-PH', {
                    style: 'currency',
                    currency: 'PHP',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(element.price);

                formattedPrice = formattedPrice.replace(/PHP/, '').trim();


                productHistoryDataSet.push([
                    element.productName,
                    formattedPrice,
                    element.quantity,
                    formattedTotal,
                ]);
            });

            const productReceiptTable = $('#productReceiptTable').DataTable({
                data: productHistoryDataSet,
                columns: [
                    { title: 'Product Name' },
                    { title: 'Price per Item' },
                    { title: 'Quantity' },
                    { title: 'Total Price' },
                ],
                columnDefs: [
                    {
                        targets: [0, 1, 2, 3], // the first column
                        className: 'text-center', // the CSS class to apply
                    },
                ],
                order: [[0, 'desc']]
            });
        },
        error: function (data) {
        }
    });
})


$('body').on('click', '.btnVoid', function () {
    var receiptId = $(this).attr('data-id');
    $('#voidModal #hdnReceiptId').val(receiptId);
    var transactionId = $(this).attr('transaction-id');
    $('#voidModal #hdnTransactionId').val(transactionId);
});



$('body').on('click', '.btnConfirmVoid', function () {
    var receiptId = $('#hdnReceiptId').val();
    var transactionId = $('#hdnTransactionId').val();
    $.ajax({
        url: '/voidProduct',
        type: 'POST',
        data: { receiptId: receiptId, transactionId: transactionId },
        success: function (data) {
            window.localStorage.setItem('show_popup_update', 'true');
            window.location.reload();
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
})


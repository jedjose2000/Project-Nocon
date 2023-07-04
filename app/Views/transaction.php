<?php include("shared/dashboard/head-dashboard.php"); ?>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



<div class="wrapper">


    <?php include("shared/dashboard/navbar-dashboard.php"); ?>

    <?php include("shared/dashboard/sidenav-dashboard.php"); ?>


    <div class="content-wrapper">

        <div class="rounded m-2 p-2">
            <div>
                <div class="bg-white rounded m-4 p-4">
                    <div class="pb-3 mb-2">
                        <div class="border p-2 rounded">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#employeeArchive"
                                        data-bs-toggle="tab">Sales
                                        Report</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#patientArchive" data-bs-toggle="tab">Transactions</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active mt-3" id="employeeArchive">
                                    <div id="reportrange" class="float-left mb-3">
                                        <i class="far fa-calendar-alt"></i>
                                        <span title="Select Date Filter" class="date-range"></span>
                                        <i class="fas fa-caret-down"></i>
                                    </div>
                                    <table id="reportsTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Product Code</th>
                                                <th class="text-center">Product Name</th>
                                                <th class="text-center">Sell Price</th>
                                                <th class="text-center">Total Sold</th>
                                                <th class="text-center">Total Quantity Sold</th>
                                                <th class="text-center">Highest Sales Date</th>
                                                <th class="text-center">Actions</th>
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
                                                        &#8369;
                                                        <?php echo number_format($row->totalPrice, 2, '.', ',') ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->totalQuantity ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo (new DateTime($row->highestSalesDate))->format('F j, Y'); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button title="View Product"
                                                            class="btn btn-outline-primary btnViewProductHistory"
                                                            data-bs-toggle="modal" data-id="<?php echo $row->productId ?>"
                                                            data-bs-target="#viewProductHistory" id="btnViewProduct">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane mt-3" id="patientArchive">
                                    <table id="transactionTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Receipt Code</th>
                                                <th class="text-center">Total Price</th>
                                                <th class="text-center">Total Payment</th>
                                                <th class="text-center">Change</th>
                                                <th class="text-center">Discount</th>
                                                <th class="text-center">Date of Transaction</th>
                                                <th class="text-center">Payment Type</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($resultReceipts as $row) {
                                                ?>
                                                <tr id="<?php echo $row->receiptId ?>">
                                                    <td class="text-center">
                                                        <?php echo $row->receiptCode ?>
                                                    </td>
                                                    <td class="text-center">
                                                        &#8369;
                                                        <?php echo number_format($row->totalPrice, 2, '.', ',') ?>
                                                    </td>
                                                    <td class="text-center">
                                                        &#8369;
                                                        <?php echo number_format($row->payment, 2, '.', ',') ?>
                                                    </td>
                                                    <td class="text-center">
                                                        &#8369;
                                                        <?php echo number_format($row->paymentChange, 2, '.', ',') ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo ($row->discount == "0.00") ? "No Discount" : $row->discount . "%" ?>
                                                    </td>

                                                    <td class="text-center">
                                                        <?php echo (new DateTime($row->dateOfTransaction))->format('F j, Y'); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $row->paymentType ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button title="View Receipt"
                                                            class="btn btn-outline-primary btnViewReceipt"
                                                            data-bs-toggle="modal" data-id="<?php echo $row->receiptId ?>"
                                                            transaction-id="<?php echo $row->transactionId ?>"
                                                            data-bs-target="#viewReceipt" id="btnViewReceipt">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                        <button title="Void Transaction"
                                                            class="btn btn-outline-danger btnVoid" data-bs-toggle="modal"
                                                            data-id="<?php echo $row->receiptId ?>"
                                                            transaction-id="<?php echo $row->transactionId ?>"
                                                            data-bs-target="#voidModal" id="btnVoid">
                                                            <i class="fas fa-slash"></i>
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
                    </div>

                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

            </div>
        </section>

    </div>


    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="viewProductHistory" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form>
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sales History</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="container p-3">
                        <input type="hidden" class="form-control" id="txtHistoryProductIdStockOut"
                            name="txtHistoryProductIdStockOut">
                        <h4 class=" mt-3">Product Sales History</h4> <!-- Add the title here -->
                        <div id="productHistoryTableContainer" class="border p-2 rounded">
                            <table id="productTableHistory" class="display" style="width:100%"></table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="viewReceipt" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form>
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Transaction</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="row gx-3 p-3">
                        <div class="col">

                            <div class="container border p-3">
                                <h4 class=" mt-3">Receipt</h4> <!-- Add the title here -->
                                <div class="receipt-input ms-3 mb-4">
                                    <label for="txtReceiptCode" class="form-label">Receipt Code</label>
                                    <input type="text" class="form-control" id="txtReceiptCode" name="txtReceiptCode"
                                        maxlength="5" disabled>
                                    <div class="invalid-feedback inventory-quantity-error"></div>
                                </div>
                                <div class="receipt-input ms-3 mb-4">
                                    <label for="txtTotalAmount" class="form-label">Total Payment</label>
                                    <input type="text" class="form-control" id="txtTotalAmount" name="txtTotalAmount"
                                        maxlength="5" disabled>
                                    <div class="invalid-feedback inventory-quantity-error"></div>
                                </div>

                                <div class="receipt-input ms-3 mb-4">
                                    <label for="txtChange" class="form-label">Change</label>
                                    <input type="text" class="form-control" id="txtChange" name="txtChange"
                                        maxlength="5" disabled>
                                    <div class="invalid-feedback inventory-quantity-error"></div>
                                </div>
                                <div class="receipt-input ms-3 mb-4">
                                    <label for="txtDiscount" class="form-label">Discount</label>
                                    <input type="text" class="form-control" id="txtDiscount" name="txtDiscount"
                                        maxlength="5" disabled>
                                    <div class="invalid-feedback inventory-quantity-error"></div>
                                </div>
                                <div class="receipt-input ms-3 mb-4">
                                    <label for="txtTotalPrice" class="form-label">Total Price</label>
                                    <input type="text" class="form-control" id="txtTotalPrice" name="txtTotalPrice"
                                        maxlength="5" disabled>
                                    <div class="invalid-feedback inventory-quantity-error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="container border p-3">
                                <input type="hidden" class="form-control" id="txtReceiptId" name="txtReceiptId">
                                <h4 class=" mt-3">Products Ordered</h4> <!-- Add the title here -->
                                <div id="productReceiptContainer" class="border p-2 rounded">
                                    <table id="productReceiptTable" class="display" style="width:100%"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="modal fade" id="voidModal" tabindex="-1" aria-labelledby="voidModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Void Transaction</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnReceiptId" id="hdnReceiptId" />
                    <input type="hidden" name="hdnTransactionId" id="hdnTransactionId" />
                    <p>Do you want to void the selected trasaction?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnConfirmVoid">Yes</button>
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
                    { "orderable": false, "targets": 6 }
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



    </script>



</div>




<?php include("shared/dashboard/footer-dashboard.php"); ?>
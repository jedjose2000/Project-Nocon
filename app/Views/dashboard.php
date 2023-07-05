<?php include("shared/dashboard/head-dashboard.php"); ?>

<div class="wrapper">

  <?php include("shared/dashboard/navbar-dashboard.php"); ?>

  <?php include("shared/dashboard/sidenav-dashboard.php"); ?>

  <div class="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
        </div>
      </div>
    </div>


    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-lg-3 col-3">

            <div class="small-box bg-success">
              <div class="inner">
                <h3>PHP
                  <?php echo number_format($overAllSales, 2, '.', ','); ?>
                </h3>
                <p>Overall Sales</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
              <a href="<?php echo base_url('/transaction'); ?>" class="small-box-footer">More info <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-3">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                  <?php echo $totalProducts; ?>
                </h3>
                <p>Total Products</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url('/product'); ?>" class="small-box-footer">More info <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-3">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>
                  <?php echo $totalStocksOnHand; ?>
                </h3>
                <p>Total Stocks On-hand</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('/inventory'); ?>" class="small-box-footer">More info <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-3">

            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
                  <?php echo $productsNearCriticalLevel; ?>
                </h3>
                <p>Products near Critical Level Quantity (CLQ)</p>
              </div>
              <div class="icon">
                <i class="fas fa-exclamation"></i>
              </div>
              <a href="<?php echo base_url('/inventory'); ?>" class="small-box-footer">More info <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>
    </section>
    <div class="form-group">
      <label for="floatingSelectGrid">Filter Date</label>
      <select class="" id="dateFilter" onchange="updateChart()">
        <option value="month">Month</option>
        <option value="week">Week</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>
        <option value="2023">2023</option>
      </select>
      <div class="chart-container">
        <canvas id="salesChart"></canvas>
      </div>
    </div>


    <script>
      // Retrieve the sales data from the PHP variable
      var salesData = <?= json_encode($salesData) ?>;

      // Extract the transaction dates and transaction counts from the salesData
      var transactionDates = salesData.map(function (data) {
        return data.transactionDate;
      });

      var transactionCounts = salesData.map(function (data) {
        return data.transactionCount;
      });

      // Create the chart using Chart.js
      var salesChartCanvas = document.getElementById("salesChart");
      var salesChart = new Chart(salesChartCanvas, {
        type: 'line',
        data: {
          labels: transactionDates,
          datasets: [{
            label: 'Number of Transactions',
            data: transactionCounts,
            fill: false,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            x: {
              display: true,
              title: {
                display: true,
                text: 'Date'
              }
            },
            y: {
              display: true,
              title: {
                display: true,
                text: 'Number of Transactions'
              },
              beginAtZero: true
            }
          },
          plugins: {
            title: {
              display: true,
              text: 'Sales Chart',
              font: {
                size: 16,
                weight: 'bold'
              }
            }
          }
        }
      });

      function updateChart() {
        // Get the selected filter option
        var filterOption = document.getElementById('dateFilter').value;

        // Update the chart data based on the selected filter option
        var filteredDates = [];
        var filteredTransactionCounts = [];

        if (filterOption === 'month') {
          // Filter logic for month
          // Example: Show data for the current month

          var currentDate = new Date();
          var currentMonth = currentDate.getMonth() + 1; // Months are zero-based
          var currentYear = currentDate.getFullYear();

          for (var i = 0; i < transactionDates.length; i++) {
            var date = new Date(transactionDates[i]);
            var month = date.getMonth() + 1;
            var year = date.getFullYear();

            if (month === currentMonth && year === currentYear) {
              filteredDates.push(transactionDates[i]);
              filteredTransactionCounts.push(transactionCounts[i]);
            }
          }
        } else if (filterOption === 'week') {
          // Filter logic for week
          // Example: Show data for the current week

          var currentDate = new Date();
          var currentWeek = getWeekNumber(currentDate);

          for (var i = 0; i < transactionDates.length; i++) {
            var date = new Date(transactionDates[i]);
            var week = getWeekNumber(date);

            if (week === currentWeek) {
              filteredDates.push(transactionDates[i]);
              filteredTransactionCounts.push(transactionCounts[i]);
            }
          }
        } else {
          // Filter logic for specific year
          // Example: Show data for the selected year

          var selectedYear = parseInt(filterOption);

          for (var i = 0; i < transactionDates.length; i++) {
            var date = new Date(transactionDates[i]);
            var year = date.getFullYear();

            if (year === selectedYear) {
              filteredDates.push(transactionDates[i]);
              filteredTransactionCounts.push(transactionCounts[i]);
            }
          }
        }

        // Update the chart data and labels
        salesChart.data.labels = filteredDates;
        salesChart.data.datasets[0].data = filteredTransactionCounts;

        // Update the chart
        salesChart.update();
      }

      // Function to get the week number of a date
      function getWeekNumber(date) {
        var onejan = new Date(date.getFullYear(), 0, 1);
        return Math.ceil(((date - onejan) / 86400000 + onejan.getDay() + 1) / 7);
      }

    </script>


  </div>


  <?php include("shared/dashboard/footer-dashboard.php"); ?>


  </html>
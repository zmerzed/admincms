<div id="layoutSidenav_content">
  <style>
    .container {
      padding: 5%;
    }
  </style>
  <?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';

  $error_messages = [];
  $year = isset($_GET['year']) ? $_GET['year'] : 2023;
  $month = isset($_GET['month']) ? $_GET['month'] : date('m');
  $monthName = date('M');
  $month_from = 1;
  $month_to = 12;
  $data = [];
  $barGraph = [];
  $barGraph[] = ["" . $year, 'Stock In', 'Stock Out'];

  foreach (range($month_from, $month_to) as $number) {

    $monthNumber = sprintf("%02d", $number);
    $date = "{$year}-{$monthNumber}-01";

    $monthData = [
      'month' => date("F", strtotime($date)),
      'month_value' => $number,
      'date' => $date
    ];

    $listing = productList([
      'date_from' => date("Y-m-01", strtotime($date)),
      'date_to' => date("Y-m-t", strtotime($date))
    ]);

    //  $monthData['listing'] = $listing;

    $params = [
      'date_from' => date("Y-m-01", strtotime($date)),
      'date_to' => date("Y-m-t", strtotime($date))
    ];

    $totalInMonth = productLogTotal($params, 'in');
    $totalOutMonth = productLogTotal($params, 'out');
    $monthData['total_in_month'] = (int) $totalInMonth;
    $monthData['total_out_month'] = (int) $totalOutMonth;

    $barGraph[] = [
      date("F", strtotime($date)),
      $monthData['total_in_month'],
      $monthData['total_out_month']
    ];

    $data[] = $monthData;
  }

  // Deal second graph
  $linearGraph[] = ['Month', 'In', 'Out'];
  $linearDate = "{$year}-{$month}-01";
  $linearGraphMonthName = "Month of " . date("F", strtotime($linearDate));
  $dateFrom = date("Y-m-01", strtotime($linearDate));
  $dateTo = date("Y-m-t", strtotime($linearDate));
  $params = [
    'date_from' => $dateFrom,
    'date_to' => $dateTo
  ];

  $monthProducts = productGetProductsByLogs($params);

  if (count($monthProducts) > 0) {
    foreach ($monthProducts as $productLog) {
      $params['product_id'] = $productLog->product_id;
      $totalInMonth = productLogTotal($params, 'in');
      $totalOutMonth = productLogTotal($params, 'out');
      $product = productFindById($productLog->product_id);
      if ($product) {
        $linearGraph[] = [$product->product_name, (int) $totalInMonth, (int) $totalOutMonth];
      }
    }
  } else {
    $linearGraph[] = [0, 0, 0];
  }
  ?>

  <div class="container" style="padding-bottom: 0">
    <div class="row">
      <div class="col">
        <button class="btn btn-primary" onclick="takeScreenShot()">Download as pdf</button>
      </div>
    </div>
  </div>
  <div class="container" id="dashboard">
    <div class="row">
      <div class="col">
        <div class="card mb-4">
          <div class="card-header">
          </div>
          <div class="card-body">
            <!-- first graph -->
            <div>
              <form method="GET" action="">
                <label>Year:</label>
                <select name="year">
                  <option value="2023" <?php echo $year == 2023 ? 'selected' : '' ?>>2023</option>
                </select>
            </div>
            <style>
              .bargraph {
                margin: 50px;
                padding: 10px;
              }
            </style>
            <div class="bargraph" id="barchart_material"></div>
            <script type="text/javascript">
              google.charts.load('current', {
                'packages': ['bar']
              });
              google.charts.setOnLoadCallback(drawChart);

              function drawChart() {
                let barGraphData = JSON.stringify(<?php echo json_encode($barGraph); ?>)
                barGraphData = JSON.parse(barGraphData);
                var data = google.visualization.arrayToDataTable(barGraphData);
                var options = {
                  chart: {
                    title: 'Stock In and Out Data',
                    subtitle: 'Stock In and Out Data: 2023',
                  },
                  bars: 'vertical'
                };

                var chart = new google.charts.Bar(document.getElementById('barchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
              }
            </script>
            <!-- end of first graph  -->
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="card mb-4">
          <div class="card-header">
          </div>
          <div class="card-body">
            <!-- second graph -->
            <div>
              <label>Month:</label>
              <select name="month">
                <option value="<?php echo $month ?>"><?php echo $monthName ?></option>
              </select>
              <input type="submit" value="run" />
              </form>
            </div>
            <style>
              .productgraph {
                margin-right: 40px;
                margin-top: 40px;
              }
            </style>
            <div class="productgraph" id="chart_div"></div>
            <script type="text/javascript">
              google.charts.load('current', {
                'packages': ['corechart']
              });
              google.charts.setOnLoadCallback(drawVisualization);

              function drawVisualization() {
                // Some raw data (not necessarily accurate)
                let linearGraphData = JSON.stringify(<?php echo json_encode($linearGraph); ?>)
                linearGraphData = JSON.parse(linearGraphData);
                let linearMonthName = <?php echo json_encode($linearGraphMonthName); ?>;
                let sample = [
                  // ['Month', 'Product 1 in', 'Product 1 out'],
                  ['Product 1', 165, 20],
                  ['Product 2', 165, 10],
                  ['Product 2', 165, 5],
                  ['Product 2', 165, 9],
                ];

                console.log('linear', linearGraphData)
                console.log('sample', sample)
                var data = google.visualization.arrayToDataTable(linearGraphData);

                var options = {
                  title: 'Product Overview',
                  vAxis: {
                    title: 'Quantity'
                  },
                  hAxis: {
                    title: linearMonthName
                  },
                  seriesType: 'bars',
                  series: {
                    10: {
                      type: 'line'
                    }
                  }
                };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                chart.draw(data, options);
              }
            </script>
            <!-- end of second graph -->
          </div>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col">
        <div class="card mb-4">
          <div class="card-header">
          </div>
          <div class="card-body">
            <!-- third graph -->
            <style>
              .axeschart {
                width: 100%;
                height: 450px;
              }
            </style>
            <div class="axeschart" id='myDiv'></div>

            <script type="text/javascript">
              d3.csv("https://raw.githubusercontent.com/plotly/datasets/master/finance-charts-apple.csv", function(err, rows) {
                function unpack(rows, key) {
                  return rows.map(function(row) {
                    return row[key];
                  });
                }
                console.log(rows)
                var x = unpack(rows, 'Date')
                var y = unpack(rows, 'AAPL.Volume')

                var trace = {
                  type: "scatter",
                  mode: "lines",
                  name: 'AAPL Volume',
                  x: x,
                  y: y,
                  line: {
                    color: 'green'
                  },
                }

                var data = [trace];

                var layout = {
                  title: 'Stocks Data Overview ',
                  xaxis: {
                    title: 'Month and Year',
                    titlefont: {
                      family: 'Arial, sans-serif',
                      size: 18,
                      color: 'black'
                    },
                    showticklabels: true,
                    tickangle: 'auto',
                    tickfont: {
                      family: 'Old Standard TT, serif',
                      size: 14,
                      color: 'grey'
                    },
                    exponentformat: 'e',
                    showexponent: 'all'
                  },
                  yaxis: {
                    title: 'Quantity',
                    titlefont: {
                      family: 'Arial, sans-serif',
                      size: 18,
                      color: 'black'
                    },
                    showticklabels: true,
                    tickangle: 45,
                    tickfont: {
                      family: 'Old Standard TT, serif',
                      size: 14,
                      color: 'grey'
                    },
                    exponentformat: 'e',
                    showexponent: 'all'
                  }
                };

                Plotly.newPlot('myDiv', data, layout);
              })
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    window.takeScreenShot = function() {
      html2canvas(document.getElementById('dashboard')).then(function(canvas) {
        var wid
        var hgt
        // document.body.appendChild(canvas)
        var img = canvas.toDataURL("image/png", wid = canvas.width, hgt = canvas.height);
        var hratio = hgt / wid
        var doc = new jsPDF('p', 'pt', 'a4');
        var width = doc.internal.pageSize.width;
        var height = width * hratio
        console.log('width', width / 2)
        console.log('height', height / 2)
        doc.addImage(img, 'JPEG', 20, 20, width / 1.2, height / 1.2);
        doc.save('product_overview.pdf');
      });
    }
  </script>
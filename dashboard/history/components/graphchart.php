<div id="layoutSidenav_content">
  <style>
    .container {
      padding: 1%;
    }
  </style>
  <?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';

  $error_messages = [];
  $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
  $graphicalYear = isset($_GET['graphicalYear']) ? $_GET['graphicalYear'] : date('Y');
  $month = isset($_GET['month']) ? $_GET['month'] : 1;

  $month_from = 1;
  $month_to = 12;
  $data = [];
  $barGraph[] = ["" . $graphicalYear, 'Stock In', 'Stock Out'];
  $products = productList([]);
  $graph1ProductId = isset($_GET['graph1_product_id']) ? $_GET['graph1_product_id'] : null;

  foreach (range($month_from, $month_to) as $number) {

    $monthNumber = sprintf("%02d", $number);
    $date = "{$graphicalYear}-{$monthNumber}-01";

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
      'date_to' => date("Y-m-t", strtotime($date)),
      'product_id' => $graph1ProductId
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



  <div class="container">

    <div class="row">
      <div class="col">
        <div class="card mb-4">
          <div class="card-header">
            <strong><i>Product Stock In / Out</i></strong>
          </div>
          <div class="card-body">
            <!-- first graph -->
            <div>
                <label>Product:</label>
                <select name="year" id="findProductChart1">
                  <?php foreach($products as $product) { ?>
                    <option value="<?php echo $product->product_id ?>" <?php echo $graph1ProductId == $product->product_id ? 'selected' : '' ?>><?php echo $product->product_name ?></option>
                  <?php } ?>  
                </select>
                <select name="graphicalYear" id="findGraphProductYear">
                  <option value="2020" <?php echo $graphicalYear == 2020 ? 'selected' : '' ?>>2020</option>
                  <option value="2021" <?php echo $graphicalYear == 2021 ? 'selected' : '' ?>>2021</option>
                  <option value="2022" <?php echo $graphicalYear == 2022 ? 'selected' : '' ?>>2022</option>
                  <option value="2023" <?php echo $graphicalYear == 2023 ? 'selected' : '' ?>>2023</option>
                  <option value="2024" <?php echo $graphicalYear == 2024 ? 'selected' : '' ?>>2024</option>
                  <option value="2025" <?php echo $graphicalYear == 2025 ? 'selected' : '' ?>>2025</option>
                  <option value="2026" <?php echo $graphicalYear == 2026 ? 'selected' : '' ?>>2026</option>
                  <option value="2027" <?php echo $graphicalYear == 2027 ? 'selected' : '' ?>>2027</option>
                  <option value="2028" <?php echo $graphicalYear == 2028 ? 'selected' : '' ?>>2028</option>
                  <option value="2029" <?php echo $graphicalYear == 2029 ? 'selected' : '' ?>>2029</option>
                  <option value="2030" <?php echo $graphicalYear == 2030 ? 'selected' : '' ?>>2030</option>
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
            <strong><i>Product Stock In / Out</i></strong>
          </div>
          <div class="card-body">
            <!-- second graph -->
            <div>
              <label>Month:</label>
              <select name="month" id="findProductChart2">
                <option value="01" <?php echo $month == 1 ? 'selected' : '' ?>>January</option>
                <option value="02" <?php echo $month == 2 ? 'selected' : '' ?>>Feburary</option>
                <option value="03" <?php echo $month == 3 ? 'selected' : '' ?>>March</option>
                <option value="04" <?php echo $month == 4 ? 'selected' : '' ?>>April</option>
                <option value="05" <?php echo $month == 5 ? 'selected' : '' ?>>May</option>
                <option value="06" <?php echo $month == 6 ? 'selected' : '' ?>>June</option>
                <option value="07" <?php echo $month == 7 ? 'selected' : '' ?>>July</option>
                <option value="08" <?php echo $month == 8 ? 'selected' : '' ?>>August</option>
                <option value="09" <?php echo $month == 9 ? 'selected' : '' ?>>September</option>
                <option value="10" <?php echo $month == 10 ? 'selected' : '' ?>>October</option>
                <option value="11" <?php echo $month == 11 ? 'selected' : '' ?>>November</option>
                <option value="12" <?php echo $month == 12 ? 'selected' : '' ?>>December</option>
              </select>
              <select name="year" id="findProductYear">
                <option value="2020" <?php echo $year == 2020 ? 'selected' : '' ?>>2020</option>
                <option value="2021" <?php echo $year == 2021 ? 'selected' : '' ?>>2021</option>
                <option value="2022" <?php echo $year == 2022 ? 'selected' : '' ?>>2022</option>
                <option value="2023" <?php echo $year == 2023 ? 'selected' : '' ?>>2023</option>
                <option value="2024" <?php echo $year == 2024 ? 'selected' : '' ?>>2024</option>
                <option value="2025" <?php echo $year == 2025 ? 'selected' : '' ?>>2025</option>
                <option value="2026" <?php echo $year == 2026 ? 'selected' : '' ?>>2026</option>
                <option value="2027" <?php echo $year == 2027 ? 'selected' : '' ?>>2027</option>
                <option value="2028" <?php echo $year == 2028 ? 'selected' : '' ?>>2028</option>
                <option value="2029" <?php echo $year == 2029 ? 'selected' : '' ?>>2029</option>
                <option value="2030" <?php echo $year == 2030 ? 'selected' : '' ?>>2030</option>
              </select>
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
                  title: '',
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
  </div>

  <script>

    $graph1ProductId = "<?php echo $graph1ProductId ?>";
    var month = "<?php echo $month; ?>";
    var year =  "<?php echo $year; ?>";
    var graphicalYear = "<?php echo $graphicalYear; ?>";
    console.log('year', year)
    var select1 = document.querySelector('#findProductChart1')
    select1.addEventListener('change',function(event){
        window.location.href = "/dashboard/history/graphical.php?graph1_product_id=" + this.value
    });

    var select2 = document.querySelector('#findProductChart2')
    select2.addEventListener('change',function(event){
        if ($graph1ProductId) {
          window.location.href = "/dashboard/history/graphical.php?graph1_product_id=" + $graph1ProductId + '&month=' + this.value + '&year=' + year
        } else {
          window.location.href = "/dashboard/history/graphical.php?month=" + this.value + '&year=' + year
        }
    });

    var select3 = document.querySelector('#findProductYear')
    select3.addEventListener('change',function(event){
      console.log('change')
        if ($graph1ProductId) {
          window.location.href = "/dashboard/history/graphical.php?graph1_product_id=" + $graph1ProductId + '&month=' + month + "&year=" + this.value
        } else {
          window.location.href = "/dashboard/history/graphical.php?month=" + month + "&year=" + this.value
        }
    });

    var select4 = document.querySelector('#findGraphProductYear')
    select4.addEventListener('change',function(event){
      console.log('change')
        if ($graph1ProductId) {
          window.location.href = "/dashboard/history/graphical.php?graph1_product_id=" + $graph1ProductId + '&month=' + month + "&year=" + year + '&graphicalYear=' + this.value
        } else {
          window.location.href = "/dashboard/history/graphical.php?month=" + month + "&year=" + year + '&graphicalYear=' + this.value 
        }
    });
  </script>

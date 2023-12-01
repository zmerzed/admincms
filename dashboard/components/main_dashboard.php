<div id="layoutSidenav_content">
  <style>
    .container {
      padding: 1%;
    }
  </style>
  <?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';

  $currentMonth = date('m');
  $currentYear = date("Y");
  $error_messages = [];
  $year = isset($_GET['year']) ? $_GET['year'] : 2023;
  $month = isset($_GET['month']) ? $_GET['month'] : date('m');
  $monthName = date('M');
  $month_from = 1;
  $month_to = 12;
  $data = [];
  $barGraph = [];
  $barGraph[] = ["" . $year, 'Stock In', 'Stock Out'];
  $products = productList([]);
  $graph1ProductId = isset($_GET['graph1_product_id']) ? $_GET['graph1_product_id'] : null;

  // Deal second graph
  $linearGraph[] = ['Month', 'Current Quantity'];
  $linearDate = "{$year}-{$month}-01";
  $linearGraphMonthName = "Month of " . date("F", strtotime($linearDate));
  $dateFrom = date("Y-m-01", strtotime($linearDate));
  $dateTo = date("Y-m-t", strtotime($linearDate));
  $params = [
    'date_from' => $dateFrom,
    'date_to' => $dateTo
  ];

  $products = productList(['sort_by_alphabetically' => true]);

  foreach ($products as $product) {

    if ($product) {
      $linearGraph[] = [$product->product_name, (int) $product->quantity];
    }
  }

  $listing = productList([
      'status' => 'Alerted',
      'sort_by_quantity' => true
  ]);
  
  ?>

  <div class="container" id="dashboard">
    <div class="row">
      <div class="col">
        <div class="card mb-4">
          <div class="card-header">
          <strong><i>Stocks</i></strong>
          </div>
          <div class="card-body">
            <!-- First graph -->
            <div>
              <label>Month:</label>
              <span><strong><?php echo $monthName ?></strong></span>
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
                  },
                  backgroundColor: 'transparent',
                  colors: ['#57de9c']
                };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                chart.draw(data, options);
              }
            </script>
            <!-- end of first graph -->
          </div>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="card mb-4">
          <div class="card-header">
          <strong><i>Low Level Alerted Stocks</i></strong>
          </div>
          <div class="card-body">
              <table class="table table-dark table-striped">
                  <thead>
                      <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Product Name</th>
                          <th scope="col">Category</th>
                          <th scope="col">Quantity</th>
                          <th scope="col">Low Quantity Level</th>
                          <th scope="col">Status</th>
                          <th scope="col">Suggested Quantity</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                          foreach($listing as $key => $product) {
                              $lowStockClass = $product->quantity <= $product->low_quantity_level ? 'text-danger' : '';
                              echo '<tr>';
                              echo '<th scope=\"row\">' . ($key + 1) . '</th>';
                              echo '<td>' . $product->product_name . "</td>";
                              echo '<td>' . $product->category . '</td>';
                              echo "<td><div class=\"{$lowStockClass}\">" . $product->quantity . 
                                  '</div></td>';
                              echo "<td><div>" . $product->low_quantity_level . 
                                  '</div></td>';
                              echo "<td>{$product->status}</td>";
                              echo '<td>' . getSuggestQuantity($product, $currentMonth, $currentYear - 1) . '</td>';
                              echo '</tr>';
                          }
                      ?>
                  </tbody>
              </table>
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

    var select = document.querySelector('#findProductChart1')
    console.log('select', select)
    select.addEventListener('change',function(event){
        window.location.href = "/dashboard?graph1_product_id=" + this.value
    });
  </script>
<style>
    form {
        display: flex;
    }
    .action {
        margin-top: 33px;
        margin-left: 1.0em;
    }
</style>
<div id="layoutSidenav_content">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';

    $month_from = 1;
    $month_to = 1;
    $currentMonth = date('m');
    $error_messages = [];
    $data = [];
    $year = isset($_GET['year']) ? $_GET['year'] : date("Y");
    if (isset($_GET['month_from'])) {
        $month_from = $_GET['month_from'];
        $month_to = $_GET['month_from'];
    }

    if ($month_to < $month_from) {
        $error_messages = ["Error: <strong>Month From</strong> must be less than to <strong>Month To</strong>"];
    } else {

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
                'date_to' => date("Y-m-t", strtotime($date)),
                'product_logs' => true
            ]);

            $monthData['listing'] = $listing;
            $data[] = $monthData;
        }

        //dd($data); display structure
    }

    ?>

    <main>
        <div class="container-fluid px-4">
            <div class="row justify-content-between mt-4 mb-4">
                <div class="col">
                    
                </div>
            </div>
            <div class="row justify-content-between mb-4">
                <form id="productForm" method="GET" action='reports'>
                    <div class="col lg-6 me-2">
                        <label class="form-label" for="quantity">Month</label>
                        <select class="form-select" name="month_from">
                            <option value="01" <?php echo $month_from == 1 ? 'selected' : '' ?>>January</option>
                            <option value="02" <?php echo $month_from == 2 ? 'selected' : '' ?>>February</option>
                            <option value="03" <?php echo $month_from == 3 ? 'selected' : '' ?>>March</option>
                            <option value="04" <?php echo $month_from == 4 ? 'selected' : '' ?>>April</option>
                            <option value="05" <?php echo $month_from == 5 ? 'selected' : '' ?>>May</option>
                            <option value="06" <?php echo $month_from == 6 ? 'selected' : '' ?>>June</option>
                            <option value="07" <?php echo $month_from == 7 ? 'selected' : '' ?>>July</option>
                            <option value="08" <?php echo $month_from == 8 ? 'selected' : '' ?>>August</option>
                            <option value="09" <?php echo $month_from == 9 ? 'selected' : '' ?>>September</option>
                            <option value="10" <?php echo $month_from == 10 ? 'selected' : '' ?>>October</option>
                            <option value="11" <?php echo $month_from == 11 ? 'selected' : '' ?>>November</option>
                            <option value="12" <?php echo $month_from == 12 ? 'selected' : '' ?>>December</option>
                        </select>
                    </div>
                    <div class="col lg-4">
                        <label class="form-label" for="quantity">Year</label>
                        <select class="form-select" name="year">
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
                    <div class="col action">
                        <input class="btn btn-primary btn-md me-2" type="submit" value="Search"/>
                        <a class="btn btn-secondary btn-md" href="/dashboard/reports">Reset</a>
                    </div>
                </form>
                <div class="col pt-4">
                    
                    <button class="btn btn-secondary btn-md" onclick="takeScreenShot()">Download as pdf</button>
                </div>
            </div>

            <!-- display if any errors -->
            <?php if (count($error_messages) > 0) {
                echo displayErrors($error_messages);
            } ?>
            <div class="row" id="reports">
                <?php if (count($error_messages) <= 0) { ?>
                    <?php foreach ($data as $month) { ?>
                        <div class="col">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <?php echo $month['month']; ?>
                                </div>
                                <div class="card-body">
                                    <?php if (count($month['listing']) <= 0) {
                                        echo "* No data available";
                                    } else { ?>
                                        <table class="table table-dark table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Product Name</th>
                                                    <th scope="col">Stock In Quantity</th>
                                                    <th scope="col">Stock Out Quantity</th>
                                                    <th scope="col">Low Quantity Level</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($month['listing'] as $key => $product) { ?>
                                                    <?php $lowStockClass = $product->quantity <= $product->low_quantity_level ? 'text-danger' : '';?>
                                                    <?php echo '<tr>'; ?>
                                                    <?php echo '<th scope=\"row\">' . ($key + 1) . '</th>'; ?>
                                                    <?php echo '<td>' . $product->product_name . "</td>"; ?>
                                                    <?php echo "<td><div>" . $product->stock_in_quantity . 
                                        '</div></td>'; ?>
                                        <?php echo "<td><div>" . $product->stock_out_quantity . 
                                        '</div></td>'; ?>
                                                    <?php echo "<td><div class=\"{$lowStockClass}\">" . $product->low_quantity_level . 
                                        '</div></td>'; ?>
                                                    <?php echo '</tr>'; ?>
                                                    <!-- Modal for view logs -->
                                                <?php } // end foreach ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </main>
</div>
<script>
    window.takeScreenShot = function() {
        html2canvas(document.getElementById('reports')).then(function(canvas) {
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
            doc.save('reports.pdf');
        });
    }
</script>
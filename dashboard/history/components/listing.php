<style>
    form {
        display: flex;
    }
</style>
<div id="layoutSidenav_content">
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';

        $month_from = 1;
        $month_to = 1;
        $error_messages = [];
        $data = [];
        $year = 2023;

        if (isset($_GET['month_from'])) {
            $month_from = $_GET['month_from'];
        }

        if (isset($_GET['month_to'])) {
            $month_to = $_GET['month_to'];
        }

        if (isset($_GET['year'])) {
            $year = $_GET['year'];
        }

        if ($month_to < $month_from) {
            $error_messages = ["Error: <strong>Month From</strong> must be less than to <strong>Month To</strong>"];
        } else {

            foreach (range($month_from, $month_to) as $number) 
            {

                $monthNumber = sprintf("%02d", $number);
                $date = "{$year}-{$monthNumber}-01";

                $monthData = [
                    'month' => date("F", strtotime($date)),
                    'month_value' => $number,
                    'date' => $date
                ];
                $logs = productLogs([
                    'date_from' => date("Y-m-01", strtotime($date)),
                    'date_to' => date("Y-m-t", strtotime($date))
                ]);

                $monthData['logs'] = $logs;
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
                <form id="productForm" method="GET" action='history'>
                    <div class="col lg-4 me-2">
                        <label class="form-label" for="quantity">Month From:</label>
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
                    <div class="col lg-4 me-2">
                        <label class="form-label" for="quantity">Month To:</label>
                        <select class="form-select" name="month_to">
                            <option value="1" <?php echo $month_to == 1 ? 'selected' : '' ?>>January</option>
                            <option value="2" <?php echo $month_to == 2 ? 'selected' : '' ?>>February</option>
                            <option value="3" <?php echo $month_to == 3 ? 'selected' : '' ?>>March</option>
                            <option value="4" <?php echo $month_to == 4 ? 'selected' : '' ?>>April</option>
                            <option value="5" <?php echo $month_to == 5 ? 'selected' : '' ?>>May</option>
                            <option value="6" <?php echo $month_to == 6 ? 'selected' : '' ?>>June</option>
                            <option value="7" <?php echo $month_to == 7 ? 'selected' : '' ?>>July</option>
                            <option value="8" <?php echo $month_to == 8 ? 'selected' : '' ?>>August</option>
                            <option value="9" <?php echo $month_to == 9 ? 'selected' : '' ?>>September</option>
                            <option value="10" <?php echo $month_to == 10 ? 'selected' : '' ?>>October</option>
                            <option value="11" <?php echo $month_to == 11 ? 'selected' : '' ?>>November</option>
                            <option value="12" <?php echo $month_to == 12 ? 'selected' : '' ?>>December</option>
                        </select>
                    </div>
                    <div class="col lg-4 me-2">
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
                    <div class="col pt-4 mt-2">
                        <input class="btn btn-primary btn-md" type="submit" value="Search" />
                        <a class="btn btn-secondary btn-md" href="/dashboard/history">Reset</a>
                    </div>
                </form>

            </div>

            <!-- display if any errors -->
            <?php if (count($error_messages) > 0) { 
                echo displayErrors($error_messages);
            } ?>
            <div class="row">
                <?php $countDataAvailable = 0; ?>
                <?php if (count($error_messages) <= 0) { ?>
                    <?php foreach($data as $key => $month) { ?>
                        <div class="col">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <?php echo $month['month']; ?>
                                </div>
                                <div class="card-body">
                                    <?php if (count($month['logs']) <= 0) {
                                        echo "* No data available";
                                    } else { ?>
                                        <?php $countDataAvailable++; ?>
                                        <table id="paginatedTable<?php echo $key; ?>" class="table table-dark table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Product Name</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Mode</th>
                                                    <th scope="col">Mode Quantity</th>
                                                    <th scope="col">Date Logs</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($month['logs'] as $product) {
                                                        echo '<tr>';
                                                        echo '<td>' . $product->product_name . "</td>";
                                                        echo '<td>' . $product->category . '</td>';
                                                        echo '<td>' . $product->quantity . '</td>';
                                                        echo '<td>' . $product->mode . '</td>';
                                                        echo '<td>' . $product->log_quantity . '</td>';
                                                        echo '<td>' . $product->created_at . '</td>';

                                                    }
                                                ?>
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

    var countDataAvailable = parseInt('<?php echo $countDataAvailable ?>');
    
    console.log('test2', countDataAvailable)
    $(document).ready(function() {

        for (let i=0; i<=countDataAvailable; i++) {
            var table = $('#paginatedTable' + i).DataTable( {
                lengthChange: false,
                // buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
            } );
        }
    });
</script>

<style>
    .card {
        min-height: 866px;
    }
</style>
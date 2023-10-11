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

        if (isset($_GET['month_from'])) {
            $month_from = $_GET['month_from'];
            $month_to = $_GET['month_from'];
        }

        if ($month_to < $month_from) {
            $error_messages = ["Error: <strong>Month From</strong> must be less than to <strong>Month To</strong>"];
        } else {

            foreach (range($month_from, $month_to) as $number) 
            {

                $monthNumber = sprintf("%02d", $number);
                $date = "2023-{$monthNumber}-01";

                $monthData = [
                    'month' => date("F", strtotime($date)),
                    'month_value' => $number,
                    'date' => $date
                ];
                $listing = productList([
                    'date_from' => date("Y-m-01", strtotime($date)),
                    'date_to' => date("Y-m-t", strtotime($date))
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
                    <h2 class="mt-4 mb-4">Reports</h2>
                </div>
            </div>
            <div class="row justify-content-between mb-4">
                <form id="productForm" method="GET" action='reports'>
                    <div class="col lg-6">
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
                    <div class="col pt-4">
                        <input class="btn btn-primary btn-md" type="submit" value="Search" />
                        <a class="btn btn-secondary btn-md" href="/dashboard/reports">Reset</a>
                    </div>
                </form>

            </div>

            <!-- display if any errors -->
            <?php if (count($error_messages) > 0) { 
                echo displayErrors($error_messages);
            } ?>
            <div class="row">
                <?php if (count($error_messages) <= 0) { ?>
                    <?php foreach($data as $month) { ?>
                        <div class="col">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <?php echo $month['month']; ?>
                                </div>
                                <div class="card-body">
                                    <?php if (count($month['listing']) <= 0) {
                                        echo "* No data available";
                                    } else { ?>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Product Name</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($month['listing'] as $product) {
                                                        echo '<tr>';
                                                        echo '<th scope=\"row\">' . $product->product_id . '</th>';
                                                        echo '<td>' . $product->product_name . "</td>";
                                                        echo '<td>' . $product->category . '</td>';
                                                        echo '<td>' . $product->quantity . '</td>';
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
z<div id="layoutSidenav_content">
    <?php 
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';

        $search = '';

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
        }

        $productLogs = productLogs(['order_by_date' => true]);
    ?>
    <main>
        <div class="container-fluid px-4">
            <div class="row justify-content-between mt-4 mb-4">
                <!-- <div class="col">
                    <form class="d-flex" method="GET" action="stocks">
                        <input class="form-control me-2" type="text" name="search" value="<?php echo $search; ?>">
                        <input type="submit" class="btn btn-outline-success" type="button"value="search">
                    </form>
                </div> -->
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    Product Logs
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Mode</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($productLogs as $key => $log) {
                                    echo '<tr>';
                                    echo '<th scope=\"row\">' . ($key + 1) . '</th>';
                                    echo '<td>' . $log->product_name . "</td>";
                                    echo '<td>' . $log->mode . '</td>';
                                    echo '<td>' . $log->log_quantity . '</td>';
                                    echo '<td>' . $log->log_created_at . '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
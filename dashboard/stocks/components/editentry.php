<div id="layoutSidenav_content">
    <?php 
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';

        $search = '';
        $error_messages = [];

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
        }

        if(isset($_POST['delete'])) {
            $log = productLogFindById($_GET['log_id']);
            $product = productFindById($log->product_id);
            $mode = isset($_POST['mode']) ? $_POST['mode'] : null;
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

            if ($mode == 'in') {
                $product->quantity = ($product->quantity - $log->quantity);
                productQuantityUpdate($product);
            } else if($mode == 'out') {
                $product->quantity = ($product->quantity + $log->quantity);
                productQuantityUpdate($product);
            }
            productLogDelete($log);
            header('location: /dashboard/stocks/entry.php');
        }

        $productLogs = productLogs(['order_by_date' => true]);
        
        if (isset($_GET['log_id']) && isset($_POST['submit'])) 
        {
            $log = productLogFindById($_GET['log_id']);
            $product = productFindById($log->product_id);
            $mode = isset($_POST['mode']) ? $_POST['mode'] : null;
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

            if ($mode == 'in') {

                if ($quantity <= 0) {
                    $error_messages = ["Error: <strong>Stock In Quantity: {$quantity} cannot be negative.</strong> "];
                } else {
                    $product->quantity = ($product->quantity - $log->quantity) + $quantity;
                    
                    productQuantityUpdate($product);
                    $log->quantity = $quantity;
                    productLogQuantityUpdate($log);
                }
            
            } else if($mode == 'out') {

                if ($quantity <= 0) {
                    $error_messages = ["Error: <strong>Stock Out Quantity: ({$quantity}) cannot be negative.</strong> "];
                } else if ($quantity > $product->quantity)  {
                    $error_messages = ["Error: <strong>Stock Out Quantity: ({$quantity}) cannot be greater than product existing quantity</strong> "];
                } else {
                    $product->quantity = ($product->quantity + $log->quantity) - $quantity;
                    productQuantityUpdate($product);
                    $log->quantity = $quantity;
                    productLogQuantityUpdate($log);
                    if ($product->quantity <= $product->low_quantity_level) {
                        // send sms
                        $adminUser = getAdminUser();
                        $suggestedQuantity = getSuggestQuantity($product);
                        //sendSMS($adminUser->phone_number, "Low Stock: {$product->product_name} suggested quantity {$suggestedQuantity}");
                        productUpdateStatus($product, 'Alerted');
                    }
                }
            }

            if (count($error_messages) <= 0) {
                header('location: /dashboard/stocks/entry.php');
            }
        }
    ?>
    <main>
        <div class="container-fluid px-4">
            <div class="row justify-content-between mt-4 mb-4">
                <!-- <div class="col pt-4">
                    <button class="btn btn-secondary btn-md" onclick="takeScreenShot()">Download as pdf</button>
                </div> -->
            </div>
            <!-- display if any errors -->
            <?php if (count($error_messages) > 0) {
                echo displayErrors($error_messages);
            } ?>
            <div class="card mb-4" id="logs">
                <div class="card-header">
                  <strong><i>Update Stocks</i></strong>
                </div>
                <div class="card-body">
                    <table id="paginatedTable" class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Mode</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Date Logs</th>
                                <th scope="col">Actions</th>
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
                                    
                                    echo "
                                    <td style=\"display:flex;\">
                                    <button type=\"button\" class=\"btn btn-secondary me-2\" data-bs-target=\"#productLogModal{$log->id}\" data-bs-toggle=\"modal\" >Edit</button>
                                    <form action=\"/dashboard/stocks/entry.php?log_id=$log->id\" method=\"POST\" onsubmit=\"return confirmDelete()\"><input type=\"submit\" name=\"delete\" value=\"Delete\" class=\"btn btn-warning\"><input type=\"hidden\" name=\"mode\" value=\"$log->mode\" class=\"btn btn-warning\"></form>
                                    </td>";
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

<?php foreach ($productLogs as $log) { ?>
    <!-- Modal for Stock In -->
    <div class="modal fade" id="productLogModal<?php echo $log->id; ?>" tabindex="-1" role="dialog" aria-labelledby="stockInModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/dashboard/stocks/entry.php?log_id=<?php echo $log->id; ?>" method="POST" onsubmit="return confirmStockIn()">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="stockin_product" class="form-label">Product</label>
                            <input type="text" class="form-control" name="product_name" value="<?php echo $log->product_name ?>" disabled />
                            <input type="hidden" class="form-control" name="mode" value="<?php echo $log->mode ?>" disabled />
                        </div>
                        <div class="mb-3">
                            <label for="stockin_category" class="form-label">Category</label>
                            <select class="form-select" name="category" disabled>
                                <option value="kitchen" <?php echo ($log->category == 'kitchen') ? 'selected' : '' ?>>Kitchen</option>
                                <option value="drinks" <?php echo ($log->category == 'drinks') ? 'selected' : '' ?>>Drinks</option>
                            </select>
                        </div>
                        <input type="hidden" name="mode" value="in" />
                        <div class="mb-3">
                            <label for="stockin_quantity" class="form-label">Quantity</label>
                            <input type="number" value="<?php echo $log->log_quantity ?>" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="quantity" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php } ?>

<script>

    $(document).ready(function() {
        var table = $('#paginatedTable').DataTable( {
            lengthChange: false,
            // buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
        } );
    
        table.buttons().container()
            .appendTo( '#example_wrapper .col-md-6:eq(0)' );
    });
</script>
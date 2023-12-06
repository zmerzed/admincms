<div id="layoutSidenav_content">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/userHelper.php';
    $search = '';
    $error_messages = [];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    }

    $listing = productList([
        'search' => $search,
        'sort_by' => 'quantity',
        'sort_direction' => 'asc'
    ]);

    if (isset($_GET['product_id']) && isset($_POST['submit'])) {
        $product = productFindById($_GET['product_id']);
        $mode = isset($_POST['mode']) ? $_POST['mode'] : null;
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
        $lowLevelQuantity = isset($_POST['low_quantity_level']) ? $_POST['low_quantity_level'] : null;

        if ($mode == 'in') {

            if ($quantity <= 0) {
                $error_messages = ["Error: <strong>Stock In Quantity: {$quantity} cannot be negative.</strong> "];
            } else {
                productLogStore($product, $_POST['mode'], $quantity);
                $product->quantity = $product->quantity + $quantity;

                productQuantityUpdate($product);
    
                if ($product->quantity > $product->low_quantity_level) {
                    productUpdateStatus($product, 'Stocked');
                }
            }
           
        } else if($mode == 'out') {

            if ($quantity <= 0) {
                $error_messages = ["Error: <strong>Stock Out Quantity: ({$quantity}) cannot be negative.</strong> "];
            } else if ($quantity > $product->quantity)  {
                $error_messages = ["Error: <strong>Stock Out Quantity: ({$quantity}) cannot be greater than product existing quantity</strong> "];
            } else {
                productLogStore($product, $_POST['mode'], $quantity);
                $product->quantity = $product->quantity - $quantity;
                productQuantityUpdate($product);
    
                if ($product->quantity <= $product->low_quantity_level) {
                    // send sms
                    $adminUser = getAdminUser();
                    $suggestedQuantity = getSuggestQuantity($product);
                    // sendSMS($adminUser->phone_number, "Low Stock: {$product->product_name} suggested quantity {$suggestedQuantity}");
                    productUpdateStatus($product, 'Alerted');
                }
            }
            
        } else if ($lowLevelQuantity) {
            $product->low_quantity_level = $lowLevelQuantity;
            productLowQuantityLevelUpdate($product);
        }

        if (count($error_messages) <= 0) {
            header('location: /dashboard/stocks/updatestock.php');
        }
    }

    // manual alert SMS 
    if (isset($_POST['alert'])) {
        
        $product = productFindById($_POST['alertProductId']); 
        $adminUser = getAdminUser();
        $suggestedQuantity = getSuggestQuantity($product);
        // sendSMS($adminUser->phone_number, "Low Stock: {$product->product_name} suggested quantity {$suggestedQuantity}");
        header('location: /dashboard/stocks/updatestock.php');
    }

    ?>
    <main>
        <div class="container-fluid px-4">
            <div class="row justify-content-between mt-4 mb-4">
            <div class="col">
            </div>
                <div class="col">
                    <form class="d-flex" method="GET" action="updatestock.php">
                        <input class="form-control me-2" type="text" name="search" value="<?php echo $search; ?>">
                        <input type="submit" class="btn btn-outline-success" type="button" value="search">
                    </form>
                </div>
            </div>
            <!-- display if any errors -->
            <?php if (count($error_messages) > 0) {
                echo displayErrors($error_messages);
            } ?>
            <div class="card mb-4">
                <div class="card-header">
                    <strong><i>Update Stocks</i></strong>
                    <a style="float:right" href="/dashboard/stocks/create.php" type="button" class="btn btn-primary">Create</a>
                </div>
                <div class="card-body">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Unit of Measurement</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Low Quantity Level</th>
                                
                                <?php if (auth()->access_level != 1) { ?>
                                    <th scope="col">Action</th>
                                    <th scope="col">SMS Alert</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listing as $no => $product) {
                                $lowStockClass = $product->quantity <= $product->low_quantity_level ? 'text-danger' : '';
                                echo '<tr>';
                                echo '<th scope="row">' . $no + 1 . '</th>';
                                echo '<td>' . $product->product_name . '</td>';
                                echo '<td>' . $product->category . '</td>';
                                echo '<td>' . $product->uom . '</td>';
                                echo "<td><div class=\"{$lowStockClass}\">" . $product->quantity . '</div></td>';
                                echo "<td><div>" . 
                                    $product->low_quantity_level . 
                                    (auth()->access_level == 1 ? "<button type=\"button\" class=\"btn btn-warning btn-xs ms-2\" data-bs-toggle=\"modal\" data-bs-target=\"#lowLevelModal{$product->product_id}\">Edit</button>" .
                                    '</div></td>' : "");
                                if (auth()->access_level != 1) {
                                    echo "
                                    <td>
                                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-toggle=\"modal\" data-bs-target=\"#stockInModal{$product->product_id}\">Stock In</button>
                                    <button type=\"button\" class=\"btn btn-warning\" data-bs-toggle=\"modal\" data-bs-target=\"#stockOutModal{$product->product_id}\">Stock Out</button>
                                    </td>";
                                    echo "
                                    <td>
                                        <form method=\"POST\" action=\"updatestock.php\">
                                            <input type=\"hidden\" name=\"alertProductId\" value=\"{$product->product_id}\"/>
                                            <input type=\"submit\" name=\"alert\" class=\"btn btn-danger\" value=\"Alert\"> 
                                        </form>
                                        
                                    </td>";
                                }
                               
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


<!---###########################################################################################################################################################--->

<!-- Modal for Stock In and Stock Out for each product -->
<?php foreach ($listing as $product) { ?>
    <!-- Modal for Stock In -->
    <div class="modal fade" id="stockInModal<?php echo $product->product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="stockInModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Stock In Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/dashboard/stocks/updatestock.php?product_id=<?php echo $product->product_id; ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="stockin_product" class="form-label">Product</label>
                            <input type="text" class="form-control" name="product_name" value="<?php echo $product->product_name ?>" disabled />
                        </div>
                        <div class="mb-3">
                            <label for="stockin_category" class="form-label">Category</label>
                            <select class="form-select" name="category" disabled>
                                <option value="kitchen" <?php echo ($product->category == 'kitchen') ? 'selected' : '' ?>>Kitchen</option>
                                <option value="drinks" <?php echo ($product->category == 'drinks') ? 'selected' : '' ?>>Drinks</option>
                            </select>
                        </div>
                        <input type="hidden" name="mode" value="in" />
                        <div class="mb-3">
                            <label for="stockin_quantity" class="form-label">Stock in Quantity</label>
                            <input type="number" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="quantity" required />
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

    <!---#######################################################################################################################################################--->

    <!-- Modal for Stock Out -->
    <div class="modal fade" id="stockOutModal<?php echo $product->product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="stockOutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Stock Out Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/dashboard/stocks/updatestock.php?product_id=<?php echo $product->product_id; ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="stockin_product" class="form-label">Product</label>
                            <input type="text" class="form-control" name="product_name" value="<?php echo $product->product_name ?>" disabled/>
                        </div>
                        <div class="mb-3">
                            <label for="stockin_category" class="form-label">Category</label>
                            <select class="form-select" name="category" disabled>
                                <option value="kitchen" <?php echo ($product->category == 'kitchen') ? 'selected' : '' ?>>Kitchen</option>
                                <option value="drinks" <?php echo ($product->category == 'drinks') ? 'selected' : '' ?>>Drinks</option>
                            </select>
                        </div>
                        <input type="hidden" name="mode" value="out" />
                        <div class="mb-3">
                            <label for="stockout_quantity" class="form-label">Stock out Quantity</label>
                            <input type="number" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="quantity" required />
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

      <!-- Modal for Low Quantity Level -->
      <div class="modal fade" id="lowLevelModal<?php echo $product->product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="stockOutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Low Quantity Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/dashboard/stocks/updatestock.php?product_id=<?php echo $product->product_id; ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="stockin_product" class="form-label">Product</label>
                            <input type="text" class="form-control" name="product_name" value="<?php echo $product->product_name ?>" disabled/>
                        </div>
                        <div class="mb-3">
                            <label for="stockin_category" class="form-label">Category</label>
                            <select class="form-select" name="category" disabled>
                                <option value="kitchen" <?php echo ($product->category == 'kitchen') ? 'selected' : '' ?>>Kitchen</option>
                                <option value="drinks" <?php echo ($product->category == 'drinks') ? 'selected' : '' ?>>Drinks</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stockout_low_quantity" class="form-label">Low Quantity Level</label>
                            <input type="number" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="low_quantity_level" value="<?php echo $product->low_quantity_level ?>" required />
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
<div id="layoutSidenav_content">
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';
            $listing = productList([]);

            if (isset($_GET['product_id']) && isset($_POST['submit'])) {
                $product = productFindById($_GET['product_id']);
                $mode = $_POST['mode'];
                $quantity = $_POST['quantity'];
                if ($mode == 'in') {
                    productLogStore($product, $_POST['mode'], $quantity);
                    $product->quantity = $product->quantity + $quantity;
                    productQuantityUpdate($product);
                } else {
                    productLogStore($product, $_POST['mode'], $quantity);
                    $product->quantity = $product->quantity - $quantity;
                    productQuantityUpdate($product);
                }

                header('location: /dashboard/stocks/updatestock.php');
            }

        ?>
        <main>
            <div class="container-fluid px-4">
                <div class="row justify-content-between mt-4 mb-4">
                    <div class="col">
                        <h2 class="mt-4 mb-4">Update Stocks</h2>
                    </div>
                    <div class="col pt-4">
                        <a href="/dashboard/stocks/create.php" type="button" class="btn btn-primary">Create</a>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        List
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($listing as $product) {
                                        $lowStockClass = $product->quantity <= 10 ? 'text-danger' : '';
                                        echo '<tr>';
                                        echo '<th scope="row">' . $product->product_id . '</th>';
                                        echo '<td>' . $product->product_name . '</td>';
                                        echo '<td>' . $product->category . '</td>';
                                        echo "<td><div class=\"{$lowStockClass}\">" . $product->quantity . '</div></td>';
                                        echo "
                                        <td>
                                            <button type=\"button\" class=\"btn btn-secondary\" data-bs-toggle=\"modal\" data-bs-target=\"#stockInModal{$product->product_id}\">Stock In</button>
                                            <button type=\"button\" class=\"btn btn-warning\" data-bs-toggle=\"modal\" data-bs-target=\"#stockOutModal{$product->product_id}\">Stock Out</button>
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


     <!---###########################################################################################################################################################--->

    <!-- Modal for Stock In and Stock Out for each product -->
    <?php foreach($listing as $product) { ?>
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
                        <!-- Add your Stock In form content here -->
                            <!-- Form fields for Stock In -->
                            <div class="mb-3">
                                <label for="stockin_product" class="form-label">Product</label>
                                <input type="text" class="form-control" name="product_name" value="<?php echo $product->product_name ?>" required/>
                            </div>
                            <div class="mb-3">
                                <label for="stockin_category" class="form-label">Category</label>
                                <select class="form-select" name="category" required>
                                    <option value="kitchen" <?php echo ($product->category == 'kitchen') ? 'selected' : '' ?>>Kitchen</option>
                                    <option value="drinks" <?php echo ($product->category == 'drinks') ? 'selected' : '' ?>>Drinks</option>
                                </select>
                            </div>
                            <input type="hidden" name="mode" value="in"/>
                            <div class="mb-3">
                                <label for="stockin_quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" value="<?php echo $product->quantity ?>" required/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit"/>
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
                        <!-- Add your Stock In form content here -->
                            <!-- Form fields for Stock In -->
                            <div class="mb-3">
                                <label for="stockin_product" class="form-label">Product</label>
                                <input type="text" class="form-control" name="product_name" value="<?php echo $product->product_name ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="stockin_category" class="form-label">Category</label>
                                <select class="form-select" name="category">
                                    <option value="kitchen" <?php echo ($product->category == 'kitchen') ? 'selected' : '' ?>>Kitchen</option>
                                    <option value="drinks" <?php echo ($product->category == 'drinks') ? 'selected' : '' ?>>Drinks</option>
                                </select>
                            </div>
                            <input type="hidden" name="mode" value="out"/>
                            <div class="mb-3">
                                <label for="stockin_quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" value="<?php echo $product->quantity ?>" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php } ?>
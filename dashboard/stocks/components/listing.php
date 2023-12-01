<div id="layoutSidenav_content">
    <?php 
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';

        $search = '';

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
        }

        $listing = productList([
            'search' => $search,
            'sort_by_quantity' => true
        ]);
    ?>
    <main>
        <div class="container-fluid px-4">
            <div class="row justify-content-between mt-4 mb-4">
            <div class="col">
            </div>
                <div class="col">
                    <form class="d-flex" method="GET" action="stocks">
                        <input class="form-control me-2" type="text" name="search" value="<?php echo $search; ?>">
                        <input type="submit" class="btn btn-outline-success" type="button"value="search">
                    </form>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                <strong><i>List of Supplies</i></strong>
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
                                <th scope="col">Action</th>
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
                                    echo "
                                    <td>
                                        <a href=\"/dashboard/stocks/actions/delete.php?id={$product->product_id}\"  type=\"button\" class=\"btn btn-warning\">Delete</a>
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
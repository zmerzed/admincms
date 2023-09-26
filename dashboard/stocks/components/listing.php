<div id="layoutSidenav_content">
    <?php 
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';
        $listing = productList([]);

    ?>
    <main>
        <div class="container-fluid px-4">
            <div class="row justify-content-between mt-4 mb-4">
                <div class="col">
                    <h2 class="mt-4 mb-4">Supplies</h2>
                </div>
                <div class="col pt-4">
                    <a href="/dashboard/stocks/create.php" type="button" class="btn btn-primary ">Create</a>
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
                                <th scope="col">SMS Alert</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($listing as $product) {
                                    echo '<tr>';
                                    echo '<th scope=\"row\">' . $product->product_id . '</th>';
                                    echo '<td>' . $product->product_name . "</td>";
                                    echo '<td>' . $product->category . '</td>';
                                    echo '<td>' . $product->quantity . '</td>';
                                    echo "
                                    <td>
                                        <a href=\"/dashboard/stocks/edit.php?id={$product->product_id}\" type=\"button\" class=\"btn btn-secondary\">Edit</a>
                                        <a href=\"/dashboard/stocks/actions/delete.php?id={$product->product_id}\"  type=\"button\" class=\"btn btn-warning\">Delete</a>
                                    </td>";
                                    echo '
                                    <td>
                                        <button type="button" class="btn btn-danger">Alert</button>
                                    </td>';
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
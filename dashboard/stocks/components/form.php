<div id="layoutSidenav_content">
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $formMode = isset($_GET['id']) ? 'update' : 'create';
        $formLabel = $formMode == 'update' ? 'Update Stock' : 'Create Stock';
        $formSubmitLabel = $formMode == 'update' ? 'Update' : 'Save';
        $product = $id ? productFindById($id) : productGetEmptyForm();
        if (isset($_POST['submit'])) {
            $product->product_name = $_POST['product_name'];
            $product->quantity = $_POST['quantity'];
            $product->category = $_POST['category'];
            
            if (productStore($product)) {
                header('location: ' . '/dashboard/stocks');
            }
        }
    ?>
    <main>
        <div class="container-fluid px-4">
            <h2 class="mt-4 mb-4"><?php echo $formLabel ?></h2>
            <div class="card mb-4">
                <div class="card-header">
                    Form
                </div>
                <div class="card-body">
                    <form id="productForm" method="POST" action='create.php'>

                        <!-- Product Name input -->
                        <div class="mb-3">
                            <label class="form-label" for="productName">Product Name</label>
                            <input class="form-control" id="productName" name="product_name" type="text" value="<?php echo $product->product_name ?>"/>
                        </div>

                        <!-- Category input -->
                        <div class="mb-3">
                            <label class="form-label" for="quantity">Category</label>
                            <select class="form-select" name="category">
                                <option value="kitchen" <?php echo ($product->category == 'kitchen') ? 'selected' : '' ?>>Kitchen</option>
                                <option value="furniture" <?php echo ($product->category == 'furniture') ? 'selected' : '' ?>>Furniture</option>
                            </select>
                        </div>
                        
                         <!-- Quantity input -->
                         <div class="mb-3">
                            <label class="form-label" for="quantity">Quantity</label>
                            <input class="form-control" id="quantity" max="200" name="quantity" type="number" value="<?php echo $product->quantity ?>"/>
                        </div>

                        <!-- Form submit button -->
                        <div class="col">
                            <div class="col">
                                <input class="btn btn-primary btn-lg" name="submit" type="submit" value="<?php echo $formSubmitLabel ?>"/>
                                <a href="/dashboard/stocks" class="btn btn-default btn-lg">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
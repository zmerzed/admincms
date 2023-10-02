<div id="layoutSidenav_content">
    <?php 
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/stockHelper.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/userHelper.php';

        $noOfUsers = userTotal();
        $noOfProducts = productTotal();
    ?>
    <main>
        <div class="container-fluid px-4">
            <div class="row justify-content-between mt-4 mb-4">

                <!-- no of products -->
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            No of Products
                        </div>
                        <div class="card-body">
                            <h1>
                                <strong><?php echo $noOfProducts; ?></strong>
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            No of Users
                        </div>
                        <div class="card-body">
                            <h1>
                                <strong><?php echo $noOfUsers; ?></strong>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
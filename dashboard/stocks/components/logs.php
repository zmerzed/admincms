<div id="layoutSidenav_content">
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
                <!-- <div class="col pt-4">
                    <button class="btn btn-secondary btn-md" onclick="takeScreenShot()">Download as pdf</button>
                </div> -->
            </div>
            <div class="card mb-4" id="logs">
                <div class="card-header">
                  <strong><i>Product Logs</i></strong>
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

<script>
    window.takeScreenShot = function() {
        html2canvas(document.getElementById('logs')).then(function(canvas) {
            var wid
            var hgt
            // document.body.appendChild(canvas)
            var img = canvas.toDataURL("image/png", wid = canvas.width, hgt = canvas.height);
            var hratio = hgt / wid
            var doc = new jsPDF('p', 'pt', 'a4');
            var width = doc.internal.pageSize.width;
            var height = width * hratio
            console.log('width', width / 2)
            console.log('height', height / 2)
            doc.addImage(img, 'JPEG', 20, 20, width / 1.2, height / 1.2);
            doc.save('logs.pdf');
        });
    }

    $(document).ready(function() {
        var table = $('#paginatedTable').DataTable( {
            lengthChange: false,
            // buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
        } );
    
        table.buttons().container()
            .appendTo( '#example_wrapper .col-md-6:eq(0)' );
    });
</script>
<style>
    form {
        display: flex;
    }
</style>
<div id="layoutSidenav_content">
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/userHelper.php';

        $listing = userList([]);
        $month_from = 1;
        $month_to = 1;
        $error_messages = [];
        $data = [];

        if (isset($_GET['month_from'])) {
            $month_from = $_GET['month_from'];
        }

        if (isset($_GET['month_to'])) {
            $month_to = $_GET['month_to'];
        }

        if ($month_to < $month_from) {
            $error_messages = ["Error: <strong>Month From</strong> must be less than to <strong>Month To</strong>"];
        } else {

            foreach (range($month_from, $month_to) as $number) {
                $monthData = [
                    'month' => $number,
                    'month_value' => $number,
                    'list' => []
                ];

                $data[] = $monthData;
            }

        }

    ?>

    <main>
        <div class="container-fluid px-4">
            <div class="row justify-content-between mt-4 mb-4">
                <div class="col">
                    <h2 class="mt-4 mb-4">Inventory History</h2>
                </div>
            </div>
            <div class="row justify-content-between mb-4">
                <form id="productForm" method="GET" action='history'>
                    <div class="col lg-6">
                        <label class="form-label" for="quantity">Month From:</label>
                        <select class="form-select" name="month_from">
                            <option value="1" <?php echo $month_from == 1 ? 'selected' : '' ?>>January</option>
                            <option value="2" <?php echo $month_from == 2 ? 'selected' : '' ?>>February</option>
                            <option value="3" <?php echo $month_from == 3 ? 'selected' : '' ?>>March</option>
                            <option value="4" <?php echo $month_from == 4 ? 'selected' : '' ?>>April</option>
                            <option value="5" <?php echo $month_from == 5 ? 'selected' : '' ?>>May</option>
                            <option value="6" <?php echo $month_from == 6 ? 'selected' : '' ?>>June</option>
                            <option value="7" <?php echo $month_from == 7 ? 'selected' : '' ?>>July</option>
                            <option value="8" <?php echo $month_from == 8 ? 'selected' : '' ?>>August</option>
                            <option value="9" <?php echo $month_from == 9 ? 'selected' : '' ?>>September</option>
                            <option value="10" <?php echo $month_from == 10 ? 'selected' : '' ?>>October</option>
                            <option value="11" <?php echo $month_from == 11 ? 'selected' : '' ?>>November</option>
                            <option value="12" <?php echo $month_from == 12 ? 'selected' : '' ?>>December</option>
                        </select>
                    </div>
                    <div class="col lg-6">
                        <label class="form-label" for="quantity">Month To:</label>
                        <select class="form-select" name="month_to">
                            <option value="1" <?php echo $month_to == 1 ? 'selected' : '' ?>>January</option>
                            <option value="2" <?php echo $month_to == 2 ? 'selected' : '' ?>>February</option>
                            <option value="3" <?php echo $month_to == 3 ? 'selected' : '' ?>>March</option>
                            <option value="4" <?php echo $month_to == 4 ? 'selected' : '' ?>>April</option>
                            <option value="5" <?php echo $month_to == 5 ? 'selected' : '' ?>>May</option>
                            <option value="6" <?php echo $month_to == 6 ? 'selected' : '' ?>>June</option>
                            <option value="7" <?php echo $month_to == 7 ? 'selected' : '' ?>>July</option>
                            <option value="8" <?php echo $month_to == 8 ? 'selected' : '' ?>>August</option>
                            <option value="9" <?php echo $month_to == 9 ? 'selected' : '' ?>>September</option>
                            <option value="10" <?php echo $month_to == 10 ? 'selected' : '' ?>>October</option>
                            <option value="11" <?php echo $month_to == 11 ? 'selected' : '' ?>>November</option>
                            <option value="12" <?php echo $month_to == 12 ? 'selected' : '' ?>>December</option>
                        </select>
                    </div>
                    <div class="col pt-4">
                        <input class="btn btn-primary btn-md" type="submit" value="Search" />
                        <a class="btn btn-secondary btn-md" href="/dashboard/history">Reset</a>
                    </div>
                </form>

            </div>

            <?php if (count($error_messages) > 0) { 
                echo displayErrors($error_messages);
            } ?>

            <?php if (count($error_messages) <= 0) { ?>
                <div class="col">
                    <div class="card mb-4">
                        <div class="card-header">
                            List
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Access Level</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($listing as $user) {
                                        echo '<tr>';
                                        echo '<th scope=\"row\">' . $user->id . '</th>';
                                        echo '<td>' . $user->username . "</td>";
                                        echo '<td>' . $user->name . '</td>';
                                        echo '<td>' . $user->phone_number . '</td>';
                                        echo '<td>' . $user->access_level . '</td>';
                                        echo "
                                    <td>
                                        <a href=\"/dashboard/users/edit.php?id={$user->id}\" type=\"button\" class=\"btn btn-secondary\">Edit</a>
                                        <a href=\"/dashboard/users/actions/delete.php?id={$user->id}\"  type=\"button\" class=\"btn btn-warning\">Delete</a>
                                    </td>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</div>
<div id="layoutSidenav_content">
    <?php 
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/userHelper.php';
        $listing = userList([]);

    ?>
    <main>
        <div class="container-fluid px-4">
            <div class="row justify-content-between mt-4 mb-4">
                <div class="col">
                    <h2 class="mt-4 mb-4">Users</h2>
                </div>
                <div class="col pt-4">
                    <a href="/dashboard/users/create.php" type="button" class="btn btn-primary ">Create</a>
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
                                <th scope="col">Username</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($listing as $user) {
                                    echo '<tr>';
                                    echo '<th scope=\"row\">' . $user->id . '</th>';
                                    echo '<td>' . $user->username . "</td>";
                                    echo '<td>' . $user->name . '</td>';
                                    echo '<td>' . $user->phone_number . '</td>';
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
    </main>
</div>
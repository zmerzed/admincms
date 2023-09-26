<div id="layoutSidenav_content">
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/userHelper.php';
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $formMode = isset($_GET['id']) ? 'update' : 'create';
        $formLabel = $formMode == 'update' ? 'Update User' : 'Create User';
        $formSubmitLabel = $formMode == 'update' ? 'Update' : 'Save';
        $user = $id ? userFindById($id) : userGetEmptyForm();

        if (isset($_POST['submit'])) {

            $user->username = $_POST['username'];
            $user->name = $_POST['name'];
            $user->password = $_POST['password'];
            $user->phone_number = $_POST['phone_number'];
            $user->access_level = $_POST['access_level'];
            
            if (userStore($user)) {
                header('location: ' . '/dashboard/users');
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

                        <!-- User Name input -->
                        <div class="mb-3">
                            <label class="form-label" for="userName">Username</label>
                            <input class="form-control" id="userName" name="username" type="text" value="<?php echo $user->username ?>"/>
                        </div>

                        <!-- Name input -->
                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" value="<?php echo $user->name ?>"/>
                        </div>
                        
                        <!-- Phone number input -->
                        <div class="mb-3">
                            <label class="form-label" for="phone_number">Phone Number</label>
                            <input class="form-control" id="phone_number" name="phone_number" type="text" value="<?php echo $user->phone_number ?>"/>
                        </div>

                        <!-- Password input -->
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="text" value="<?php echo $user->password ?>"/>
                        </div>

                        <!-- Access Level input -->
                        <div class="mb-3">
                            <label class="form-label" for="access_level">Access Level</label>
                            <select class="form-select" name="access_level">
                                <option value="1" <?php echo ($user->access_level == 1) ? 'selected' : '' ?>>Admin</option>
                                <option value="2" <?php echo ($user->access_level == 2) ? 'selected' : '' ?>>Guest</option>
                            </select>
                        </div>


                        <!-- Form submit button -->
                        <div class="col">
                            <div class="col">
                                <input class="btn btn-primary btn-lg" name="submit" type="submit" value="<?php echo $formSubmitLabel ?>"/>
                                <a href="/dashboard/users" class="btn btn-default btn-lg">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
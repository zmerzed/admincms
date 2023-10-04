<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Log In</title>
  <link rel="stylesheet" href="css/login.css ">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <?php 
    ob_start();
    session_start();
  ?>
  <div class="wrapper">
    <span class="bg-animate"></span>

    <div class="form-box login">
      <h2>Login</h2>
      <form method="POST" action="/auth/verify.php">
        <div class="input-box">
          <input type="text" name="username" id="username" required>
          <label>Username</label>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          <input type="password" name="password" id="password" required>
          <label>Password</label>
          <i class='bx bxs-lock-alt'></i>
          <?php if(isset($_SESSION['login_error'])) { ?>
            <div class="errors" style="padding-top: 20px">
              <?php echo $_SESSION['login_error']; ?>
            </div>
          <?php } ?>
        </div>
        <button class="btn" type="submit">Login</button>
      </form>
    </div>
    <div class="info-text login">
      <h2>Welcome Back!</h2>
      <p>You can easily monitor your stocks information in this system.</p>
    </div>
  </div>

  <script>
    function validateForm() {
      // Get the values entered by the user
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;

      // Replace these with your actual login credentials
      var validUsername = "abiing";
      var validPassword = "admin123";

      // For simplicity, we'll perform basic validation here
      if (username === "" || password === "") {
        alert("Username and password are required.");
        return false;
      } else if (username !== validUsername || password !== validPassword) {
        alert("Invalid username or password. Please try again.");
        return false;
      }

      // Redirect to the home page on successful login (replace 'admin_dashboard.html' with your actual home page URL)
      window.location.href = "admin_dashboard.html";

      // Prevent the form from actually submitting
      return false;
    }
  </script>

</body>

</html>

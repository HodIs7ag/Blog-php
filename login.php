<?php

include 'templates/header.php';

// check if user is already logged in
if (isLoggedIn()) {
    header('Location: index.php');
}

// check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])){
        $form_email = $_POST['email'];
        $form_password = $_POST['password'];

        // check if user exists
        $sql = "SELECT * FROM users WHERE email = '$form_email'";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                $db_password = $user['Password'];

                echo var_dump($user);
                if (password_verify($form_password, $db_password)) {
                    echo 'Logged in successfully';
                    // set session, redirect to index.php
                    $_SESSION['LoggedIn'] = true;
                    $_SESSION['UserID'] = $user['UserID'];
                    $_SESSION['email'] = $user['Email'];
                    header('Location: index.php');
                    
                } else {
                    echo 'Invalid email or password';
                }
            }
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}
?>




<div class="container login text-center">
		<section class="login-section text-center">
			<h3 class="header text-success">Account Login</h3>

            <!-- login form -->
			<form class="login-form" action="./login.php" method="POST">
			 <div class="form-row">
              <!-- email -->
			  <div class="form-group col-md-6">
			    <input type="email" name="email" class="form-control py-4 border-left" id="email" aria-describedby="idHelp" placeholder="Email">
			  </div>
               <!-- password -->
			  <div class="form-group col-md-6">
			    <input type="password" name="password" class="form-control py-4 border-right" id="password" placeholder="Password">
			  </div>
               <!-- submit button -->
			  </div>
              <button type="submit" class="btn btn-lg btn-success col-12 py-2">Sign in</button>
              <p class="text-center mt-4"> <a href="#">Forgot Password</a></p>
              <p class="text-center">Don't have Account? <a href="./register.php">Sign up</a></p>

			</form>

		</section>
</div>
    

</form>

<?php include 'templates/footer.php'; ?>
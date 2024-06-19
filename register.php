

<?php
include 'config.php';
include 'templates/header.php';

//check if user is already logged in
if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == true) {
    header('Location: index.php');
    exit;
}

//check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        $sql = "SELECT `UserID` FROM users WHERE Email = '$email'";
        //validate form data
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($password2)) {
            echo 'All fields are required';
        } else if ($password != $password2) {
            echo 'Passwords do not match';
        } else if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0){
            //check if email already exists
            echo 'Email already exists';
        } else {
            //hash password
            $password = password_hash($password, PASSWORD_DEFAULT);

            //insert new user into database
            $sql = "INSERT INTO users (`FirstName`, `LastName`, `Email`, `Password`) VALUES ('$first_name', '$last_name', '$email', '$password')";
            $result = mysqli_query($conn, $sql);
            

            if ($result) {
                echo "User registered successfully";
                header ('Location: login.php');
                exit;
            }
        }
    }
}

?>




<div class="container register">
    <section class="login-section">
        <h3 class="header text-success">Create Account</h3>

        <!-- login form -->
        <form class="signup-form" action="./register.php" method="POST">
            <div class="form-row">
            <!-- first and last names -->
                <div class="form-group col-md-6">
                    <input type="text" name="first_name" class="form-control py-4 border-left"  placeholder="First Name">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" name="last_name" class="form-control py-4 border-left"  placeholder="Last Name">
                </div>

            <!-- email -->
            <input type="email" name="email" class="form-control py-4 col-12 mb-3" placeholder="Email" >
            <input type="password" name="password" class="form-control py-4 col-12 mb-3" placeholder="Password">
            <input type="password" name="password2" class="form-control py-4 col-12 mb-3" placeholder="Confirm Password">
            </div>
            
            <!-- submit button -->
            <button type="submit" class="btn btn-lg btn-success col-12 py-2">Sign up</button>
            <p class="text-center">Already have an account? <a href="./login.php">Login</a></p>
            </div>
            
        </form>

        

    </section>
</div>


<?php
include 'templates/footer.php';
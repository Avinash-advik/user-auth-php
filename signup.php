<?php 
    $title = 'Registration';
    include './layout/header.php';
    session_start();
    if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
        header("Location: index.php");
        exit();
    }
?>
<?php 
    $errors = array();
    $success = '';
    if(isset($_POST['submit'])){
        $fullName = $_POST['full_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        if($_FILES['profile_photo']){
            $extension = explode(".", $_FILES['profile_photo']['name'])[1];
            $filename = uniqid() . '.' . $extension;
            $upload_path = "./uploads/".$filename;
            if (!move_uploaded_file($_FILES['profile_photo']['tmp_name'], $upload_path)) {
                array_push($errors, "Failed to upload image!");
            }
        }

        // Securing the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); 
        $createdAt = date("Y-m-d H:i:s");
        // Check if any filed is empty or not
        if(empty($fullName) || empty($email) || empty($password) || empty($confirmPassword) || empty($filename)){
            array_push($errors, "All fields are required");
        }
        // Check if email is valid or not
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email is not valid");
        }
        // Check if password and confirm password is not same
        if($password != $confirmPassword){
            array_push($errors, "Password and Confirm Password are not same.");
        }
        // check if email already exists
        $checkemailexists = "select email from users where email = '$email'";
        $result = mysqli_query($conn, $checkemailexists);
        if(mysqli_num_rows($result) > 0){
            array_push($errors, "Email already exists!");
        }

        // check if we have no errors
        if(count($errors) == 0){
            $sql = "INSERT INTO users (full_name, email, profile_photo, password, created_at) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss",$fullName, $email, $filename, $passwordHash, $createdAt);

            // Execute statement
            if ($stmt->execute()) {
                $success = "User registered successfully!";
            } else {
                array_push($errors, 'Something went wrong');
            }
            // Close statement and connection
            $stmt->close();
            $conn->close();
        }
    }
?>

<div class="offset-md-4 col-md-5 mt-5">
    <?php
    if($success != ""){
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $success ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php
    } 
    if(count($errors) > 0){
    ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo implode("</br>",$errors); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    }
    ?>
    <div class="card">
        <div class="card-body">
            <h4 class="text-center card-title">Register</h4>
            <hr>
            <form action="signup.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" name="full_name" class="form-control" Placeholder="Full Name:" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" Placeholder="Email:" required>
                </div>
                <div class="form-group">
                    <label for="profile_photo">Profile Photo</label>
                    <input type="file" name="profile_photo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" Placeholder="Password:" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="Password" name="confirm_password" class="form-control" Placeholder="Confirm Password:" required>
                </div>
                <div class="form-group text-right">
                    <input type="submit" value="signup" name="submit" class="btn btn-primary">
                </div>
            </form>
            <div class="text-center">
                <p>Already have and account? <a href="login.php">Login Here</a></p>
            </div>
        </div>
    </div>
</div>

<?php 
    include './layout/footer.php';
?>
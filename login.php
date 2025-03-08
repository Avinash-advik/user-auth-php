<?php 
    $title = 'Login';
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
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if any filed is empty or not
        if(empty($email) || empty($password)){
            array_push($errors, "All fields are required");
        }
        // Check if email is valid or not
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email is not valid");
        }

        // check if email already exists
        $sql = "select * from users where email = '$email'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if(password_verify($password, $user['password'])){
                // SESSION VARIABLE
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['photo'] = $user['profile_photo'];
                header("Location: index.php");
                die();
            }else{
                array_push($errors, "Incorrect Password!");
            }
        }else{
            array_push($errors, "Email does not exists!");
        }

        // check if we have no errors
        if(count($errors) == 0){
            $sql = "INSERT INTO users (full_name, email, profile_photo, password, created_at) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss",$fullName, $email, $profilePhoto, $passwordHash, $createdAt);

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
            <h4 class="text-center card-title">Login</h4>
            <hr>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" Placeholder="Email:" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" Placeholder="Password:" required>
                </div>
                <div class="form-group text-right">
                    <input type="submit" value="login" name="submit" class="btn btn-primary">
                </div>
            </form>
            <div class="text-center">
                <p>Not registered yet? <a href="signup.php">Register Here</a></p>
            </div>
        </div>
    </div>
</div>

<?php 
    include './layout/footer.php';
?>
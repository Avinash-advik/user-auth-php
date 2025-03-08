<?php 
    $title = 'Dashboard';
    include './layout/header.php';
    session_start();
    if (!isset($_SESSION['id']) && !isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }
?>

<div class="offset-md-1 col-md-10 mt-5">
    <div class="card">
        <div class="card-body">
            <h4 class="text-center">Welcome to Dashboard</h4>
            <div class="row">
                <div class="col-md-3">
                    <img src="./uploads/<?php echo $_SESSION['photo']?>" alt="profile" class="img-thumbnail profile-img">
                </div>
                <div class="col-md-8">
                    <p class="text-muted">Name: <?php echo $_SESSION['name']?></p>
                    <p class="text-muted">Email: <?php echo $_SESSION['email']?></p>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    include './layout/footer.php';
?>
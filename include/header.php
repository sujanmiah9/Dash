<?php
    require_once 'include/dbcon.php';
    session_start();
    if(!isset($_SESSION['email'])){
        header('location: login.php');
    }
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM `user` WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();
    $picture = $result['photo'];
    $name = $result['full_name'];
    $id = $result['id'];

    $sql = "SELECT * FROM `catagories`;";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Shop Now</title>
    <link rel="sortcut icon" type="image/x-icon" href="./img/logo2.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
    .bg_overlay3{
        background-image: url(img/bg.jpg);
        background-repeat: no-repeat;
        background-attachment: fixed;
}
    </style>
</head>
<body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top">
        <a class="navbar-brand mr-1" href="index.html">Shop Now</a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Navbar -->
	<ul class="navbar-nav ">
		<li class="nav-item">
			<a class="nav-link nav-l" href="#">
                <span class="welcome_note">Welcome</span> 
				<span style="color:#fbc531;font-size:20px;">
                    <?php echo $name;?>
                </span>
            </a>
		</li>
	</ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
                Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                Product
            </a>
        </li>
		<li class="nav-item dropdown no-arrow ml-3">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Catagories
            </a>
        <div class="dropdown-menu">
            <?php
                foreach($results as $result){
                    ?>
                
            <a class="dropdown-item" href="http://<?php echo $result->url;?>"><img src="./img/icon/<?php echo $result->icon;?>" alt="1" style="height:15px;width:15px;"> <?php echo $result->name;?></a>
            <?php
                }
            ?>
        </div>
        </li>
		<li class="nav-item dropdown">
            <a class="nav-link" href="#" >
                About us
            </a>
        </li>
		<li class="nav-item dropdown">
            <a class="nav-link" href="#" >
                Contact Us
            </a>
        </li>
        <li class="nav-item dropdown no-arrow ml-3">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="./uploaded/<?php echo $picture;?>" class="img-fluid rounded-circle" style="height:35px; width:35px;">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <div class="dropdown-header" style="color:black; font-weight:bold;font-size:20px;"> <?php echo $name;?>  </div>
                <a class="dropdown-item" href="userProfile.php?id=<?php echo base64_encode($id);?>"> <i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="changePassword.php"> <i class="fa fa-key"></i> Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"> <i class="fa fa-power-off"></i> Logout</a>
            </div>
        </li>
        </ul>
    </nav>
    <div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
            <i class="fa fa-fw fa-home"></i>
        <span>Home</span>
        </a>
        </li>
		<li class="nav-item dropdown">
            <a class="nav-link" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-folder"></i>
            <span>
                Catagories list
                <i class="float-right fa fa-angle-down"></i>
            </span>
            </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <?php
                foreach($results as $result){
                    ?>
                
            <a class="dropdown-item" href="http://<?php echo $result->url;?>"><img src="./img/icon/<?php echo $result->icon;?>" alt="1" style="height:15px;width:15px;"> <?php echo $result->name;?></a>
            <?php
                }
            ?>
        </div>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link"data-toggle="dropdown">
                <i class="fa fa-fw fa-folder"></i>
                <span>
                    Product
                    <i class="float-right fa fa-angle-down"></i>
                </span>
            </a>
            <div class="dropdown-menu">
            <a class="nav-link text-dark" href="addProduct.php"><i class="fa fa-fw fa-plus"></i> Add Product</a>
            <a class="nav-link text-dark" href="viewProduct.php"><i class="fa fa-fw fa-eye"></i>View Product</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link" data-toggle="dropdown">
                <i class="fa fa-fw fa-folder"></i>
                <span>Catagories <i class="float-right fa fa-angle-down"></i></span>
            </a>
            <div class="dropdown-menu">
            <a class="nav-link text-dark" href="addCatagories.php"><i class="fa fa-fw fa-plus"></i>Add Catagories</a>
            <a class="nav-link text-dark" href="viewCatagories.php"><i class="fa fa-fw fa-eye"></i>View Catagoris</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link" data-toggle="dropdown">
                <i class="fa fa-fw fa-folder"></i>
                <span>Brand <i class="float-right fa fa-angle-down"></i></span>
            </a>
            <div class="dropdown-menu">
            <a class="nav-link text-dark" href="addBrand.php"><i class="fa fa-fw fa-plus"></i>Add Brand</a>
            <a class="nav-link text-dark" href="viewBrand.php"><i class="fa fa-fw fa-eye"></i>View Brand</a>
            </div>
        </li>
        <li class="nav-item">
            
        </li>
        <li class="nav-item">
            <a class="nav-link" href="ViewUser.php">
                <i class="fa fa-fw fa-eye"></i>
            <span> View Users</span></a>
        </li>
    </ul>
    
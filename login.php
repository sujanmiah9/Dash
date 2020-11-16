<?php
include_once 'include/dbcon.php';
session_start();
if(isset($_SESSION['email'])){
  header('location: dashboard.php');
}
if(isset($_POST['login'])){
  $email    = $_POST['email'];
  $password = $_POST['password'];

  if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $email_valid = "Invalid Email Formate. Please try again.";
  }
  $sql = "SELECT * FROM `user` WHERE `email`= :email";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':email',$email,PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->rowCount();
  if($row >0){
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach($results as $result){
      if($result->password == $password){
        $_SESSION['email'] = $email;
        header('location: dashboard.php');
        echo "successfull";
      }else{
        $pass_check = "Worng Password. Try again";
      }
    }
  }else{
    $email_check = "Worng Email Address. Try again";
  }
}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="sortcut icon" type="image/x-icon" href="./img/logo2.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
  </head>
  <body>
    <div class="bg_overlay">
    <div class="container">    
      <div class="row">
        <div class="col-sm-4 offset-sm-4">
          <div class="card c_bg">
            <div class="card-body">
            <div class="row pb-4">
                <div class="col-md-6 flt_right">
                  <a href="signUp.php">SIGN UP</a>
                </div>
                <div class="col-md-6">
                <a class="active visi" href="login.php">SIGN IN</a>
                </div>
              </div>
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="email" class="form-control input_box" name="email" placeholder="Enter Your E-mail" required="required" autofocus="autofocus">
                  <div style="color: #FC427B;">
                    <?php
                    if(isset($email_check)){
                      echo $email_check;
                    }
                    if(isset($email_valid)){
                      echo $email_valid;
                    }
                    ?>
                  </div>
                </div>
                <div class="form-group">
                  <input type="password" id="password" class="form-control input_box" name="password" placeholder="Enter Your Password">
                <div style="color: #FC427B;">
                  <?php
                  if(isset($pass_check)){
                    echo $pass_check;
                  }
                  ?>
                </div>
                </div>
                <div class="btn_color">
                  <input type="submit" name="login" value="Login" class="btn btn-block brder">
                </div>
              </form>
              <div class="text-center">
            <br>
            <a class="d-block small" href="forgotPassword.php">Forgot Password?</a>
          </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).on('click', 'a', function(){
        $(this).addClass('active_cls').siblings().removeClass('active_cls')
      })
    </script>
  </body>
</html>
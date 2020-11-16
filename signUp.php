<?php
require_once('include/dbcon.php');

function validate($data){
  $data = trim($data);
  $data = stripcslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['signup'])){
  $email      = validate(strtolower($_POST['email']));
  $fullname   = validate($_POST['fullname']);
  $addres     = validate($_POST['address']);
  $c_number   = validate($_POST['number']);
  $pass       = $_POST['password'];
  $cpassword  = $_POST['cpassword'];

  $picture = $_FILES['picture']['name'];
  $pic     = explode('.', $picture);
  $pic     = end($pic);
  $orgin_pic = $fullname.'.'.$pic;

  $error = array();
  if(empty($email)){
    $error['email']= "The required field is empty!";
  }
  if(empty($fullname)){
    $error['fullname']= "The required field is empty!";
  }
  if(empty($c_number)){
    $error['c_number']= "The required field is empty!";
  }
  if(empty($pass)){
    $error['pass']= "The required field is empty!";
  }
  if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $email_valid = "Invalid Email Formate. Please try again.";
  }
  if(count($error)==0){
    $sql ="SELECT * FROM `user` WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email',$email, PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount()==0){
      if(strlen($pass)>3){
        if($pass == $cpassword){
          $sql = "INSERT INTO `user`(`full_name`, `email`, `address`, `c_number`, `password`,`photo`)
            VALUES (:fullname, :email, :addres, :c_number, :pass, :orgin_pic)";
    
            $query = $db->prepare($sql);
            $query->bindParam(':fullname',$fullname, PDO::PARAM_STR);
            $query->bindParam(':email',$email, PDO::PARAM_STR);
            $query->bindParam(':addres',$addres, PDO::PARAM_STR);
            $query->bindParam(':c_number',$c_number, PDO::PARAM_STR);
            $query->bindParam(':pass',$pass,PDO::PARAM_STR);
            $query->bindParam(':orgin_pic',$orgin_pic,PDO::PARAM_STR);
            $result = $query->execute();
    
            if($result){
              $tmp_file = $_FILES['picture']['tmp_name'];
              move_uploaded_file($tmp_file,"uploaded/".$orgin_pic);
              echo '<script type:"text/script">
                swal("Success", "Signup Successfull", "success");
              </script>';
            }else{
              echo '<script type:"text/script">
                swal("Error", "Something is Wrong! Please Try again.", "error");
              </script>';
            }
        }else{
          $pass_check = "password not match";
        }
      }else{
        $pass_lenth = "Password more than 4 characters.";
      }
    }else{
      $email_use = "Email Already Exist. Try another Email.";
    }
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
    <title>Sign Up</title>
  </head>
  <body>
    <div class="bg_overlay2">
    <div class="container">    
      <div class="row">
        <div class="col-sm-4 offset-sm-4">
          <div class="card c_bg">
            <div class="card-body">
            <div class= "row pb-4">
                <div class="col-md-6 flt_right">
                  <a class="active" href="signUp.php">SIGN UP</a>
                </div>
                <div class="col-md-6">
                <a href="login.php">SIGN IN</a>
                </div>
              </div>
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="email" class="form-control input_box" name="email" placeholder="Enter Your E-mail" autofocus="autofocus">
                  <span style="color:#FC427B; font-weight:bold; font-style:italic">
                    <?php
                      if(isset($error['email'])){
                        echo $error['email'];
                      }
                      if(isset($email_valid)){
                        echo $email_valid;
                      }
                      if(isset($email_use)){
                        echo $email_use;
                      }
                    ?>
                  </span>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control input_box" name="fullname" placeholder="Enter Your Full Name">
                  <span style="color:#FC427B; font-weight:bold; font-style:italic">
                    <?php
                      if(isset($error['fullname'])){
                        echo $error['fullname'];
                      }
                    ?>
                  </span>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control input_box" name="address" placeholder="Enter Your Address">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control input_box" name="number" placeholder="Enter Your Number">
                  <span style="color:#FC427B; font-weight:bold; font-style:italic">
                    <?php
                      if(isset($error['c_number'])){
                        echo $error['c_number'];
                      }
                    ?>
                  </span>
                </div>
                <div class="form-group">
                  <input type="password" id="password" class="form-control input_box" name="password" placeholder="Enter Your Password">
                  <span style="color:#FC427B; font-weight:bold; font-style:italic">
                    <?php
                      if(isset($error['pass'])){
                        echo $error['pass'];
                      }
                      if(isset($pass_lenth)){
                        echo $pass_lenth;
                      }
                    ?>
                  </span>
                </div>
                <div class="form-group">
                  <input type="password" id="password" class="form-control input_box" name="cpassword" placeholder="Enter Your Confirm Password">
                  <span style="color:#FC427B; font-weight:bold; font-style:italic">
                  <?php
                      if(isset($pass_check)){
                        echo $pass_check;
                      }
                    ?>
                  </span>
                </div>
                <div class="form-group">
                      <input type="file" class="form-control input_box p-1 pl-4" name="picture">
                </div>
                <div class="btn_color">
                  <input type="submit" name="signup" value="Sign Up" class="btn btn-block brder">
                </div>
              </form>
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
  </body>
</html>
<?php
require_once('include/dbcon.php');

function validate($data){
  $data = trim($data);
  $data = stripcslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['change_pass'])){
  $email      = validate($_POST['email']) ;
  $c_number   = validate($_POST['number']);
  $npass      = $_POST['npassword'];
  $cpass      = $_POST['cpassword'];

  $error = array();
  if(empty($email)){
    $error['email']= "The required field is empty!";
  }
  if(empty($c_number)){
    $error['c_number']= "The required field is empty!";
  }
  if(empty($npass)){
    $error['npass']= "The required field is empty!";
  }
  if(count($error)==0){
    $sql = "SELECT * FROM `user` WHERE email = :email and c_number = :c_number";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':c_number', $c_number, PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount()>0){
      if(strlen($npass)>3){
        if($npass == $cpass){
          $sql = "UPDATE `user` SET `password`=:npass WHERE email = :email and c_number = :c_number";
            $query = $db->prepare($sql);
            $query->bindParam(':email',$email, PDO::PARAM_STR);
            $query->bindParam(':c_number',$c_number, PDO::PARAM_STR);
            $query->bindParam(':npass',$npass,PDO::PARAM_STR);
            $result = $query->execute();
            if($result){
              echo '<script type:"text/script">
                swal("Success", "Password change Successfull", "success");
              </script>';
            }else{
              echo '<script type:"text/script">
                swal("Error", "Something is Wrong! Try again.", "error");
              </script>';
            }
        }else{
          $pass_check = "Confirm password not match";
        }
      }else{
        $pass_lenth = "Password more than 4 characters.";
      }
    }else{
      echo '<script type:"text/script">
        swal("Error", "Signup Email And Contact Number Not Match. Please Try Again.", "error");
        </script>';
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
    <title>Password Recovery</title>
    <style>
      .bg_overlay3{
        padding: 150px 0px;
        background-image: url(img/bg.jpg);
        background-repeat: no-repeat;
        background-attachment: fixed;
}
    </style>
  </head>
  <body>
    <div class="bg_overlay3">
    <div class="container">    
      <div class="row">
        <div class="col-sm-4 offset-sm-4">
          <div class="card" style="background-color: #6D214F;">
            <div class="card-header" style="background-color: #B33771;">
              <span style="color: white;font-size:20px;font-weight:bold">Password Recovery</span>
              <span class="float-right">
                <a href="login.php" class="text-white">Login</a>
              </span>
            </div>
            <div class="card-body">
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="email" class="form-control input_box" name="email" placeholder="Enter Your Reg E-mail" autofocus="autofocus">
                  <span style="color:#F97F51; font-weight:bold; font-style:italic">
                    <?php
                      if(isset($error['email'])){
                        echo $error['email'];
                      }
                    ?>
                  </span>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control input_box" name="number" placeholder="Enter Reg Phone Number"  autofocus="autofocus">
                  <span style="color:#F97F51; font-weight:bold; font-style:italic">
                    <?php
                      if(isset($error['c_number'])){
                        echo $error['c_number'];
                      }
                    ?>
                  </span>
                </div>
                <div class="form-group">
                  <input type="password" id="password" class="form-control input_box" name="npassword" placeholder="Enter New Password">
                  <span style="color:#F97F51; font-weight:bold; font-style:italic">
                    <?php
                      if(isset($error['npass'])){
                        echo $error['npass'];
                      }
                      if(isset($pass_lenth)){
                        echo $pass_lenth;
                      }
                    ?>
                  </span>
                </div>
                <div class="form-group">
                  <input type="password" id="password" class="form-control input_box" name="cpassword" placeholder="Confirm New Password">
                  <span style="color:#F97F51; font-weight:bold; font-style:italic">
                  <?php
                      if(isset($pass_check)){
                        echo $pass_check;
                      }
                    ?>
                  </span>
                </div>
                <div class="btn_color">
                  <input type="submit" name="change_pass" value="Change Password" class="btn btn-block brder">
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
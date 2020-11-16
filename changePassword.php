<?php
    require_once 'include/header.php';
    require_once 'include/dbcon.php';

        if(isset($_POST['update_password'])){
            $oldpassword    = $_POST['oldpassword'];
            $npass          = $_POST['npassword'];
            $cpass          = $_POST['cpassword'];
            
            $error = array();
            if(empty($oldpassword)){
            $error['oldpassword']= "The required field is empty!";
            }
            if(empty($npass)){
            $error['npass']= "The required field is empty!";
            }
            if(count($error)==0){
                $sql = "SELECT * FROM `user` WHERE password = :oldpassword";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':oldpassword', $oldpassword, PDO::PARAM_STR);
                $stmt->execute();
                if($stmt->rowCount()>0){
                    if(strlen($npass)>3){
                        if($npass == $cpass){
                            $sql = "UPDATE `user` SET `password`=:npass WHERE password = :oldpassword";
                            $query = $db->prepare($sql);
                            $query->bindParam(':oldpassword',$oldpassword, PDO::PARAM_STR);
                            $query->bindParam(':npass',$npass,PDO::PARAM_STR);
                            $result = $query->execute();
                            if($result){
                                echo '<script type:"text/script">
                                swal("Success", "Password Change Successfull", "success");
                                </script>';
                            }else{
                                echo '<script type:"text/script">
                                    swal("Error", "Something is Wrong! Try again.", "error");
                                </script>';
                            }
                        }else{
                            $pass_check = "Confirm Password Not Match.";
                        }
                    }else{
                        $pass_lenth = "Password More Than 4 Characters.";
                    }
                }else{
                    $oldpass_check = "Old Password Not Match. Please Try Again.";
                }
            }
        }
        ?>
<!-- User change password -->
    <div class="container pt-5 mt-5">    
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
            <div class="card" style="background-color: #CAD3C8;">
                <div class="card-header" style="background-color: #eee;">
                <span style="font-size:20px;font-weight:bold">Change Password</span>
                </div>
                <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                    <input type="password" class="form-control" name="oldpassword" placeholder="Enter old password"  autofocus="autofocus">
                    <span style="color:red; font-weight:bold; font-style:italic">
                        <?php
                        if(isset($error['oldpassword'])){
                            echo $error['oldpassword'];
                        }
                        if(isset($oldpass_check)){
                            echo $oldpass_check;
                        }
                        ?>
                    </span>
                    </div>
                    <div class="form-group">
                    <input type="password" id="password" class="form-control" name="npassword" placeholder="Enter New Password">
                    <span style="color:red; font-weight:bold; font-style:italic">
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
                    <input type="password" id="password" class="form-control" name="cpassword" placeholder="Confirm New Password">
                    <span style="color:red; font-weight:bold; font-style:italic">
                    <?php
                        if(isset($pass_check)){
                            echo $pass_check;
                        }
                        ?>
                    </span>
                    </div>
                    <div class="btn_color">
                    <input type="submit" name="update_password" value="Update Password" class="btn btn-block brder">
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
        </div>
<?php
    require_once 'include/footer.php';
?>

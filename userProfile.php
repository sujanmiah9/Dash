<?php
    require_once 'include/header.php';
    require_once 'include/dbcon.php';

    $id = "";
    if(base64_decode($_GET['id'])){
        $id =(int) base64_decode($_GET['id']);
    }

    $sql = "SELECT * FROM `user` WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id',$id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();


    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $full_name  = $_POST['full_name'];
        $email      = strtolower($_POST['email']);
        $address    = $_POST['address'];
        $c_number   = $_POST['c_number'];
        $picture    = $_FILES['picture']['name'];

        if(empty($picture)){
            $sql = "UPDATE `user` SET `full_name`=:full_name,`email`=:email, `address`=:addresss, `c_number`=:c_number WHERE `id`=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id,PDO::PARAM_STR);
            $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
            $stmt->bindParam(':email',$email, PDO::PARAM_STR);
            $stmt->bindParam(':addresss', $address, PDO::PARAM_STR);
            $stmt->bindParam(':c_number', $c_number, PDO::PARAM_STR);
            $result = $stmt->execute();
            if($result){
                echo '<script type:"text/script">alert("Data Update Successfull.");</script>';
            }else{
                echo '<script type:"text/script">alert("Data update Error! Try again.");</script>';
            }
        }else{
            $pic        = explode('.', $picture);
            $pic        = end($pic);
            $orgin_pic  = $full_name.'.'.$pic;
            $sql = "UPDATE `user` SET `full_name`=:full_name,`email`=:email, `address`=:addresss, `c_number`=:c_number,`photo`=:orgin_pic WHERE `id`=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id,PDO::PARAM_STR);
            $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
            $stmt->bindParam(':email',$email, PDO::PARAM_STR);
            $stmt->bindParam(':addresss', $address, PDO::PARAM_STR);
            $stmt->bindParam(':c_number', $c_number, PDO::PARAM_STR);
            $stmt->bindParam(':orgin_pic', $orgin_pic, PDO::PARAM_STR);
            $result = $stmt->execute();
            if($result){
                $tmp_name = $_FILES['picture']['tmp_name'];
                @unlink("uploaded/".$result['photo']);
                move_uploaded_file($tmp_name, "uploaded/".$orgin_pic);
                echo '<script type:"text/script">
                    swal("Success", "Profile Update Successfull", "success");
                </script>';
            }else{
                echo '<script type:"text/script">
                    swal("Error", "Something is Wrong! Try again.", "error");
                </script>';
            }
        }  
    }
?>
<!-- User Profile -->
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-header bg-info text-center text-white">
                    <h4 class="display-5" style="font-weight: 500;">User Profile Update</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="">Full Name</label>
                                        <input type="hidden" name="id" value="<?php echo $result['id'];?>">
                                        <input type="text" name="full_name" class="form-control" value="<?php echo $result['full_name'];?>">
                                        <small class="text-danger">If user name update then must be profile picture update.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo $result['email'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" name="address" class="form-control" value="<?php echo $result['address'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Contact Number</label>
                                        <input type="text" name="c_number" class="form-control" value="<?php echo $result['c_number'];?>">
                                    </div>
                                
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="uploaded/<?php echo $result['photo'];?>" alt="" style="height: 180px; width:200px;" class="img-fluid">
                                        <label for="">Upload Picture</label>
                                        <input type="file" name="picture" class="form-control p-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="update" class="btn btn-info btn-lg" value="Update Profile">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    require_once 'include/footer.php';
?>

<?php
    require_once 'include/header.php';
    require_once 'include/dbcon.php';

    if(isset($_POST['addbrand'])){
        $name       = $_POST['name'];
        $descript   = $_POST['descript'];

        $error = array();
        if(empty($name)){
            $error['name'] = "The required field is empty!";
        }
        if(count($error) == 0){
            $sql = "INSERT INTO `add_brand`(`name`, `description`) VALUES (:nam, :descript)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nam',$name,PDO::PARAM_STR);
            $stmt->bindParam(':descript', $descript, PDO::PARAM_STR);
            $result = $stmt->execute();
            if($result){
                echo '<script type:"text/script">
                    swal("Added", "New Brand Add Successfull", "success");
                </script>';
            }else{
                echo '<script type:"text/script">
                    swal("Error", "Something is Wrong! Try again.", "error");
                </script>';
            }
        }
    }
?>
<!--main content start-->
<div class="container p-5 mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <span style="font-size:25px;">Add New Brand</span>
                    <span class="float-right"><a style="color: #fff;text-decoration:none;" href="viewBrand.php">View Brand</a></span>
                </div>
                    <div class="card-body" style="background-color:#eee">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Brand Name</label>
                            <input type="text" class="form-control" name="name" value="" placeholder="Enter new Brand..." >
                            <div style="color:red;">
                            <?php
                                if(isset($error['name'])){
                                    echo $error['name'];
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Description <small class="text-muted">(Optional)</small></label>
                            <textarea name="descript" class="form-control" rows="8" cols="80" placeholder="Add some note or description about this Brand..."></textarea>
                        </div>
                    </div>
                        <div class="card-footer text-right bg-light">
                            <input type="submit" class="btn btn-danger" name="addbrand" value="Add Brand">
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
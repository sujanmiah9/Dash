<?php
    require_once 'include/header.php';
    include_once 'include/dbcon.php';

    $id = "";
    if(base64_decode($_GET['id'])){
    $id = (int) base64_decode($_GET['id']);
}
    $sql = "SELECT * FROM `catagories` WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id,PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();

    if(isset($_POST['update'])){
        $id       = $_POST['id'];
        $name     = $_POST['name'];
        $descript = $_POST['descript'];

        $sql  = "UPDATE `catagories` SET `name`=:namee,`description`=:descript WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_STR);
        $stmt->bindParam(':namee',$name,PDO::PARAM_STR);
        $stmt->bindParam(':descript',$descript,PDO::PARAM_STR);
        $result = $stmt->execute();
        if($result){
            echo '<script type:"text/scritp">
                swal("Success", "Catagories Update Successfull", "success");
            </script>';
        }else{
            echo '<script type:"text/scritp">
                swal("Error", "Something is Wrong! Try again.", "error");
            </script>';
        }
    }
?>
<div class="container pt-5 mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white bg-danger">
                    Updata Brand
                    <span class="float-right">
                        <a href="viewCatagories.php" class="text-white">
                        <i class="fa fa-fw fa-bandcamp"></i>
                        View Catagories
                        </a>
                    </span>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Brand Name</label>
                            <input type="hidden" name="id" value="<?php echo $result['id'];?>">
                            <input type="text" class="form-control" name="name" value="<?php echo $result['name'];?>">
                        </div>
                        <div class="form-group">
                            <label for="">Brand Description</label>
                            <textarea type="text" class="form-control" name="descript" value="<?php echo $result['description'];?>" rows="6"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-secondary float-right" name="update" value="Update Caragories">
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
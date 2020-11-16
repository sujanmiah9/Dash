<?php
    require_once 'include/header.php';
    include_once 'include/dbcon.php';

    $id = "";
    if(base64_decode($_GET['id'])){
    $id = (int) base64_decode($_GET['id']);
}
    $sql = "SELECT * FROM `add_product` WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id,PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();
    $type = $result['id'];
    $type = $result['product_type'];
    $brand = $result['product_brand'];
    $name = $result['product_name'];
    $size = $result['product_size'];
    $color = $result['product_color'];
    $price = $result['product_price'];
    $item = $result['product_item'];
    $description = $result['product_description'];
    $picture = $result['product_picture'];


    //udatde product code
    if(isset($_POST['updateProduct'])){
        $id          = $_POST['id'];
        $p_type      = $_POST['p_type'];
        $p_brand     = $_POST['p_brand'];
        $p_name      = $_POST['p_name'];
        $p_size      = $_POST['p_size'];
        $p_color     = $_POST['p_color'];
        $p_price     = $_POST['p_price'];
        $p_item      = $_POST['p_item'];
        $p_descript  = $_POST['p_descript'];
        $picture     = $_FILES['picture']['name'];
        
            if(empty($picture)){
                $sql = "UPDATE `add_product` SET `product_type`=:p_type,`product_brand`=:p_brand,`product_name`=:p_name,
                `product_size`=:p_size, `product_color`=:p_color,`product_price`=:p_price,
                `product_item`=:p_item,`product_description`=:p_descript WHERE id = :id;";
    
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->bindParam(':p_type', $p_type, PDO::PARAM_STR);
                $stmt->bindParam(':p_brand',$p_brand, PDO::PARAM_STR);
                $stmt->bindParam(':p_name', $p_name, PDO::PARAM_STR);
                $stmt->bindParam(':p_size', $p_size, PDO::PARAM_STR);
                $stmt->bindParam(':p_color', $p_color, PDO::PARAM_STR);
                $stmt->bindParam(':p_price', $p_price, PDO::PARAM_STR);
                $stmt->bindParam(':p_item', $p_item, PDO::PARAM_STR);
                $stmt->bindParam(':p_descript', $p_descript, PDO::PARAM_STR);
                $result = $stmt->execute();
                if($result){
                    echo '<script type:"text/script">alert("Product Update Successfull.")</script>';
                }else{
                    echo '<script type:"text/script">alert("Product Update Error! please try again..")</script>';
                } 
            }else{
                $pic     = explode('.', $picture);
                $pic     = end($pic);
                $orgin_pic = $p_name.'.'.$pic;
                
                $sql = "UPDATE `add_product` SET `product_type`=:p_type,`product_brand`=:p_brand,`product_name`=:p_name,
                `product_size`=:p_size, `product_color`=:p_color,`product_price`=:p_price,
                `product_item`=:p_item,`product_description`=:p_descript,`product_picture`=:p_photo WHERE id = :id;";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->bindParam(':p_type', $p_type, PDO::PARAM_STR);
                $stmt->bindParam(':p_brand',$p_brand, PDO::PARAM_STR);
                $stmt->bindParam(':p_name', $p_name, PDO::PARAM_STR);
                $stmt->bindParam(':p_size', $p_size, PDO::PARAM_STR);
                $stmt->bindParam(':p_color', $p_color, PDO::PARAM_STR);
                $stmt->bindParam(':p_price', $p_price, PDO::PARAM_STR);
                $stmt->bindParam(':p_item', $p_item, PDO::PARAM_STR);
                $stmt->bindParam(':p_descript', $p_descript, PDO::PARAM_STR);
                $stmt->bindParam(':p_photo', $orgin_pic, PDO::PARAM_STR);
                $result = $stmt->execute();
                if($result){
                    $tmp_file = $_FILES['picture']['tmp_name'];
                    @unlink("uploaded/".$picture);
                    move_uploaded_file($tmp_file,"uploaded/".$orgin_pic);
                    echo '<script type:"text/script">
                        swal("Success", "Product Update Successfull", "success");
                    </script>';
                }else{
                    echo '<script type:"text/script">
                        swal("Error", "Something is Wrong! Try again.", "error");
                    </script>';
            }
        }
    }
?>

<?php
//dynamic product type add
    $sql = "SELECT * FROM `catagories`;";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


//dyinamic product brand add
    $sql = "SELECT * FROM `add_brand`";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container pt-5 mt-5">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-white bg-info">
                    Updata Product
                    <span class="float-right">
                        <a href="viewProduct.php" class="text-white">
                        <i class="fa fa-fw fa-bandcamp"></i>
                        View Product
                        </a>
                    </span>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                    <label>Product Type</label>
                                        <select class="form-control text-primary" name="p_type" required>
                                            <option selected><?php echo $result['product_type'];?><option>
                                            <option disabled><sub>Please select a Catagories</sub></option>
                                            <?php
                                                foreach($results as $result){
                                            ?>
                                            <option value="<?php echo $result['name'];?>"><?php echo $result['name']?></option>
                                        <?php } ?>
                                        </select>
                                    <small class="float-right">Catagories not listed here? <a href="addCatagories.php">Add new</a> </small>
                                </div>
                                <div class="form-group">
                                    <label>Product Brand</label>
                                        <select class="form-control text-primary"name="p_brand" required>
                                            <option selected><?php echo $brand?><option>
                                            <option disabled><sub>Please select a product brand</sub></option>
                                            <?php
                                                foreach($results2 as $result2){
                                            ?>
                                            <option value="<?php echo $result2['name'];?>"><?php echo $result2['name'];?></option>
                                            <?php } ?>
                                        </select>
                                        <small class="float-right">Products brand not listed here? <a href="addBrand.php">Add new</a> </small>
                                </div>
                                <div class="form-group">
                                    <label for="">Product Name</label>
                                    <input type="text" class="form-control" name="p_name" value="<?php echo $name?>" placeholder="Enter product name..." >
                                    <small class="text-danger">If product name update then must be product picture update.</small>
                                </div>
                                <div class="form-group">
                                    <label>Product Size</label>
                                    <select class="form-control text-primary" name="p_size" required>
                                        <option selected><?php echo $size;?></option>
                                        <option disabled><sub>Please select a product size..</sub></option>
                                        <option value="Small">Small</option>
                                        <option value="Mediam">Mediam</option>
                                        <option value="Large">Large</option>
                                    </select>
                                    <div style="color:red">
                                        <?php
                                            if(isset($error['p_size'])){
                                                echo $error['p_size'];
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Product Color</label>
                                    <select class="form-control text-primary" name="p_color" required>
                                        <option selected><?php echo $color;?></option>
                                        <option disabled><sub>Please select a product Color..</sub></option>
                                        <option value="Grey">Grey</option>
                                        <option value="Beige">Beige</option>
                                        <option value="White">White</option>
                                        <option value="Black">Black</option>
                                        <option value="Blue">Blue</option>
                                        <option value="Pink">Pink</option>
                                        <option value="Green">Green</option>
                                    </select>
                                    <div style="color:red">
                                        <?php
                                            if(isset($error['p_color'])){
                                                echo $error['p_color'];
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Product Price <small class="text-muted">(tk)</small> </label>
                                    <input type="number" class="form-control" name="p_price" value="<?php echo $price;?>" placeholder="Enter cost of product per item..." >
                                    <div style="color:red">
                                        <?php
                                            if(isset($error['p_price'])){
                                                echo $error['p_price'];
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Product item</label>
                                    <input type="number" class="form-control" name="p_item" value="<?php echo $item;?>" placeholder="Enter number of items..." >
                                    <div style="color:red">
                                        <?php
                                            if(isset($error['p_item'])){
                                                echo $error['p_item'];
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Description <small class="text-muted">(Optional)</small></label>
                                    <textarea name="p_descript" class="form-control" value="<?php echo $description;?>" rows="8" cols="80" placeholder="Add some note or description about this catagories..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="uploaded/<?php echo $picture;?>" alt="" class="img-fluid" style="height: 200px; width:200px;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Product Picture</label>
                                    <input type="file" class="form-control" name="picture">
                                </div>
                                <div class="bg-light">
                                    <input type="submit" class="btn btn-info" name="updateProduct" value="Update Product">
                                </div>
                            </div>
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
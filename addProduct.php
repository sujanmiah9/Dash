<?php
    require_once 'include/header.php';
    require_once 'include/dbcon.php';

    $p_type = $p_brand = $p_size = $p_color = $p_price ="";
    function validate($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if(isset($_POST['addProduct'])){
        $p_type      = $_POST['p_type'];
        $p_brand     = $_POST['p_brand'];
        $p_name      = validate($_POST['p_name']);
        $p_size      = $_POST['p_size'];
        $p_color     = $_POST['p_color'];
        $p_price     = validate($_POST['p_price']);
        $p_item      = validate($_POST['p_item']);
        $p_descript  = $_POST['p_descript'];

    
        $picture = $_FILES['picture']['name'];
        $pic     = explode('.', $picture);
        $pic     = end($pic);
        $orgin_pic = $p_name.'.'.$pic;

        $error = array();
        if(empty($p_type)){
            $error['p_type']= "The required field is empty!";
        }
        if(empty($p_brand)){
            $error['p_brand']= "The required field is empty!";
        }
        if(empty($p_name)){
            $error['p_name']= "The required field is empty!";
        }
        if(empty($p_size)){
            $error['p_size']= "The required field is empty!";
        }
        if(empty($p_color)){
            $error['p_color']= "The required field is empty!";
        }
        if(empty($p_price)){
            $error['p_price']= "The required field is empty!";
        }
        if(empty($p_item)){
            $error['p_item']= "The required field is empty!";
        }

        if(count($error)==0){
            $sql = "INSERT INTO `add_product`(`product_type`, `product_brand`, `product_name`, `product_size`, `product_color`, `product_price`, `product_item`, `product_description`, `product_picture`)
            VALUES (:p_type, :p_brand, :p_name, :p_size, :p_color, :p_price, :p_item, :p_descript, :p_photo)";

            $stmt = $db->prepare($sql);
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
                move_uploaded_file($tmp_file,"uploaded/".$orgin_pic);
                echo '<script type:"text/script">
                    swal("Added", "New Product Add Successfull", "success");
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
<!--main content start-->
<div class="container p-5 mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card" style="background-color: #eee;">
                <div class="card-header text-white"style="background-color: #30336b;" >
                    <span style="font-size:25px;">Add Product</span>
                    <span class="float-right"><a style="color: #fff;text-decoration:none;" href="viewProduct.php">View Product</a></span>
                </div>
                    <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Product Type</label>
                        <select class="form-control text-primary" name="p_type" required>
                        <option disabled selected><sub>Please select a Catagories</sub></option>
                        <?php
                            foreach($results as $result){
                        ?>
                        <option value="<?php echo $result['name'];?>"><?php echo $result['name']?></option>
                        <?php } ?>
                        </select>
                        <small class="float-right">Catagories not listed here? <a href="addCatagories.php">Add new</a> </small>
                    <div style="color:red">
                        <?php
                            if(isset($error['p_type'])){
                                echo $error['p_type'];
                            }
                        ?>
                    </div>
                    </div>
                    <div class="form-group">
                        <label>Product Brand</label>
                        <select class="form-control text-primary"name="p_brand" required>
                            <option disabled selected><sub>Please select a product brand</sub></option>
                            <?php
                                foreach($results2 as $result2){
                            ?>
                            <option value="<?php echo $result2['name'];?>"><?php echo $result2['name'];?></option>
                            <?php } ?>
                            </select>
                            <small class="float-right">Products brand not listed here? <a href="addBrand.php">Add new</a> </small>
                            <div style="color:red">
                                <?php
                                    if(isset($error['p_brand'])){
                                        echo $error['p_brand'];
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <input type="text" class="form-control" name="p_name" value="" placeholder="Enter product name..." >
                            <div style="color:red">
                                <?php
                                    if(isset($error['p_name'])){
                                        echo $error['p_name'];
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Product Size</label>
                            <select class="form-control text-primary" name="p_size" required>
                                <option disabled selected><sub>Please select a product size..</sub></option>
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
                                <option disabled selected><sub>Please select a product Color..</sub></option>
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
                            <input type="number" class="form-control" name="p_price" value="" placeholder="Enter cost of product per item..." >
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
                            <input type="number" class="form-control" name="p_item" value="" placeholder="Enter number of items..." >
                            <div style="color:red">
                                <?php
                                    if(isset($error['p_item'])){
                                        echo $error['p_item'];
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Product Picture</label>
                            <input type="file" class="form-control" name="picture">
                        </div>
                        <div class="form-group">
                            <label for="">Description <small class="text-muted">(Optional)</small></label>
                            <textarea name="p_descript" class="form-control" rows="8" cols="80" placeholder="Add some note or description about this catagories..."></textarea>
                        </div>
                    </div>
                        <div class="card-footer text-right bg-light">
                            <input type="submit" class="btn btn-dark" name="addProduct" value="Add Product">
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php
    include_once 'include/footer.php';
?>
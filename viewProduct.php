<?php
    require_once 'include/header.php';
    require_once 'include/dbcon.php';

    $sql  = "SELECT * FROM `add_product`";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container pt-5 mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: #1B1464;color:#fff;">
                    <i class="fa fa-table"></i>
                        Product List
                    <a href="addProduct.php">
                        <span class="float-right text-white">
                            <i class="fa fa-plus"></i>
                                Add Product
                        </span>
                    </a>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sl. No</th>
                                <th>Product type</th>
                                <th>Product Brand</th>
                                <th>Product Name</th>
                                <th>Product Size</th>
                                <th>Product Color</th>
                                <th>Product Price</th>
                                <th>Product item</th>
                                <th>Product Description</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($results as $result=>$value){
                                ?>
                            <tr>
                                <td><?php echo htmlentities($result+1);?></td>
                                <td><?php echo htmlentities($value['product_type']);?></td>
                                <td><?php echo htmlentities($value['product_brand']);?></td>
                                <td><?php echo htmlentities($value['product_name']);?></td>
                                <td><?php echo htmlentities($value['product_size']);?></td>
                                <td><?php echo htmlentities($value['product_color']);?></td>
                                <td><?php echo htmlentities($value['product_price']);?></td>
                                <td><?php echo htmlentities($value['product_item']);?></td>
                                <td><?php echo htmlentities($value['product_description']);?></td>
                                <td>
                                    <img src="uploaded/<?php echo htmlentities($value['product_picture']);?>" alt="img" style="height:80px; width:70px;"> 
                                </td>
                                <td>
                                    <a href="editProduct.php?id=<?php echo base64_encode($value['id']);?>" class="btn btn-primary btn-block">Edit</a> &nbsp&nbsp&nbsp&nbsp;
                                    <a href="delete.php?action=productDelete&id=<?php echo base64_encode($value['id']);?>" class="btn btn-danger btn-block" onclick="return confirm('Are you sure to delete this product name?')">Delete</a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    require_once 'include/footer.php';
?>
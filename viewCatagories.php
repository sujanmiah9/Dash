<?php
    require_once 'include/header.php';
    require_once 'include/dbcon.php';


    $sql = "SELECT * FROM `catagories`";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container pt-5 mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: #1B1464;color:#fff;">
                    <i class="fa fa-user"></i>
                        Catagories List
                        <span class="float-right">
                            <a href="addBrand.php" class="text-white">
                            <i class="fa fa-plus"></i>
                            Add Catagories
                            </a>
                        </span>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sl. No</th>
                                <th>Catagorie Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($results as $result=>$value){
                                    ?>
                            <tr>
                                <td><?php echo htmlentities($result+1);?></td>
                                <td><?php echo htmlentities($value['name']);?></td>
                                <td><?php echo htmlentities($value['description']);?></td>
                                <td>
                                    <a href="editCatagories.php?id=<?php echo base64_encode($value['id']);?>" class="btn btn-primary">Edit</a> &nbsp&nbsp&nbsp&nbsp;
                                    <a href="delete.php?action=cataDelete&id=<?php echo base64_encode($value['id']);?>" onclick="return confirm('Are you sure to delete this Catagories?')" class="btn btn-danger">Delete</a>
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
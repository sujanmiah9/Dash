<?php
    require_once 'include/header.php';
    require_once 'include/dbcon.php';
?>
<div class="container pt-5 mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: #1B1464;color:#fff;">
                    <i class="fa fa-user"></i>
                        User List
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sl.No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>C_Number</th>
                                <th>Photo</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $sql = "SELECT * FROM `user`";
                        $prepare = $db->prepare($sql);
                        $prepare->execute();
                        $results = $prepare->fetchAll(PDO::FETCH_ASSOC);
                        foreach($results as $result=>$value){ ?>
                
                            <tr>
                                <td><?php echo $result+1;?></td>
                                <td><?php echo $value['full_name'];?></td>
                                <td><?php echo $value['email'];?></td>
                                <td><?php echo $value['address'];?></td>
                                <td><?php echo $value['c_number'];?></td>
                                <td>
                                <img src="uploaded/<?php echo htmlentities($value['photo']);?>" alt="img" style="height:80px; width:70px;"> 
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
<?php
  require_once 'include/header.php';
  require_once 'include/dbcon.php';


// all user row count
  $sql = "SELECT * FROM `user`;";
  $prepare = $db->prepare($sql);
  $prepare->execute();
  $row = $prepare->rowCount();

  //all product count
  $sql = "SELECT * FROM `add_product`;";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $row2 = $stmt->rowCount();

  //all catagories count

  $sql = "SELECT * FROM `catagories`;";
  $stmt= $db->prepare($sql);
  $stmt->execute();
  $row3 = $stmt->rowCount();

  //all brand count
  $sql = "SELECT * FROM `add_brand`;";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $row4 = $stmt->rowCount();
?>

		<!--Main content start-->
    <div id="content-wrapper">
        <div class="container-fluid pt-5 mt-3">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="dashboard.php">Home</a>
            </li>
            <li class="breadcrumb-item active">Dashboard Statistics</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
              <div class="card">
                <div class="card-header" style="background-color:#273c75;color:#fff">
                  <h1>Total User</h1>
                </div>
                <div class="card-body" style="background-color:#192a56;color:#fff">
                  <div class="card-text">
                    <h1 class="text-center display-4"><strong>
                      <?php
                      echo $row;
                      ?>
                    </strong></h1>
                  </div>
                </div>
                <a class="card-footer "style="background-color:#273c75;color:#fff" href="viewUser.php">
                  <span class="float-left">View List</span>
                  <span class="float-right">
                    <i class="fa fa-arrow-circle-right"></i>
                  </span>
                </a>
              </div>
            </div>
			<div class="col-md-4 col-sm-6 col-xs-12 mb-3">
              <div class="card">
                <div class="card-header" style="background-color:#e84118;color:#fff">
                  <h1>Total Product</h1>
                </div>
                <div class="card-body" style="background-color:#c23616;color:#fff">
                  <div class="card-text">
                    <h1 class="text-center display-4"><strong>
                      <?php
                        echo htmlentities($row2);
                      ?>
                    </strong></h1>
                  </div>
                </div>
                <a class="card-footer "style="background-color:#e84118;color:#fff" href="viewProduct.php">
                  <span class="float-left">View List</span>
                  <span class="float-right">
                    <i class="fa fa-arrow-circle-right"></i>
                  </span>
                </a>
              </div>
            </div>
			<div class="col-md-4 col-sm-6 col-xs-12 mb-3">
              <div class="card">
                <div class="card-header" style="background-color:#485460;color:#fff">
                  <h1>Total Catatories</h1>
                </div>
                <div class="card-body" style="background-color:#1e272e;color:#fff">
                  <div class="card-text">
                    <h1 class="text-center display-4"><strong>
                      <div>
                        <?php
                          echo htmlentities($row3);
                        ?>
                      </div>
                    </strong></h1>
                  </div>
                </div>
                <a class="card-footer "style="background-color:#485460;color:#fff" href="viewCatagories.php">
                  <span class="float-left">View List</span>
                  <span class="float-right">
                    <i class="fa fa-arrow-circle-right"></i>
                  </span>
                </a>
              </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-4">
          <div class="card">
                <div class="card-header" style="background-color:#4cd137;color:#fff">
                  <h1>Total Brand</h1>
                </div>
                <div class="card-body" style="background-color:#44bd32;color:#fff">
                  <div class="card-text">
                    <h1 class="text-center display-4"><strong>
                      <div>
                        <?php
                          echo htmlentities($row4);
                        ?>
                      </div>
                    </strong></h1>
                  </div>
                </div>
                <a class="card-footer "style="background-color:#4cd137;color:#fff" href="viewBrand.php">
                  <span class="float-left">View List</span>
                  <span class="float-right">
                    <i class="fa fa-arrow-circle-right"></i>
                  </span>
                </a>
              </div>
          </div>
        </div>
        </div>
    <!--Main content end-->
    <?php
  require_once 'include/footer.php';
?>
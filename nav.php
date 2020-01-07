<?php require 'navbar.html'; ?>
<nav class="navbar navbar-expand-md navbar-dark bg-info fixed-top">
    <div class="container">
        <?php if($_SESSION['level']=='admin') {
            $usr=$_SESSION['username'];
            $home="admin.php";
        }elseif($_SESSION['level']=='keuangan') {
            $usr=$_SESSION['username'];
            $home="keuangan.php";
        }elseif($_SESSION['level']=='warga') {
            $userin=mysqli_fetch_array(mysqli_query($conn,"SELECT * from warga where Nomor_KK='".$_SESSION['username']."'"));
            $usr=$userin['Nama'];
            $home="home.php";
        }else{
            $home="login.php";
        }
        ?>
        <a class="navbar-brand" href="<?=$home?>">Rusunawa - <?=$usr?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                <!-- <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a> -->
                <?php if($_SESSION['level']=='admin') {?>
                 <a class="nav-item nav-link <?php if($_GET['page']=='hunian'){echo 'active';}?>" href="admin.php?page=hunian">Penempatan Hunian<span class="sr-only">(current)</span></a>
                 <span class="nav-item nav-link">|</span>
                 <a class="nav-item nav-link <?php if($_GET['page']=='warga'){echo 'active';}?>" href="admin.php?page=warga">Data Warga<span class="sr-only">(current)</span></a>
                 <span class="nav-item nav-link">|</span>
                 <a class="nav-item nav-link <?php if($_GET['page']=='unit'){echo 'active';}?>" href="admin.php?page=unit">Data Unit<span class="sr-only">(current)</span></a>
                 <span class="nav-item nav-link">|</span>
                 <a class="nav-item nav-link <?php if($_GET['page']=='user'){echo 'active';}?>" href="admin.php?page=user">Data User<span class="sr-only">(current)</span></a>
                 <span class="nav-item nav-link">|</span>

                <?php }elseif ($_SESSION['level']=='keuangan') {?>
                <a class="nav-item nav-link" href="transaction.php">Transaction<span class="sr-only">(current)</span></a>
                <?php }elseif ($_SESSION['level']=='warga') {?>
                <a class="nav-item nav-link <?php if($_GET['page']=='info'){echo 'active';}?>" href="home.php?page=info">Informasi<span class="sr-only">(current)</span></a>
                <!-- <a class="nav-item nav-link <?php if($_GET['page']=='bill'){echo 'active';}?>" href="home.php?page=bill">Tagihan<span class="sr-only">(current)</span></a> -->
                <?php } ?>
               
               <div class="btn-group">
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <?=$usr?>
                  </button>
                  <div class="dropdown-menu">
                    <span class="dropdown-item"><i class="fa fa-clock-o"></i> Last Login <br>
                      <small><?=$_SESSION['last']?></small></span>
                    <a class="dropdown-item" href="changepass.php"><i class="fa fa-lock"></i> Ubah Password</a>
                    <a class="dropdown-item text-danger" href="logout.php"><i class="fa fa-power-off"></i> Log Out</a>
                  </div>
                </div>
               
                <!-- <a class="nav-item btn btn-danger tombol" href="logout.php">Log Out</a> -->
            </div>
        </div>
    </div>
</nav>
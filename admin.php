<style type="text/css">
	#edit{
		color: blue;
		padding: 10px;
		text-decoration: none;
	}
	#edit:hover{
		border-bottom: 2px solid blue;
		background-color: white;
		color: blue;
	}
	#delete{
		color: red;
		padding: 10px;
		text-decoration:none;
	}
	#delete:hover{
		border-bottom: 2px solid red;
		background-color: white;
		color: red;
	}
	.col-warga:hover{
		background-color: #eee
	}
	.col-warga{
		padding: 20px;
		border-radius: 10px;
		border-bottom: 2px solid blue;
	}
	.col-unit{
		padding: 20px;
		border-radius: 10px;
		border-bottom: 2px solid cyan;
	}
	.col-unit:hover{
		background-color: #eee;
	}
</style>
<?php
include 'koneksi.php';
if (isset($_SESSION['level'])) {
    if ($_SESSION['level']=='admin') { 
        
        }else{
            header('location: login.php');
        }
}else{
    header('location: login.php');
}
include 'nav.php';
$id=$_GET['id'];
$warga=mysqli_query($conn,'SELECT * from warga order by Nomor_KK');
$unit=mysqli_query($conn,'SELECT * from unit order by Kode_unit');
$huni=mysqli_query($conn,'SELECT * from penghuni order by id_unit');
$user=mysqli_query($conn,'SELECT * from user where level !="warga" order by level');

if ($_GET['page']=='user') {

$act=$_GET['act'];
switch ($act) {
    case 'delete':
    $id = $_GET['id'];
    $sql = "DELETE from user where username='$id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
      echo "<script>alert('Data berhasil dihapus!');window.location.href='?page=user'</script>";
    } else {
      echo mysqli_error($con);
    }
        break;
    case 'tambah':
    if (isset($_POST['simpan'])) {
        $uname=$_POST['username'];
        $Password=$_POST['Password'];
        $CPassword=$_POST['CPassword'];
        $level=$_POST['level'];
        if ($Password != $CPassword) {
            $_SESSION['pass']=$Password;
            echo "<script>alert('Password Tidak Cocok');window.location.href='?page=user&act=tambah&username=$uname&level=$level'</script>";
        }
        $cek=mysqli_query($conn,"SELECT * from user where user='$uname'");
        if (mysqli_num_rows($cek)>0) {
            echo "<script>alert('Username telah digunakan! Proses penyimpanan dibatalkan')</script>";
        }else{
            $insert=mysqli_query($conn,"INSERT INTO user VALUES ('$uname','$Password','$level',null)");
            if ($insert) {
                echo "<script>alert('Data berhasil disimpan');window.location.href='admin.php?page=user'</script>";
            }else{
                echo "<script>alert('Penambahan data gagal!');window.location.href='admin.php?page=user&act=tambah'</script>";
            }
        }
    }
    ?>

     <div class="container">
        <div class="col-10 mx-auto shadow">
            <br>
            <h3>Form Tambah User</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" <?php if (isset($_GET['username'])){echo "value='".$_GET['username']."'";}?> required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="Password" class="form-control" name="Password" <?php if ($_SESSION['pass']!=$Password){echo "value='".$_SESSION['pass']."'";}?> required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="Password" class="form-control" name="CPassword" required>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select class="custom-select" name="level" required>
                        <option selected disabled>--Pilih level--</option>
                        <option value="admin" <?php if($_GET['level']=='admin'){echo "selected";}?>>Admin</option>
                        <!-- <option value="Keuangan">Keuangan</option> -->
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info" name="simpan">Save</button>
                </div>
                <br>
            </form>
        </div>
    </div>

    <?php
        break;
    default:
    ?>
    <div class="container">
        <div class="col-12 mx-auto">
            <h3 class="text-left">Data User<span class="float-right no-print"><a href="admin.php?page=user&act=tambah" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data User</a></span></h3>
        </div>
    <br>
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="table-responsive-lg">
                    <table class="table table-hover table-striped text-center shadow p-3 mb-5 bg-white rounded">
                        <thead class="bg-info text-light">
                            <tr>
                                <th>Username</th>
                                <th>Level</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row=mysqli_fetch_array($user)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['username'];?></td>
                                    <td><?php echo $row['level'];?></td>
                                    <td>
                                    <!-- <a id="edit" href="?page=user&act=edit&id=<?=$row['username']?>">Ubah</a> -->
                                    <a id="delete" href="?page=user&act=delete&id=<?=$row['username']?>" onclick="return confirm('Hapus data dengan username <?=$row['username']?>?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
        break;
    }
}elseif ($_GET['page']=='warga') {

$act=$_GET['act'];
switch ($act) {
	case 'edit':
	if (isset($_POST['simpan'])) {
		$noKK=$_POST['noKK'];
		$noSK=$_POST['noSK'];
		$nama=$_POST['nama'];
		$dob=$_POST['dob'];
        $pob=$_POST['pob'];
		$JK=$_POST['sex'];
		$agama=$_POST['agama'];
		$tel=$_POST['tel'];
		$NIK=$_POST['NIK'];
		$noREK=$_POST['noREK'];
		$update=mysqli_query($conn,"UPDATE warga SET 
			Nomor_KK='$noKK',
			No_SP='$noSK',
			Nama='$nama',
			TTL='$dob',
            TempatLahir='$pob',
			JK='$JK',
			Agama='$agama',
			Telp='$tel',
			NIK='$NIK',
			Nomor_REK='$noREK'
			where Nomor_KK='$id'
			");
		if ($update) {
            $userwarga=mysqli_query($conn,"UPDATE user SET username='$noKK' where username='$id'");
			echo "<script>alert('Data berhasil diubah');window.location.href='admin.php?page=warga'</script>";
		}else{
			echo "<script>alert('Pengubahan data gagal!');window.location.href='admin.php?page=warga&act=edit&id=$id'</script>";
		}
	}
	$edit=mysqli_fetch_array(mysqli_query($conn,"SELECT * from warga where Nomor_KK='$id'"));
	?>

	<div class="container">
		<div class="col-8 mx-auto">
            <div class="shadow p-3 mb-5 bg-white rounded">
            	<h3>Form Penambahan Warga Rusunawa</h3>
            	<hr>
            	<form method="POST">
            		<input type="text" name="id" value="<?=$_GET["id"]?>" hidden>
        			<div class="form-group">
        				<label>Nomor Kartu Keluarga (KK)</label>
        				<input type="text" class="form-control" name="noKK" value="<?=$edit['Nomor_KK']?>" required>
        			</div>
        			<div class="form-group">
        				<label>Nomor Surat Perjanjian (SP)</label>
        				<input type="text" class="form-control" name="noSK" value="<?=$edit['No_SP']?>" required>
        			</div>
        			<div class="form-group">
        				<label>Nama Kepala Keluarga</label>
        				<input type="text" class="form-control" name="nama" value="<?=$edit['Nama']?>" required>
        			</div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" name="pob" value="<?=$edit['TempatLahir']?>" required>
                    </div>
        			<div class="form-group">
        				<label>Tanggal Lahir</label>
        				<input type="date" class="form-control" name="dob" value="<?=$edit['TTL']?>" required>
        			</div>
        			<div class="form-group">
        				<label>Gender</label>
        				<select class="form-control" name="sex" required>
        					<option value="Pria" <?php if ($edit['JK']=="Pria"){echo "selected";}?>>Pria</option>
        					<option value="Wanita" <?php if ($edit['JK']=="Wanita"){echo "selected";}?>>Wanita</option>
        				</select>
        			</div>
        			<div class="form-group">
        				<label>Agama</label>
        				<input type="text" class="form-control" name="agama" value="<?=$edit['Agama']?>" required>
        			</div>
        			<div class="form-group">
        				<label>Nomor Telpon</label>
        				<input type="tel" class="form-control" name="tel" value="<?=$edit['Telp']?>" required>
        			</div>
        			<div class="form-group">
        				<label>Nomor Induk Kependudukan (NIK)</label>
        				<input type="text" class="form-control" name="NIK" value="<?=$edit['NIK']?>" required>
        			</div>
        			<div class="form-group">
        				<label>Nomor Rekening</label>
        				<input type="text" class="form-control" name="noREK" value="<?=$edit['Nomor_REK']?>" required>
        			</div>
        			<br>
        			<div class="form-group">
        				<button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-save"></i>Simpan Data</button>
        			</div>
            	</form>
            </div>			
        </div>
	</div>

	<?php
		break;
	case 'delete':
	$id = $_GET['id'];
    $sql = "DELETE from warga where Nomor_KK='$id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
      echo "<script>alert('Data berhasil dihapus!');window.location.href='?page=warga'</script>";
    } else {
      echo mysqli_error($conn);
    }
		break;
	case 'tambah':
	if (isset($_POST['simpan'])) {
		$noKK=$_POST['noKK'];
		$noSK=$_POST['noSK'];
		$nama=$_POST['nama'];
		$dob=$_POST['dob'];
        $pob=$_POST['pob'];
		$JK=$_POST['sex'];
		$agama=$_POST['agama'];
		$tel=$_POST['tel'];
		$NIK=$_POST['NIK'];
		$noREK=$_POST['noREK'];
		$cek=mysqli_query($conn,"SELECT * from warga where Nomor_KK='$noKK'");
		if (mysqli_num_rows($cek)>0) {
			echo "<script>alert('Data sudah tersedia! proses penyimpanan dibatalkan')</script>";
		}else{
			$insert=mysqli_query($conn,"INSERT INTO warga VALUES ('$noKK','$noSK','$nama','$pob','$dob','$JK','$agama','$tel','$NIK','$noREK')");
			if ($insert) {
                $userwarga=mysqli_query($conn,"INSERT INTO user VALUES ('$noKK','12345678','warga',null)");
				echo "<script>alert('Data berhasil disimpan');window.location.href='admin.php?page=warga'</script>";
			}else{
				echo "<script>alert('Penambahan data gagal!');window.location.href='admin.php?page=warga&act=tambah'</script>";
			}
		}
	}
	?>
	<div class="container">
		<div class="col-8 mx-auto">
            <div class="shadow p-3 mb-5 bg-white rounded">
            	<h3>Form Penambahan Warga Rusunawa</h3>
            	<hr>
            	<form method="POST">
        			<div class="form-group">
        				<label>Nomor Kartu Keluarga (KK)</label>
        				<input type="text" class="form-control" name="noKK" required>
        			</div>
        			<div class="form-group">
        				<label>Nomor Surat Perjanjian (SP)</label>
        				<input type="text" class="form-control" name="noSK" required>
        			</div>
        			<div class="form-group">
        				<label>Nama Kepala Keluarga</label>
        				<input type="text" class="form-control" name="nama" required>
        			</div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" name="pob" required>
                    </div>
        			<div class="form-group">
        				<label>Tanggal Lahir</label>
        				<input type="date" class="form-control" name="dob" required>
        			</div>
        			<div class="form-group">
        				<label>Gender</label>
        				<select class="form-control" name="sex" required>
        					<option value="Pria" selected>Pria</option>
        					<option value="Wanita">Wanita</option>
        				</select>
        			</div>
        			<div class="form-group">
        				<label>Agama</label>
        				<input type="text" class="form-control" name="agama" required>
        			</div>
        			<div class="form-group">
        				<label>Nomor Telpon</label>
        				<input type="tel" class="form-control" name="tel" required>
        			</div>
        			<div class="form-group">
        				<label>Nomor Induk Kependudukan (NIK)</label>
        				<input type="text" class="form-control" name="NIK" required>
        			</div>
        			<div class="form-group">
        				<label>Nomor Rekening</label>
        				<input type="text" class="form-control" name="noREK" required>
        			</div>
        			<br>
        			<div class="form-group">
        				<button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-save"></i>Simpan Data</button>
        			</div>
            	</form>
            </div>			
        </div>
	</div>
<?php break;
	
	default:
?>
    <div class="container">
        <div class="col-12 mx-auto">
        	<h3 class="text-center">
                <span class="float-left"><button class="btn btn-info" onclick="javascript:window.print()"><i class="fa fa-print"></i> Print</button></span> 

                <i class="fa fa-user"></i> Data Warga Rusunawa Jatinegara 

                <span class="float-right no-print"><a href="admin.php?page=warga&act=tambah" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data Warga</a></span>
            </h3>
            <h3 class="no-print"></h3>
        </div>
    <br>
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="table-responsive-lg">
                    <table class="table table-hover table-striped text-center shadow p-3 mb-5 bg-white rounded">
                        <thead class="bg-info text-light">
                            <tr>
                                <th scope="col">No. KK</th>
                                <th scope="col">No. SP</th>
                                <th scope="col">Nama</th>
                                <th scope="col">TTL</th>
                                <th scope="col">Telp</th>
                                <th scope="col">No. Rek</th>
                                <th scope="col" class="no-print"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row=mysqli_fetch_array($warga)) {
                                if ($row['Nomor_KK']!="") {
                                    $ttl=$row['Nomor_KK'].", ";
                                }else{
                                    $ttl=", ";
                                }
                                ?>
                            	<tr></tr>
                            	<td><?=$row['Nomor_KK']?></td>
                            	<td><?=$row['No_SP']?></td>
                            	<td><?=$row['Nama']?></td>
                            	<td><?=$row['TTL']?></td>
                            	<td><?=$row['Telp']?></td>
                            	<td><?=$row['Nomor_REK']?></td>
                            	<td class="no-print">
                            	<a id="edit" href="?page=warga&act=edit&id=<?=$row['Nomor_KK']?>">Ubah</a>
                            	<a id="delete" href="?page=warga&act=delete&id=<?=$row['Nomor_KK']?>" onclick="return confirm('Hapus data <?=$row['Nomor_KK']?> atas nama <?=$row['Nama']?>?')">Hapus</a>
                            	</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">

        </div>

        </div>
    <br><br><br>
    <?php
		break;
	}//end warga
}elseif($_GET['page']=='unit'){

$act=$_GET['act'];
switch ($act) {
	case 'edit':
	if (isset($_POST['simpan'])) {
		$nomor=$_POST['nomor'];
		$blok=$_POST['blok'];
		$id=$_POST['id'];
        $harga=$_POST['harga'];
		$lantaisebenarnya=$_POST['lantai'];
		$lantai=$_POST['lantai']*100;
		$num=$lantai+$nomor;
		$kode=$blok.$num;//saved format e.g. A101
		$info=$_POST['info'];
		$update=mysqli_query($conn,"UPDATE unit SET
			Kode_unit='$kode',
			No_unit='$nomor',
			Lantai='$lantaisebenarnya',
			Blok='$blok',
			info='$info',
            harga='$harga'
			where Kode_unit='$id'
			");
		if ($update) {
			echo "<script>alert('Data berhasil diubah');window.location.href='admin.php?page=unit'</script>";
		}else{
			echo "<script>alert('Pengubahan data gagal!');window.location.href='admin.php?page=unit&act=edit&id=$id'</script>";
		}
	}
	$edit=mysqli_fetch_array(mysqli_query($conn,"SELECT * from unit where Kode_unit='$id'"));
	?>

	<div class="container">
		<div class="col-6 mx-auto">
            <div class="shadow p-3 mb-5 bg-white rounded">
            	<h3>Form Penambahan Unit Rusunawa</h3>
            	<hr>
            	<form method="POST">
        			<div class="form-group">
        				<label>Kode Unit</label>
        				<input type="text" class="form-control" value="<?=$edit['Kode_unit']?>" name="id" readonly>
        			</div>
        			<div class="form-group">
        				<label>Nomor Unit</label>
        				<input type="text" class="form-control" value="<?=$edit['No_unit']?>" name="nomor" required>
        			</div>
        			<div class="form-group">
        				<label>Lantai</label>
        				<input type="number" class="form-control" value="<?=$edit['Lantai']?>" name="lantai" required>
        			</div>
        			<div class="form-group">
                        <label>Blok</label>
                        <input type="text" class="form-control" value="<?=$edit['Blok']?>" name="blok" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Unit</label>
                        <input type="text" class="form-control" value="<?=$edit['harga']?>" name="harga" required>
                    </div>
        			<div class="form-group">
        				<label>Deskripsi</label>
        				<textarea name="info" class="form-control" required><?=$edit['info']?></textarea>
        			</div>
        			<div class="form-group">
        				<button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-save"></i>Simpan Data</button>
        			</div>
            	</form>
            </div>			
        </div>
	</div>
	<?php
		break;
	case 'delete':
	$id = $_GET['id'];
    $sql = "DELETE from unit where Kode_unit='$id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
      echo "<script>alert('Data berhasil dihapus!');window.location.href='?page=unit'</script>";
    } else {
      echo mysqli_error($conn);
    }
		break;
	case 'tambah':
	if (isset($_POST['simpan'])) {
		$nomor=$_POST['nomor'];
		$blok=$_POST['blok'];
		$id=$_POST['id'];
        $harga=$_POST['harga'];
		$lantaisebenarnya=$_POST['lantai'];
		$lantai=$_POST['lantai']*100;
		$num=$lantai+$nomor;
		$kode=$blok.$num;//saved format e.g. A101
		$info=$_POST['info'];
		$cek=mysqli_query($conn,"SELECT * from unit where Kode_unit='$kode'");
		if (mysqli_num_rows($cek)>0) {
			echo "<script>alert('Unit sudah tersedia! proses penyimpanan dibatalkan')</script>";
		}else{
			$insert=mysqli_query($conn,"INSERT INTO unit VALUES ('$kode','$nomor','$lantaisebenarnya','$blok','$info','$harga')");
			if ($insert) {
				echo "<script>alert('Unit berhasil disimpan');window.location.href='admin.php?page=unit'</script>";
			}else{
				echo "<script>alert('Penambahan unit gagal!');window.location.href='admin.php?page=unit&act=tambah'</script>";
			}
		}
	}
	?>
	<div class="container">
		<div class="col-6 mx-auto">
            <div class="shadow p-3 mb-5 bg-white rounded">
            	<h3>Form Penambahan Unit Rusunawa</h3>
            	<hr>
            	<form method="POST">
                    <div class="form-group">
                        <label>Blok</label>
                        <input type="text" class="form-control" name="blok" required>
                    </div>
                    <div class="form-group">
                        <label>Lantai</label>
                        <input type="number" class="form-control" name="lantai" required>
                    </div>
        			<div class="form-group">
        				<label>Nomor Unit</label>
        				<input type="number" class="form-control" name="nomor" required>
        			</div>
                    <div class="form-group">
                        <label>Harga Unit</label>
                        <input type="text" class="form-control" min="1000" name="harga" required>
                    </div>
        			<div class="form-group">
        				<label>Deskripsi</label>
        				<textarea name="info" class="form-control" required></textarea>
        			</div>
        			<div class="form-group">
        				<button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-save"></i>Simpan Data</button>
        			</div>
            	</form>
            </div>			
        </div>
	</div>
<?php break;
	default:
?>
    <div class="container">
        <div class="col-12 mx-auto">
        	<h3 class="text-center">
                <span class="float-left"><button class="btn btn-info" onclick="javascript:window.print()"><i class="fa fa-print"></i> Print</button></span> 
                <i class="fa fa-building"></i> Data Unit Rusunawa Jatinegara <span class="float-right no-print"><a href="admin.php?page=unit&act=tambah" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Unit</a></span>
            </h3>
        </div>
    <br>
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="table-responsive-lg">
                    <table class="table table-hover table-striped text-center shadow p-3 mb-5 bg-white rounded">
                        <thead class="bg-info text-light">
                            <tr>
                                <th scope="col">Kode Unit</th>
                                <th scope="col">Blok</th>
                                <th scope="col">Lantai</th>
                                <th scope="col">Nomor Unit</th>
                                <th scope="col">Info</th>
                                <th scope="col">Harga Sewa</th>
                                <th scope="col" class="no-print"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row=mysqli_fetch_array($unit)) {?>
                            	<tr>
                            	<td><?=$row['Kode_unit']?></td>
                                <td><?=$row['Blok']?></td>
                                <td><?=$row['Lantai']?></td>
                            	<td><?=$row['No_unit']?></td>
                            	<td><?=$row['info']?></td>
                                <td>Rp. <?=number_format($row['harga'])?></td>
                            	<td class="no-print">
                            	<a id="edit" href="?page=unit&act=edit&id=<?=$row['Kode_unit']?>">Ubah</a>
                            	<a id="delete" href="?page=unit&act=delete&id=<?=$row['Kode_unit']?>" onclick="return confirm('Hapus unit <?=$row['Kode_unit']?>?')">Hapus</a>
                            	</td>
                            	</tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">

        </div>

        </div>
    <br><br><br>
    <?php
		break;
	}
}	//end unit
elseif ($_GET["page"]=="hunian") {
    switch ($_GET["act"]) {
        case 'kosong':
                $delete=mysqli_query($conn,"DELETE from penghuni where id_unit='$_GET[unit]' ");
                if ($delete) {
                    echo "<script>alert(' Unit $_GET[unit] telah dikosongkan ! ');window.location.href='?page=hunian'</script>";
                }else{
                    echo "<script>alert('Pengosongan unit gagal!')</script></script>";
                }
            break;
        case 'edit':
            if (isset($_POST["simpan"])) {
                $unit=$_GET["unit"];
                $KK=$_POST["KK"];
                //$tgl=$_POST["tgl"];
                $cek=mysqli_query($conn,"SELECT * from penghuni where id_unit='$unit'");
                $war=mysqli_query($conn,"SELECT * from warga where Nomor_KK='$KK'");
                $w=mysqli_fetch_array($war);
                if (mysqli_num_rows($cek)>0) {
                    $change=mysqli_query($conn,"UPDATE penghuni set id_warga='$KK', No_SP='$w[No_SP]' where id_unit='$unit'");
                }else{
                    $input=mysqli_query($conn,"INSERT INTO penghuni (id_warga,id_unit,No_SP) VALUES ('$KK','$unit','$w[No_SP]')");
                }
                if ($change or $input) {
                    echo "<script>alert('Data berhasil diubah!');window.location.href='?page=hunian'</script>";
                }else{
                    echo "<script>alert('Perubahan gagal!')</script></script>";
                }
            }
            //$warga=mysqli_query($conn,"SELECT * from warga where Nomor_KK NOT IN (select id_warga from penghuni) order by Nama");
            $warga=mysqli_query($conn,"SELECT * from warga order by Nama");
            $sql=mysqli_query($conn,"SELECT * from penghuni where id_unit='".$_GET['unit']."'");
            $huni=mysqli_fetch_array($sql);
            if (mysqli_num_rows($sql)>0) {
                $selected="selected";
                $btn='<span class="float-right"><a class="btn btn-danger" href="?page=hunian&act=kosong&unit='.$_GET['unit'].'">Kosongkan '.$_GET['unit'].'</a></span>';
                
            }else{
                $selected="";
                $btn="";
                $warga=mysqli_query($conn,"SELECT * from warga where Nomor_KK NOT IN (select id_warga from penghuni) order by Nama");
            }
            ?>
            <div class="container">
                <div class="col-8 mx-auto">
                    <h3>Form Penempatan Hunian Unit <?=$_GET['unit']?> <?= $btn ?></h3>
                </div>
                <br>
                <div class="row">
                    <div class="col-6 mx-auto shadow">
                        <form method="POST">
                            <div class="form-group">
                                <label>Nama Warga</label>
                                <select class="custom-select" name="KK" id="KK" required>
                                    <option disabled selected>-- Daftar Warga --</option>
                                    <?php while ($option=mysqli_fetch_array($warga)) {?>
                                        <option value="<?=$option['Nomor_KK']?>" 
                    <?php if ($huni['id_warga']==$option['Nomor_KK']){ echo $selected; } ?>
                                            ><?=$option['Nomor_KK']?> | <?=$option['Nama']?> | <?=$option['No_SP']?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- <div class="form-group"> -->
                                <!-- <label>Nomor SP</label>
                                <select name="tgl" id="SP" class="custom-select" disabled>
                                    <?php while ($label=mysqli_fetch_array($warga)) {?>
                                        <option data-chained="<?=$option['Nomor_KK']?>" value="<?=$option['No_SP']?>"><?=$option['No_SP']?></option>
                                    <?php } ?>
                                </select>
 -->                                <!-- <input type="date" class="form-control" name="tgl" <?php //if (isset($huni['tgl_masuk'])){ echo "value='".$huni['tgl_masuk']."'";}?> required> -->
                            <!-- </div> -->
                            <div class="form-group">
                                <button type="submit" name="simpan" class="btn btn-success">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                //$("#SP").chained("#KK");
            </script>
            <?php
            break;
        
        default:
            ?>
            <div class="container">
        <div class="col-12 mx-auto">
            <h3><i class="fa fa-home"></i> Data Penempatan Hunian</h3>
        </div>
        <br>
        <div class="row">
            <div class="col-12 mx-auto">
                
                <div class="table-responsive-lg">
                    <table class="table table-hover table-striped text-center shadow p-3 mb-5 bg-white rounded">
                        <thead class="bg-info text-light">
                            <tr>
                                <th scope="col">Nomor Unit</th>
                                <th scope="col">Penghuni</th>
                                <th scope="col">Nomor SP</th>
                                <th scope="col" class="no-print"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while ($row=mysqli_fetch_array($unit)) {
                                    $un=mysqli_query($conn,"SELECT * from penghuni where id_unit='".$row['Kode_unit']."'");
                                        if (mysqli_num_rows($un) > 0) {
                                            $unitin=mysqli_fetch_array($un);
                                            $warga=mysqli_fetch_array(mysqli_query($conn,"SELECT * from warga where Nomor_KK='".$unitin['id_warga']."'"));

                                            $nama=$warga['Nama'];
                                            $KK=$warga['Nomor_KK'];
                                            $label='<p><strong>'.$nama.'</strong><br><small>'.$KK.'</small></p>';
                                            $masuk=$unitin['No_SP'];
                                        }else{
                                            $label='<span class="badge badge-info">Kosong</span>';
                                            $masuk='<span class="badge badge-success">Tersedia</span>';
                                        }
                                    ?>
                                <tr>
                                    <td><?= $row['Kode_unit'] ?></td>
                                    <td><?= $label ?></td>
                                    <td><?= $masuk ?></td>
                                    <td class="no-print">
                                        <a id="edit" href="?page=hunian&act=edit&unit=<?=$row[Kode_unit]?>">Ubah</a>
                                    </td>
                                </tr>

                        <?php } ?>
                        </tbody>
                    </table>  
                </div>
            </div>
        </div>
    </div>
            <?php
            break;
    }
    ?>
    
<?php
}
else{//dashboard?>
<div class="container">
		<div class="col-8 mx-auto">
            <div class="shadow p-3 mb-5 bg-white rounded">
            	<div class="row" style="margin:5px;">
            		<div class="col-6 col-warga ">
            			<div class="form-group">
            				<label>Jumlah Keluarga</label>
            				<h3 class="pull-right"><?=mysqli_num_rows($warga)?></h3>
            			</div>
            		</div>
            		<div class="col-6 col-unit">
            			<div class="form-group">
            				<label>Jumlah Unit</label>
            				<h3  class="pull-right"><?=mysqli_num_rows($unit)?></h3>
            			</div>
            		</div>
            	</div>
	        </div>
	    </div>
<?php } ?>
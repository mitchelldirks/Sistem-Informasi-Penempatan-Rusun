<?php
include 'koneksi.php';
$_SESSION['pass']='';
if (isset($_GET['gagal'])) {
    ?>
    <style>
        input[type=password] {
            border: 1px solid #ff0000;
        }
    </style>

    <?php
}

$user=mysqli_fetch_array(mysqli_query($conn,"SELECT * from user where username='".$_SESSION['username']."'"));
$_SESSION['pass']=$user['password'];
if (isset($_POST['simpan'])) {
	if ($_POST['old']==$_SESSION['pass']) {
		if ($_POST['Password']==$_POST['CPassword']) {
			$update=mysqli_query($conn,"UPDATE user set password='".$_POST['Password']."' where username='".$_SESSION['username']."'");
			 $_SESSION['success']=1;
			 echo "<script>alert('Password Berhasil diubah');</script>";
		}else{
			 echo "<script>alert('Password Baru Tidak Cocok');</script>";
		}
	}else{
		echo "<script>alert('Password Lama Salah');</script>";
	}
}else{

}
include 'nav.php';
?>
<div class="container">
    <div class="col-10 mx-auto shadow">
    	
    	<div class="box-title">
    		<?php if ($_SESSION['success']==1){ ?>
    		<span class="alert alert-success float-right">Password Telah Diubah</span>
    	<?php }
		$_SESSION['success']--;
    	 ?>
    		<h3>Form Ubah Password</h3>

    	</div>
    	<div class="box-body">
    		<form method="POST">
    			<div class="form-group">
                    <label>Password Lama</label>
                    <input type="Password" class="form-control" name="old"  required>
                </div>
    			<div class="form-group">
                    <label>Password Baru</label>
                    <input type="Password" class="form-control" name="Password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="Password" class="form-control" name="CPassword" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info" name="simpan">Save</button>
                </div>
                <br>
    		</form>
    	</div>
    </div>
</div>
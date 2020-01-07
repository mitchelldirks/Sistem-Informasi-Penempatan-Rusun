<style type="text/css">
	.col-unit{
		padding: 20px;
		border-radius: 10px;
		border-bottom: 4px solid cyan;
	}
	.col-unit:hover{
		background-color: #eee;
		color: #333;
	}

</style>
<?php
include 'koneksi.php';
include 'nav.php';
if ($_GET['page']=='info') {
switch ($_GET['act']) {
	case 'value':
			# code...
		break;
	default: ?>
	<div class="container">
        <div class="col-8 mx-auto">
            <h3 class="text-left">Data User a/n <?=$usr?></h3>
        </div>
    <br>
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="table-responsive-lg">
                    <table class="table table-hover table-striped text-center shadow p-3 mb-5 bg-white rounded">
                       
                        <tbody>
                        	<?php 
                        	//16/-1/MtchllGntg
                        	$uniti=mysqli_query($conn,"SELECT * from penghuni where No_SP='".$userin["No_SP"]."'");

                        	$unit=mysqli_fetch_array($uniti);
                        	if (mysqli_num_rows($uniti)>0) {
                        		?>
                        	<tr class="bg-info text-light">
                        		<th colspan="2">Detail Hunian</th>
                        	</tr>
                        	<tr>
                        		<td>Nomor SP</td><td><?=$unit['No_SP']?></td>
                        	</tr>
                        	<tr>
                        		<td>Unit</td><td><?=$unit['id_unit']?></td>
                        	</tr>
                        	<?php $hargain=mysqli_fetch_array(mysqli_query($conn,"SELECT * from unit where Kode_unit='".$unit['id_unit']."'")); ?>
                        	<tr>
                        		<td>Harga Sewa</td><td>Rp. <?=number_format($hargain['harga'])?></td>
                        	</tr>

                        <?php
                        	} ?>
                        	<tr class="bg-info text-light">
                        		<th colspan="2">Detail Informasi</th>
                        	</tr>
                        	<tr>
                        		<td>NIK</td><td><?=$userin['NIK']?></td>
                        	</tr>
                        	<tr>
                        		<td>Nama Warga</td><td ><?=$userin['Nama']?></td>
                        	</tr>
                        	<tr>
                        		<td>TTL</td><td><?=$userin['TempatLahir']?>, <?php 
                        		$date=date_create($userin['TTL']);
                        		echo date_format($date,'d F Y');?></td>
                        	</tr>
                        	<tr>
                        		<td>Jenis Kelamin</td><td><?=$userin['JK']?></td>
                        	</tr>
                        	<tr>
                        		<td>Telp</td><td><?=$userin['Telp']?></td>
                        	</tr>
                        	<tr>
                        		<td>Nomor Rekening</td><td><?=$userin['Nomor_REK']?></td>
                        	</tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
		break;
	}
}else{?>
<div class="container">
	<div class="col-7 mx-auto">
        <div class="shadow p-3 mb-5 bg-white rounded">
            	<div class="row" style="margin:5px;">
            		<div class="col-12 col-unit ">
            			<div class="form-group">
            				<?php
            	$uniti=mysqli_query($conn,"SELECT * from penghuni where No_SP='".$userin["No_SP"]."'");
                $unit=mysqli_fetch_array($uniti);
                $hargain=mysqli_fetch_array(mysqli_query($conn,"SELECT * from unit where Kode_unit='".$unit['id_unit']."'"));
            				?>
            				<h3><strong><?=$usr?></strong><br><small><?=$userin['Nomor_KK']?><br></span></small></h3>
            				<h4 class="text-left"><small><span class="pull-left"><?=$unit['No_SP']?><br>Unit <?=$unit['id_unit']?> </span></small><span class="pull-right">Sewa Perbulan <br><strong> Rp. <?=$hargain['harga']?></strong></span></h4>
            			</div>
            		</div>
            	</div>
	        </div>
    </div>
</div>
<?php } ?>
	

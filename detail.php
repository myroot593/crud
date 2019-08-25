<?php
/*
ROOT93.co.id | COMPUTER | NETWORKING | WEB PROGRAMMING
*/
include ('koneksi.php');
include ('function.php');
?>
<html>
<head>
	<title>DETAIL DATA ROOT93</title>
</head>
<body>

<?php
if(!empty($_GET['id'])){

	if(!detail_data_2(trim($_GET['id']))){
		
		die ("Data tidak ditemukan");
	}


}else{


		die("error");
	
}
mysqli_close($koneksi);


?>
<table border="1" width="500">
<tr>
	<th>ID</th>
	<th>NAMA MAHASISWA</th>
	<th>NIM</th>
	<th>TANGGAL DAFTAR</th>
</tr>
<tr>
	<td><?php echo $id;?></td>
	<td><?php echo $nama_mahasiswa;?></td>
	<td><?php echo $nim; ?></td>
	<td><?php echo $tanggal_daftar;?></td>
</tr>
<a href="javascript:history.back()">Kembali</a>
<?php 
$array=array(0=>"$id",'id'=>"$id");
print json_encode($array);


?>
</form>
</body>
</html>

<?php
include ('koneksi.php');
include ('function.php');
?>
<html>
<head>
	<title>DELETE DATA ROOT93</title>
</head>
<body>

<?php
if(isset($_POST['id']) && !empty($_POST['id'])){
	//panggil function delete data
	if(delete_data(trim($_POST['id']))){
		echo "data berhasil dihapus";
		echo "<a href='tampil_data.php'>Tampil data</a>";
	}else{
		echo "Gagal mendelete data";
	}
//close koneksi

mysqli_close($koneksi);


}else{

	if(empty(trim($_GET["id"]))){
		header("location:error");
	}
}


?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
<input type="hidden" name="id" value="<?php echo trim($_GET['id']); ?>" />
<p> Yakin ingin menghapus data ?</p>
<input type="submit" value="Ya">
<a href="javascript:history.back()">Kembali</a>
</form>
</body>
</html>

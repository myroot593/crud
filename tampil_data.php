<?php
include ('koneksi.php');
include ('function.php');
?>
<html>
<head>
	<title>Menampilkan data root93.co.id</title>
</head>
<body>

<?php
//memanggi function
$result = tampil_data();
		//mengeksekusi function didalam percabangan
		if($result){
		//jika data di tabel lebih besar dari 0 atau memiliki data maka eksekusi perulangan	atau looping
		if(mysqli_num_rows($result)>0){
		echo "<table border='1' width='500'>";
		echo "<tr>";
		echo "<th>ID</th>";
		echo "<th>NIM</th>";
		echo "<th>NAMA MAHASISWA</th>";
		echo "<th>FOTO</th>";
		echo "<th>AKSI</th>";
		echo "</tr>";
		//loping data
		while($row=mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>".$row['id']."</td>";
		echo "<td>".$row['nim']."</td>";
		echo "<td>".$row['nama_mahasiswa']."</td>";

		if(empty($row['foto_mahasiswa'])){
			echo "<td><img height='100px' width='80px' src='default_foto.jpg' /></td>";
		}else{
			echo "<td><img height='100px' width='80px' src='foto/".$row['foto_mahasiswa']."' /></td>";

		}	
		
		echo "<td>";
		echo "<a href='delete.php?id=".$row['id']." 'title = 'delete'>DELETE</a>";
		echo " | ";
		echo "<a href='detail.php?id=".$row['id']." 'title= detail'>DETAIL</a>";
		echo " | ";
		echo "<a href='update.php?id=".$row['id']." 'title= update'>UPDATE</a>";
		echo "</td>";

		echo "</tr>";
	}
		echo "</table>";
		echo "<a href='input.php'>Input data</a>";
		//free result
		mysqli_free_result($result);
	
	//namun jika tidak lebih besar dari pada > 0 atau tidak ditemukan data maka jalan perintah berikut
}else{
	echo "Data masih kosong";
}
//percabangan result ketika function tidak bisa mengeksekusi perintah
}else{
 echo "Terjadi kesalahan. Coba lagi nanti".mysqli_error($koneksi);
}
//close koneksi 
mysqli_close($koneksi);
?>

</body>
</html>

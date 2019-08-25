<?php
/*
ROOT93.co.id | COMPUTER | NETWORKING | WEB PROGRAMMING
*/
include ('koneksi.php');
include ('function.php');
?>

<?php

if(!empty($_GET['id'])){

	if(!detail_data_2(trim($_GET['id']))){		
		die ("Data tidak ditemukan");
	}
	}else{
	die("error");	
}

?>

<?php
//set variabel
$id_err = $nim_err = $nama_mahasiswa_err = $foto_mahasiswa_err = "";
//jika ada request post maka jalankan percabangan
if($_SERVER["REQUEST_METHOD"]=="POST"){
	if(empty($_POST['id'])){
		$id_err="id masih ksong";
	}else{
		$var_id=$_POST['id'];
		$var_id=mysqli_real_escape_string($koneksi, $var_id);
	}
	if(empty(trim($_POST['nim']))){
        $nim_err = "Nim tidak boleh kosong";
    }else{
        $nim=$_POST['nim'];
        $nim=mysqli_real_escape_string($koneksi, $nim);
    }
    
    if(empty(trim($_POST['nama_mahasiswa']))){
        $nama_mahasiswa_err = "Nama mahasiswa tidak boleh kosong";
    }else{
        $nama_mahasiswa = $_POST['nama_mahasiswa'];
        $nama_mahasiswa = mysqli_real_escape_string($koneksi, $nama_mahasiswa);
    }
    //set kondisi
    if (empty($_FILES["foto_mahasiswa"]["tmp_name"])){
    
        /*panggil fungsi detail data untuk memberikan nilai variabel pada nilai item foto, jika nilai variabel tidak ditemukan, maka nilai item pada variabel item_foto akan kosong, sebaliknya jika nilai item berisi variabel, maka variabel tersebut akan berisi nilai nama foto sebelumnya
        */
        //memanggil fungsi detail img, fungsi ini tersendiri agar data tidak bentrok
        if(detail_data_img(trim($_POST['id']))){             
        $item_foto=$foto_mahasiswa;
		}	
        
        }else{
            //ketika user mengsisi file upload
            $imgFile = $_FILES['foto_mahasiswa']['name'];
            $tmp_dir = $_FILES['foto_mahasiswa']['tmp_name'];
            $imgSize = $_FILES['foto_mahasiswa']['size'];
            $upload_dir = 'foto/';
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); 
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
            $item_foto = rand(1000,1000000).".".$imgExt;
            if(in_array($imgExt, $valid_extensions)){           
            if($imgSize > 400000){
            $foto_mahasiswa_err="Foto terlalu besar.Max 400KB";
       
            }else{
             $foto_mahasiswa=$tmp_dir;    
            } 
            }else{
            $foto_mahasiswa_err="Ektensi Foto siswa tidak sesuai ketentuan upload, format JPEG, PNG";
                
            }     
}
if(empty($id_err) && empty($nim_err) && empty($nama_mahasiswa_err) && empty($foto_mahasiswa_err)){
	if(update_mahasiswa($var_id, $nim, $nama_mahasiswa, $foto_mahasiswa)){
		echo "Data berhasil di update";
		echo "<meta http-equiv=\"refresh\"content=\"2;URL=tampil_data.php\"/>";
	}else{
		die("Gagal update");
	}
}

}

?>
<html>
<head>
<title>UPDATE DATA ROOT93</title>
</head>
<body>

<table border="1" width="500">
	<tr>

	<th>NAMA MAHASISWA</th>
	<th>NIM</th>
	<th>FOTO</th>

	</tr>
	<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>" method="POST" enctype="multipart/form-data"/ >
	<tr>	
	<td><input type="text" name="nama_mahasiswa" value="<?php echo $nama_mahasiswa;?>"></td>
	<td><input type="text" name="nim" value="<?php echo $nim;?>">
	<input type="hidden" name="id" value="<?php echo $id;?>"></td>
	<td><input type="file" name="foto_mahasiswa" /><br/>
		<label>Foto saat ini :</label>
	<img src="foto/<?php echo $foto_mahasiswa;?>" width="80" height="78"/></td>
	</tr>
	<tr>
		<td colspan="3"><input type="submit" name="kirim" value="Update" />
		<a href="javascript:history.back()">Kembali</a></td>
	</tr>
	</form>
</table>

<?php echo $id_err; ?>
<?php echo $nim_err; ?>
<?php echo $nama_mahasiswa_err; ?>
<?php echo $foto_mahasiswa_err; ?>
</body>
</html>

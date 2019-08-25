<?php
include ('koneksi.php');
include ('function.php');
?>
<?php
//set variabel
$nim = $nama_mahasiswa = $foto_mahasiswa = "";
$nim_err = $nama_mahasiswa_err = $foto_mahasiswa_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
    if (empty($_FILES["foto_mahasiswa"]["tmp_name"])){
            //ketika kondisi data kosong                             
           $item_foto = '';             
                 
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
//cek input sebelum insert untuk memastikan tidak ada data yang error
    if(empty($nim_err) && empty($nama_mahasiswa_err) && empty($foto_mahasiswa_err)){

    /* Panggil function */
        if(simpan_mahasiswa($nim, $nama_mahasiswa, $foto_mahasiswa)){
            echo 'Berhasil menyimpan data';
            echo "<a href='tampil_data.php'>Tampil data</a>";
        }else{
            echo 'Gagal menyimpan data';
        }
      
}
  mysqli_close($koneksi);
  //close koneksi

    //end POST  
    }


?>

<html>
<head>
    <title>Input Mahasiswa root93</title>
</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" />
<label>Nim :</label>
<input type="text" name="nim" size="15" />
<label>Nama Mahasiswa :</label>
<input type="text" name="nama_mahasiswa" size="15" />
<label>Foto</label>
<input type="file" name="foto_mahasiswa" id="foto_mahasiswa" />
<input type="Submit" name="submit" value="Submit">
</form>
<?php echo $nim_err; ?>
<?php echo $nama_mahasiswa_err; ?>
<?php echo $foto_mahasiswa_err; ?>
</body>
</html>

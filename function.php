<?php
function prepare($data){
	global $koneksi;
	$perintah=mysqli_prepare($koneksi,$data);
	if(!$perintah) die("Gagal melakukan koneksi".mysqli_error($koneksi));
	return $perintah;
}
function query($data){
	global $koneksi;
	$perintah=mysqli_query($koneksi, $data);
	if(!$perintah) die("Gagal melakukan koneksi".mysqli_error($koneksi));
	return $perintah;
}
function execute($data){
	$perintah=mysqli_stmt_execute($data);
	return $data;
}
function stmt_close($data){
	$perintah=mysqli_stmt_close($data);
	return $data;
}

function simpan_mahasiswa($nim, $nama_mahasiswa, $foto_mahasiswa){
    global $upload_dir;
    global $item_foto;
    $sql="INSERT INTO datamhs(nim, nama_mahasiswa, foto_mahasiswa) VALUES (?,?,?)";
    if($stmt=prepare($sql)){
        mysqli_stmt_bind_param($stmt,"sss",$param_nim, $param_nama_mahasiswa, $param_foto_mahasiswa);
        $param_nim = $nim;
        $param_nama_mahasiswa = $nama_mahasiswa;
        $param_foto_mahasiswa = $item_foto;
    //cek apakah nilai var kosong atau tidak, jika kosong eksekusi tanpa move
        if (empty($_FILES["foto_mahasiswa"]["tmp_name"])){
    	if(execute($stmt)){
		    return true;
			}else{
		    return false;
			}
    }else{  
		if(execute($stmt)&&(move_uploaded_file($foto_mahasiswa, $upload_dir.$item_foto))){
	    return true;
		}else{
	    return false;
		}
	}
	
	}
	//Close statement
	stmt_close($koneksi);
	//End function
}

function tampil_data(){
	$sql="SELECT id, nim, nama_mahasiswa, foto_mahasiswa, tanggal_daftar FROM datamhs";
	$result=query($sql);
	return $result;
}


function delete_data($var_id){
	global $koneksi;
	$sql = "DELETE FROM datamhs where id =?";
	if($stmt=mysqli_prepare($koneksi, $sql)){
		mysqli_stmt_bind_param($stmt,"i", $param_id);
		$param_id = $var_id;
		
		if(mysqli_stmt_execute($stmt)){
			return true;
		}else{
			return false;
		}
	}
	
	mysqli_stmt_close($stmt);
}

function detail_data($var_id){
	global $koneksi;
	global $result;
	$sql="SELECT id, nim, nama_mahasiswa, foto_mahasiswa,  tanggal_daftar FROM datamhs WHERE id=?";
	if($stmt=mysqli_prepare($koneksi, $sql)){
		mysqli_stmt_bind_param($stmt,"i",$param_id);
		$param_id = $var_id;
		if(mysqli_stmt_execute($stmt)){
			//get result bisa diganti jadi store result
			$result=mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result)==1){
				return true; //jika ada data nilai true
			}else{
				return false; //jika data tidak ditemukan nilai false
			}
		}else{
			echo "Terjadi kesalahan";
		}
	}
	mysqli_stmt_close($stmt);
}
function detail_data_2($var_id){
	global $koneksi;
	global $id, $nim, $nama_mahasiswa, $foto_mahasiswa, $tanggal_daftar;
	$sql="SELECT id, nim, nama_mahasiswa, foto_mahasiswa,  tanggal_daftar FROM datamhs WHERE id=?";
	if($stmt=mysqli_prepare($koneksi, $sql)){
		mysqli_stmt_bind_param($stmt,"i",$param_id);
		$param_id = $var_id;
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			mysqli_stmt_bind_result($stmt, $id, $nim, $nama_mahasiswa, $foto_mahasiswa, $tanggal_daftar);
			mysqli_stmt_fetch($stmt);			
			
			if(mysqli_stmt_num_rows($stmt)==1){
				return true; //jika ada data nilai true
			}else{
				return false; //jika data tidak ditemukan nilai false
			}
		}else{
			echo "Terjadi kesalahan";
		}
	}
	mysqli_stmt_close($stmt);
}


function update_mahasiswa($var_id, $nim, $nama_mahasiswa, $foto_mahasiswa){
	global $koneksi;
	global $item_foto;
	global $upload_dir;
	$sql ="UPDATE datamhs SET nim=?, nama_mahasiswa=?, foto_mahasiswa=? WHERE id=?";
	if($stmt=mysqli_prepare($koneksi, $sql)){
		mysqli_stmt_bind_param($stmt,"sssi",$param_nim, $param_nama_mahasiswa, $param_foto_mahasiswa, $param_id);
		//set parameter
		$param_id = $var_id;
		$param_nim = $nim;
		$param_nama_mahasiswa = $nama_mahasiswa;
		$param_foto_mahasiswa = $item_foto;
		//membuat kondisi optional upload, menyimpan foto sebelumnya jika ada atau memproses foto jika ada
		if(empty($_FILES["foto_mahasiswa"]["tmp_name"])){
	    	if(mysqli_stmt_execute($stmt)){
			    return true;
				}else{
			    return false;
				}
		    }else{  
				if(mysqli_stmt_execute($stmt)&&(move_uploaded_file($foto_mahasiswa, $upload_dir.$item_foto))){
			    return true;
				}else{
			    return false;
				}
			}

	}
}
function cek_nim($data){
	global $koneksi;
	$sql = "SELECT nim FROM datamhs WHERE nim=?";
	if($stmt=mysqli_prepare($koneksi, $sql)){
		mysqli_stmt_bind_param($stmt,"s", $param_nim);
		$param_nim=$data;
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt)==1){
				$simpan=true;
			}else{
				$simpan=false;
			}
			return $simpan;
		}else{
			die("Error");
		}
	}
	mysqli_stmt_close($stmt);
}
/*function detail data img khusus dipanggil untuk menampilkan variabel foto ketika update
karena jika menggunakan fungsi detail data sebelumnya maka data akan terreplace dan tidak akan tersimpan.
Lihat dokumentasinya di :
https://www.root93.co.id/2019/08/kegagalan-fungsi-simpan-gambar-cms-rimi.html
*/
function detail_data_img($var_id){
    global $var_item, $foto_mahasiswa;
     $sql = "SELECT id, foto_mahasiswa FROM datamhs WHERE id = ?";
      if($stmt = prepare($sql)){
          mysqli_stmt_bind_param($stmt, "i", $param_id);
          $param_id = $var_id;
          if(execute($stmt)){     
             
             /*
             Old Get Result
             global $row;
             $result = get_result($stmt);
             $row = fetch($result, MYSQLI_ASSOC);
              */
          mysqli_stmt_store_result($stmt);
          mysqli_stmt_bind_result($stmt, $var_item, $foto_mahasiswa);
            mysqli_stmt_fetch($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
              return true;
              }else{                 
              return false;
              }

            }else{
              echo "Terjadi kesalahan. Coba lagi nanti";
            }
             
          }

             mysqli_stmt_close($stmt);
}
?>


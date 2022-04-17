<?php 
session_start();
if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require_once "functions.php";

// jika tidak ada id di url
if( !isset($_GET["id"]) ) {
  header("Location: index.php");
  exit;
}

// ambil id dari url
$id = $_GET["id"];

// query siswa berdasarkan id
$swa = query("SELECT * FROM siswa WHERE id = $id");


// cek apakah tombol ubah sudah di tekan atau belum
if( isset($_POST["ubah"]) ) {
  // ambil semua data yang di inputkan
  if( ubah($_POST) > 0) {
    echo "<script>
      alert('Data Berhasil di ubah');
      window.location.href = 'index.php';
    </script>";
    
  } else {
    echo "<script>
      alert('Data Gagal di ubah');
    </script>";
  }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Data Siswa</title>
</head>
<body>
  
  <h3>Form ubah Data Siswa</h3>

  <form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $swa['id']; ?>">
    <ul>
      <li>
        <label>
          Nama : 
          <input type="text" name="nama" autofocus required value="<?= $swa['nama']; ?>">
        </label>
      </li>
      <li>
        <label>
          NIS : 
          <input type="text" name="nis" required value="<?= $swa['nis']; ?>">
        </label>
      </li>
      <li>
        <label>
          Email : 
          <input type="text" name="email" required value="<?= $swa['email']; ?>">
        </label>
      </li>
      <li>
        <label>
          Jurusan : 
          <input type="text" name="jurusan" required value="<?= $swa['jurusan']; ?>">
        </label>
      </li>
      <li>
        <input type="hidden" name="gambar_lama" value="<?= $swa['gambar']; ?>">
        <label>
          Gambar : 
          <input type="file" name="gambar" class="gambar" onchange="previewImage()">
        </label>
        <img src="img/<?= $swa['gambar']; ?>" width="120" style="display: block;" class="img-preview">
      </li>
      <li>
        <button type="submit" name="ubah">Ubah</button>
      </li>
    </ul>
  </form>
  
<script>
  // previewImage untuk tambah dan ubah
  function previewImage() {
      const gambar = document.querySelector('.gambar');
      const imgPreview = document.querySelector('.img-preview');

      const oFReader = new FileReader();
      oFReader.readAsDataURL(gambar.files[0]);

      oFReader.onload = function (oFREvent) {
        imgPreview.src = oFREvent.target.result;
      };
    }
</script>
</body>
</html>
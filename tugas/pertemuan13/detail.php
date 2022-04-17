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

// ambil id dari URL
$id = $_GET["id"];

// query siswa berdasarkan id
$swa = query("SELECT * FROM siswa WHERE id = $id");


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Siswa</title>
</head>
<body>
  
  <h3>Detail Siswa</h3>

  <ul>
    <li><img src="img/<?= $swa["gambar"]; ?>" width="250px"></li>
    <li>NIS     : <?= $swa["nis"]; ?></li>
    <li>Nama    : <?= $swa["nama"]; ?></li>
    <li>Email   : <?= $swa["email"]; ?></li>
    <li>Jurusan : <?= $swa["jurusan"]; ?></li>
    <li>
      <a href="ubah.php?id=<?= $swa['id']; ?>">Ubah</a> | <a href="hapus.php?id=<?= $swa['id']; ?>" onclick="return confirm('anda yakin ingin menghapus?')">Hapus</a>
    </li>
    <li>
      <a href="index.php">Kembali</a>
    </li>
  </ul>

</body>
</html>
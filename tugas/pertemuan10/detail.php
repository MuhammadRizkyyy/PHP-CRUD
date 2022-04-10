<?php 
require_once "functions.php";

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
    <li><img src="img/<?= $swa["gambar"]; ?>"></li>
    <li>NIS     : <?= $swa["nis"]; ?></li>
    <li>Nama    : <?= $swa["nama"]; ?></li>
    <li>Email   : <?= $swa["email"]; ?></li>
    <li>Jurusan : <?= $swa["jurusan"]; ?></li>
    <li>
      <a href="">Ubah</a> | <a href="">Hapus</a>
    </li>
    <li>
      <a href="latihan3.php">Kembali</a>
    </li>
  </ul>

</body>
</html>
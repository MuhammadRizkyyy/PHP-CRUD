<?php
session_start();
require_once "functions.php";

// cek apakah ada session
if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

// tampung ke variabel siswa
$siswa = query("SELECT * FROM siswa");

// ketika tombol cari di klik
if( isset($_POST["cari"]) ) {
  $siswa = cari($_POST["keyword"]);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Siswa</title>
</head>
<body>
  
  <a href="logout.php">Logout</a>
  <h3>Daftar Siswa</h3>
  <a href="tambah.php">Tambah data siswa</a>
  <br><br>

  <form action="" method="POST">
    <input type="text" name="keyword" size="30" autofocus placeholder="search here..." autocomplete="off" class="keyword">
    <button type="submit" name="cari" class="tombol-cari">Cari</button>
  </form><br>

  <div class="container">
    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <th>No.</th>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Aksi</th>
      </tr>

      <?php if(empty($siswa)) : ?>
        <tr>
          <td colspan="4">
            <h3 style="color: red; font-style:italic; text-align:center;">Data tidak ditemukan!</h3>
          </td>
        </tr>
      <?php endif; ?>

      <?php $i = 1;
      foreach( $siswa as $swa ) : ?>
        <tr>
          <td><?= $i++; ?></td>
          <td><img src="img/<?= $swa["gambar"]; ?>" width="55"></td>
          <td><?= $swa["nama"]; ?></td>
          <td>
            <a href="detail.php?id=<?= $swa["id"]; ?>">Lihat detail...</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <script src="js/script.js"></script>
</body>
</html>
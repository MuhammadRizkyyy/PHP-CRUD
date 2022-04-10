<?php 

// koneksi ke db dan pilih database

$conn = mysqli_connect("localhost", "root", "", "latihan");

// query isi table siswa
$query = "SELECT * FROM siswa";
$result = mysqli_query($conn, $query);

// Ubah data ke dalam array
$rows = [];
while( $row = mysqli_fetch_assoc($result) ) {
  $rows[] = $row;
}

// tampung ke variabel siswa
$siswa = $rows;

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
  
  <h3>Daftar Siswa</h3>
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>No.</th>
      <th>Gambar</th>
      <th>NIS</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Jurusan</th>
      <th>Aksi</th>
    </tr>

    <?php $i = 1;
    foreach( $siswa as $swa ) : ?>
      <tr>
        <td><?= $i++; ?></td>
        <td><img src="img/<?= $swa["gambar"]; ?>" width="55"></td>
        <td><?= $swa["nis"]; ?></td>
        <td><?= $swa["nama"]; ?></td>
        <td><?= $swa["email"]; ?></td>
        <td><?= $swa["jurusan"]; ?></td>
        <td>
          <a href="">Ubah</a> | <a href="">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

</body>
</html>
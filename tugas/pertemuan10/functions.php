<?php 

function koneksi() {
  return mysqli_connect("localhost", "root", "", "latihan");
}

function query($query) {
  $conn = koneksi();

  $result = mysqli_query($conn, $query);

  // jika hasilnya hanya 1 saja
  if( mysqli_num_rows($result) == 1 ) {
    return mysqli_fetch_assoc($result);
  }

  $rows = [];
  while( $row = mysqli_fetch_assoc($result) ) {
    $rows[] = $row;
  }

  return $rows;
}


function tambah($data) {
  $conn = koneksi();
  
  $nama = htmlspecialchars($data["nama"]);
  $nis = htmlspecialchars($data["nis"]);
  $email = htmlspecialchars($data["email"]);
  $jurusan = htmlspecialchars($data["jurusan"]);
  $gambar = htmlspecialchars($data["gambar"]);


  $query = "INSERT INTO `siswa` (`nama`, `nis`, `email`, `jurusan`, `gambar`) VALUES ('$nama', '$nis', '$email', '$jurusan', '$gambar')";

  mysqli_query($conn, $query);


  echo mysqli_error($conn);
  // untuk mengasih tahu bahwa ada baris yang berubah di database
  // maksud dari berubah bisa nambah, menghapus, atau di modifikasi
  return mysqli_affected_rows($conn);
}

?>
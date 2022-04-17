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

function upload() {
  $nama_file = $_FILES["gambar"]["name"];
  $tipe_file = $_FILES["gambar"]["type"];
  $ukuran_file = $_FILES["gambar"]["size"];
  $error = $_FILES["gambar"]["error"];
  $tmp_file = $_FILES["gambar"]["tmp_name"];

  // ketika tidak ada gambar yang dipilih
  if( $error == 4 ) {
    // echo "<script>
    //   alert('Pilih gambar terlebih dahulu');
    // </script>";
    return 'gambar7.png';
  }

  // cek ekstensi file
  $daftar_gambar = ["jpg", "jpeg", "png"];
  $ekstensi_file = explode(".", $nama_file);
  $ekstensi_file = strtolower(end($ekstensi_file));
  if( !in_array($ekstensi_file, $daftar_gambar) ) {
    echo "<script>
          alert('Yang anda pilih bukan gambar');
          </script>";
    return false;
  }

  // cek tipe file
  if( $tipe_file != "image/jpeg" && $tipe_file != "image/png" ) {
    echo "<script>
          alert('Yang anda pilih bukan gambar');
          </script>";
    return false;
  }

  // cek ukuran file
  // maksimal 5mb = 5000000
  if( $ukuran_file > 5000000 ) {
    echo "<script>
          alert('Ukuran gambar terlalu besar');
          </script>";
    return false;
  }

  // lolos pengecekan, siap upload file
  // generate nama_file gambar baru
  $nama_file_baru = uniqid();
  $nama_file_baru .= ".";
  $nama_file_baru .= $ekstensi_file;
  move_uploaded_file($tmp_file, "img/" . $nama_file_baru);

  return $nama_file_baru;

}

function tambah($data) {
  $conn = koneksi();
  
  $nama = htmlspecialchars($data["nama"]);
  $nis = htmlspecialchars($data["nis"]);
  $email = htmlspecialchars($data["email"]);
  $jurusan = htmlspecialchars($data["jurusan"]);
  // $gambar = htmlspecialchars($data["gambar"]);

  // upload gambar
  $gambar = upload();

  if( !$gambar ) {
    return false;
  }


  $query = "INSERT INTO `siswa` (`nama`, `nis`, `email`, `jurusan`, `gambar`) VALUES ('$nama', '$nis', '$email', '$jurusan', '$gambar')";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  // untuk mengasih tahu bahwa ada baris yang berubah di database
  // maksud dari berubah bisa nambah, menghapus, atau di modifikasi
  return mysqli_affected_rows($conn);
}

function hapus($id) {
  $conn = koneksi();

  // menghapus gambar di folder image
  $swa = query("SELECT * FROM siswa WHERE id = $id");
  if($swa["gambar"] != "gambar7.png") {
    unlink("img/" . $swa["gambar"]);
  }

  mysqli_query($conn, "DELETE FROM siswa WHERE id = $id") or die(mysqli_error($conn));

  return mysqli_affected_rows($conn);
}


function ubah($data) {
  $conn = koneksi();
  
  $id = $data["id"];
  $nama = htmlspecialchars($data["nama"]);
  $nis = htmlspecialchars($data["nis"]);
  $email = htmlspecialchars($data["email"]);
  $jurusan = htmlspecialchars($data["jurusan"]);
  $gambar_lama = htmlspecialchars($data["gambar_lama"]);

  $gambar = upload();
  if( !$gambar ) {
    return false;
  }

  if( $gambar == 'gambar7.png' ) {
    $gambar = $gambar_lama;
  }

  $query = "UPDATE siswa SET nama = '$nama', nis = '$nis', email = '$email', jurusan = '$jurusan', gambar = '$gambar' WHERE id = $id";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  // untuk mengasih tahu bahwa ada baris yang berubah di database
  // maksud dari berubah bisa nambah, menghapus, atau di modifikasi
  return mysqli_affected_rows($conn);
}

function cari($keyword) {
  $conn = koneksi();

  $query = "SELECT * FROM siswa WHERE nama LIKE '%$keyword%'";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

  $rows = [];
  while( $row = mysqli_fetch_assoc($result) ) {
    $rows[] = $row;
  }

  return $rows;
}

function login($data) {
  $conn = koneksi();

  $username = htmlspecialchars($data["username"]);
  $password = htmlspecialchars($data["password"]);

    // cek dulu username nya
  if( $user = query("SELECT * FROM users WHERE username = '$username'") ) {
    // cek password
    if( password_verify($password, $user["password"]) ) {
      // set session
      $_SESSION["login"] = true;

      header("Location: index.php");
      exit;
    }

  }
  return [
    "error" => true,
    "pesan" => "Username atau Password salah"
  ];

}

function registrasi($data) {
  $conn = koneksi();

  $username = htmlspecialchars(strtolower($data["username"]));
  $password1 = mysqli_real_escape_string($conn, $data["password1"]);
  $password2 = mysqli_real_escape_string($conn, $data["password2"]);

  // jika username atau password kosong
  if( empty($username) || empty($password1) || empty($password2) ) {
    echo "<script>
            alert('Username atau Password tidak boleh kosong');
            document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  // jika username sudah ada di dalam databse
  if( query("SELECT * FROM users WHERE username = '$username'") ) {
    echo "<script>
            alert('Username sudah terdaftar');
            document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  // cek apakah password sama dengan konfirmasi password
  if( $password1 !== $password2 ) {
    echo "<script>
            alert('Konfirmasi password tidak sesuai');
            document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  // membatasi password lebih kecil dari 5 digit
  if( strlen($password1) < 5 ) {
    echo "<script>
            alert('Password terlalu pendek');
            document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  // jika username dan password sudah sesuai
  // pertama ekripsi dulu password nya
  $password_baru = password_hash($password1, PASSWORD_DEFAULT);

  // insert ke tabel users
  $query = "INSERT INTO users VALUES(null, '$username', '$password_baru', 0)";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  return mysqli_affected_rows($conn);

}


?>
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

// ambil id dari dari URL
$id = $_GET["id"];
if( hapus($id) > 0) {
  echo "<script>
    alert('Data Berhasil di hapus');
    window.location.href = 'index.php';
  </script>";
  
} else {
  echo "<script>
    alert('Data Gagal di hapus');
  </script>";
}

?>
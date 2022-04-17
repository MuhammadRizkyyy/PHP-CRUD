<?php 
require_once "../functions.php";

$siswa = cari($_GET["keyword"]);

?>

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
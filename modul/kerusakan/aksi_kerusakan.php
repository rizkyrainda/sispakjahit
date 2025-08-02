<?php

session_start();
if (!(isset($_SESSION['username']) && isset($_SESSION['password']))) {
  header('location:index.php');
  exit();
} else {
?>
  <?php

  session_start();
  include "../../config/koneksi.php";

  $module = $_GET[module];
  $act = $_GET[act];

// Hapus kerusakan
  if ($module == 'kerusakan' AND $act == 'hapus') {
    mysql_query("DELETE FROM kerusakan WHERE kode_kerusakan='$_GET[id]'");
    header('location:../../index.php?module=' . $module);
  }

// Input kerusakan
  elseif ($module == 'kerusakan' AND $act == 'input') {
    $nama_kerusakan = $_POST[nama_kerusakan];
    $det_kerusakan = $_POST[det_kerusakan];
    $srn_kerusakan = $_POST[srn_kerusakan];
    $fileName = $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../../gambar/kerusakan/" . $_FILES['gambar']['name']);
    mysql_query("INSERT INTO kerusakan(
			      nama_kerusakan,det_kerusakan,srn_kerusakan,gambar) 
	                       VALUES(
				'$nama_kerusakan','$det_kerusakan','$srn_kerusakan','$fileName')");

    header('location:../../index.php?module=' . $module);
  }

// Update kerusakan
  elseif ($module == 'kerusakan' AND $act == 'update') {
    $nama_kerusakan = $_POST[nama_kerusakan];
    $det_kerusakan = $_POST[det_kerusakan];
    $srn_kerusakan = $_POST[srn_kerusakan];

    $fileName = $_FILES['gambar']['name'];
    if ($fileName) {
      move_uploaded_file($_FILES['gambar']['tmp_name'], "../../gambar/kerusakan/" . $_FILES['gambar']['name']);

      mysql_query("UPDATE kerusakan SET
					nama_kerusakan   = '$nama_kerusakan',
					det_kerusakan   = '$det_kerusakan',
					srn_kerusakan   = '$srn_kerusakan',
                      gambar   = '$fileName'
               WHERE kode_kerusakan       = '$_POST[id]'");
    } else {
      mysql_query("UPDATE kerusakan SET
					nama_kerusakan   = '$nama_kerusakan',
					det_kerusakan   = '$det_kerusakan',
					srn_kerusakan   = '$srn_kerusakan'
               WHERE kode_kerusakan       = '$_POST[id]'");
    }
    header('location:../../index.php?module=' . $module);
  }
  ?>
<?php } ?>

<?php
include 'function/admin/karyawan.php';

if (isset($_GET['id'])) {
    $result = deleteKaryawan($_GET['id']);
    if ($result) {
        echo '<script>alert("Karyawan berhasil dihapus!"); window.location.href = "dashboard.php?route=karyawan";</script>';
    } else {
        echo '<script>alert("Gagal menghapus karyawan!"); window.location.href = "dashboard.php?route=karyawan";</script>';
    }
} else {
    echo '<script>window.location.href = "dashboard.php?route=karyawan";</script>';
}
?>

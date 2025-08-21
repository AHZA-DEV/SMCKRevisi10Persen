
<?php
include 'function/admin/departemen.php';

if (isset($_GET['id'])) {
    $result = deleteDepartemen($_GET['id']);
    if ($result) {
        echo '<script>alert("Departemen berhasil dihapus!"); window.location.href = "dashboard.php?route=departemen";</script>';
    } else {
        echo '<script>alert("Gagal menghapus departemen!"); window.location.href = "dashboard.php?route=departemen";</script>';
    }
} else {
    echo '<script>window.location.href = "dashboard.php?route=departemen";</script>';
}
?>


<?php
include_once 'config/koneksi.php';

function getAllDepartemen() {
    global $conn;
    $query = "SELECT * FROM departemen ORDER BY created_at DESC";
    return mysqli_query($conn, $query);
}

function getDepartemenById($id) {
    global $conn;
    $query = "SELECT * FROM departemen WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function createDepartemen($data) {
    global $conn;
    $kode = mysqli_real_escape_string($conn, $data['kode_departemen']);
    $nama = mysqli_real_escape_string($conn, $data['nama_departemen']);
    $deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
    
    $query = "INSERT INTO departemen (kode_departemen, nama_departemen, deskripsi) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $kode, $nama, $deskripsi);
    return mysqli_stmt_execute($stmt);
}

function updateDepartemen($id, $data) {
    global $conn;
    $kode = mysqli_real_escape_string($conn, $data['kode_departemen']);
    $nama = mysqli_real_escape_string($conn, $data['nama_departemen']);
    $deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
    
    $query = "UPDATE departemen SET kode_departemen = ?, nama_departemen = ?, deskripsi = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $kode, $nama, $deskripsi, $id);
    return mysqli_stmt_execute($stmt);
}

function deleteDepartemen($id) {
    global $conn;
    $query = "DELETE FROM departemen WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}

function getDepartemenForDropdown() {
    global $conn;
    $query = "SELECT id, nama_departemen FROM departemen ORDER BY nama_departemen";
    return mysqli_query($conn, $query);
}
?>

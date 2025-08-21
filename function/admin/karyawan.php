
<?php
include_once 'config/koneksi.php';

function getAllKaryawan() {
    global $conn;
    $query = "SELECT k.*, d.nama_departemen 
              FROM karyawan k 
              LEFT JOIN departemen d ON k.id_departemen = d.id 
              ORDER BY k.created_at DESC";
    return mysqli_query($conn, $query);
}

function getKaryawanById($id) {
    global $conn;
    $query = "SELECT * FROM karyawan WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function createKaryawan($data) {
    global $conn;
    
    $nip = mysqli_real_escape_string($conn, $data['nip']);
    $nama_depan = mysqli_real_escape_string($conn, $data['nama_depan']);
    $nama_belakang = mysqli_real_escape_string($conn, $data['nama_belakang']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $id_departemen = !empty($data['id_departemen']) ? intval($data['id_departemen']) : null;
    $jabatan = mysqli_real_escape_string($conn, $data['jabatan']);
    $tanggal_mulai_kerja = !empty($data['tanggal_mulai_kerja']) ? $data['tanggal_mulai_kerja'] : null;
    $no_telepon = mysqli_real_escape_string($conn, $data['no_telepon']);
    $alamat = mysqli_real_escape_string($conn, $data['alamat']);
    $peran = mysqli_real_escape_string($conn, $data['peran']);
    
    $query = "INSERT INTO karyawan (nip, nama_depan, nama_belakang, email, password, id_departemen, jabatan, tanggal_mulai_kerja, no_telepon, alamat, peran) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssisssss", $nip, $nama_depan, $nama_belakang, $email, $password, $id_departemen, $jabatan, $tanggal_mulai_kerja, $no_telepon, $alamat, $peran);
    return mysqli_stmt_execute($stmt);
}

function updateKaryawan($id, $data) {
    global $conn;
    
    $nip = mysqli_real_escape_string($conn, $data['nip']);
    $nama_depan = mysqli_real_escape_string($conn, $data['nama_depan']);
    $nama_belakang = mysqli_real_escape_string($conn, $data['nama_belakang']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $id_departemen = !empty($data['id_departemen']) ? intval($data['id_departemen']) : null;
    $jabatan = mysqli_real_escape_string($conn, $data['jabatan']);
    $tanggal_mulai_kerja = !empty($data['tanggal_mulai_kerja']) ? $data['tanggal_mulai_kerja'] : null;
    $no_telepon = mysqli_real_escape_string($conn, $data['no_telepon']);
    $alamat = mysqli_real_escape_string($conn, $data['alamat']);
    $peran = mysqli_real_escape_string($conn, $data['peran']);
    
    if (!empty($data['password'])) {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $query = "UPDATE karyawan SET nip = ?, nama_depan = ?, nama_belakang = ?, email = ?, password = ?, id_departemen = ?, jabatan = ?, tanggal_mulai_kerja = ?, no_telepon = ?, alamat = ?, peran = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssisssssi", $nip, $nama_depan, $nama_belakang, $email, $password, $id_departemen, $jabatan, $tanggal_mulai_kerja, $no_telepon, $alamat, $peran, $id);
    } else {
        $query = "UPDATE karyawan SET nip = ?, nama_depan = ?, nama_belakang = ?, email = ?, id_departemen = ?, jabatan = ?, tanggal_mulai_kerja = ?, no_telepon = ?, alamat = ?, peran = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssisssssi", $nip, $nama_depan, $nama_belakang, $email, $id_departemen, $jabatan, $tanggal_mulai_kerja, $no_telepon, $alamat, $peran, $id);
    }
    
    return mysqli_stmt_execute($stmt);
}

function deleteKaryawan($id) {
    global $conn;
    $query = "DELETE FROM karyawan WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}
?>

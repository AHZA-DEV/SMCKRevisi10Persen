
<?php
include_once 'config/koneksi.php';

function getAllCuti() {
    global $conn;
    $query = "SELECT c.*, 
                     k.nama_depan, k.nama_belakang, k.nip,
                     d.nama_departemen,
                     jc.nama_cuti,
                     admin.nama_depan as admin_nama_depan, admin.nama_belakang as admin_nama_belakang
              FROM cuti c
              JOIN karyawan k ON c.id_karyawan = k.id
              LEFT JOIN departemen d ON k.id_departemen = d.id
              JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id
              LEFT JOIN karyawan admin ON c.disetujui_oleh = admin.id
              ORDER BY c.created_at DESC";
    return mysqli_query($conn, $query);
}

function getCutiById($id) {
    global $conn;
    $query = "SELECT c.*, 
                     k.nama_depan, k.nama_belakang, k.nip, k.jabatan,
                     d.nama_departemen,
                     jc.nama_cuti,
                     admin.nama_depan as nama_penyetuju
              FROM cuti c
              JOIN karyawan k ON c.id_karyawan = k.id
              LEFT JOIN departemen d ON k.id_departemen = d.id
              JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id
              LEFT JOIN karyawan admin ON c.disetujui_oleh = admin.id
              WHERE c.id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function setujuiCuti($id, $admin_id) {
    global $conn;
    $query = "UPDATE cuti SET status = 'disetujui', disetujui_oleh = ?, disetujui_pada = NOW() WHERE id = ? AND status = 'menunggu'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $admin_id, $id);
    return mysqli_stmt_execute($stmt);
}

function tolakCuti($id, $admin_id, $alasan_penolakan) {
    global $conn;
    $query = "UPDATE cuti SET status = 'ditolak', disetujui_oleh = ?, disetujui_pada = NOW(), alasan_penolakan = ? WHERE id = ? AND status = 'menunggu'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isi", $admin_id, $alasan_penolakan, $id);
    return mysqli_stmt_execute($stmt);
}

function getCutiStatistics() {
    global $conn;
    $stats = [];
    
    // Total pengajuan
    $query = "SELECT COUNT(*) as total FROM cuti";
    $result = mysqli_query($conn, $query);
    $stats['total'] = mysqli_fetch_assoc($result)['total'];
    
    // Menunggu
    $query = "SELECT COUNT(*) as menunggu FROM cuti WHERE status = 'menunggu'";
    $result = mysqli_query($conn, $query);
    $stats['menunggu'] = mysqli_fetch_assoc($result)['menunggu'];
    
    // Disetujui
    $query = "SELECT COUNT(*) as disetujui FROM cuti WHERE status = 'disetujui'";
    $result = mysqli_query($conn, $query);
    $stats['disetujui'] = mysqli_fetch_assoc($result)['disetujui'];
    
    // Ditolak
    $query = "SELECT COUNT(*) as ditolak FROM cuti WHERE status = 'ditolak'";
    $result = mysqli_query($conn, $query);
    $stats['ditolak'] = mysqli_fetch_assoc($result)['ditolak'];
    
    return $stats;
}

function getAllJenisCuti() {
    global $conn;
    $query = "SELECT * FROM jenis_cuti ORDER BY nama_cuti";
    return mysqli_query($conn, $query);
}
?>

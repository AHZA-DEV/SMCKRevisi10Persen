
<?php
include_once '../config/koneksi.php';

function getDashboardStats() {
    global $conn;
    
    $stats = array();
    
    // Total Karyawan
    $query = "SELECT COUNT(*) as total FROM karyawan";
    $result = mysqli_query($conn, $query);
    $stats['total_karyawan'] = mysqli_fetch_assoc($result)['total'];
    
    // Total Departemen
    $query = "SELECT COUNT(*) as total FROM departemen";
    $result = mysqli_query($conn, $query);
    $stats['total_departemen'] = mysqli_fetch_assoc($result)['total'];
    
    // Cuti Menunggu
    $query = "SELECT COUNT(*) as total FROM cuti WHERE status = 'menunggu'";
    $result = mysqli_query($conn, $query);
    $stats['cuti_menunggu'] = mysqli_fetch_assoc($result)['total'];
    
    // Cuti Disetujui Bulan Ini
    $query = "SELECT COUNT(*) as total FROM cuti WHERE status = 'disetujui' AND MONTH(tanggal_mulai) = MONTH(CURRENT_DATE())";
    $result = mysqli_query($conn, $query);
    $stats['cuti_disetujui'] = mysqli_fetch_assoc($result)['total'];
    
    return $stats;
}

function getRecentActivities() {
    global $conn;
    
    $query = "SELECT c.*, k.nama_depan, k.nama_belakang, jc.nama_cuti, k.nip
              FROM cuti c 
              JOIN karyawan k ON c.id_karyawan = k.id 
              JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id
              ORDER BY c.tanggal_pengajuan DESC 
              LIMIT 10";
    
    return mysqli_query($conn, $query);
}

function getCutiStatisticsMonthly() {
    global $conn;
    
    $query = "SELECT 
                MONTH(tanggal_mulai) as bulan,
                COUNT(*) as total,
                SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
                SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak,
                SUM(CASE WHEN status = 'menunggu' THEN 1 ELSE 0 END) as menunggu
              FROM cuti 
              WHERE YEAR(tanggal_mulai) = YEAR(CURRENT_DATE())
              GROUP BY MONTH(tanggal_mulai)
              ORDER BY bulan";
    
    return mysqli_query($conn, $query);
}

function getCutiByDepartment() {
    global $conn;
    
    $query = "SELECT 
                d.nama_departemen,
                COUNT(c.id) as total_cuti
              FROM departemen d
              LEFT JOIN karyawan k ON d.id = k.id_departemen
              LEFT JOIN cuti c ON k.id = c.id_karyawan
              GROUP BY d.id, d.nama_departemen
              ORDER BY total_cuti DESC";
    
    return mysqli_query($conn, $query);
}
?>

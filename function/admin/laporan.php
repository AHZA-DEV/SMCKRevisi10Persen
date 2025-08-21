
<?php
include_once '../config/koneksi.php';

function getLaporanCuti($filter = array()) {
    global $conn;
    
    $query = "SELECT 
                c.*,
                k.nip,
                k.nama_depan,
                k.nama_belakang,
                d.nama_departemen,
                jc.nama_cuti,
                c.tanggal_pengajuan,
                c.tanggal_mulai,
                c.tanggal_selesai,
                c.jumlah_hari,
                c.status,
                c.keterangan
              FROM cuti c
              JOIN karyawan k ON c.id_karyawan = k.id
              LEFT JOIN departemen d ON k.id_departemen = d.id
              JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id";
    
    $where = array();
    $params = array();
    $types = '';
    
    if (!empty($filter['tanggal_mulai'])) {
        $where[] = "c.tanggal_mulai >= ?";
        $params[] = $filter['tanggal_mulai'];
        $types .= 's';
    }
    
    if (!empty($filter['tanggal_selesai'])) {
        $where[] = "c.tanggal_selesai <= ?";
        $params[] = $filter['tanggal_selesai'];
        $types .= 's';
    }
    
    if (!empty($filter['status'])) {
        $where[] = "c.status = ?";
        $params[] = $filter['status'];
        $types .= 's';
    }
    
    if (!empty($filter['id_departemen'])) {
        $where[] = "k.id_departemen = ?";
        $params[] = $filter['id_departemen'];
        $types .= 'i';
    }
    
    if (!empty($where)) {
        $query .= " WHERE " . implode(" AND ", $where);
    }
    
    $query .= " ORDER BY c.tanggal_pengajuan DESC";
    
    $stmt = mysqli_prepare($conn, $query);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

function getLaporanKaryawan($filter = array()) {
    global $conn;
    
    $query = "SELECT 
                k.*,
                d.nama_departemen,
                COUNT(c.id) as total_cuti,
                SUM(CASE WHEN c.status = 'disetujui' THEN c.jumlah_hari ELSE 0 END) as total_hari_cuti
              FROM karyawan k
              LEFT JOIN departemen d ON k.id_departemen = d.id
              LEFT JOIN cuti c ON k.id = c.id_karyawan";
    
    $where = array();
    $params = array();
    $types = '';
    
    if (!empty($filter['id_departemen'])) {
        $where[] = "k.id_departemen = ?";
        $params[] = $filter['id_departemen'];
        $types .= 'i';
    }
    
    if (!empty($filter['peran'])) {
        $where[] = "k.peran = ?";
        $params[] = $filter['peran'];
        $types .= 's';
    }
    
    if (!empty($where)) {
        $query .= " WHERE " . implode(" AND ", $where);
    }
    
    $query .= " GROUP BY k.id ORDER BY k.nama_depan";
    
    $stmt = mysqli_prepare($conn, $query);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

function generateLaporanPDF($data, $jenis_laporan) {
    // Implementasi PDF generation akan menggunakan library seperti TCPDF atau FPDF
    // Untuk sekarang, kita buat placeholder
    return true;
}

function generateLaporanExcel($data, $jenis_laporan) {
    // Implementasi Excel generation akan menggunakan library seperti PhpSpreadsheet
    // Untuk sekarang, kita buat placeholder
    return true;
}

function getStatistikCuti() {
    global $conn;
    
    $stats = array();
    
    // Total cuti per status
    $query = "SELECT status, COUNT(*) as total FROM cuti GROUP BY status";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['status'][$row['status']] = $row['total'];
    }
    
    // Total cuti per bulan (tahun ini)
    $query = "SELECT 
                MONTH(tanggal_mulai) as bulan,
                COUNT(*) as total
              FROM cuti 
              WHERE YEAR(tanggal_mulai) = YEAR(CURRENT_DATE())
              GROUP BY MONTH(tanggal_mulai)";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['bulanan'][$row['bulan']] = $row['total'];
    }
    
    // Total cuti per departemen
    $query = "SELECT 
                d.nama_departemen,
                COUNT(c.id) as total
              FROM departemen d
              LEFT JOIN karyawan k ON d.id = k.id_departemen
              LEFT JOIN cuti c ON k.id = c.id_karyawan
              GROUP BY d.id";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['departemen'][$row['nama_departemen']] = $row['total'];
    }
    
    return $stats;
}
?>

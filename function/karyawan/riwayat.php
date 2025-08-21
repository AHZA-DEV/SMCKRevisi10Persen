
<?php
include_once 'config/koneksi.php';

// Fungsi untuk mendapatkan riwayat cuti karyawan dengan filter
function getRiwayatCuti($id_karyawan, $filters = []) {
    global $conn;
    
    $where_clause = "c.id_karyawan = ?";
    $params = [$id_karyawan];
    $types = "i";
    
    // Filter berdasarkan status
    if (!empty($filters['status'])) {
        $where_clause .= " AND c.status = ?";
        $params[] = $filters['status'];
        $types .= "s";
    }
    
    // Filter berdasarkan jenis cuti
    if (!empty($filters['jenis_cuti'])) {
        $where_clause .= " AND c.id_jenis_cuti = ?";
        $params[] = $filters['jenis_cuti'];
        $types .= "i";
    }
    
    // Filter berdasarkan tahun
    if (!empty($filters['tahun'])) {
        $where_clause .= " AND YEAR(c.tanggal_mulai) = ?";
        $params[] = $filters['tahun'];
        $types .= "i";
    }
    
    // Filter berdasarkan rentang tanggal
    if (!empty($filters['tanggal_dari']) && !empty($filters['tanggal_sampai'])) {
        $where_clause .= " AND c.tanggal_mulai >= ? AND c.tanggal_selesai <= ?";
        $params[] = $filters['tanggal_dari'];
        $params[] = $filters['tanggal_sampai'];
        $types .= "ss";
    }
    
    $query = "SELECT c.*, jc.nama_cuti, jc.maksimal_hari,
              CASE 
                  WHEN c.disetujui_oleh IS NOT NULL THEN CONCAT(k.nama_depan, ' ', k.nama_belakang)
                  ELSE NULL
              END as nama_penyetuju
              FROM cuti c 
              LEFT JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id 
              LEFT JOIN karyawan k ON c.disetujui_oleh = k.id 
              WHERE $where_clause 
              ORDER BY c.created_at DESC";
    
    $stmt = mysqli_prepare($conn, $query);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// Fungsi untuk mendapatkan statistik riwayat cuti
function getStatistikRiwayat($id_karyawan, $tahun = null) {
    global $conn;
    
    $where_clause = "id_karyawan = ?";
    $params = [$id_karyawan];
    $types = "i";
    
    if ($tahun) {
        $where_clause .= " AND YEAR(tanggal_mulai) = ?";
        $params[] = $tahun;
        $types .= "i";
    }
    
    $query = "SELECT 
                COUNT(*) as total_pengajuan,
                COUNT(CASE WHEN status = 'disetujui' THEN 1 END) as disetujui,
                COUNT(CASE WHEN status = 'ditolak' THEN 1 END) as ditolak,
                COUNT(CASE WHEN status = 'menunggu' THEN 1 END) as pending,
                COUNT(CASE WHEN status = 'dibatalkan' THEN 1 END) as dibatalkan,
                COALESCE(SUM(CASE WHEN status = 'disetujui' THEN jumlah_hari ELSE 0 END), 0) as total_hari_cuti
              FROM cuti 
              WHERE $where_clause";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Fungsi untuk mendapatkan riwayat cuti berdasarkan bulan
function getRiwayatPerBulan($id_karyawan, $tahun) {
    global $conn;
    
    $query = "SELECT 
                MONTH(tanggal_mulai) as bulan,
                COUNT(*) as jumlah_pengajuan,
                COALESCE(SUM(CASE WHEN status = 'disetujui' THEN jumlah_hari ELSE 0 END), 0) as hari_cuti
              FROM cuti 
              WHERE id_karyawan = ? AND YEAR(tanggal_mulai) = ? 
              GROUP BY MONTH(tanggal_mulai) 
              ORDER BY bulan";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_karyawan, $tahun);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// Fungsi untuk mendapatkan riwayat berdasarkan jenis cuti
function getRiwayatPerJenisCuti($id_karyawan, $tahun = null) {
    global $conn;
    
    $where_clause = "c.id_karyawan = ?";
    $params = [$id_karyawan];
    $types = "i";
    
    if ($tahun) {
        $where_clause .= " AND YEAR(c.tanggal_mulai) = ?";
        $params[] = $tahun;
        $types .= "i";
    }
    
    $query = "SELECT 
                jc.nama_cuti,
                COUNT(*) as jumlah_pengajuan,
                COALESCE(SUM(CASE WHEN c.status = 'disetujui' THEN c.jumlah_hari ELSE 0 END), 0) as hari_cuti
              FROM cuti c 
              LEFT JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id 
              WHERE $where_clause 
              GROUP BY c.id_jenis_cuti, jc.nama_cuti 
              ORDER BY hari_cuti DESC";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// Fungsi untuk ekspor riwayat ke CSV
function exportRiwayatCSV($id_karyawan, $filters = []) {
    $riwayat = getRiwayatCuti($id_karyawan, $filters);
    
    $filename = "riwayat_cuti_" . date('Y-m-d') . ".csv";
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // Header CSV
    fputcsv($output, [
        'No',
        'Jenis Cuti', 
        'Tanggal Mulai', 
        'Tanggal Selesai', 
        'Jumlah Hari', 
        'Status', 
        'Alasan', 
        'Tanggal Pengajuan',
        'Disetujui Oleh'
    ]);
    
    $no = 1;
    while ($row = mysqli_fetch_assoc($riwayat)) {
        fputcsv($output, [
            $no++,
            $row['nama_cuti'],
            date('d/m/Y', strtotime($row['tanggal_mulai'])),
            date('d/m/Y', strtotime($row['tanggal_selesai'])),
            $row['jumlah_hari'],
            $row['status'],
            $row['alasan'],
            date('d/m/Y H:i', strtotime($row['created_at'])),
            $row['nama_penyetuju'] ?: '-'
        ]);
    }
    
    fclose($output);
}

// Fungsi untuk mendapatkan tahun-tahun yang tersedia dalam riwayat
function getTahunRiwayat($id_karyawan) {
    global $conn;
    
    $query = "SELECT DISTINCT YEAR(tanggal_mulai) as tahun 
              FROM cuti 
              WHERE id_karyawan = ? 
              ORDER BY tahun DESC";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_karyawan);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}
?>


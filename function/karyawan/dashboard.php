
<?php
include_once 'config/koneksi.php';

// Fungsi untuk mendapatkan ringkasan dashboard karyawan
function getDashboardSummary($id_karyawan) {
    global $conn;
    
    // Data karyawan
    $query1 = "SELECT k.*, d.nama_departemen 
               FROM karyawan k 
               LEFT JOIN departemen d ON k.id_departemen = d.id 
               WHERE k.id = ?";
    
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "i", $id_karyawan);
    mysqli_stmt_execute($stmt1);
    $karyawan = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt1));
    
    // Add null check
    if (!$karyawan) {
        $karyawan = [];
    }
    
    // Statistik cuti tahun ini
    $tahun_ini = date('Y');
    $query2 = "SELECT 
                 COUNT(*) as total_pengajuan,
                 COUNT(CASE WHEN status = 'Disetujui' THEN 1 END) as disetujui,
                 COUNT(CASE WHEN status = 'Pending' THEN 1 END) as pending,
                 COALESCE(SUM(CASE WHEN status = 'Disetujui' THEN jumlah_hari ELSE 0 END), 0) as hari_terpakai
               FROM cuti 
               WHERE id_karyawan = ? AND YEAR(tanggal_mulai) = ?";
    
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "ii", $id_karyawan, $tahun_ini);
    mysqli_stmt_execute($stmt2);
    $statistik = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt2));
    
    // Hitung sisa cuti
    $total_cuti = 12; // Default, bisa diambil dari setting
    $sisa_cuti = $total_cuti - $statistik['hari_terpakai'];
    
    return [
        'karyawan' => $karyawan,
        'statistik' => $statistik,
        'sisa_cuti' => $sisa_cuti,
        'total_cuti' => $total_cuti
    ];
}

// Fungsi untuk mendapatkan pengajuan cuti terbaru
function getCutiTerbaru($id_karyawan, $limit = 5) {
    global $conn;
    
    $query = "SELECT c.*, jc.nama_cuti 
              FROM cuti c 
              LEFT JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id 
              WHERE c.id_karyawan = ? 
              ORDER BY c.created_at DESC 
              LIMIT ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_karyawan, $limit);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// Fungsi untuk mendapatkan data chart cuti per bulan
function getChartCutiPerBulan($id_karyawan, $tahun) {
    global $conn;
    
    $query = "SELECT 
                MONTH(tanggal_mulai) as bulan,
                COALESCE(SUM(CASE WHEN status = 'Disetujui' THEN jumlah_hari ELSE 0 END), 0) as hari_cuti
              FROM cuti 
              WHERE id_karyawan = ? AND YEAR(tanggal_mulai) = ? 
              GROUP BY MONTH(tanggal_mulai) 
              ORDER BY bulan";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_karyawan, $tahun);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $data = [];
    
    // Inisialisasi data 12 bulan
    for ($i = 1; $i <= 12; $i++) {
        $data[$i] = 0;
    }
    
    // Isi data yang ada
    while ($row = mysqli_fetch_assoc($result)) {
        $data[$row['bulan']] = $row['hari_cuti'];
    }
    
    return array_values($data);
}

// Fungsi untuk mendapatkan cuti yang akan datang
function getCutiMendatang($id_karyawan) {
    global $conn;
    
    $query = "SELECT c.*, jc.nama_cuti 
              FROM cuti c 
              LEFT JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id 
              WHERE c.id_karyawan = ? 
              AND c.tanggal_mulai > NOW() 
              AND c.status IN ('Pending', 'Disetujui') 
              ORDER BY c.tanggal_mulai ASC 
              LIMIT 3";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_karyawan);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// Fungsi untuk mendapatkan aktivitas terbaru
function getAktivitasTerbaru($id_karyawan, $limit = 5) {
    global $conn;
    
    $query = "SELECT 
                c.id,
                c.created_at as tanggal,
                CONCAT('Mengajukan cuti ', jc.nama_cuti) as aktivitas,
                c.status,
                'cuti' as tipe
              FROM cuti c 
              LEFT JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id 
              WHERE c.id_karyawan = ? 
              ORDER BY c.created_at DESC 
              LIMIT ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_karyawan, $limit);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// Fungsi untuk mendapatkan notifikasi untuk karyawan
function getNotifikasiKaryawan($id_karyawan) {
    global $conn;
    
    $notifications = [];
    
    // Cek cuti yang hampir expired (3 hari lagi)
    $query1 = "SELECT COUNT(*) as jumlah 
               FROM cuti 
               WHERE id_karyawan = ? 
               AND status = 'Disetujui' 
               AND tanggal_mulai BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 3 DAY)";
    
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "i", $id_karyawan);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt1));
    
    if ($result1['jumlah'] > 0) {
        $notifications[] = [
            'type' => 'info',
            'title' => 'Cuti Segera Dimulai',
            'message' => "Anda memiliki {$result1['jumlah']} cuti yang akan dimulai dalam 3 hari ke depan"
        ];
    }
    
    // Cek sisa cuti yang sedikit
    $summary = getDashboardSummary($id_karyawan);
    if ($summary['sisa_cuti'] <= 3 && $summary['sisa_cuti'] > 0) {
        $notifications[] = [
            'type' => 'warning',
            'title' => 'Sisa Cuti Sedikit',
            'message' => "Sisa cuti Anda hanya {$summary['sisa_cuti']} hari lagi"
        ];
    }
    
    return $notifications;
}

// Fungsi untuk mendapatkan data perbandingan dengan rekan kerja (departemen)
function getPerbandinganDepartemen($id_karyawan) {
    global $conn;
    
    $query = "SELECT 
                AVG(total_cuti.hari_cuti) as rata_rata_departemen
              FROM (
                  SELECT 
                      k.id,
                      COALESCE(SUM(CASE WHEN c.status = 'Disetujui' THEN c.jumlah_hari ELSE 0 END), 0) as hari_cuti
                  FROM karyawan k
                  LEFT JOIN cuti c ON k.id = c.id_karyawan AND YEAR(c.tanggal_mulai) = YEAR(NOW())
                  WHERE k.id_departemen = (SELECT id_departemen FROM karyawan WHERE id = ?)
                  AND k.id != ?
                  GROUP BY k.id
              ) as total_cuti";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_karyawan, $id_karyawan);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row['rata_rata_departemen'] ?: 0;
}
?>


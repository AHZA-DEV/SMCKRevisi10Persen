
<?php
include_once 'config/koneksi.php';

// Fungsi untuk mendapatkan event cuti untuk kalender
function getKalenderCuti($id_karyawan, $bulan = null, $tahun = null) {
    global $conn;
    
    $where_clause = "c.id_karyawan = ?";
    $params = [$id_karyawan];
    $types = "i";
    
    if ($bulan && $tahun) {
        $where_clause .= " AND (MONTH(c.tanggal_mulai) = ? AND YEAR(c.tanggal_mulai) = ?)";
        $params[] = $bulan;
        $params[] = $tahun;
        $types .= "ii";
    }
    
    $query = "SELECT c.*, jc.nama_cuti 
              FROM cuti c 
              LEFT JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id 
              WHERE $where_clause 
              AND c.status IN ('menunggu', 'disetujui') 
              ORDER BY c.tanggal_mulai";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// Fungsi untuk mendapatkan event cuti tim (departemen yang sama)
function getKalenderCutiTim($id_karyawan, $bulan = null, $tahun = null) {
    global $conn;
    
    $where_clause = "k.id_departemen = (SELECT id_departemen FROM karyawan WHERE id = ?)";
    $params = [$id_karyawan];
    $types = "i";
    
    if ($bulan && $tahun) {
        $where_clause .= " AND (MONTH(c.tanggal_mulai) = ? AND YEAR(c.tanggal_mulai) = ?)";
        $params[] = $bulan;
        $params[] = $tahun;
        $types .= "ii";
    }
    
    $query = "SELECT c.*, jc.nama_cuti, k.nama_depan, k.nama_belakang 
              FROM cuti c 
              LEFT JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id 
              LEFT JOIN karyawan k ON c.id_karyawan = k.id 
              WHERE $where_clause 
              AND c.status = 'disetujui' 
              AND c.id_karyawan != ? 
              ORDER BY c.tanggal_mulai";
    
    $stmt = mysqli_prepare($conn, $query);
    $params[] = $id_karyawan;
    $types .= "i";
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// Fungsi untuk generate kalender bulan
function generateKalender($bulan, $tahun) {
    $firstDay = mktime(0, 0, 0, $bulan, 1, $tahun);
    $daysInMonth = date('t', $firstDay);
    $startDay = date('w', $firstDay);
    
    $calendar = [];
    $week = [];
    
    // Isi hari kosong di awal bulan
    for ($i = 0; $i < $startDay; $i++) {
        $week[] = '';
    }
    
    // Isi hari dalam bulan
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $week[] = $day;
        
        if (count($week) == 7) {
            $calendar[] = $week;
            $week = [];
        }
    }
    
    // Isi hari kosong di akhir bulan
    if (!empty($week)) {
        while (count($week) < 7) {
            $week[] = '';
        }
        $calendar[] = $week;
    }
    
    return $calendar;
}

// Fungsi untuk mendapatkan event pada tanggal tertentu
function getEventPadaTanggal($tanggal, $events) {
    $event_hari = [];
    
    while ($event = mysqli_fetch_assoc($events)) {
        $start = new DateTime($event['tanggal_mulai']);
        $end = new DateTime($event['tanggal_selesai']);
        $current = new DateTime($tanggal);
        
        if ($current >= $start && $current <= $end) {
            $event_hari[] = $event;
        }
    }
    
    // Reset pointer
    mysqli_data_seek($events, 0);
    
    return $event_hari;
}

// Fungsi untuk mendapatkan libur nasional (bisa dikustomisasi)
function getLiburNasional($tahun) {
    // Contoh libur nasional - bisa disesuaikan
    return [
        $tahun . '-01-01' => 'Tahun Baru',
        $tahun . '-08-17' => 'Hari Kemerdekaan RI',
        $tahun . '-12-25' => 'Hari Natal'
    ];
}

// Fungsi untuk mendapatkan cuti yang akan datang
if (!function_exists('getCutiMendatang')) {
    function getCutiMendatang($id_karyawan) {
        global $conn;
        
        $query = "SELECT c.*, jc.nama_cuti 
                  FROM cuti c 
                  LEFT JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id 
                  WHERE c.id_karyawan = ? 
                  AND c.tanggal_mulai > NOW() 
                  AND c.status IN ('menunggu', 'disetujui') 
                  ORDER BY c.tanggal_mulai ASC 
                  LIMIT 3";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_karyawan);
        mysqli_stmt_execute($stmt);
        
        return mysqli_stmt_get_result($stmt);
    }
}

// Fungsi untuk cek apakah tanggal adalah weekend
function isWeekend($tanggal) {
    $dayOfWeek = date('N', strtotime($tanggal));
    return ($dayOfWeek == 6 || $dayOfWeek == 7); // Saturday = 6, Sunday = 7
}
?>


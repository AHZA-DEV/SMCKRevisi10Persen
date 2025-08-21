
<?php
include_once 'config/koneksi.php';

// Fungsi untuk mengajukan cuti baru
function ajukanCuti($id_karyawan, $id_jenis_cuti, $tanggal_mulai, $tanggal_selesai, $alasan, $alamat_cuti = '') {
    global $conn;
    
    // Hitung jumlah hari cuti
    $start = new DateTime($tanggal_mulai);
    $end = new DateTime($tanggal_selesai);
    $interval = $start->diff($end);
    $jumlah_hari = $interval->days + 1;
    
    $query = "INSERT INTO cuti (id_karyawan, id_jenis_cuti, tanggal_mulai, tanggal_selesai, jumlah_hari, alasan, status) 
              VALUES (?, ?, ?, ?, ?, ?, 'menunggu')";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iississ", $id_karyawan, $id_jenis_cuti, $tanggal_mulai, $tanggal_selesai, $jumlah_hari, $alasan, $alamat_cuti);
    
    return mysqli_stmt_execute($stmt);
}

// Fungsi untuk mendapatkan daftar cuti karyawan
if (!function_exists('getCutiKaryawan')) {
    function getCutiKaryawan($id_karyawan) {
        global $conn;
        
        $query = "SELECT c.*, jc.nama_cuti, jc.maksimal_hari 
                  FROM cuti c 
                  LEFT JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id 
                  WHERE c.id_karyawan = ? 
                  ORDER BY c.created_at DESC";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_karyawan);
        mysqli_stmt_execute($stmt);
        
        return mysqli_stmt_get_result($stmt);
    }
}

// Fungsi untuk mendapatkan detail cuti berdasarkan ID
function getDetailCuti($id_cuti, $id_karyawan) {
    global $conn;
    
    $query = "SELECT c.*, jc.nama_cuti, jc.maksimal_hari 
              FROM cuti c 
              LEFT JOIN jenis_cuti jc ON c.id_jenis_cuti = jc.id 
              WHERE c.id = ? AND c.id_karyawan = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_cuti, $id_karyawan);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// Fungsi untuk update cuti (hanya jika status masih pending)
function updateCuti($id_cuti, $id_karyawan, $id_jenis_cuti, $tanggal_mulai, $tanggal_selesai, $alasan, $alamat_cuti = '') {
    global $conn;
    
    // Hitung jumlah hari cuti
    $start = new DateTime($tanggal_mulai);
    $end = new DateTime($tanggal_selesai);
    $interval = $start->diff($end);
    $jumlah_hari = $interval->days + 1;
    
    $query = "UPDATE cuti SET id_jenis_cuti = ?, tanggal_mulai = ?, tanggal_selesai = ?, jumlah_hari = ?, alasan = ?, alamat_cuti = ? 
              WHERE id = ? AND id_karyawan = ? AND status = 'menunggu'";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isssissi", $id_jenis_cuti, $tanggal_mulai, $tanggal_selesai, $jumlah_hari, $alasan, $alamat_cuti, $id_cuti, $id_karyawan);
    
    return mysqli_stmt_execute($stmt);
}

// Fungsi untuk membatalkan cuti (hanya jika status masih pending)
function batalkanCuti($id_cuti, $id_karyawan) {
    global $conn;
    
    $query = "UPDATE cuti SET status = 'ditolak' WHERE id = ? AND id_karyawan = ? AND status = 'menunggu'";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_cuti, $id_karyawan);
    
    return mysqli_stmt_execute($stmt);
}

// Fungsi untuk mendapatkan jenis cuti yang aktif
function getJenisCutiAktif() {
    global $conn;
    
    $query = "SELECT * FROM jenis_cuti ORDER BY nama_cuti";
    
    return mysqli_query($conn, $query);
}

// Fungsi untuk menghitung sisa cuti karyawan
function getSisaCuti($id_karyawan) {
    global $conn;
    
    $query = "SELECT COALESCE(SUM(jumlah_hari), 0) as total_digunakan 
              FROM cuti 
              WHERE id_karyawan = ? AND status = 'disetujui' 
              AND YEAR(tanggal_mulai) = YEAR(NOW())";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_karyawan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    $total_cuti = 12; // Default cuti tahunan
    return $total_cuti - $row['total_digunakan'];
}

// Fungsi untuk validasi tanggal cuti
function validateTanggalCuti($tanggal_mulai, $tanggal_selesai) {
    $today = new DateTime();
    $start = new DateTime($tanggal_mulai);
    $end = new DateTime($tanggal_selesai);
    
    // Tanggal mulai harus di masa depan
    if ($start <= $today) {
        return ['status' => false, 'message' => 'Tanggal mulai cuti harus setelah hari ini'];
    }
    
    // Tanggal selesai harus setelah tanggal mulai
    if ($end < $start) {
        return ['status' => false, 'message' => 'Tanggal selesai harus setelah tanggal mulai'];
    }
    
    return ['status' => true, 'message' => 'Valid'];
}
?>


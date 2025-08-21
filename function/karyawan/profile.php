<?php
include_once 'config/koneksi.php';

// Fungsi untuk mendapatkan data profile karyawan
function getProfileKaryawan($id_karyawan) {
    global $conn;

    $query = "SELECT k.*, d.nama_departemen 
              FROM karyawan k 
              LEFT JOIN departemen d ON k.id_departemen = d.id 
              WHERE k.id = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_karyawan);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $profile = mysqli_fetch_assoc($result);

    // Add null check for profile data
    if (!$profile) {
        $profile = [];
    }
    return $profile;
}

// Fungsi untuk update profile karyawan
function updateProfile($id_karyawan, $data) {
    global $conn;

    $query = "UPDATE karyawan SET 
              nama_depan = ?, 
              nama_belakang = ?, 
              email = ?, 
              no_telepon = ?, 
              alamat = ?, 
              tanggal_lahir = ? 
              WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", 
        $data['nama_depan'], 
        $data['nama_belakang'], 
        $data['email'], 
        $data['no_telepon'], 
        $data['alamat'], 
        $data['tanggal_lahir'], 
        $id_karyawan
    );

    return mysqli_stmt_execute($stmt);
}

// Fungsi untuk update password
function updatePassword($id_karyawan, $password_lama, $password_baru) {
    global $conn;

    // Verifikasi password lama
    $query = "SELECT password FROM karyawan WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_karyawan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if (!password_verify($password_lama, $user['password'])) {
        return ['status' => false, 'message' => 'Password lama tidak sesuai'];
    }

    // Update password baru
    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
    $query = "UPDATE karyawan SET password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $password_hash, $id_karyawan);

    if (mysqli_stmt_execute($stmt)) {
        return ['status' => true, 'message' => 'Password berhasil diubah'];
    } else {
        return ['status' => false, 'message' => 'Gagal mengubah password'];
    }
}

// Fungsi untuk upload foto profil
function updateFotoProfil($id_karyawan, $foto_path) {
    global $conn;

    $query = "UPDATE karyawan SET foto_profil = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $foto_path, $id_karyawan);

    return mysqli_stmt_execute($stmt);
}

// Fungsi untuk validasi email unique
function validateEmailUnique($email, $id_karyawan) {
    global $conn;

    $query = "SELECT id FROM karyawan WHERE email = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $email, $id_karyawan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_num_rows($result) == 0;
}

// Fungsi untuk mendapatkan riwayat aktivitas karyawan
function getRiwayatAktivitas($id_karyawan, $limit = 10) {
    global $conn;

    $query = "SELECT 
                'cuti' as tipe,
                CONCAT('Mengajukan cuti ', jc.nama_cuti) as aktivitas,
                c.created_at as tanggal,
                c.status
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

// Fungsi untuk mendapatkan statistik karyawan
function getStatistikKaryawan($id_karyawan) {
    global $conn;

    // Total cuti digunakan tahun ini
    $query1 = "SELECT COALESCE(SUM(jumlah_hari), 0) as total_cuti 
               FROM cuti 
               WHERE id_karyawan = ? AND status = 'disetujui' 
               AND YEAR(tanggal_mulai) = YEAR(NOW())";

    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "i", $id_karyawan);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    $cuti_data = mysqli_fetch_assoc($result1);

    // Total pengajuan cuti
    $query2 = "SELECT COUNT(*) as total_pengajuan 
               FROM cuti 
               WHERE id_karyawan = ?";

    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "i", $id_karyawan);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    $pengajuan_data = mysqli_fetch_assoc($result2);

    // Sisa cuti
    $sisa_cuti = 12 - $cuti_data['total_cuti'];

    return [
        'cuti_digunakan' => $cuti_data['total_cuti'],
        'sisa_cuti' => $sisa_cuti,
        'total_pengajuan' => $pengajuan_data['total_pengajuan']
    ];
}

// Dummy function definitions to resolve undefined function errors
// These should be replaced with actual implementations if they exist elsewhere
function getCutiKaryawan($id_karyawan) {
    // Placeholder: Replace with actual implementation
    // This function was called in pages/karyawan/cuti/view.php
    return []; 
}

function getCutiMendatang($id_karyawan) {
    // Placeholder: Replace with actual implementation
    // This function was called in pages/karyawan/kalender/view.php
    return [];
}

?>
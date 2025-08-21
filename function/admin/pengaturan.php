
<?php
include_once '../config/koneksi.php';

// ========== JENIS CUTI ==========
function getAllJenisCuti() {
    global $conn;
    
    $query = "SELECT * FROM jenis_cuti ORDER BY nama_cuti";
    return mysqli_query($conn, $query);
}

function getJenisCutiById($id) {
    global $conn;
    
    $query = "SELECT * FROM jenis_cuti WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}

function createJenisCuti($data) {
    global $conn;
    
    $query = "INSERT INTO jenis_cuti (nama_cuti, max_hari, deskripsi, is_active) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    
    $is_active = isset($data['is_active']) ? 1 : 0;
    
    mysqli_stmt_bind_param($stmt, "sisi", 
        $data['nama_cuti'], 
        $data['max_hari'], 
        $data['deskripsi'], 
        $is_active
    );
    
    return mysqli_stmt_execute($stmt);
}

function updateJenisCuti($id, $data) {
    global $conn;
    
    $query = "UPDATE jenis_cuti SET nama_cuti = ?, max_hari = ?, deskripsi = ?, is_active = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    $is_active = isset($data['is_active']) ? 1 : 0;
    
    mysqli_stmt_bind_param($stmt, "sisii", 
        $data['nama_cuti'], 
        $data['max_hari'], 
        $data['deskripsi'], 
        $is_active,
        $id
    );
    
    return mysqli_stmt_execute($stmt);
}

function deleteJenisCuti($id) {
    global $conn;
    
    // Cek apakah jenis cuti sedang digunakan
    $query = "SELECT COUNT(*) as count FROM cuti WHERE id_jenis_cuti = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_fetch_assoc($result)['count'];
    
    if ($count > 0) {
        return false; // Tidak bisa dihapus karena sedang digunakan
    }
    
    $query = "DELETE FROM jenis_cuti WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    return mysqli_stmt_execute($stmt);
}

// ========== PENGATURAN SISTEM ==========
function getSistemSettings() {
    global $conn;
    
    $query = "SELECT * FROM sistem_settings";
    $result = mysqli_query($conn, $query);
    
    $settings = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
    return $settings;
}

function updateSistemSetting($key, $value) {
    global $conn;
    
    $query = "INSERT INTO sistem_settings (setting_key, setting_value) VALUES (?, ?) 
              ON DUPLICATE KEY UPDATE setting_value = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $key, $value, $value);
    
    return mysqli_stmt_execute($stmt);
}

function getCompanyInfo() {
    global $conn;
    
    $query = "SELECT * FROM company_info LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    return mysqli_fetch_assoc($result);
}

function updateCompanyInfo($data) {
    global $conn;
    
    // Cek apakah data company sudah ada
    $check_query = "SELECT id FROM company_info LIMIT 1";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Update existing
        $row = mysqli_fetch_assoc($check_result);
        $query = "UPDATE company_info SET 
                    nama_perusahaan = ?, 
                    alamat = ?, 
                    telepon = ?, 
                    email = ?, 
                    logo = ? 
                  WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", 
            $data['nama_perusahaan'], 
            $data['alamat'], 
            $data['telepon'], 
            $data['email'], 
            $data['logo'],
            $row['id']
        );
    } else {
        // Insert new
        $query = "INSERT INTO company_info (nama_perusahaan, alamat, telepon, email, logo) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", 
            $data['nama_perusahaan'], 
            $data['alamat'], 
            $data['telepon'], 
            $data['email'], 
            $data['logo']
        );
    }
    
    return mysqli_stmt_execute($stmt);
}

function backupDatabase() {
    global $conn;
    
    // Implementasi backup database
    // Untuk sekarang return true sebagai placeholder
    return true;
}

function restoreDatabase($file_path) {
    global $conn;
    
    // Implementasi restore database
    // Untuk sekarang return true sebagai placeholder
    return true;
}
?>

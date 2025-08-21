
<?php
include 'function/karyawan/profile.php';

$id_karyawan = $_SESSION['user_id'];

// Handle photo upload
if (isset($_POST['upload_foto'])) {
    $upload_dir = 'uploads/profile/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $file = $_FILES['foto_profil'];
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    
    if (in_array($file_extension, $allowed_extensions) && $file['size'] <= 2097152) { // 2MB
        $filename = 'profile_' . $id_karyawan . '_' . time() . '.' . $file_extension;
        $filepath = $upload_dir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            if (updateFotoProfil($id_karyawan, $filepath)) {
                $_SESSION['message'] = 'Foto profil berhasil diubah';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Gagal menyimpan foto profil';
                $_SESSION['message_type'] = 'danger';
            }
        } else {
            $_SESSION['message'] = 'Gagal upload foto';
            $_SESSION['message_type'] = 'danger';
        }
    } else {
        $_SESSION['message'] = 'Format file tidak valid atau ukuran terlalu besar';
        $_SESSION['message_type'] = 'danger';
    }
    
    header('Location: dashboard.php?route=profile');
    exit();
}

// Handle password change
if (isset($_POST['ubah_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    
    if ($password_baru !== $konfirmasi_password) {
        $_SESSION['message'] = 'Konfirmasi password tidak sama';
        $_SESSION['message_type'] = 'danger';
    } else {
        $result = updatePassword($id_karyawan, $password_lama, $password_baru);
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = $result['status'] ? 'success' : 'danger';
    }
    
    header('Location: dashboard.php?route=profile');
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['upload_foto']) && !isset($_POST['ubah_password'])) {
    $data = [
        'nama_depan' => trim($_POST['nama_depan']),
        'nama_belakang' => trim($_POST['nama_belakang']),
        'email' => trim($_POST['email']),
        'no_telepon' => trim($_POST['no_telepon']),
        'alamat' => trim($_POST['alamat']),
        'tanggal_lahir' => $_POST['tanggal_lahir']
    ];
    
    // Validate email uniqueness
    if (!validateEmailUnique($data['email'], $id_karyawan)) {
        $_SESSION['message'] = 'Email sudah digunakan oleh karyawan lain';
        $_SESSION['message_type'] = 'danger';
    } else {
        if (updateProfile($id_karyawan, $data)) {
            $_SESSION['message'] = 'Profile berhasil diperbarui';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Gagal memperbarui profile';
            $_SESSION['message_type'] = 'danger';
        }
    }
    
    header('Location: dashboard.php?route=profile');
    exit();
}
?>

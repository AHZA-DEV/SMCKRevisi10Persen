
<?php
// session_start();

// Determine the correct path to koneksi.php based on where auth.php is called from
$config_path = '';
if (file_exists(__DIR__ . '/../config/koneksi.php')) {
    $config_path = __DIR__ . '/../config/koneksi.php';
} elseif (file_exists('config/koneksi.php')) {
    $config_path = 'config/koneksi.php';
} elseif (file_exists('../config/koneksi.php')) {
    $config_path = '../config/koneksi.php';
} elseif (file_exists('../../config/koneksi.php')) {
    $config_path = '../../config/koneksi.php';
} elseif (file_exists('../../../config/koneksi.php')) {
    $config_path = '../../../config/koneksi.php';
}

if ($config_path && file_exists($config_path)) {
    include_once $config_path;
} else {
    die('Error: Database configuration file not found.');
}

// Fungsi untuk login user
function login($email, $password) {
    global $conn;
    
    // Query untuk mendapatkan data user berdasarkan email
    $query = "SELECT id, nip, nama_depan, nama_belakang, email, password, peran, id_departemen, jabatan, foto_profil 
              FROM karyawan 
              WHERE email = ? OR nip = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nip'] = $user['nip'];
            $_SESSION['user_name'] = $user['nama_depan'] . ' ' . $user['nama_belakang'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['peran'];
            $_SESSION['user_departemen'] = $user['id_departemen'];
            $_SESSION['user_jabatan'] = $user['jabatan'];
            $_SESSION['user_foto'] = $user['foto_profil'];
            $_SESSION['is_logged_in'] = true;
            
            return [
                'status' => 'success',
                'message' => 'Login berhasil',
                'role' => $user['peran']
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Password salah'
            ];
        }
    } else {
        return [
            'status' => 'error',
            'message' => 'Email atau NIP tidak ditemukan'
        ];
    }
}

// Fungsi untuk logout
function logout() {
    session_start();
    session_unset();
    session_destroy();
    return [
        'status' => 'success',
        'message' => 'Logout berhasil'
    ];
}

// Fungsi untuk cek apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
}

// Fungsi untuk cek role user
function getUserRole() {
    return isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
}

// Fungsi untuk redirect berdasarkan role
function redirectByRole($role) {
    if ($role === 'admin') {
        header("Location: dashboard.php?route=dashboard");
    } else if ($role === 'karyawan') {
        header("Location: dashboard.php?route=karyawan-dashboard");
    } else {
        header("Location: login.php");
    }
    exit();
}

// Fungsi untuk proteksi halaman
function requireLogin() {
    if (!isLoggedIn()) {
        // Determine correct path to login.php based on current location
        $login_path = '';
        if (file_exists('login.php')) {
            $login_path = 'login.php';
        } elseif (file_exists('../login.php')) {
            $login_path = '../login.php';
        } elseif (file_exists('../../login.php')) {
            $login_path = '../../login.php';
        } elseif (file_exists('../../../login.php')) {
            $login_path = '../../../login.php';
        } else {
            $login_path = '/login.php'; // fallback to root
        }
        
        header("Location: $login_path");
        exit();
    }
}

// Fungsi untuk proteksi halaman admin
// function requireAdmin() {
//     requireLogin();
//     if (getUserRole() !== 'admin') {
//         // Redirect to karyawan dashboard if not admin
//         $karyawan_dashboard = '';
//         if (file_exists('pages/karyawan/dashboard/view.php')) {
//             $karyawan_dashboard = 'pages/karyawan/dashboard/view.php';
//         } elseif (file_exists('../karyawan/dashboard/view.php')) {
//             $karyawan_dashboard = '../karyawan/dashboard/view.php';
//         } elseif (file_exists('../../karyawan/dashboard/view.php')) {
//             $karyawan_dashboard = '../../karyawan/dashboard/view.php';
//         } else {
//             $karyawan_dashboard = '/pages/karyawan/dashboard/view.php';
//         }
        
//         header("Location: $karyawan_dashboard");
//         exit();
//     }
// }
?>

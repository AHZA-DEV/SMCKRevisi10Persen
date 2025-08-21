
<?php
// Handle route from GET parameter
if (isset($_GET['route'])) {
    $route = $_GET['route'];
    switch ($route) {
        case 'admin':
            include 'pages/admin/cuti/view.php';
            break;
        case 'about':
            include 'pages/about.php';
            break;
        case 'contact':
            include 'pages/contact.php';
            break;
        // ===========================================
        // Admin List Sidebar
        // Dashboard
        case 'dashboard':
            include "pages/admin/dashboard/view.php";
            break;

        // Karyawan
        case 'karyawan':
            include "pages/admin/karyawan/view.php";
            break;

        case 'addkaryawan':
            include "pages/admin/karyawan/create.php";
            break;

        case 'editkaryawan':
            include "pages/admin/karyawan/update.php";
            break;

        case 'deletekaryawan':
            include "pages/admin/karyawan/delete.php";
            break;

        // Departemen
        case 'departemen':
            include "pages/admin/departemen/view.php";
            break;

        case 'adddepartemen':
            include "pages/admin/departemen/create.php";
            break;

        case 'editdepartemen':
            include "pages/admin/departemen/update.php";
            break;

        case 'deletedepartemen':
            include "pages/admin/departemen/delete.php";
            break;

        // Cuti Admin
        case 'cuti':
            include "pages/admin/cuti/view.php";
            break;

        case 'detailcuti':
            include "pages/admin/cuti/detail.php";
            break;

        case 'setujuicuti':
            include "pages/admin/cuti/setujui.php";
            break;

        case 'tolakcuti':
            include "pages/admin/cuti/tolak.php";
            break;

        // Laporan
        case 'laporan':
            include "pages/admin/laporan/view.php";
            break;

        case 'cetaklaporan':
            include "pages/admin/laporan/cetak.php";
            break;

        case 'eksporlaporan':
            include "pages/admin/laporan/ekspor.php";
            break;
        
        case 'pengaturan':
            include "pages/admin/pengaturan/view.php";
            break;

        // ===========================================
        // Karyawan List Sidebar
        // Karyawan Pages
        case 'karyawan-dashboard':
            include "pages/karyawan/dashboard/view.php";
            break;

        case 'cuti-karyawan':
            include "pages/karyawan/cuti/view.php";
            break;

        case 'ajukancuti':
            include "pages/karyawan/cuti/ajukan.php";
            break;

        case 'updatecuti':
            include "pages/karyawan/cuti/update.php";
            break;

        case 'batalkancuti':
            include "pages/karyawan/cuti/batalkan.php";
            break;

        case 'kalender':
            include "pages/karyawan/kalender/view.php";
            break;

        case 'riwayat':
            include "pages/karyawan/riwayat/view.php";
            break;

        case 'rekappdf':
            include "pages/karyawan/riwayat/rekapPdf.php";
            break;

        case 'profile':
            include "pages/karyawan/profile/view.php";
            break;

        case 'editprofile':
            include "pages/karyawan/profile/update.php";
            break;
            
    }
}
?>

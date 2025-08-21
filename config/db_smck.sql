-- Membuat database
CREATE DATABASE IF NOT EXISTS db_smck;
USE db_smck;

-- Tabel departemen
CREATE TABLE departemen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_departemen VARCHAR(10) NOT NULL,
    nama_departemen VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel karyawan
CREATE TABLE karyawan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(20) UNIQUE NOT NULL,
    nama_depan VARCHAR(50) NOT NULL,
    nama_belakang VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    id_departemen INT,
    jabatan VARCHAR(100),
    tanggal_mulai_kerja DATE,
    no_telepon VARCHAR(20),
    alamat TEXT,
    peran ENUM('admin', 'karyawan') DEFAULT 'karyawan',
    sisa_cuti INT DEFAULT 12,
    foto_profil VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_departemen) REFERENCES departemen(id)
);

-- Tabel jenis_cuti
CREATE TABLE jenis_cuti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_cuti VARCHAR(10) NOT NULL,
    nama_cuti VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    maksimal_hari INT,
    is_dibayar BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel cuti
CREATE TABLE cuti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_karyawan INT NOT NULL,
    id_jenis_cuti INT NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    jumlah_hari INT NOT NULL,
    alasan TEXT NOT NULL,
    status ENUM('menunggu', 'disetujui', 'ditolak') DEFAULT 'menunggu',
    disetujui_oleh INT,
    disetujui_pada DATETIME,
    alasan_penolakan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_karyawan) REFERENCES karyawan(id),
    FOREIGN KEY (id_jenis_cuti) REFERENCES jenis_cuti(id),
    FOREIGN KEY (disetujui_oleh) REFERENCES karyawan(id)
);

-- Tabel notifikasi
CREATE TABLE notifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_karyawan INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    pesan TEXT NOT NULL,
    sudah_dibaca BOOLEAN DEFAULT FALSE,
    tautan VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_karyawan) REFERENCES karyawan(id)
);

-- Tabel sisa_cuti_tahunan
CREATE TABLE sisa_cuti_tahunan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_karyawan INT NOT NULL,
    tahun YEAR NOT NULL,
    sisa_cuti INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_karyawan) REFERENCES karyawan(id)
);

-- Tabel pengaturan_sistem
CREATE TABLE pengaturan_sistem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kunci_pengaturan VARCHAR(100) NOT NULL,
    nilai_pengaturan TEXT NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =============================================
-- DATA DUMMY
-- =============================================

-- Insert data departemen
INSERT INTO departemen (kode_departemen, nama_departemen, deskripsi) VALUES
('IT', 'Teknologi Informasi', 'Departemen yang menangani teknologi informasi dan sistem'),
('HRD', 'Sumber Daya Manusia', 'Departemen yang menangani sumber daya manusia'),
('KEU', 'Keuangan', 'Departemen yang menangani keuangan perusahaan'),
('MKT', 'Pemasaran', 'Departemen yang menangani pemasaran dan penjualan'),
('OPR', 'Operasional', 'Departemen yang menangani operasional perusahaan');

-- Insert data jenis cuti
INSERT INTO jenis_cuti (kode_cuti, nama_cuti, deskripsi, maksimal_hari, is_dibayar) VALUES
('CT001', 'Cuti Tahunan', 'Cuti tahunan karyawan', 12, TRUE),
('CT002', 'Cuti Sakit', 'Cuti karena sakit dengan surat dokter', 30, TRUE),
('CT003', 'Cuti Melahirkan', 'Cuti untuk melahirkan', 90, TRUE),
('CT004', 'Cuti Besar', 'Cuti besar setelah bekerja minimal 5 tahun', 60, TRUE),
('CT005', 'Cuti Penting', 'Cuti untuk keperluan penting (menikah, khitanan, dll)', 3, TRUE),
('CT006', 'Cuti Diluar Tanggungan', 'Cuti tanpa dibayar', 30, FALSE);

-- Insert data admin
INSERT INTO karyawan (nip, nama_depan, nama_belakang, email, password, id_departemen, jabatan, tanggal_mulai_kerja, peran, sisa_cuti) VALUES
('ADM001', 'Admin', 'Sistem', 'admin@perusahaan.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 'Administrator', '2020-01-01', 'admin', 12);

-- Insert data karyawan
INSERT INTO karyawan (nip, nama_depan, nama_belakang, email, password, id_departemen, jabatan, tanggal_mulai_kerja, no_telepon, alamat, sisa_cuti) VALUES
('KRY001', 'Budi', 'Santoso', 'budi.santoso@perusahaan.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'Programmer', '2021-03-15', '081234567890', 'Jl. Merdeka No. 10 Jakarta', 10),
('KRY002', 'Siti', 'Rahayu', 'siti.rahayu@perusahaan.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 'HR Staff', '2020-08-20', '081234567891', 'Jl. Sudirman No. 45 Jakarta', 8),
('KRY003', 'Ahmad', 'Fauzi', 'ahmad.fauzi@perusahaan.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, 'Accountant', '2019-05-10', '081234567892', 'Jl. Gatot Subroto No. 12 Jakarta', 5),
('KRY004', 'Dewi', 'Anggraini', 'dewi.anggraini@perusahaan.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4, 'Marketing Executive', '2022-01-25', '081234567893', 'Jl. Thamrin No. 8 Jakarta', 12);

-- Insert data cuti
INSERT INTO cuti (id_karyawan, id_jenis_cuti, tanggal_mulai, tanggal_selesai, jumlah_hari, alasan, status, disetujui_oleh, disetujui_pada) VALUES
(2, 1, '2023-06-01', '2023-06-05', 5, 'Liburan keluarga', 'disetujui', 1, '2023-05-25 10:30:00'),
(3, 2, '2023-07-10', '2023-07-12', 3, 'Sakit demam', 'disetujui', 1, '2023-07-09 14:15:00'),
(2, 1, '2023-08-15', '2023-08-18', 4, 'Acara keluarga', 'menunggu', NULL, NULL),
(4, 5, '2023-09-01', '2023-09-01', 1, 'Menikahkan adik', 'disetujui', 1, '2023-08-28 09:45:00'),
(5, 1, '2023-10-10', '2023-10-20', 11, 'Liburan panjang', 'ditolak', 1, '2023-10-05 16:20:00');

-- Insert data notifikasi
INSERT INTO notifikasi (id_karyawan, judul, pesan, sudah_dibaca, tautan) VALUES
(1, 'Pengajuan Cuti Baru', 'Budi Santoso mengajukan cuti pada tanggal 15-18 Agustus 2023', FALSE, '/admin/cuti.php'),
(2, 'Cuti Disetujui', 'Pengajuan cuti Anda pada tanggal 1-5 Juni 2023 telah disetujui', TRUE, '/karyawan/cuti/riwayat.php'),
(3, 'Cuti Disetujui', 'Pengajuan cuti sakit Anda pada tanggal 10-12 Juli 2023 telah disetujui', TRUE, '/karyawan/cuti/riwayat.php'),
(4, 'Cuti Disetujui', 'Pengajuan cuti penting Anda pada tanggal 1 September 2023 telah disetujui', FALSE, '/karyawan/cuti/riwayat.php'),
(5, 'Cuti Ditolak', 'Pengajuan cuti Anda pada tanggal 10-20 Oktober 2023 telah ditolak', FALSE, '/karyawan/cuti/riwayat.php');

-- Insert data sisa cuti tahunan
INSERT INTO sisa_cuti_tahunan (id_karyawan, tahun, sisa_cuti) VALUES
(2, 2023, 10),
(3, 2023, 8),
(4, 2023, 5),
(5, 2023, 12);

-- Insert data pengaturan sistem
INSERT INTO pengaturan_sistem (kunci_pengaturan, nilai_pengaturan, deskripsi) VALUES
('nama_perusahaan', 'PT. Contoh Perusahaan', 'Nama perusahaan'),
('alamat_perusahaan', 'Jl. Contoh No. 123, Jakarta', 'Alamat perusahaan'),
('max_cuti_tahunan', '12', 'Maksimal cuti tahunan per karyawan'),
('min_pemberitahuan_cuti', '3', 'Minimal hari pemberitahuan sebelum cuti'),
('masa_kerja_minimal', '1', 'Masa kerja minimal untuk cuti tahunan (tahun)'),
('email_admin', 'admin@perusahaan.com', 'Email administrator sistem');

-- Update alasan penolakan untuk cuti yang ditolak
UPDATE cuti SET alasan_penolakan = 'Kuota cuti tidak mencukupi untuk periode tersebut' WHERE id = 5;
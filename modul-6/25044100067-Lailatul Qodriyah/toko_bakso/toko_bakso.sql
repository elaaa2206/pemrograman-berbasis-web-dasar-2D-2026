CREATE DATABASE toko_bakso;
USE toko_bakso;

-- tabel user
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(100) UNIQUE,
    PASSWORD VARCHAR(255),
    ROLE ENUM('admin','user') DEFAULT 'user'
);

-- tabel menu bakso
CREATE TABLE menu_bakso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_menu VARCHAR(100),
    harga INT,
    stok INT,
    jenis VARCHAR(50),
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO menu_bakso (nama_menu, harga, stok, jenis, deskripsi) VALUES
('Bakso Urat', 15000, 20, 'Bakso', 'Bakso urat kuah gurih'),
('Bakso Halus', 12000, 25, 'Bakso', 'Bakso halus lembut dan enak'),
('Bakso Jumbo', 20000, 15, 'Bakso', 'Bakso ukuran jumbo isi daging'),
('Bakso Lava', 22000, 10, 'Bakso Pedas', 'Bakso isi sambal pedas'),
('Bakso Mercon', 25000, 12, 'Bakso Pedas', 'Bakso super pedas level tinggi'),
('Bakso Telur', 18000, 18, 'Bakso', 'Bakso isi telur ayam'),
('Mie Ayam Bakso', 17000, 20, 'Mie', 'Mie ayam dengan bakso'),
('Mie Yamin', 16000, 15, 'Mie', 'Mie manis gurih dengan topping ayam'),
('Pangsit Kuah', 14000, 20, 'Makanan', 'Pangsit kuah hangat'),
('Siomay', 13000, 25, 'Makanan', 'Siomay ikan saus kacang'),

('Es Teh', 5000, 50, 'Minuman', 'Es teh manis segar'),
('Teh Hangat', 4000, 40, 'Minuman', 'Teh hangat manis'),
('Es Jeruk', 7000, 35, 'Minuman', 'Jeruk segar dingin'),
('Jeruk Hangat', 6000, 30, 'Minuman', 'Jeruk hangat menyegarkan'),
('Es Milo', 10000, 20, 'Minuman', 'Milo dingin coklat'),
('Es Coklat', 9000, 25, 'Minuman', 'Minuman coklat segar'),
('Air Mineral', 4000, 50, 'Minuman', 'Air mineral botol'),
('Es Kopi', 12000, 15, 'Minuman', 'Es kopi susu'),
('Jus Alpukat', 15000, 10, 'Minuman', 'Jus alpukat creamy'),
('Jus Jeruk', 12000, 12, 'Minuman', 'Jus jeruk fresh');

CREATE TABLE pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    menu_id INT,
    jumlah INT,
    total_harga INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE pesanan
ADD STATUS ENUM('pending','selesai') DEFAULT 'pending';

ALTER TABLE pesanan
ADD pembayaran ENUM('belum_bayar','sudah_bayar')
DEFAULT 'belum_bayar';
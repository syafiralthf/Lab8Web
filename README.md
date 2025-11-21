# Lab8Web

NAMA: SYAFIRA LUTHFI AZZAHRA

NIM: 312410353

KELAS: TI.24.A.4

MATKUL: PEMROGRAMAN WEB 1

# Membuat Database

## Membuat Tabel

```php
CREATE TABLE data_barang (
  id_barang int(10) auto_increment Primary Key,
  kategori varchar(30),
  nama varchar(30),
  gambar varchar(100),
  harga_beli decimal(10,0),
  harga_jual decimal(10,0),
  stok int(4)
);
```

<img width="1514" height="704" alt="image" src="https://github.com/user-attachments/assets/08975146-28d5-4934-85c1-49064af9810d" />

Untuk mengisi tabel data_barang, digunakan perintah SQL INSERT yang fungsinya memasukkan data awal ke dalam database agar aplikasi memiliki contoh barang saat dijalankan. Pada praktikum ini dimasukkan tiga data produk elektronik berupa HP Samsung, HP Xiaomi, dan HP Oppo. Setiap data berisi kategori, nama barang, nama file gambar, harga beli, harga jual, dan jumlah stok. Nilai gambar diisi dengan nama file yang sesuai dengan file yang disimpan di folder gambar. Perintah INSERT ini dijalankan melalui menu SQL di phpMyAdmin, dan setelah berhasil dieksekusi, data langsung muncul di tabel sehingga dapat ditampilkan di halaman utama aplikasi CRUD.

## Menambahkan Data

```php
INSERT INTO data_barang (kategori, nama, gambar, harga_beli, harga_jual, stok)
VALUES ('Elektronik', 'HP Samsung Android', 'hp_samsung.png', 2000000, 2400000, 5),
('Elektronik', 'HP Xiaomi Android', 'hp_xiaomi.png', 3000000, 3700000, 5),
('Elektronik', 'HP Oppo Android', 'hp_oppo.png', 1700000, 2000000, 5);
```

<img width="1273" height="788" alt="image" src="https://github.com/user-attachments/assets/fb081101-d2f0-4913-8d02-f0f557e2584d" />

# Membuat Koneksi Database (koneksi.php)

```php
<?php 

$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db   = "latihan1"; 

$conn = mysqli_connect($host, $user, $pass, $db); 

if ($conn == false) {
    echo "Koneksi ke server gagal.";
    die();
} else {
    echo "Koneksi berhasil";
}

?>
```

Kode tersebut digunakan untuk membuat koneksi antara aplikasi PHP dengan database MySQL. Bagian awal mendefinisikan informasi server seperti host, username, password, dan nama database yang akan digunakan. Setelah itu, fungsi `mysqli_connect()` dipakai untuk mencoba menghubungkan PHP ke MySQL menggunakan data tersebut. Jika koneksi gagal, program akan menampilkan pesan “Koneksi ke server gagal.” dan menghentikan proses dengan `die()`. Sebaliknya, jika koneksi berhasil, maka akan muncul pesan “Koneksi berhasil”. File ini menjadi dasar agar halaman lain yang membutuhkan akses ke database dapat berjalan dengan benar.

<img width="693" height="372" alt="image" src="https://github.com/user-attachments/assets/9c065069-0844-40a7-9456-1ba71b33c05b" />

# Menampilkan Data (index.php)

```php
<?php 
include 'koneksi.php';

$sql = "SELECT * FROM data_barang";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Data Barang</h1>

    <a href="tambah.php" class="btn">+ Tambah Barang</a>

    <table>
        <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td>
                    <?php if ($row["gambar"] != ""): ?>
                        <img src="gambar/<?php echo $row["gambar"]; ?>" class="thumb">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?= $row["nama"] ?></td>
                <td><?= $row["kategori"] ?></td>
                <td><?= number_format($row["harga_beli"]) ?></td>
                <td><?= number_format($row["harga_jual"]) ?></td>
                <td><?= $row["stok"] ?></td>
                <td>
                    <a class="link" href="ubah.php?id=<?= $row['id_barang'] ?>">Ubah</a> |
                    <a class="link" href="hapus.php?id=<?= $row['id_barang'] ?>" onclick="return confirm('Hapus data?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>

    </table>

</div>

</body>
</html>
```

File `index.php` digunakan sebagai halaman utama untuk menampilkan seluruh data barang yang ada di dalam database. Pada bagian awal, file `koneksi.php` dipanggil untuk menghubungkan aplikasi dengan database lalu perintah SQL `SELECT * FROM data_barang` dijalankan untuk mengambil semua data dari tabel. Hasil query tersebut kemudian ditampilkan ke dalam tabel HTML melalui perulangan `while`, di mana setiap baris data ditampilkan lengkap dengan gambar, nama, kategori, harga beli, harga jual, dan stok. Jika barang memiliki gambar, file tersebut ditampilkan dari folder `gambar/`, dan jika tidak ada gambar maka akan ditampilkan tanda kosong. Selain itu, pada kolom aksi terdapat link untuk mengubah dan menghapus data sehingga halaman ini berfungsi sebagai fitur *Read* dalam proses CRUD.

* Menyertakan file `koneksi.php` agar bisa terhubung dengan database.
* Menjalankan query SQL `SELECT * FROM data_barang` untuk mengambil semua data barang.
* Menggunakan `mysqli_fetch_assoc()` untuk membaca data per baris dari hasil query.
* Menampilkan data dalam bentuk tabel HTML yang memuat gambar, nama, kategori, harga, dan stok.
* Mengecek apakah gambar tersedia; jika ada, gambar ditampilkan dari folder `gambar/`.
* Menggunakan `number_format()` agar tampilan harga lebih rapi.
* Menambahkan tombol Ubah dan Hapus untuk mengakses fitur edit dan delete berdasarkan `id_barang`.
* Menyediakan tombol Tambah Barang yang mengarah ke *tambah.php*.
* Berfungsi sebagai halaman utama dan bagian *Read* dalam operasi CRUD.

<img width="1919" height="864" alt="image" src="https://github.com/user-attachments/assets/61baacf1-68d7-40df-af8c-237958c689c4" />

# Menambahkan Data (tambah.php)

```php
<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if ($gambar != "") {
        move_uploaded_file($tmp, "gambar/$gambar");
    }

    mysqli_query($conn, "INSERT INTO data_barang (nama, kategori, harga_beli, harga_jual, stok, gambar)
    VALUES ('$nama','$kategori','$harga_beli','$harga_jual','$stok','$gambar')");

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Tambah Barang</h1>

    <form action="" method="post" enctype="multipart/form-data">

        <label>Nama Barang</label>
        <input type="text" name="nama" required>

        <label>Kategori</label>
        <select name="kategori">
            <option>Elektronik</option>
            <option>Komputer</option>
            <option>Hand Phone</option>
        </select>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli">

        <label>Harga Jual</label>
        <input type="number" name="harga_jual">

        <label>Stok</label>
        <input type="number" name="stok">

        <label>Gambar</label>
        <input type="file" name="gambar">

        <button type="submit" name="submit" class="btn">Simpan</button>

    </form>
</div>

</body>
</html>
```

Kode `tambah.php` berfungsi untuk menambahkan data barang baru ke dalam database. Saat form dikirim, data seperti nama, kategori, harga beli, harga jual, stok, dan gambar ditangkap menggunakan `$_POST` dan `$_FILES`. Jika pengguna memilih gambar, file tersebut dipindahkan dari folder sementara ke folder `gambar/` agar bisa ditampilkan pada halaman utama. Setelah semua data siap, perintah SQL `INSERT INTO data_barang` dijalankan untuk menyimpan data tersebut ke dalam tabel. Jika proses berhasil, halaman akan dialihkan kembali ke `index.php` sehingga pengguna dapat melihat data baru yang telah berhasil ditambahkan.

* File `koneksi.php` di-include untuk menghubungkan PHP dengan database.
* Data form seperti nama, kategori, harga beli, harga jual, dan stok diambil menggunakan `$_POST`.
* File gambar diambil melalui `$_FILES` dan dicek apakah ada file yang diupload.
* Jika ada gambar, file dipindahkan dari folder sementara ke folder `gambar/` menggunakan `move_uploaded_file()`.
* SQL `INSERT INTO data_barang` digunakan untuk menambahkan data baru ke tabel `data_barang`.
* Setelah berhasil menyimpan data, pengguna diarahkan kembali ke halaman `index.php` agar dapat melihat item yang baru ditambahkan.
* HTML menyediakan form input untuk memasukkan data barang lengkap beserta upload gambar.

<img width="1919" height="966" alt="image" src="https://github.com/user-attachments/assets/ed83f110-2d92-447c-9452-bb4b4edc4615" />

# Mengubah Data (ubah.php)

```php
<?php
include 'koneksi.php';

$id = $_GET['id'];
$q = mysqli_query($conn, "SELECT * FROM data_barang WHERE id_barang='$id'");
$data = mysqli_fetch_assoc($q);

if (isset($_POST['submit'])) {

    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];

    $gambar_baru = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if ($gambar_baru != "") {
        move_uploaded_file($tmp, "gambar/$gambar_baru");
        $g = $gambar_baru;
    } else {
        $g = $data['gambar'];
    }

    mysqli_query($conn,
        "UPDATE data_barang SET 
            nama='$nama',
            kategori='$kategori',
            harga_beli='$harga_beli',
            harga_jual='$harga_jual',
            stok='$stok',
            gambar='$g'
        WHERE id_barang='$id'"
    );

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ubah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Ubah Barang</h1>

    <form method="post" enctype="multipart/form-data">

        <label>Nama</label>
        <input type="text" name="nama" value="<?= $data['nama'] ?>">

        <label>Kategori</label>
        <select name="kategori">
            <option <?= ($data['kategori']=="Elektronik")?"selected":"" ?>>Elektronik</option>
            <option <?= ($data['kategori']=="Komputer")?"selected":"" ?>>Komputer</option>
            <option <?= ($data['kategori']=="Hand Phone")?"selected":"" ?>>Hand Phone</option>
        </select>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli" value="<?= $data['harga_beli'] ?>">

        <label>Harga Jual</label>
        <input type="number" name="harga_jual" value="<?= $data['harga_jual'] ?>">

        <label>Stok</label>
        <input type="number" name="stok" value="<?= $data['stok'] ?>">

        <label>Gambar</label>
        <input type="file" name="gambar">

        <button class="btn" name="submit">Simpan</button>

    </form>
</div>

</body>
</html>
```

File `ubah.php` digunakan untuk mengedit data barang yang sudah tersimpan di database. Ketika halaman ini dibuka, aplikasi mengambil data berdasarkan `id_barang` melalui parameter `id` di URL, lalu menampilkan nilai lama ke dalam form agar bisa diedit. Jika tombol simpan ditekan, data yang diinputkan oleh pengguna akan ditangkap menggunakan `$_POST`, termasuk nama, kategori, harga, dan stok. Untuk bagian gambar, kode mengecek apakah pengguna mengupload gambar baru; jika iya, file gambar dipindahkan ke folder `gambar/`, jika tidak, aplikasi tetap memakai gambar lama yang sudah ada di database. Setelah itu, perintah SQL `UPDATE data_barang` dijalankan untuk memperbarui data sesuai perubahan yang dilakukan. Jika pembaruan berhasil, halaman langsung diarahkan kembali ke `index.php` agar pengguna bisa melihat hasil edit pada daftar barang.

* Meng-*include* file `koneksi.php` untuk menghubungkan file dengan database.
* Mengambil `id_barang` dari URL menggunakan `$_GET['id']`.
* Menjalankan query `SELECT * FROM data_barang WHERE id_barang='$id'` untuk menampilkan data lama ke form.
* Saat tombol submit ditekan, semua input seperti nama, kategori, harga, dan stok diambil menggunakan `$_POST`.
* Mengecek apakah ada gambar baru yang diupload:
  * Jika ada, file disimpan ke folder `gambar/` dan nama file baru digunakan.
  * Jika tidak ada, gambar tetap memakai file lama dari database.
* Menjalankan query `UPDATE data_barang SET ...` untuk memperbarui data di database.
* Setelah update berhasil, halaman diarahkan ke `index.php`.
* HTML form menampilkan data lama agar mudah diedit oleh pengguna.

<img width="1919" height="951" alt="image" src="https://github.com/user-attachments/assets/769f6d98-4f31-42cc-b090-09992a517f62" />

# Menghapus Data (hapus.data)

```php
<?php
include 'koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM data_barang WHERE id_barang='$id'");

header("Location: index.php");
?>
```

File `hapus.php` berfungsi untuk menghapus data barang berdasarkan `id_barang` yang dikirim melalui URL. Ketika pengguna menekan tombol hapus, halaman ini menerima nilai `id` menggunakan `$_GET['id']`, lalu menjalankan perintah SQL `DELETE FROM data_barang` untuk menghapus baris data yang sesuai dari database. Setelah proses penghapusan selesai, halaman langsung diarahkan kembali ke `index.php` agar pengguna dapat melihat daftar barang terbaru tanpa data yang sudah dihapus. File ini adalah bagian dari fitur *Delete* dalam proses CRUD.

* Meng-*include* file `koneksi.php` untuk menghubungkan ke database.
* Mengambil `id_barang` dari URL menggunakan `$_GET['id']`.
* Menjalankan query SQL `DELETE FROM data_barang WHERE id_barang='$id'` untuk menghapus data.
* Tidak memerlukan form karena proses berjalan otomatis saat link hapus diklik.
* Setelah data terhapus, pengguna diarahkan kembali ke halaman `index.php`.
* Digunakan sebagai fitur *Delete* dalam sistem CRUD.

<img width="1479" height="858" alt="image" src="https://github.com/user-attachments/assets/d3e58c62-b298-4eae-8f84-f2a7237d01a3" />

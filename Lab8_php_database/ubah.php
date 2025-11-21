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
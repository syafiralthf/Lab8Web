<?php 
include ("koneksi.php");

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
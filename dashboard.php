<?php
session_start();
include 'config.php';
if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

// Tambah produk
if (isset($_POST['nama']) && isset($_POST['harga'])) {
    $stmt = $conn->prepare("INSERT INTO produk (nama, harga) VALUES (?, ?)");
    $stmt->bind_param("sd", $_POST['nama'], $_POST['harga']);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

// Hapus produk
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $conn->query("DELETE FROM produk WHERE id=$id");
    header("Location: dashboard.php");
    exit();
}

// Ambil semua produk
$produk = $conn->query("SELECT * FROM produk");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Selamat datang, <?php echo $_SESSION['login']; ?>! <a href="logout.php" class="btn btn-danger btn-sm float-end">Logout</a></h2>

    <h4 class="mt-4">Tambah Produk</h4>
    <form method="post" class="row g-3">
        <div class="col-md-5">
            <input type="text" name="nama" class="form-control" placeholder="Nama produk" required>
        </div>
        <div class="col-md-4">
            <input type="number" step="0.01" name="harga" class="form-control" placeholder="Harga" required>
        </div>
        <div class="col-md-3">
            <button class="btn btn-success">Tambah</button>
        </div>
    </form>

    <h4 class="mt-4">Daftar Produk</h4>
    <table class="table table-bordered">
        <tr><th>No</th><th>Nama</th><th>Harga</th><th>Aksi</th></tr>
        <?php $no=1; while($row = $produk->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= number_format($row['harga'], 2) ?></td>
            <td><a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

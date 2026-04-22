<?php
session_start();

/* =========================
   DATA DEFAULT
========================= */
if (!isset($_SESSION['data_buku'])) {
    $_SESSION['data_buku'] = [
        ['id'=>1,'judul'=>'Some Kind of Wonderful','penulis'=>'Winna Efendi','kategori'=>'Fiksi'],
        ['id'=>2,'judul'=>'Filosofi Teras','penulis'=>'Henry Manampiring','kategori'=>'Filsafat']
    ];
}

/* =========================
   CRUD PHP
========================= */
if (isset($_POST['tambah_buku'])) {
    $id = end($_SESSION['data_buku'])['id'] + 1;
    $_SESSION['data_buku'][] = [
        'id'=>$id,
        'judul'=>$_POST['judul_baru'],
        'penulis'=>$_POST['penulis_baru'],
        'kategori'=>$_POST['kategori_baru']
    ];
}

if (isset($_POST['hapus_buku'])) {
    foreach ($_SESSION['data_buku'] as $k=>$v) {
        if ($v['id'] == $_POST['id_hapus']) {
            unset($_SESSION['data_buku'][$k]);
        }
    }
    $_SESSION['data_buku'] = array_values($_SESSION['data_buku']);
}

/* =========================
   PAGE ROUTER
========================= */
$page = $_GET['page'] ?? 'home';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>OXSLIB SPACE</title>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">

<style>
body {
    margin:0;
    font-family:'Outfit',sans-serif;
    background:#0f172a;
    color:white;
}

/* NAVBAR */
nav {
    display:flex;
    justify-content:space-between;
    padding:15px 30px;
    background:#020617;
}

nav a {
    color:white;
    text-decoration:none;
    margin-right:15px;
}

nav a:hover { color:gold; }

/* CONTAINER */
.container {
    padding:30px;
}

/* CARD */
.card {
    background:#1e293b;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
}

/* TABLE */
table {
    width:100%;
    border-collapse:collapse;
}
th,td {
    padding:10px;
    border:1px solid #334155;
}

/* BUTTON */
button {
    padding:10px;
    border:none;
    background:gold;
    cursor:pointer;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav>
    <div>
        <a href="?page=home">Home</a>
        <a href="?page=katalog">Katalog</a>
        <a href="?page=php">Tugas PHP</a>
    </div>
</nav>

<div class="container">

<?php if($page=='home'): ?>

    <div class="card">
        <h1>📚 OXSLIB SPACE</h1>
        <p>Website perpustakaan digital modern</p>
    </div>

<?php elseif($page=='katalog'): ?>

    <div class="card">
        <h2>📖 Katalog Buku</h2>
        <ul>
            <li>HTML CSS JavaScript</li>
            <li>Pemrograman Web</li>
            <li>PHP & HTML</li>
        </ul>
    </div>

<?php elseif($page=='php'): ?>

    <div class="card">
        <h2>🔥 Tugas PHP</h2>

        <!-- LOOP -->
        <h3>Perulangan</h3>
        <?php
        for($i=1;$i<=10;$i++){
            echo "$i. Belajar PHP<br>";
        }
        ?>

        <!-- KALKULATOR -->
        <h3>Kalkulator</h3>
        <form method="POST">
            <input type="number" name="a" required>
            <input type="number" name="b" required>
            <select name="op">
                <option value="+">+</option>
                <option value="-">-</option>
            </select>
            <button name="hitung">Hitung</button>
        </form>

        <?php
        if(isset($_POST['hitung'])){
            $a=$_POST['a'];
            $b=$_POST['b'];
            $op=$_POST['op'];

            $hasil = ($op=='+') ? $a+$b : $a-$b;
            echo "<p>Hasil: $hasil</p>";
        }
        ?>

        <!-- LOGIN -->
        <h3>Login</h3>
        <form method="POST">
            <input type="text" name="u">
            <input type="password" name="p">
            <button name="login">Login</button>
        </form>

        <?php
        if(isset($_POST['login'])){
            if($_POST['u']=="admin" && $_POST['p']=="12345"){
                echo "Login sukses";
            } else {
                echo "Login gagal";
            }
        }
        ?>

        <!-- TABEL -->
        <h3>Database Buku</h3>
        <table>
            <tr>
                <th>ID</th><th>Judul</th><th>Penulis</th><th>Aksi</th>
            </tr>

            <?php foreach($_SESSION['data_buku'] as $b): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= $b['judul'] ?></td>
                <td><?= $b['penulis'] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id_hapus" value="<?= $b['id'] ?>">
                        <button name="hapus_buku">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- TAMBAH -->
        <h4>Tambah Buku</h4>
        <form method="POST">
            <input type="text" name="judul_baru" placeholder="Judul">
            <input type="text" name="penulis_baru" placeholder="Penulis">
            <input type="text" name="kategori_baru" placeholder="Kategori">
            <button name="tambah_buku">Tambah</button>
        </form>

    </div>

<?php endif; ?>

</div>

</body>
</html>

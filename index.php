<?php
session_start();

/* ============================
   DATA SESSION (DATABASE SEMENTARA)
============================ */
if (!isset($_SESSION['data_buku'])) {
    $_SESSION['data_buku'] = [
        ['id'=>1,'judul'=>'Some Kind of Wonderful','penulis'=>'Winna Efendi','kategori'=>'Fiksi'],
        ['id'=>2,'judul'=>'Filosofi Teras','penulis'=>'Henry Manampiring','kategori'=>'Filsafat']
    ];
}

/* ============================
   TAMBAH DATA
============================ */
if(isset($_POST['tambah_buku'])){
    $id = count($_SESSION['data_buku']) + 1;
    $_SESSION['data_buku'][] = [
        'id'=>$id,
        'judul'=>$_POST['judul'],
        'penulis'=>$_POST['penulis'],
        'kategori'=>$_POST['kategori']
    ];
}

/* ============================
   HAPUS DATA
============================ */
if(isset($_POST['hapus'])){
    foreach($_SESSION['data_buku'] as $key=>$b){
        if($b['id'] == $_POST['id']){
            unset($_SESSION['data_buku'][$key]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>OXSLIB SPACE</title>

<style>
body{
    font-family: Arial;
    background:#0f172a;
    color:white;
    margin:0;
}

/* NAVBAR */
nav{
    background:black;
    padding:15px;
}
nav a{
    color:white;
    margin-right:15px;
    cursor:pointer;
    text-decoration:none;
}

/* SECTION */
.section{
    display:none;
    padding:20px;
}
.active{
    display:block;
}

/* BOX */
.box{
    background:#1e293b;
    padding:20px;
    margin:20px 0;
    border-radius:10px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}
td,th{
    border:1px solid #444;
    padding:10px;
}
</style>

<script>
function showMenu(menu){
    document.querySelectorAll('.section').forEach(x=>x.classList.remove('active'));
    document.getElementById(menu).classList.add('active');
}
</script>

</head>

<body>

<!-- NAVBAR -->
<nav>
    <a onclick="showMenu('home')">Home</a>
    <a onclick="showMenu('katalog')">Katalog</a>
    <a onclick="showMenu('tugas')">Tugas PHP</a>
</nav>

<!-- HOME -->
<div id="home" class="section active">
    <h1>OXSLIB SPACE</h1>
    <p>Website perpustakaan digital</p>
</div>

<!-- KATALOG -->
<div id="katalog" class="section">
    <h2>Daftar Buku</h2>
    <ul>
        <li>HTML CSS JS</li>
        <li>Pemrograman Web</li>
        <li>PHP Dasar</li>
    </ul>
</div>

<!-- ============================
     TAB TUGAS PHP
============================ -->
<div id="tugas" class="section">

<!-- 1. LOOP -->
<div class="box">
<h3>1. Perulangan 1 - 100</h3>
<?php
for($i=1;$i<=100;$i++){
    echo "$i. Ini hari ke-$i belajar PHP <br>";
}
?>
</div>

<!-- 2. KALKULATOR -->
<div class="box">
<h3>2. Kalkulator</h3>
<form method="POST">
    <input type="number" name="a" required>
    <input type="number" name="b" required>
    <select name="op">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
    </select>
    <button name="hitung">Hitung</button>
</form>

<?php
if(isset($_POST['hitung'])){
    $a=$_POST['a'];
    $b=$_POST['b'];
    $op=$_POST['op'];

    if($op=='+') $h=$a+$b;
    elseif($op=='-') $h=$a-$b;
    elseif($op=='*') $h=$a*$b;
    elseif($op=='/') $h=$b!=0?$a/$b:"Error";

    echo "<p>Hasil: $h</p>";
}
?>
</div>

<!-- 3. LOGIN -->
<div class="box">
<h3>3. Login</h3>
<form method="POST">
    <input type="text" name="user">
    <input type="password" name="pass">
    <button name="login">Login</button>
</form>

<?php
if(isset($_POST['login'])){
    $u=$_POST['user'];
    $p=$_POST['pass'];

    if(empty($u)||empty($p)){
        echo "Input tidak lengkap";
    }elseif($u=="admin" && $p=="12345"){
        echo "Login sukses";
    }else{
        echo "Login gagal";
    }
}
?>
</div>

<!-- 4. CRUD -->
<div class="box">
<h3>4. CRUD Data Buku</h3>

<table>
<tr>
<th>ID</th><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Aksi</th>
</tr>

<?php foreach($_SESSION['data_buku'] as $b){ ?>
<tr>
<td><?= $b['id'] ?></td>
<td><?= $b['judul'] ?></td>
<td><?= $b['penulis'] ?></td>
<td><?= $b['kategori'] ?></td>
<td>
<form method="POST">
<input type="hidden" name="id" value="<?= $b['id'] ?>">
<button name="hapus">Hapus</button>
</form>
</td>
</tr>
<?php } ?>
</table>

<h4>Tambah Data</h4>
<form method="POST">
<input type="text" name="judul" placeholder="Judul" required>
<input type="text" name="penulis" placeholder="Penulis" required>
<input type="text" name="kategori" placeholder="Kategori" required>
<button name="tambah_buku">Tambah</button>
</form>

</div>

</div>

</body>
</html>

<?php
include 'koneksi.php';

// ==========================
// ERROR REPORT
// ==========================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ==========================
// TAMBAH DATA
// ==========================
if (isset($_POST['tambah'])) {

    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $sandi = mysqli_real_escape_string($koneksi, $_POST['sandi']);

    $query = "INSERT INTO users (nama, sandi) VALUES ('$nama', '$sandi')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo mysqli_error($koneksi);
    }
}

// ==========================
// HAPUS DATA
// ==========================
if (isset($_GET['hapus'])) {

    $id = (int)$_GET['hapus'];

    $query = "DELETE FROM users WHERE id=$id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo mysqli_error($koneksi);
    }
}

// ==========================
// AMBIL DATA EDIT
// ==========================
$editData = null;

if (isset($_GET['edit'])) {

    $id = (int)$_GET['edit'];

    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE id=$id");

    $editData = mysqli_fetch_assoc($result);
}

// ==========================
// UPDATE DATA
// ==========================
if (isset($_POST['update'])) {

    $id    = (int)$_POST['id'];
    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $sandi = mysqli_real_escape_string($koneksi, $_POST['sandi']);

    $query = "UPDATE users SET 
                nama='$nama',
                sandi='$sandi'
              WHERE id=$id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Data</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    min-height:100vh;
    background: linear-gradient(135deg, #0f172a, #1e293b, #312e81);
    padding:40px;
    color:white;
}

/* ========================= */
/* CONTAINER */
/* ========================= */

.container{
    max-width:1200px;
    margin:auto;
}

/* ========================= */
/* HEADER */
/* ========================= */

.header{
    margin-bottom:30px;
}

.header h1{
    font-size:40px;
    font-weight:700;
    margin-bottom:10px;
}

.header p{
    color:#cbd5e1;
}

/* ========================= */
/* GRID */
/* ========================= */

.grid{
    display:grid;
    grid-template-columns:350px 1fr;
    gap:25px;
}

@media(max-width:900px){

    .grid{
        grid-template-columns:1fr;
    }

}

/* ========================= */
/* CARD */
/* ========================= */

.card{
    background: rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(14px);
    border-radius:25px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

/* ========================= */
/* FORM */
/* ========================= */

.form-title{
    font-size:24px;
    margin-bottom:20px;
    font-weight:600;
}

.input-group{
    margin-bottom:18px;
}

.input-group label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    color:#e2e8f0;
}

.input-group input{
    width:100%;
    padding:14px;
    border:none;
    outline:none;
    border-radius:14px;
    background:rgba(255,255,255,0.1);
    color:white;
    font-size:15px;
}

.input-group input::placeholder{
    color:#cbd5e1;
}

/* ========================= */
/* BUTTON */
/* ========================= */

.btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    cursor:pointer;
    font-size:15px;
    font-weight:600;
    transition:0.3s;
}

.btn-primary{
    background:linear-gradient(135deg,#8b5cf6,#6366f1);
    color:white;
}

.btn-primary:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(99,102,241,0.4);
}

.btn-update{
    background:linear-gradient(135deg,#10b981,#059669);
    color:white;
}

.btn-update:hover{
    transform:translateY(-2px);
}

.btn-cancel{
    display:block;
    text-align:center;
    margin-top:12px;
    text-decoration:none;
    color:#cbd5e1;
}

/* ========================= */
/* TABLE */
/* ========================= */

.table-title{
    font-size:24px;
    margin-bottom:20px;
    font-weight:600;
}

.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:rgba(255,255,255,0.08);
}

th{
    padding:16px;
    text-align:left;
    color:#e2e8f0;
    font-size:14px;
}

td{
    padding:16px;
    border-top:1px solid rgba(255,255,255,0.08);
    color:#f1f5f9;
}

tr{
    transition:0.3s;
}

tbody tr:hover{
    background:rgba(255,255,255,0.05);
}

/* ========================= */
/* ACTION BUTTON */
/* ========================= */

.action{
    display:flex;
    gap:10px;
}

.edit-btn,
.delete-btn{
    padding:8px 14px;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    transition:0.3s;
}

.edit-btn{
    background:#3b82f6;
    color:white;
}

.edit-btn:hover{
    background:#2563eb;
}

.delete-btn{
    background:#ef4444;
    color:white;
}

.delete-btn:hover{
    background:#dc2626;
}

/* ========================= */
/* BADGE */
/* ========================= */

.badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:30px;
    background:rgba(139,92,246,0.2);
    color:#c4b5fd;
    font-size:13px;
}

/* ========================= */
/* GLOW */
/* ========================= */

.glow{
    position:fixed;
    width:400px;
    height:400px;
    border-radius:50%;
    background:#7c3aed;
    filter:blur(150px);
    opacity:0.3;
    z-index:-1;
}

.glow.one{
    top:-100px;
    left:-100px;
}

.glow.two{
    bottom:-100px;
    right:-100px;
}

</style>
</head>

<body>

<div class="glow one"></div>
<div class="glow two"></div>

<div class="container">

    <div class="header">
        <h1>Modern CRUD Users</h1>
        <p>PHP Native + MySQL dengan tampilan modern dan aesthetic</p>
    </div>

    <div class="grid">

        <!-- FORM -->
        <div class="card">

            <?php if($editData){ ?>

                <div class="form-title">Edit User</div>

                <form method="POST">

                    <input type="hidden" name="id" value="<?= $editData['id']; ?>">

                    <div class="input-group">
                        <label>Nama</label>
                        <input type="text"
                               name="nama"
                               value="<?= $editData['nama']; ?>"
                               required>
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <input type="text"
                               name="sandi"
                               value="<?= $editData['sandi']; ?>"
                               required>
                    </div>

                    <button type="submit"
                            name="update"
                            class="btn btn-update">
                        Update Data
                    </button>

                    <a href="index.php" class="btn-cancel">
                        Batal Edit
                    </a>

                </form>

            <?php } else { ?>

                <div class="form-title">Tambah User</div>

                <form method="POST">

                    <div class="input-group">
                        <label>Nama</label>
                        <input type="text"
                               name="nama"
                               placeholder="Masukkan nama..."
                               required>
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <input type="password"
                               name="sandi"
                               placeholder="Masukkan password..."
                               required>
                    </div>

                    <button type="submit"
                            name="tambah"
                            class="btn btn-primary">
                        Simpan Data
                    </button>

                </form>

            <?php } ?>

        </div>

        <!-- TABLE -->
        <div class="card">

            <div class="table-title">
                Data Users
            </div>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $data = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");

                    while($d = mysqli_fetch_assoc($data)){
                    ?>

                    <tr>

                        <td><?= $d['id']; ?></td>

                        <td><?= $d['nama']; ?></td>

                        <td><?= $d['sandi']; ?></td>

                        <td>
                            <span class="badge">
                                Active
                            </span>
                        </td>

                        <td>

                            <div class="action">

                                <a href="index.php?edit=<?= $d['id']; ?>"
                                   class="edit-btn">
                                   Edit
                                </a>

                                <a href="index.php?hapus=<?= $d['id']; ?>"
                                   class="delete-btn"
                                   onclick="return confirm('Yakin ingin hapus data ini?')">
                                   Hapus
                                </a>

                            </div>

                        </td>

                    </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>

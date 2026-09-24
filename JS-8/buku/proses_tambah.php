<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}


$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$isbn = trim($_POST['isbn'] ?? '');
$stok = $_POST['stok'] ?? '';
$kategori = trim($_POST['kategori'] ?? '');


$errors = [];


if ($judul === '') {
    $errors[] = 'Judul wajib diisi.';
}


if ($pengarang === '') {
    $errors[] = 'Pengarang wajib diisi.';
}


if (
    !is_numeric($tahun) ||
    $tahun < 1900 ||
    $tahun > 2026
) {
    $errors[] = 'Tahun harus di antara 1900-2026.';
}


if (
    !is_numeric($stok) ||
    $stok < 0
) {
    $errors[] = 'Stok tidak boleh negatif.';
}


if ($kategori === '') {
    $errors[] = 'Kategori wajib dipilih.';
}


if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => implode(' ', $errors)
    ];

    header('Location: tambah.php');
    exit;
}


try {

    $sql = "
        INSERT INTO buku
        (
            judul,
            pengarang,
            tahun,
            isbn,
            stok,
            kategori
        )
        VALUES
        (
            :judul,
            :pengarang,
            :tahun,
            :isbn,
            :stok,
            :kategori
        )
        RETURNING id
    ";


    $stmt = $pdo->prepare($sql);


    $stmt->execute([
        'judul' => $judul,
        'pengarang' => $pengarang,
        'tahun' => (int) $tahun,
        'isbn' => $isbn,
        'stok' => (int) $stok,
        'kategori' => $kategori
    ]);


    $_SESSION['flash'] = [
        'type' => 'success',
        'pesan' => 'Buku berhasil ditambahkan.'
    ];


    header('Location: list.php');
    exit;


} catch (PDOException $e) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Data buku gagal disimpan.'
    ];


    header('Location: tambah.php');
    exit;
}
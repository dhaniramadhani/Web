<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}


$nama = trim($_POST['nama'] ?? '');
$noAnggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');


$errors = [];


if ($nama === '') {
    $errors[] = 'Nama wajib diisi.';
}


if ($noAnggota === '') {
    $errors[] = 'No. Anggota wajib diisi.';
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
        INSERT INTO anggota
        (
            nama,
            no_anggota,
            alamat,
            no_hp
        )
        VALUES
        (
            :nama,
            :no_anggota,
            :alamat,
            :no_hp
        )
        RETURNING id
    ";


    $stmt = $pdo->prepare($sql);


    $stmt->execute([
        'nama' => $nama,
        'no_anggota' => $noAnggota,
        'alamat' => $alamat,
        'no_hp' => $noHp
    ]);


    $_SESSION['flash'] = [
        'type' => 'success',
        'pesan' => 'Anggota berhasil ditambahkan.'
    ];


    header('Location: list.php');
    exit;


} catch (PDOException $e) {

    if ($e->getCode() === '23505') {

        $pesan =
            'No. Anggota sudah digunakan.';

    } else {

        $pesan =
            'Data anggota gagal disimpan.';

    }


    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => $pesan
    ];


    header('Location: tambah.php');
    exit;
}
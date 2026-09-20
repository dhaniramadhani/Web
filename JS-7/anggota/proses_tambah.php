<?php

session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Location: tambah.php');

    exit;
}


$noAnggota =
    trim($_POST['no_anggota'] ?? '');

$nama =
    trim($_POST['nama'] ?? '');

$alamat =
    trim($_POST['alamat'] ?? '');

$noHp =
    trim($_POST['no_hp'] ?? '');


$errors = [];


if ($noAnggota === '') {

    $errors[] =
        "No. Anggota wajib diisi.";

}


if ($nama === '') {

    $errors[] =
        "Nama wajib diisi.";

}


if (!empty($errors)) {

    $_SESSION['flash'] = [

        'type' => 'error',

        'pesan' =>
            implode(' ', $errors)

    ];


    header('Location: tambah.php');

    exit;
}


if (!isset($_SESSION['anggota'])) {

    $_SESSION['anggota'] = [];

}


$_SESSION['anggota'][] = [

    'no_anggota' =>
        $noAnggota,

    'nama' =>
        $nama,

    'alamat' =>
        $alamat,

    'no_hp' =>
        $noHp

];


$_SESSION['flash'] = [

    'type' => 'success',

    'pesan' =>
        'Anggota berhasil ditambahkan.'

];


header('Location: list.php');

exit;
<?php

$q = "DELETE FROM aset WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>alert('Hapus Data Berhasil!')</script>";
    echo "<script>location.href = '?h=aset&id_jenis_aset=" . $_GET['id_jenis_aset'] . "&id_kategori_aset=" . $_GET['id_kategori_aset'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}

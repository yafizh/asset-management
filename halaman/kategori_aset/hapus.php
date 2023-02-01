<?php

$q = "DELETE FROM kategori_aset WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>alert('Hapus Data Berhasil!')</script>";
    echo "<script>location.href = '?h=kategori_aset';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}

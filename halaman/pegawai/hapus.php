<?php
if (
    $mysqli->query("DELETE FROM pegawai WHERE id=" . $_GET['id']) 
    && 
    $mysqli->query("DELETE FROM pengguna WHERE id=" . $_GET['id_pengguna'])) {
    echo "<script>alert('Hapus Data Berhasil!')</script>";
    echo "<script>location.href = '?h=pegawai';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}

<?php

$q = "DELETE FROM aset WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>alert('Hapus Data Berhasil!')</script>";
    echo "<script>location.href = '?h=aset_per_jenis_aset&id=" . $_GET['id_jenis_aset'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}

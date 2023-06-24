<?php
if ($mysqli->query("DELETE FROM aset_hilang WHERE id=" . $_GET['id'])) {
    echo "<script>alert('Hapus Data Berhasil!')</script>";
    echo "<script>location.href = '?h=aset_hilang';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}

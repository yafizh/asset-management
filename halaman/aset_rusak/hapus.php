<?php
$data = $mysqli->query("SELECT * FROM aset_rusak WHERE id=" . $_GET['id'])->fetch_assoc();
if ($mysqli->query("DELETE FROM aset_rusak WHERE id=" . $_GET['id']) && $mysqli->query("UPDATE aset SET status=1 WHERE id=" . $data['id_aset'])) {
    echo "<script>alert('Hapus Data Berhasil!')</script>";
    echo "<script>location.href = '?h=aset_rusak_per_kategori_aset&id=" . $_GET['id_kategori_aset'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}

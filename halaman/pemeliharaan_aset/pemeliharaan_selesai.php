<?php

$q = "UPDATE pemeliharaan_aset SET tanggal_selesai='" . Date('Y-m-d') . "' WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>alert('Pemeliharaan Aset Selesai!')</script>";
    echo "<script>location.href = '?h=detail_pemeliharaan_aset&id=" . $_GET['id'] . "';</script>";
} else {
    echo "<script>alert('Pemeliharaan Aset Belum Selesai!')</script>";
    die($mysqli->error);
}

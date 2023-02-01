<?php
$data = $mysqli->query("SELECT * FROM pemeliharaan_aset WHERE id=" . $_GET['id'])->fetch_assoc();
if ($mysqli->query("UPDATE pemeliharaan_aset SET tanggal_selesai='" . Date('Y-m-d') . "' WHERE id=" . $_GET['id']) && $mysqli->query("UPDATE aset SET status=1 WHERE id=" . $data['id_aset'])) {
    echo "<script>alert('Pemeliharaan Aset Selesai!')</script>";
    echo "<script>location.href = '?h=detail_pemeliharaan_aset&id=" . $_GET['id'] . "';</script>";
} else {
    echo "<script>alert('Pemeliharaan Aset Belum Selesai!')</script>";
    die($mysqli->error);
}

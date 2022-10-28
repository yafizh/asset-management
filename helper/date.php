<?php

const BULAN_DALAM_INDONESIA = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "July",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember"
];

const HARI_DALAM_INDONESIA = [
    "Minggu",
    "Senin",
    "Selasa",
    "Rabu",
    "Kamis",
    "Jumat",
    "Sabtu"
];

function tanggalIndonesiaString($date)
{
    $tanggal = explode('-', $date)[2];
    $bulan = explode('-', $date)[1];
    $tahun = explode('-', $date)[0];
    return HARI_DALAM_INDONESIA[Date("w", strtotime($date))] . ', ' . $tanggal . ' ' . BULAN_DALAM_INDONESIA[$bulan - 1] . ' ' . $tahun;
}

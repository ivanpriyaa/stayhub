<?php

function format_uang($angka)
{
    if ($angka >= 1000000000) {
        return number_format($angka / 1000000000, 1, ',', '.') . ' m';
    }

    if ($angka >= 1000000) {
        return number_format($angka / 1000000, 1, ',', '.') . ' jt';
    }

    if ($angka >= 1000) {
        return number_format($angka / 1000, 1, ',', '.') . ' rb';
    }

    return $angka;
}
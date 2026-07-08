<?php

function hitung_persen_diskon(float $subtotal): int
{
    if ($subtotal >= 50_000_000) return 20;
    if ($subtotal >= 25_000_000) return 12;
    if ($subtotal >= 15_000_000) return 7;
    if ($subtotal >= 5_000_000)  return 3;
    return 0;
}

function hitung_diskon(float $subtotal): float
{
    return $subtotal * hitung_persen_diskon($subtotal) / 100;
}


function hitung_biaya_jasa(float $total_harga): float
{
    if ($total_harga <= 10_000_000) {
        return $total_harga * 0.01; // 1%
    }
    return $total_harga * 0.02;     // 2%
}

function hitung_diskon_voucher(float $total_harga, string $voucher_code): float
{
    $vouchers = [
        'PROMO2025'   => 10,
        'PROMO2026'   => 15,
        'AKHIRTAHUN'  => 25,
    ];

    $kode = strtoupper(trim($voucher_code));
    $persen = $vouchers[$kode] ?? 0;

    return $total_harga * $persen / 100;
}

function hitung_free_mouse(float $total_harga): float
{
    return $total_harga > 15_000_000 ? 150_000 : 0;
}
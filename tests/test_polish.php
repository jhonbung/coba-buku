<?php

$cookieJar = tempnam(sys_get_temp_dir(), 'laracook');

// 1. GET login page
$ch = curl_init('http://127.0.0.1:8000/admin/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
$html = curl_exec($ch);
preg_match('/name="_token" value="([^"]+)"/', $html, $matches);
$token = $matches[1] ?? '';

// 2. Login
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/admin/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $token,
    'login' => 'bianca_admin',
    'password' => 'Notonegoro@2026!Royal',
]));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_exec($ch);

// 3. Test /admin/products with new fluid layout
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/admin/products');
curl_setopt($ch, CURLOPT_POST, false);
$resProducts = curl_exec($ch);

// 4. Test /admin
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/admin');
$resIndex = curl_exec($ch);
curl_close($ch);

$okProducts = (strpos($resProducts, 'CONTROL CENTER') !== false) && (strpos($resProducts, 'Tambah Produk Baru') !== false);
$okIndex = (strpos($resIndex, 'CONTROL CENTER') !== false) && (strpos($resIndex, 'Dashboard Ringkasan Toko') !== false);

echo "Admin Products: " . ($okProducts ? "OK (Fluid Topbar & High-Taste Applied)" : "FAILED") . "\n";
echo "Admin Index: " . ($okIndex ? "OK (Fluid Topbar & High-Taste Applied)" : "FAILED") . "\n";

@unlink($cookieJar);

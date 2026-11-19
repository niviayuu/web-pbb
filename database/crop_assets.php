<?php

$publicImg = __DIR__ . '/../public/images/';
if (!is_dir($publicImg)) {
    mkdir($publicImg, 0777, true);
}

// 1. Crop Bupati & Wakil Bupati from BERANDA-1.png
$beranda1Path = __DIR__ . '/../ui_ux_reference/BERANDA-1.png';
if (file_exists($beranda1Path)) {
    $img1 = imagecreatefrompng($beranda1Path);
    $w1 = imagesx($img1);
    $h1 = imagesy($img1);

    // Left side hero illustration is about 50% width
    $cropW = (int)($w1 * 0.52);
    $hero = imagecrop($img1, ['x' => 0, 'y' => 0, 'width' => $cropW, 'height' => $h1]);
    if ($hero !== false) {
        imagepng($hero, $publicImg . 'bupati-hero.png');
        imagedestroy($hero);
    }

    // Logo on top left
    $logo = imagecrop($img1, ['x' => (int)($w1 * 0.02), 'y' => (int)($h1 * 0.03), 'width' => (int)($w1 * 0.16), 'height' => (int)($h1 * 0.09)]);
    if ($logo !== false) {
        imagepng($logo, $publicImg . 'bapenda-logo.png');
        imagedestroy($logo);
    }
    imagedestroy($img1);
}

// 2. Crop Banner from BERANDA.png
$berandaPath = __DIR__ . '/../ui_ux_reference/BERANDA.png';
if (file_exists($berandaPath)) {
    $imgB = imagecreatefrompng($berandaPath);
    $wb = imagesx($imgB);
    $hb = imagesy($imgB);

    // Banner is located at roughly x: 18%, y: 6.5%, w: 46%, h: 10%
    $banner = imagecrop($imgB, ['x' => (int)($wb * 0.175), 'y' => (int)($hb * 0.07), 'width' => (int)($wb * 0.465), 'height' => (int)($hb * 0.11)]);
    if ($banner !== false) {
        imagepng($banner, $publicImg . 'banner-peta.png');
        imagedestroy($banner);
    }
    imagedestroy($imgB);
}

// 3. Crop News thumbnails from Informasi -- DONE.png
$infoPath = __DIR__ . '/../ui_ux_reference/Informasi -- DONE.png';
if (file_exists($infoPath)) {
    $imgI = imagecreatefrompng($infoPath);
    $wi = imagesx($imgI);
    $hi = imagesy($imgI);

    // News item 1 thumbnail
    $n1 = imagecrop($imgI, ['x' => (int)($wi * 0.193), 'y' => (int)($hi * 0.365), 'width' => (int)($wi * 0.105), 'height' => (int)($hi * 0.125)]);
    if ($n1 !== false) {
        imagejpeg($n1, $publicImg . 'berita-1.jpg', 90);
        imagedestroy($n1);
    }
    // News item 2 thumbnail
    $n2 = imagecrop($imgI, ['x' => (int)($wi * 0.193), 'y' => (int)($hi * 0.525), 'width' => (int)($wi * 0.105), 'height' => (int)($hi * 0.125)]);
    if ($n2 !== false) {
        imagejpeg($n2, $publicImg . 'berita-2.jpg', 90);
        imagedestroy($n2);
    }
    // News item 3 thumbnail
    $n3 = imagecrop($imgI, ['x' => (int)($wi * 0.193), 'y' => (int)($hi * 0.678), 'width' => (int)($wi * 0.105), 'height' => (int)($hi * 0.125)]);
    if ($n3 !== false) {
        imagejpeg($n3, $publicImg . 'berita-3.jpg', 90);
        imagedestroy($n3);
    }
    imagedestroy($imgI);
}

echo "Extracted assets successfully into public/images/\n";


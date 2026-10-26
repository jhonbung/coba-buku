<?php
// Script to generate luxury SVGs for Bianca Veana Bookstore

$dir = __DIR__ . '/../../public/images';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

function makeCover($title, $subtitle, $series, $bgGradStart, $bgGradEnd, $accentColor = '#C6A16B', $motif = 'swan') {
    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 900" width="100%" height="100%">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$bgGradStart}"/>
      <stop offset="50%" stop-color="#172B49"/>
      <stop offset="100%" stop-color="{$bgGradEnd}"/>
    </linearGradient>
    <linearGradient id="gold" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#F5E6C8"/>
      <stop offset="35%" stop-color="#C6A16B"/>
      <stop offset="70%" stop-color="#DFBA7D"/>
      <stop offset="100%" stop-color="#99773D"/>
    </linearGradient>
    <filter id="shadow" x="-10%" y="-10%" width="120%" height="120%">
      <feDropShadow dx="0" dy="8" stdDeviation="12" flood-color="#000000" flood-opacity="0.45"/>
    </filter>
  </defs>

  <!-- Background -->
  <rect width="600" height="900" fill="url(#bg)"/>

  <!-- Subtle Texture Grid -->
  <rect width="600" height="900" fill="none" stroke="rgba(198,161,107,0.06)" stroke-width="1"/>

  <!-- Luxury Borders -->
  <rect x="25" y="25" width="550" height="850" fill="none" stroke="url(#gold)" stroke-width="2" opacity="0.85"/>
  <rect x="35" y="35" width="530" height="830" fill="none" stroke="rgba(244,235,221,0.25)" stroke-width="1"/>
  
  <!-- Corner Ornaments -->
  <g stroke="url(#gold)" stroke-width="1.5" fill="none" opacity="0.9">
    <path d="M 35 65 L 65 65 L 65 35"/>
    <circle cx="65" cy="65" r="3" fill="#C6A16B"/>
    <path d="M 565 65 L 535 65 L 535 35"/>
    <circle cx="535" cy="65" r="3" fill="#C6A16B"/>
    <path d="M 35 835 L 65 835 L 65 865"/>
    <circle cx="65" cy="835" r="3" fill="#C6A16B"/>
    <path d="M 565 835 L 535 835 L 535 865"/>
    <circle cx="535" cy="835" r="3" fill="#C6A16B"/>
  </g>

  <!-- Royal Arch / Frame -->
  <path d="M 120 280 C 120 180, 480 180, 480 280 L 480 620 C 480 720, 120 720, 120 620 Z" fill="rgba(11,21,38,0.4)" stroke="url(#gold)" stroke-width="1.5"/>

  <!-- Top Brand Tag -->
  <text x="300" y="100" font-family="'Playfair Display', serif" font-size="14" letter-spacing="6" fill="#F4EBDD" text-anchor="middle" font-weight="600">BIANCA VEANA UNIVERSE</text>
  <line x1="220" y1="115" x2="380" y2="115" stroke="url(#gold)" stroke-width="1" opacity="0.7"/>

  <!-- Series Badge -->
  <text x="300" y="160" font-family="'Montserrat', sans-serif" font-size="12" letter-spacing="3" fill="#C6A16B" text-anchor="middle" font-weight="500">{$series}</text>

  <!-- Central Crest / Motif -->
  <g transform="translate(300, 390)" stroke="url(#gold)" fill="none" stroke-width="2">
    <!-- Royal Swan & Crown -->
    <circle cx="0" cy="0" r="80" stroke="rgba(198,161,107,0.3)" stroke-width="1"/>
    <circle cx="0" cy="0" r="95" stroke="rgba(198,161,107,0.15)" stroke-dasharray="4,6"/>
    <!-- Crown -->
    <path d="M -30 -35 L -45 -10 L -15 -18 L 0 -42 L 15 -18 L 45 -10 L 30 -35 Z" fill="url(#gold)" opacity="0.8"/>
    <!-- Swan shape -->
    <path d="M -15 25 C -35 15, -40 -15, -20 -15 C -10 -15, -5 -5, 0 10 C 5 25, 25 25, 35 10 C 40 0, 30 -10, 20 -5 C 28 -5, 32 5, 25 15 C 15 28, -5 35, -15 25 Z" fill="#F4EBDD" opacity="0.95"/>
    <!-- Flourish -->
    <path d="M -70 50 Q 0 80 70 50" stroke="url(#gold)" stroke-width="1.5"/>
  </g>

  <!-- Book Title -->
  <text x="300" y="550" font-family="'Playfair Display', serif" font-size="46" letter-spacing="4" fill="url(#gold)" text-anchor="middle" font-weight="700" filter="url(#shadow)">{$title}</text>
  
  <!-- Subtitle -->
  <text x="300" y="590" font-family="'Montserrat', sans-serif" font-size="13" letter-spacing="2" fill="#E7D8C2" text-anchor="middle" opacity="0.9">{$subtitle}</text>

  <line x1="180" y1="640" x2="420" y2="640" stroke="url(#gold)" stroke-width="1" opacity="0.6"/>

  <!-- Author Name -->
  <text x="300" y="740" font-family="'Playfair Display', serif" font-size="18" letter-spacing="5" fill="#FFFFFF" text-anchor="middle" font-weight="600">A NOVEL BY</text>
  <text x="300" y="775" font-family="'Playfair Display', serif" font-size="24" letter-spacing="6" fill="url(#gold)" text-anchor="middle" font-weight="700">BIANCA VEANA</text>
  
  <!-- Bottom Seal -->
  <text x="300" y="830" font-family="'Montserrat', sans-serif" font-size="10" letter-spacing="3" fill="#E7D8C2" text-anchor="middle" opacity="0.6">EXCLUSIVE ROYAL EDITION</text>
</svg>
SVG;
    return $svg;
}

$covers = [
    'mantra.svg' => ['MANTRA', 'NOTONEGORO SERIES I', 'THE SEVEN NOTONEGORO', '#0e1d33', '#1b3252'],
    'hierarchy.svg' => ['HIERARCHY', 'NOTONEGORO SERIES II', 'THE SEVEN NOTONEGORO', '#162238', '#294b78'],
    'fate.svg' => ['FATE', 'NOTONEGORO SERIES III', 'NEW PRE-ORDER NOVEL', '#0b1626', '#1c365d'],
    'serenity.svg' => ['SERENITY', 'NOTONEGORO SERIES IV', 'THE SEVEN NOTONEGORO', '#1a273b', '#203a5c'],
    'beauty_in_madness.svg' => ['BEAUTY IN MADNESS', 'A STANDALONE NOVEL', 'DARK ROMANCE SPECIAL', '#14141d', '#2b1b2a'],
    'mantra_boxset.svg' => ['MANTRA BOXSET', 'ROYAL COLLECTOR BOX', 'SPECIAL LIMITED EDITION', '#1a1824', '#382b4a'],
    'ebook_mantra.svg' => ['MANTRA (E-BOOK)', 'DIGITAL COMPLETE NOVEL', 'INSTANT READ & DOWNLOAD', '#101c2e', '#233d61'],
    'ebook_chapter1.svg' => ['MANTRA BAB 1-5', 'SERIAL DIGITAL CHAPTER', 'SAMPLE EDITION', '#122033', '#1d3454'],
    'ebook_hierarchy.svg' => ['HIERARCHY (E-BOOK)', 'DIGITAL COMPLETE NOVEL', 'INSTANT READ & DOWNLOAD', '#111e33', '#25446e'],
    'ebook_fate.svg' => ['FATE (DIGITAL PO)', 'DIGITAL EARLY ACCESS', 'PRE-ORDER NOVEL', '#0f1a2b', '#2a4870'],
    'merch_bookmark.svg' => ['GOLD BOOKMARK', 'ROYAL LOTUS & WAX SEAL', 'EXCLUSIVE MERCHANDISE', '#1a2433', '#2a3d54'],
    'merch_candle.svg' => ['SCENTED CANDLE', 'PALACE AMBER & WOOD', 'EXCLUSIVE MERCHANDISE', '#1e2430', '#3b3945'],
    'merch_totebag.svg' => ['ROYAL TOTE BAG', 'EMBROIDERED GOLD SWAN', 'EXCLUSIVE MERCHANDISE', '#132133', '#1e3857'],
];

foreach ($covers as $file => $data) {
    file_put_contents("$dir/$file", makeCover($data[0], $data[1], $data[2], $data[3], $data[4]));
}

echo "Successfully generated all luxury SVG graphics.\n";

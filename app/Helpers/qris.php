<?php

if (!function_exists('crc16_qris')) {
    function crc16_qris($data) {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($data); $i++) {
            $x = (($crc >> 8) ^ ord($data[$i])) & 0xFF;
            $x ^= $x >> 4;
            $crc = (($crc << 8) ^ ($x << 12) ^ ($x << 5) ^ $x) & 0xFFFF;
        }
        return str_pad(strtoupper(dechex($crc)), 4, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('generate_qris_dynamic')) {
    function generate_qris_dynamic($amount) {
        // Static JagoSkill QRIS payload decoded from the image
        $staticQris = '00020101021126570011ID.DANA.WWW011893600915382314742002098231474200303UMI51440014ID.CO.QRIS.WWW0215ID10253714711820303UMI5204549953033605802ID5915Anugerah Store 6012Kab. Pangkep6105906536304486A';

        // 1. Strip the last 4 CRC characters (e.g. "486A")
        $base = substr($staticQris, 0, -4);

        // 2. Change 010211 (static) to 010212 (dynamic)
        $base = str_replace('010211', '010212', $base);

        // 3. Format amount: 54 + [length of amount] + [amount]
        $amountStr = (string) round($amount);
        $amountLength = str_pad(strlen($amountStr), 2, '0', STR_PAD_LEFT);
        $amountTag = '54' . $amountLength . $amountStr;

        // 4. QRIS specs require the amount tag (54) to be inserted before country code tag (58).
        // Let's locate '5802ID' (which is Tag 58, length 02, value ID)
        $pos = strpos($base, '5802ID');
        if ($pos !== false) {
            $base = substr($base, 0, $pos) . $amountTag . substr($base, $pos);
        } else {
            // Fallback: append it before tag 63
            $pos63 = strpos($base, '6304');
            if ($pos63 !== false) {
                $base = substr($base, 0, $pos63) . $amountTag . substr($base, $pos63);
            }
        }

        // 5. Calculate new CRC16 checksum
        $newCrc = crc16_qris($base);

        // 6. Return full dynamic QRIS payload
        return $base . $newCrc;
    }
}

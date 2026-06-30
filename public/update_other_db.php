<?php
$host = 'mysql';
$db   = 'jagoskill_local';
$user = 'jagoskill';
$pass = 'jagoskill';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$settingsToEnable = [
    'forum_general_settings',
    'attendances_settings',
    'certificate_settings'
];

foreach ($settingsToEnable as $sName) {
    $stmt = $pdo->prepare("SELECT id FROM settings WHERE name = ?");
    $stmt->execute([$sName]);
    $setting = $stmt->fetch();
    
    if (!$setting) {
        $pdo->prepare("INSERT INTO settings (name, page) VALUES (?, 'general')")->execute([$sName]);
        $settingId = $pdo->lastInsertId();
    } else {
        $settingId = $setting['id'];
    }
    
    $stmt = $pdo->prepare("SELECT id, value FROM setting_translations WHERE setting_id = ?");
    $stmt->execute([$settingId]);
    $translations = $stmt->fetchAll();
    
    if (empty($translations)) {
        $val = json_encode(['status' => '1']);
        $pdo->prepare("INSERT INTO setting_translations (setting_id, locale, value) VALUES (?, 'en', ?)")->execute([$settingId, $val]);
        $pdo->prepare("INSERT INTO setting_translations (setting_id, locale, value) VALUES (?, 'id', ?)")->execute([$settingId, $val]);
    } else {
        foreach ($translations as $row) {
            $val = json_decode($row['value'], true) ?: [];
            $val['status'] = '1';
            $val['status'] = true;
            $newVal = json_encode($val);
            $pdo->prepare("UPDATE setting_translations SET value = ? WHERE id = ?")->execute([$newVal, $row['id']]);
        }
    }
}

echo "Other settings updated via PDO!\n";

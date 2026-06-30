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

$stmt = $pdo->prepare("SELECT id FROM settings WHERE name = 'features'");
$stmt->execute();
$setting = $stmt->fetch();

if (!$setting) {
    echo "Settings 'features' not found.\n";
    exit;
}

$stmt = $pdo->prepare("SELECT value FROM setting_translations WHERE setting_id = ?");
$stmt->execute([$setting['id']]);
$translations = $stmt->fetchAll();

foreach ($translations as $row) {
    $val = json_decode($row['value'], true);
    
    $val['upcoming_courses_status'] = '1';
    $val['course_bundle_status'] = '1';
    $val['quiz_status'] = '1';
    $val['certificate_status'] = '1';
    $val['webinar_assignment_status'] = '1';
    $val['course_forum_status'] = '1';
    $val['course_notes_status'] = '1';
    $val['course_notices_status'] = '1';
    $val['enrollment_status'] = '1';
    $val['waitlist_status'] = '1';
    $val['attendance_status'] = '1';
    
    $newVal = json_encode($val);
    
    $updateStmt = $pdo->prepare("UPDATE setting_translations SET value = ? WHERE setting_id = ? AND value = ?");
    $updateStmt->execute([$newVal, $setting['id'], $row['value']]);
}

echo "Features updated via PDO!\n";

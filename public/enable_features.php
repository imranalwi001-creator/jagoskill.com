<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$setting = \App\Models\Setting::where('name', 'features')->first();
$value = json_decode($setting->value, true);

// Enable the features
$features_to_enable = [
    'upcoming_courses_status' => '1',
    'course_bundle_status' => '1',
    'quiz_status' => '1',
    'certificate_status' => '1',
    'webinar_assignment_status' => '1',
    'course_forum_status' => '1',
    'course_notes_status' => '1', // Course Notices? No, notes. Wait, course notices. Let me check the exact key.
    'enrollment_status' => '1', 
    'waitlist_status' => '1',
    'attendance_status' => '1'
];

foreach ($features_to_enable as $key => $val) {
    $value[$key] = $val;
}

$setting->value = json_encode($value);
$setting->save();

echo "Features enabled successfully!";

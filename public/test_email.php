<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    Mail::raw('SMTP test mail from JagoSkill', function($message) {
        $message->to('layanan@jagoskill.com')->subject('JagoSkill Test SMTP');
    });
    echo "Email sent successfully!\n";
} catch (\Exception $e) {
    echo "Error sending email: " . $e->getMessage() . "\n";
}

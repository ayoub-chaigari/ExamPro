<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Mail::raw('This is a test email.', function (Message $message) {
        $message->to('test@example.com')
                ->subject('Test Email');
    });
    echo "Mail.php success\n";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}

<?php

namespace App\Services\System;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AlertService
{
    public function sendFailedJobAlert(array $jobData): void
    {
        $subject = 'Failed Job Alert - ' . now()->format('Y-m-d H:i:s');
        $message = $this->formatFailedJobMessage($jobData);

        // ส่ง email
        $this->sendEmailAlert($subject, $message);

        // ส่งไปยัง channel อื่น ๆ ได้ที่นี่
        $this->sendLineAlert($message);
    }

    protected function formatFailedJobMessage(array $jobData): string
    {
        return "Failed Job Alert:\n" .
               "Job ID: {$jobData['id']}\n" .
               "Connection: {$jobData['connection']}\n" .
               "Queue: {$jobData['queue']}\n" .
               "Exception: {$jobData['exception']}\n" .
               "Failed At: {$jobData['failed_at']}\n";
    }

    protected function sendEmailAlert(string $subject, string $message): void
    {
        // สมมุติว่ามี admin email อยู่ใน config
        $adminEmail = config('app.admin_email', 'admin@example.com');

        try {
            Mail::raw($message, function ($mail) use ($adminEmail, $subject) {
                $mail->to($adminEmail)->subject($subject);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send email alert', ['error' => $e->getMessage()]);
        }
    }

    protected function sendLineAlert(string $message): void
    {
        $lineToken = config('services.line.notify_token');
        if ($lineToken) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://notify-api.line.me/api/notify');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'message=' . urlencode($message));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $lineToken,
                'Content-Type: application/x-www-form-urlencoded'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }
}

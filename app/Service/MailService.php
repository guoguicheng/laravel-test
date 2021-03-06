<?php

namespace App\Service;

use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * 发送文本邮件
     *
     * @param string $email
     * @param string $title
     * @param string $msg
     * @return boolean
     */
    public function sendEmail(string $email, string $title, string $msg): bool
    {
        // 纯文本信息邮件测试
        Mail::raw($msg, function ($message) use ($email, $title) {
            $to = $email;
            $message->to($to)->subject($title);
        });
        if (count(Mail::failures()) < 1) {
            return true;
        } else {
            return false;
        }
    }
}

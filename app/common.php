<?php
// 应用公共文件

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use think\facade\Db;

if (!function_exists('send_email')) {
    /**
     * 发送邮件
     * @param string $to 收件人邮箱
     * @param string $subject 邮件主题
     * @param string $content 邮件内容
     * @return boolean|string 成功返回true，失败返回错误信息
     */
    function send_email($to, $subject, $content)
    {
        $config = Db::name('system_config')->column('value', 'name');
        
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = $config['smtp_host'] ?? '';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $config['smtp_user'] ?? '';                     // SMTP username
            $mail->Password   = $config['smtp_pass'] ?? '';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = $config['smtp_port'] ?? 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom($config['smtp_from'] ?? $config['smtp_user'], $config['site_title'] ?? '系统邮件');
            $mail->addAddress($to);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $content;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

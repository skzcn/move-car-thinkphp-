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

if (!function_exists('generateMapUrls')) {
    function generateMapUrls($lat, $lng)
    {
        return [
            'amapUrl' => "https://uri.amap.com/marker?position={$lng},{$lat}&name=车主位置",
            'appleUrl' => "http://maps.apple.com/?q={$lat},{$lng}",
            'qqUrl' => "https://apis.map.qq.com/uri/v1/marker?marker=coord:{$lat},{$lng};title:车主位置"
        ];
    }
}

if (!function_exists('curl_request')) {
    function curl_request($url, $method = 'GET', $data = [], $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            if (is_array($data)) {
                // Check if headers imply JSON
                $isJson = false;
                foreach ($headers as $header) {
                    if (stripos($header, 'application/json') !== false) {
                        $isJson = true;
                        break;
                    }
                }
                if ($isJson) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                }
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            trace("Curl Error: $error", 'error');
            return false;
        }
        return $result;
    }
}

if (!function_exists('sendNotification')) {
    function sendNotification($user, $body, $url = '')
    {
        $notifyType = $user['notify_type'] ?? 'bark';
        $result = false;

        // 记录日志
        trace("Sending notification to user {$user['username']} via {$notifyType}", 'info');
        
        // Debug Log
        $logMsg = date('Y-m-d H:i:s') . " - Sending to {$user['username']} via {$notifyType}\n";
        $logMsg .= "User Data: " . json_encode($user) . "\n";
        file_put_contents(app()->getRootPath() . 'runtime/notify_debug.log', $logMsg, FILE_APPEND);

        switch ($notifyType) {
            case 'bark':
                if (!empty($user['bark_url'])) {
                    $barkUrl = rtrim($user['bark_url'], '/');
                    $encodedBody = urlencode($body);
                    $reqUrl = "{$barkUrl}/{$encodedBody}";
                    if ($url) {
                        $reqUrl .= "?url=" . urlencode($url);
                    }
                    $result = curl_request($reqUrl);
                }
                break;

            case 'server_chan':
                if (!empty($user['server_chan_key'])) {
                    $key = $user['server_chan_key'];
                    $result = curl_request(
                        "https://sctapi.ftqq.com/{$key}.send",
                        'POST',
                        [
                            'title' => '挪车通知',
                            'desp' => $body . "\n\n[点击处理]({$url})"
                        ],
                        ['Content-type: application/x-www-form-urlencoded']
                    );
                }
                break;

            case 'webhook':
                if (!empty($user['webhook_url'])) {
                    $webhookUrl = $user['webhook_url'];
                    $result = curl_request(
                        $webhookUrl,
                        'POST',
                        [
                            'title' => '挪车通知',
                            'body' => $body,
                            'url' => $url,
                            'time' => time()
                        ],
                        ['Content-type: application/json']
                    );
                }
                break;

            case 'qywx':
                if (!empty($user['qywx_key'])) {
                    $key = $user['qywx_key'];
                    // Auto-extract key if full URL is provided
                    if (strpos($key, 'http') === 0) {
                        parse_str(parse_url($key, PHP_URL_QUERY), $params);
                        if (isset($params['key'])) {
                            $key = $params['key'];
                        }
                    }
                    
                    $result = curl_request(
                        "https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key={$key}",
                        'POST',
                        [
                            'msgtype' => 'text',
                            'text' => [
                                'content' => $body . "\n\n请点击链接处理：" . $url
                            ]
                        ],
                        ['Content-type: application/json']
                    );
                }
                break;

            case 'dingtalk':
                if (!empty($user['dingtalk_token'])) {
                    $token = $user['dingtalk_token'];
                    // Auto-extract token if full URL is provided
                    if (strpos($token, 'http') === 0) {
                        parse_str(parse_url($token, PHP_URL_QUERY), $params);
                        if (isset($params['access_token'])) {
                            $token = $params['access_token'];
                        }
                    }

                    $result = curl_request(
                        "https://oapi.dingtalk.com/robot/send?access_token={$token}",
                        'POST',
                        [
                            'msgtype' => 'text',
                            'text' => [
                                'content' => "【挪车通知】" . $body . "\n\n请点击链接处理：" . $url
                            ]
                        ],
                        ['Content-type: application/json']
                    );
                }
                break;

            case 'wxpush':
                if (!empty($user['wxpush_uid'])) {
                    $uids = explode(',', $user['wxpush_uid']); // 支持多个UID
                    
                    // 优先从用户信息中获取 AppToken，如果没有则从系统配置获取
                    $appToken = !empty($user['wxpush_app_token']) ? $user['wxpush_app_token'] : \think\facade\Db::name('system_config')->where('name', 'wxpush_app_token')->value('value');
                    
                    if ($appToken) {
                        $result = curl_request(
                            "https://wxpusher.zjiecode.com/api/send/message",
                            'POST',
                            [
                                'appToken' => $appToken,
                                'content' => $body,
                                'summary' => '挪车通知',
                                'contentType' => 1,
                                'uids' => $uids,
                                'url' => $url
                            ],
                            ['Content-type: application/json']
                        );
                        file_put_contents(app()->getRootPath() . 'runtime/notify_debug.log', "WxPush Result: " . $result . "\n", FILE_APPEND);
                    } else {
                        trace("WxPusher AppToken not configured", 'error');
                    }
                }
                break;

            case 'telegram':
                if (!empty($user['tg_bot_token']) && !empty($user['tg_chat_id'])) {
                    $token = $user['tg_bot_token'];
                    $chatId = $user['tg_chat_id'];
                    $text = $body . "\n\n[点击处理]({$url})";
                    $result = curl_request(
                        "https://api.telegram.org/bot{$token}/sendMessage",
                        'POST',
                        [
                            'chat_id' => $chatId,
                            'text' => $text,
                            'parse_mode' => 'Markdown'
                        ],
                        ['Content-type: application/x-www-form-urlencoded']
                    );
                }
                break;

            case 'email':
                if (!empty($user['email'])) {
                    $result = send_email($user['email'], '挪车通知', $body . "<br><br><a href='{$url}'>点击处理</a>");
                }
                break;
        }

        return $result;
    }
}

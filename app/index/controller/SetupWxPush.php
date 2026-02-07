<?php
namespace app\index\controller;

use app\BaseController;
use think\facade\Db;

class SetupWxPush extends BaseController
{
    public function index()
    {
        $action = $this->request->param('action');
        $token = $this->request->param('token');
        $uid = $this->request->param('uid');
        
        $msg = "";

        // Handle Token Update
        if ($action === 'save' && $token) {
            $exists = Db::name('system_config')->where('name', 'wxpush_app_token')->find();
            if ($exists) {
                Db::name('system_config')->where('name', 'wxpush_app_token')->update(['value' => $token]);
            } else {
                Db::name('system_config')->insert(['name' => 'wxpush_app_token', 'value' => $token, 'title' => 'WxPush AppToken']);
            }
            $msg = "AppToken updated successfully!";
        }

        // Get Current Token
        $currentToken = Db::name('system_config')->where('name', 'wxpush_app_token')->value('value');

        // Handle Test Send
        $testResult = "";
        if ($action === 'test' && $uid && $currentToken) {
            $url = "https://wxpusher.zjiecode.com/api/send/message";
            $data = [
                'appToken' => $currentToken,
                'content' => "This is a test message from MoveCar Setup Script.",
                'summary' => 'Setup Test',
                'contentType' => 1,
                'uids' => [$uid],
                'url' => $this->request->domain()
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            
            $testResult = $error ? "Curl Error: $error" : "API Response: $response";
        }

        // Render UI
        $tokenStatus = $currentToken ? '<span style="color:green">Configured</span>' : '<span style="color:red">Not Configured</span>';
        
        echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>WxPusher Setup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <style>
        body { padding: 20px; max-width: 800px; margin: 0 auto; font-family: sans-serif; background-color: #f8f9fa; }
        .card { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .result { background: #2d2d2d; color: #fff; padding: 15px; border-radius: 6px; margin-top: 20px; word-break: break-all; font-family: monospace; }
        .success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .status-badge { display: inline-block; padding: 5px 10px; border-radius: 4px; background: #eee; margin-left: 10px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
            WxPusher Configuration
            <div class="status-badge">Status: {$tokenStatus}</div>
        </h2>
        
        {if $msg}
        <div class="success">{$msg}</div>
        {/if}

        <form class="layui-form" action="" method="get">
            <input type="hidden" name="action" value="save">
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 100px;">AppToken</label>
                <div class="layui-input-block" style="margin-left: 130px;">
                    <input type="text" name="token" value="{$currentToken}" placeholder="Enter WxPusher AppToken (starts with AT_...)" class="layui-input" required>
                    <div class="layui-word-aux" style="margin-top: 5px;">Get it from <a href="https://wxpusher.zjiecode.com/admin/" target="_blank" style="color: #1E9FFF;">WxPusher Admin Panel</a></div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-left: 130px;">
                    <button class="layui-btn layui-btn-normal">Save Configuration</button>
                </div>
            </div>
        </form>

        <hr style="margin: 30px 0;">

        <h3>Test Notification</h3>
        <p style="color: #666; margin-bottom: 20px;">Send a test message to verify your configuration.</p>
        
        <form class="layui-form" action="" method="get">
            <input type="hidden" name="action" value="test">
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 100px;">Your UID</label>
                <div class="layui-input-block" style="margin-left: 130px;">
                    <input type="text" name="uid" value="{$uid}" placeholder="Enter your UID (starts with UID_...)" class="layui-input" required>
                    <div class="layui-word-aux">Scan the QR code in WxPusher to get your UID</div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-left: 130px;">
                    <button class="layui-btn layui-btn-warm">Send Test Message</button>
                </div>
            </div>
        </form>

        {if $testResult}
        <div class="result">
            <strong>API Response:</strong><br>
            {$testResult}
        </div>
        {/if}
    </div>
</body>
</html>
HTML;
    }
}

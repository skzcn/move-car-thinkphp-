<?php
namespace app\index\controller;

use app\BaseController;
use think\facade\Db;

class UpdateDb extends BaseController
{
    public function index()
    {
        $sql = [
            "ALTER TABLE `users` ADD COLUMN `webhook_url` varchar(255) DEFAULT '' COMMENT 'Webhook地址';",
            "ALTER TABLE `users` ADD COLUMN `qywx_key` varchar(255) DEFAULT '' COMMENT '企业微信Key';",
            "ALTER TABLE `users` ADD COLUMN `dingtalk_token` varchar(255) DEFAULT '' COMMENT '钉钉Token';",
            "ALTER TABLE `users` ADD COLUMN `wxpush_uid` varchar(255) DEFAULT '' COMMENT 'WxPush UID';",
            "ALTER TABLE `users` ADD COLUMN `tg_bot_token` varchar(255) DEFAULT '' COMMENT 'Telegram Bot Token';",
            "ALTER TABLE `users` ADD COLUMN `tg_chat_id` varchar(255) DEFAULT '' COMMENT 'Telegram Chat ID';",
            "ALTER TABLE `users` ADD COLUMN `notify_type` varchar(50) DEFAULT 'bark' COMMENT '当前使用的通知方式';"
        ];

        foreach ($sql as $s) {
            try {
                Db::execute($s);
                echo "Executed: $s <br>";
            } catch (\Exception $e) {
                echo "Error executing: $s - " . $e->getMessage() . "<br>";
            }
        }
        return "Database update attempt finished.";
    }
}
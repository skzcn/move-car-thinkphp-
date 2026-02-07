<?php
namespace app\index\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Cache;

class Api extends BaseController
{
    public function notify()
    {
        if ($this->request->isPost()) {
            try {
                $data = $this->request->post();
                $username = $data['username'] ?? 'default';
                $message = $data['message'] ?? '车旁有人等待';
                $location = $data['location'] ?? null;
                if (is_string($location)) {
                    $location = json_decode($location, true);
                }
                $delayed = $data['delayed'] ?? false;

                $user = Db::name('users')->where('username', $username)->find();
                if (!$user) {
                    return json(['success' => false, 'error' => 'User not found']);
                }

                $confirmUrl = $this->request->domain() . (string)url('user/ownerConfirm', ['u' => $username]);

                $notifyBody = "🚗 挪车请求";
                if (!empty($user['plate'])) $notifyBody .= " ({$user['plate']})";
                if ($message) $notifyBody .= "\\n💬 留言: {$message}";

                if ($location && isset($location['lat']) && isset($location['lng'])) {
                    $urls = generateMapUrls($location['lat'], $location['lng']);
                    $notifyBody .= "\\n📍 已附带位置信息，点击查看";
                    Cache::set("requester_location_{$username}", array_merge($location, $urls), 3600);
                } else {
                    $notifyBody .= "\\n⚠️ 未提供位置信息";
                }

                Cache::set("notify_status_{$username}", 'waiting', 600);

                if ($delayed) {
                    sleep(3);
                }

                sendNotification($user, $notifyBody, $confirmUrl);

                return json(['success' => true]);
            } catch (\Exception $e) {
                return json(['success' => false, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
            }
        }
    }

    public function checkStatus()
    {
        $username = $this->request->param('u', 'default');
        $status = Cache::get("notify_status_{$username}", 'waiting');
        $ownerLocation = Cache::get("owner_location_{$username}");

        return json([
            'status' => $status,
            'ownerLocation' => $ownerLocation
        ]);
    }

    public function getLocation()
    {
        $username = $this->request->param('u', 'default');
        $location = Cache::get("requester_location_{$username}");
        if ($location) {
            return json($location);
        }
        return json(['error' => 'No location'], 404);
    }

    public function ownerConfirmAction()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $username = $data['username'] ?? 'default';
            $ownerLocation = $data['location'] ?? null;
            if (is_string($ownerLocation)) {
                $ownerLocation = json_decode($ownerLocation, true);
            }

            if ($ownerLocation) {
                $urls = generateMapUrls($ownerLocation['lat'], $ownerLocation['lng']);
                Cache::set("owner_location_{$username}", array_merge($ownerLocation, $urls), 3600);
            }

            Cache::set("notify_status_{$username}", 'confirmed', 600);
            
            // 记录日志
            $user = Db::name('users')->where('username', $username)->find();
            if ($user) {
                Db::name('move_car_logs')->insert([
                    'user_id' => $user['id'],
                    'message' => Cache::get("last_message_{$username}", ''),
                    'requester_location' => json_encode(Cache::get("requester_location_{$username}")),
                    'owner_location' => json_encode(Cache::get("owner_location_{$username}")),
                    'status' => 'confirmed',
                    'create_time' => time(),
                    'update_time' => time()
                ]);
            }

            return json(['success' => true]);
        }
    }
}

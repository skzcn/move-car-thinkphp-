<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;
use think\facade\Session;

class Notice extends BaseController
{
    public function initialize()
    {
        if (!Session::has('admin_id')) {
            return redirect((string)url('admin/login/index'))->send();
        }
    }

    public function index()
    {
        $list = Db::name('notices')->order('id desc')->paginate(15);
        View::assign('list', $list);
        return View::fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $title = $data['title'] ?? '';
            $content = $data['content'] ?? '';
            $target = $data['target'] ?? 'all'; // all or specific user_ids
            $userIds = $data['user_ids'] ?? [];

            if (empty($title) || empty($content)) {
                return json(['code' => 1, 'msg' => '标题和内容不能为空']);
            }

            Db::startTrans();
            try {
                $noticeId = Db::name('notices')->insertGetId([
                    'title' => $title,
                    'content' => $content,
                    'create_time' => time()
                ]);

                if ($target == 'all') {
                    $users = Db::name('users')->column('id');
                    $insertData = [];
                    foreach ($users as $uid) {
                        $insertData[] = [
                            'user_id' => $uid,
                            'notice_id' => $noticeId,
                            'is_read' => 0
                        ];
                    }
                    if (!empty($insertData)) {
                        Db::name('user_notices')->insertAll($insertData);
                    }
                } else {
                    if (!empty($userIds)) {
                        $insertData = [];
                        foreach ($userIds as $uid) {
                            $insertData[] = [
                                'user_id' => $uid,
                                'notice_id' => $noticeId,
                                'is_read' => 0
                            ];
                        }
                        Db::name('user_notices')->insertAll($insertData);
                    }
                }

                Db::commit();
                return json(['code' => 0, 'msg' => '发布成功']);
            } catch (\Exception $e) {
                Db::rollback();
                return json(['code' => 1, 'msg' => '发布失败: ' . $e->getMessage()]);
            }
        }

        $users = Db::name('users')->field('id, username, nickname')->select();
        View::assign('users', $users);
        return View::fetch();
    }

    public function delete()
    {
        $id = $this->request->param('id');
        if (!$id) {
            return json(['code' => 1, 'msg' => '参数错误']);
        }

        Db::startTrans();
        try {
            Db::name('notices')->delete($id);
            Db::name('user_notices')->where('notice_id', $id)->delete();
            Db::commit();
            return json(['code' => 0, 'msg' => '删除成功']);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['code' => 1, 'msg' => '删除失败: ' . $e->getMessage()]);
        }
    }
}

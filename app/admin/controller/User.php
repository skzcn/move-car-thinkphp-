<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;
use think\facade\Session;

class User extends BaseController
{
    public function initialize()
    {
        if (!Session::has('admin_id')) {
            return redirect((string)url('admin/login/index'))->send();
        }
    }

    public function index()
    {
        if ($this->request->isAjax()) {
            $page = $this->request->param('page', 1);
            $limit = $this->request->param('limit', 10);
            $keyword = $this->request->param('keyword', '');

            $where = [];
            if ($keyword) {
                $where[] = ['username|nickname|plate|mobile', 'like', "%{$keyword}%"];
            }

            $list = Db::name('users')
                ->where($where)
                ->page($page, $limit)
                ->order('id desc')
                ->select();
            $count = Db::name('users')->where($where)->count();

            return json([
                'code' => 0,
                'msg' => '',
                'count' => $count,
                'data' => $list
            ]);
        }
        return View::fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['create_time'] = time();
            $data['update_time'] = time();
            
            // 密码加密
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                unset($data['password']); // 防止空密码
            }

            try {
                Db::name('users')->insert($data);
                return json(['code' => 0, 'msg' => '添加成功']);
            } catch (\Exception $e) {
                return json(['code' => 1, 'msg' => '添加失败: ' . $e->getMessage()]);
            }
        }
        return View::fetch('edit');
    }

    public function edit()
    {
        $id = $this->request->param('id');
        $user = Db::name('users')->find($id);
        
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['update_time'] = time();
            
            // 密码处理
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                unset($data['password']); // 不修改密码
            }
            
            try {
                Db::name('users')->where('id', $id)->update($data);
                return json(['code' => 0, 'msg' => '修改成功']);
            } catch (\Exception $e) {
                return json(['code' => 1, 'msg' => '修改失败: ' . $e->getMessage()]);
            }
        }
        
        View::assign('user', $user);
        return View::fetch();
    }

    public function delete()
    {
        $id = $this->request->param('id');
        try {
            Db::name('users')->delete($id);
            return json(['code' => 0, 'msg' => '删除成功']);
        } catch (\Exception $e) {
            return json(['code' => 1, 'msg' => '删除失败']);
        }
    }
}

<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;
use think\facade\Session;

class Admin extends BaseController
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
                $where[] = ['username|nickname|email', 'like', "%{$keyword}%"];
            }

            $list = Db::name('admins')
                ->where($where)
                ->page($page, $limit)
                ->order('id desc')
                ->select();
            $count = Db::name('admins')->where($where)->count();

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
            
            if (empty($data['username']) || empty($data['password'])) {
                return json(['code' => 1, 'msg' => '用户名和密码不能为空']);
            }

            $exists = Db::name('admins')->where('username', $data['username'])->find();
            if ($exists) {
                return json(['code' => 1, 'msg' => '用户名已存在']);
            }

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['create_time'] = time();
            $data['update_time'] = time();
            
            try {
                Db::name('admins')->insert($data);
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
        if (empty($id)) {
            return json(['code' => 1, 'msg' => '参数错误']);
        }

        $admin = Db::name('admins')->find($id);
        if (!$admin) {
            return json(['code' => 1, 'msg' => '管理员不存在']);
        }
        
        if ($this->request->isPost()) {
            $data = $this->request->post();
            
            // 移除ID，防止更新主键
            if (isset($data['id'])) {
                unset($data['id']);
            }

            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                unset($data['password']);
            }
            
            $data['update_time'] = time();
            
            try {
                Db::name('admins')->where('id', $id)->update($data);
                return json(['code' => 0, 'msg' => '修改成功']);
            } catch (\Exception $e) {
                return json(['code' => 1, 'msg' => '修改失败: ' . $e->getMessage()]);
            }
        }
        
        View::assign('admin', $admin);
        return View::fetch();
    }

    public function delete()
    {
        $id = $this->request->param('id');
        if ($id == 1) {
            return json(['code' => 1, 'msg' => '超级管理员不能删除']);
        }
        try {
            Db::name('admins')->delete($id);
            return json(['code' => 0, 'msg' => '删除成功']);
        } catch (\Exception $e) {
            return json(['code' => 1, 'msg' => '删除失败']);
        }
    }
}

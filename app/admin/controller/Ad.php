<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;

class Ad extends BaseController
{
    public function initialize()
    {
        if (!\think\facade\Session::has('admin_id')) {
            return redirect((string)url('admin/login/index'))->send();
        }
    }

    public function index()
    {
        $list = Db::name('ads')->order('sort desc, id desc')->paginate(10);
        View::assign('list', $list);
        return View::fetch();
    }

    public function edit()
    {
        $id = $this->request->param('id', 0);
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['status'] = isset($data['status']) ? 1 : 0;
            $data['update_time'] = time();
            
            try {
                if ($id > 0) {
                    Db::name('ads')->where('id', $id)->strict(false)->update($data);
                } else {
                    unset($data['id']);
                    $data['create_time'] = time();
                    Db::name('ads')->strict(false)->insert($data);
                }
                return json(['code' => 0, 'msg' => '保存成功']);
            } catch (\Exception $e) {
                return json(['code' => 1, 'msg' => '保存失败: ' . $e->getMessage()]);
            }
        }

        $info = Db::name('ads')->find($id);
        View::assign('info', $info);
        return View::fetch();
    }

    public function delete()
    {
        $id = $this->request->param('id', 0);
        Db::name('ads')->delete($id);
        return json(['code' => 0, 'msg' => '删除成功']);
    }

    public function status()
    {
        $id = input('id/d', 0);
        $status = input('status/d', 0);
        
        if (!$id) {
            return json(['code' => 1, 'msg' => '参数错误：ID缺失']);
        }

        try {
            $res = Db::name('ads')->where('id', $id)->update([
                'status' => $status, 
                'update_time' => time()
            ]);
            return json(['code' => 0, 'msg' => '操作成功']);
        } catch (\Exception $e) {
            return json(['code' => 1, 'msg' => '操作失败: ' . $e->getMessage()]);
        }
    }
}

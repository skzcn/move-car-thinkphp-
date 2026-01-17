<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;
use think\facade\Session;

class System extends BaseController
{
    public function initialize()
    {
        if (!Session::has('admin_id')) {
            return redirect((string)url('admin/login/index'))->send();
        }
    }

    public function index()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            try {
                foreach ($data as $name => $value) {
                    Db::name('system_config')->where('name', $name)->update(['value' => $value]);
                }
                return json(['code' => 0, 'msg' => '保存成功']);
            } catch (\Exception $e) {
                return json(['code' => 1, 'msg' => '保存失败: ' . $e->getMessage()]);
            }
        }

        $config = Db::name('system_config')->column('value', 'name');
        View::assign('config', $config);
        return View::fetch();
    }
}

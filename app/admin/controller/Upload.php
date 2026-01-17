<?php
namespace app\admin\controller;

use app\BaseController;
use think\exception\ValidateException;
use think\facade\Filesystem;

class Upload extends BaseController
{
    public function image()
    {
        $file = request()->file('file');
        try {
            validate(['file' => [
                'fileSize' => 1024 * 1024 * 2,
                'fileExt'  => 'jpg,png,gif,jpeg',
                'fileMime' => 'image/jpeg,image/png,image/gif',
            ]])->check(['file' => $file]);
            
            $savename = Filesystem::disk('public')->putFile('ads', $file);
            $url = '/storage/' . str_replace('\\', '/', $savename);
            
            return json(['code' => 0, 'msg' => '上传成功', 'url' => $url]);
        } catch (ValidateException $e) {
            return json(['code' => 1, 'msg' => $e->getError()]);
        }
    }
}

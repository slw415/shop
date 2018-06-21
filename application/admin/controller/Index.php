<?php
namespace app\admin\controller;

use think\Request;
use think\Validate;
use think\Controller;
class Index extends controller
{
    //定义控制器初始化方法_initialize，在该控制器的方法调用之前首先执行。
/*    public function _initialize()
    {
        if(!session('email')){
            $this->redirect('admin/index');
        }
    }*/
    public function index()
    {
        return view('/index/houtai');
    }
}

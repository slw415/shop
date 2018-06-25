<?php

namespace app\admin\controller;

use think\Request;
use think\Validate;
use think\Controller;
class Configuration extends controller
{
    public function introduce()
    {
        $introduce =\app\admin\model\Configuration::find();
        $introduce =substr($introduce->img,7);
        return view('contact_us',['introduce'=>$introduce]);
    }
    public function introduce_store()
    {
        $files = request()->file('img');
        $infos = $files->move(ROOT_PATH . 'public' . DS . 'static');
        if ($infos)
        {
            $info = new \app\admin\model\Configuration();
            $info = $info->save([
              'img'=>  '/public/static/' . $infos->getSaveName()
            ]);
            $data['status'] = '0';
            $data['msg'] = '/static/' . $infos->getSaveName();
        }else{
            $data['status'] = '1';
            $data['msg'] = '更新失败';
        }
        return json($data);
    }
    //背景图设置
      public function Login_background()
    {
        $Login_background =\app\admin\model\Configuration::find();
        $Login_background =substr($Login_background->img,7);
        return view('/logo_background/denglu');
    }
     public function Login_background_store()
    {
         $files = request()->file('img');
        $infos = $files->move(ROOT_PATH . 'public' . DS . 'static');
        if ($infos)
        {
            $info = new \app\admin\model\Configuration();
            $info = $info->save([
              'img'=>  '/public/static/' . $infos->getSaveName()
            ]);
            $data['status'] = '0';
            $data['msg'] = '/static/' . $infos->getSaveName();
        }else{
            $data['status'] = '1';
            $data['msg'] = '更新失败';
        }
        return json($data); 
      var_dump(1);
      exit();
    }
    //流程图设置
    public function Login_flowchart()
    {
         $Login_flowchart =\app\admin\model\Configuration::find();
        $Login_flowchart =substr($Login_flowchart->img,7);
        return view('/logo_background/denglu');
        return view('/Login_flowchart/denglu_one');
    }
       public function Login_flowchart_store()
    {
          $files = request()->file('img');
        $infos = $files->move(ROOT_PATH . 'public' . DS . 'static');
        if ($infos)
        {
            $info = new \app\admin\model\Configuration();
            $info = $info->save([
              'img'=>  '/public/static/' . $infos->getSaveName()
            ]);
            $data['status'] = '0';
            $data['msg'] = '/static/' . $infos->getSaveName();
        }else{
            $data['status'] = '1';
            $data['msg'] = '更新失败';
        }
        return json($data); 
         var_dump(1);
         exit();
    }
}
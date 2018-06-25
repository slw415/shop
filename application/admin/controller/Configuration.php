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
        $info = new \app\admin\model\Configuration();
        if (!$files){
            $imgs = \app\admin\model\Configuration::find();
            $imgs = $imgs['img'];
            $info = $info->save([
                'img'=> $imgs
            ],['id'=>1]);
            if ($info==0){
                $data['status'] = '0';
                $data['msg'] = substr($imgs,7);
            }else{
                $data['status'] = '1';
                $data['msg'] = '更新失败';
            }
        }else{
            $infos = $files->move(ROOT_PATH . 'public' . DS . 'static');
            if ($infos)
            {
                $info = $info->save([
                    'img'=>  '/public/static/' . $infos->getSaveName()
                ],['id'=>1]);
                $data['status'] = '0';
                $data['msg'] = '/static/' . $infos->getSaveName();
            }else{
                $data['status'] = '1';
                $data['msg'] = '更新失败';
            }
        }
        return json($data);
    }
    //背景图设置
      public function Login_background()
    {
        $Login_background =\app\admin\model\Configuration::find();
        $Login_background =substr($Login_background->img1,7);
        $Login_background = substr_replace($Login_background,'/',16,0);
        $Login_background = substr($Login_background,0,17).substr($Login_background,18);
        return view('/logo_background/denglu',['login_background'=>$Login_background]);
    }
     public function Login_background_store()
    {
        $files = request()->file('img');
        $info = new \app\admin\model\Configuration();
        if (!$files){
            $imgs = \app\admin\model\Configuration::find();
            $imgs = $imgs['img1'];
            $info = $info->save([
                'img1'=> $imgs
            ],['id'=>1]);
            if ($info==0){
                $data['status'] = '0';
                $data['msg'] = substr($imgs,7);
            }else{
                $data['status'] = '1';
                $data['msg'] = '更新失败';
            }
        }else{
            $infos = $files->move(ROOT_PATH . 'public' . DS . 'static');
            if ($infos)
            {
                $info = $info->save([
                    'img1'=>  '/public/static/' . $infos->getSaveName()
                ],['id'=>1]);
                $data['status'] = '0';
                $data['msg'] = '/static/' . $infos->getSaveName();
            }else{
                $data['status'] = '1';
                $data['msg'] = '更新失败';
            }
        }
        return json($data);
    }
    //流程图设置
    public function Login_flowchart()
    {
         $Login_flowchart =\app\admin\model\Configuration::find();
         $Login_flowchart =substr($Login_flowchart->img2,7);
        return view('/Login_flowchart/denglu_one',['Login_flowchart'=>$Login_flowchart]);
    }
       public function Login_flowchart_store()
    {
        $files = request()->file('img');
        $info = new \app\admin\model\Configuration();
        if (!$files) {
            $imgs = \app\admin\model\Configuration::find();
            $imgs = $imgs['img2'];
            $info = $info->save([
                'img2' => $imgs
            ], ['id' => 1]);
            if ($info == 0) {
                $data['status'] = '0';
                $data['msg'] = substr($imgs, 7);
            } else {
                $data['status'] = '1';
                $data['msg'] = '更新失败';
            }
        } else {
            $infos = $files->move(ROOT_PATH . 'public' . DS . 'static');
            if ($infos) {
                $info = $info->save([
                    'img2' => '/public/static/' . $infos->getSaveName()
                ], ['id' => 1]);
                $data['status'] = '0';
                $data['msg'] = '/static/' . $infos->getSaveName();
            } else {
                $data['status'] = '1';
                $data['msg'] = '更新失败';
            }
        }
        return json($data);
    }

}
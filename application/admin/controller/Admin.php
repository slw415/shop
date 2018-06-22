<?php
namespace app\admin\controller;

use think\Request;
use think\Validate;
use think\Controller;
class Admin extends controller
{
    public function index()
    {
        return view('land');
    }
    //显示注册页面
    public function register()
    {
        return view('register');
    }
    /**
     * 验证手机号是否正确
     *
     */
    function isMobile($mobile) {
        if(preg_match("/^1[34578]\d{9}$/", $mobile)){
            return 1;
        }
    }
    //注册认证
    public function register_form()
    {
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $paypal = $_POST['paypal'];
        $password = $_POST['password'];
        $user = \app\admin\model\Admin::where('email',$email)->find();
        if ($user)
        {
            $data['status'] = '1';
            $data['msg'] ='已经存在当前用户';
        }elseif($this ->isMobile($phone)!=1){
            $data['status'] = '1';
            $data['msg'] ='请输入正确的手机号格式';
        }else
        {
            $rule = [
                'email'  => 'require|email',
                'phone'   => 'require',
                'paypal' => 'require',
                'password' => 'length:4,8',
            ];
            $msg = [
                'email.require' => '邮箱必须填写',
                'email.email'    => '邮箱格式错误',
                'phone.require'   => '手机号必须填写',
                'paypal.require'  => 'paypal必须填写',
                'password.length'=> '密码长度必须在4到8位',
            ];
            $data = [
                'email'  => $email,
                'phone'   => $phone,
                'paypal' => $paypal,
                'passowrd' => $password
            ];
            $validate = new Validate($rule,$msg);
            $result   = $validate->check($data);
            if(!$result){
                $data['status'] = '1';
                $data['msg'] = $validate->getError();
            }else{
                $admin = \app\admin\model\Admin::create([
                    'email'  =>  $email,
                    'phone' =>   $phone,
                    'paypal' => $paypal,
                    'password'=> $password,
                    'created_up'=>date('Y-m-d')
                ]);
                if (!$admin)
                {
                    $data['status'] = '1';
                    $data['msg'] = '创建失败';
                }else{
                    $data['status'] = '0';
                    $data['msg'] = '创建成功';
                }
            }
        }
        return json($data);
    }

    //登录验证
    public function land_form()
    {

        $password = $_POST['password'];
        $email = $_POST['email'];
        $user = \app\admin\model\Admin::where('email',$email)->find();
        if ($user['password']==$password)
        {
            \think\Session::set('email',$user['email']);
            $data['status'] = '0';
            $data['msg'] = '跳转首页';
        }else{
            $data['status'] = '1';
            $data['msg'] = '密码错误';
        }
         return json($data);
    }
   
}

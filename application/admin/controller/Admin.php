<?php
namespace app\admin\controller;

use think\Request;
use think\Validate;

class Admin
{
    public function index()
    {
        return view('admin/land');
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
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
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
        }elseif($this ->isMobile($phone)){
            $data['status'] = '1';
            $data['msg'] ='请输入正确的手机号格式';
        }else
        {
            $rule = [
                'email'  => 'require|email',
                'phone'   => 'require',
                'paypal' => 'require',
                'password' => 'require|length:4,8',
            ];
            $msg = [
                'email.require' => '邮箱必须填写',
                'email.email'    => '邮箱格式错误',
                'phone.require'   => '手机号必须填写',
                'paypal.require'  => 'paypal必须填写',
                'password.require'=> '密码必须填写',
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
                $admin = Admin::create([
                    'email'  =>  $email,
                    'phone' =>   $phone,
                    'paypal' => $paypal,
                    'password'=> $password
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
}

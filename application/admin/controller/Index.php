<?php
namespace app\admin\controller;

use app\admin\model\CommoditiesEdit;
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
    //商品提交
    public function index_form()
    {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $original_price = $_POST['original_price'];
        $inventory = $_POST['inventory'];
        $instructions = $_POST['instructions'];
        if (request()->isPost()) {
            $rule = [
                'title' => 'require',
                'price' => 'require|number',
                'original_price' => 'require|number',
                'inventory' =>'require',
                'instructions' => 'require',
            ];
            $msg = [
                'title.require' => '商品标题填写',
                'price.require' => '商品价格必须填写',
                'price.number' => '商品价格必须为数字',
                'original_price.require' => '商品原价必须填写',
                'original_price.number' => '商品原价必须为数字',
                'inventory.require' => '库存必须填写',
                'instructions.require' => '说明必须填写',
            ];
            $data = [
                'title' => $title,
                'price' => $price,
                'original_price' => $original_price,
                'inventory' => $inventory,
                'instructions' =>$instructions
            ];
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $data['status'] = '1';
                $data['msg'] = $validate->getError();
                return json($data);
            }
            $files1 = request()->file('details_img');

            $files = request()->file('chart_img');

            if (!$files || !$files1) {
                $data['status'] = '1';
                $data['msg'] = '请上传图片';

            }else{
                $chat_name=[];
                foreach ($files as $key => $file) {
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
                    // $info = $file->move(ROOT_PATH . 'public/uploads');
                    $chat_name[] = '/public/upload/' . $info->getSaveName();
                }
                $details_img =[];
                foreach ($files1 as $file1){
                    $info1 = $file1->move(ROOT_PATH . 'public' . DS . 'upload');
                    // $info = $file->move(ROOT_PATH . 'public/uploads');
                    $details_img[] = '/public/upload/' . $info1->getSaveName();
                }
                $details_img =implode(" ",$details_img);
                $chat_name =implode(" ",$chat_name);
                    if ($info) {
                        $admin = CommoditiesEdit::create([
                            'title'  =>  $title,
                            'price' =>   $price,
                            'original_price' => $original_price,
                            'inventory'=> $inventory,
                            'instructions'=> $instructions,
                            'chart_img' => $chat_name,
                            'details_img' => $details_img,
                            'created_up'=>date('Y-m-d')
                        ]);
                        if ($admin)
                        {
                            $data['status'] = '0';
                           $data['msg'] = json_encode(CommoditiesEdit::order('id','desc')->limit(1)->find());

                        }else{
                            $data['status'] = '1';
                            $data['msg'] = '添加失败';
                        }
                    }else{
                        $data['status'] = '1';
                        $data['msg'] = $info->getError();
                    }

            }
            return json($data);
        }
    }


}

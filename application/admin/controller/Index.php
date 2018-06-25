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
                foreach ($files as $key => $file) {
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'static');
                    // $info = $file->move(ROOT_PATH . 'public/uploads');
                    $chat_name[] = '/public/static/' . $info->getSaveName();
                }
                foreach ($files1 as $file1){
                    $info1 = $file1->move(ROOT_PATH . 'public' . DS . 'static');
                    // $info = $file->move(ROOT_PATH . 'public/uploads');
                    $details_img[] = '/public/static/' . $info1->getSaveName();
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
        public function shop_index(Request $request)
        {
            $search_input = $request->param('search_input');
             $shop = CommoditiesEdit::where('title','like',"%$search_input%")->select();
            $shop = collection($shop)->toArray();
            $arr =[];
          /*  explode(" ",$v['chart_img'][0])*/
             foreach ($shop as &$v) {
                 $v['con'] = substr(explode(" ", $v['chart_img'])[0],7);
             }
             return view('/index/shangpinbianji',['search_input'=>$search_input,'shop'=> $shop]);
        }
    public function edit_shop($id)
    {
        $shop = CommoditiesEdit::where('id',$id)->find();
        $chart_imgs = $shop['chart_img'];
        $chart_imgss =explode(" ",$chart_imgs);
        $chart_img = explode(' ',$chart_imgs);
        foreach ($chart_img as &$v)
        {
          $v = substr($v,7);
        }
        $details_imgs = $shop['details_img'];
        $details_img = explode(' ',$details_imgs);
        $details_imgss = explode(' ',$details_imgs);
        foreach ($details_img as &$v)
        {
            $v = substr($v,7);
        }
        return view('index/houtai_edit',['shop' => $shop,'chart_img'=>$chart_img,'details_img'=>$details_img,'details_imgss'=>$details_imgss,'chart_imgss'=>$chart_imgss]);
    }

        public function store_shop($id)
    {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $original_price = $_POST['original_price'];
        $inventory = $_POST['inventory'];
        $instructions = $_POST['instructions'];
        $old = $_POST['hidden'];
        $old = implode(" ",$old);
        $old1 = $_POST['hidden1'];
        $old1 = implode(" ",$old1);
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

            $shop = CommoditiesEdit::where('id',$id)->find();
            $chart_img = $shop['chart_img'];
            $chart_img = explode(' ',$chart_img);
            $details_img = $shop['details_img'];
            $details_img = explode(' ',$details_img);
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);

            if (!$result) {
                $data['status'] = '1';
                $data['msg'] = $validate->getError();
                return json($data);
            }
            $files1 = request()->file('details_img');
            $files = request()->file('chart_img');
            $user = new CommoditiesEdit;
            if (!$files &&!$files1) {

                //如果图片不存在 ，直接跟新
                // save方法第二个参数为更新条件
                $info = $user->save([
                    'title' => $title,
                    'price' => $price,
                    'original_price' => $original_price,
                    'inventory' => $inventory,
                    'instructions' => $instructions,
                    'created_up'=>date('Y-m-d'),
                    'chart_img' => $chart_img,
                    'details_img'=>$details_img,
                ], ['id' => $id]);
                    $data['status'] = '0';
                    $data['msg'] = json_encode(CommoditiesEdit::where('id',$id)->find());
            }elseif($files && $files1){

                foreach ($files as $key => $file) {
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'static');
                    // $info = $file->move(ROOT_PATH . 'public/uploads');
                    $chart[] = '/public/static/' . $info->getSaveName();
                }
                foreach ($files1 as $key => $file1){
                    $info1 = $file1->move(ROOT_PATH . 'public' . DS . 'static');
                    // $info = $file->move(ROOT_PATH . 'public/uploads');
                    $details[] = '/public/static/' . $info1->getSaveName();
                }
                $details_img = implode(' ',$details);
                $details_img =$details_img.' '.$old1;
                $chart_img = implode(' ',$chart);
                $chart_img =$chart_img.' '.$old;
                // save方法第二个参数为更新条件
                $info = $user->save([
                    'title' => $title,
                    'price' => $price,
                    'original_price' => $original_price,
                    'inventory' => $inventory,
                    'instructions' => $instructions,
                    'created_up'=>date('Y-m-d'),
                    'chart_img' => $chart_img,
                    'details_img'=>$details_img,
                ], ['id' => $id]);
                if($info){
                    $data['status'] = '0';
                    $data['msg'] = json_encode(CommoditiesEdit::where('id',$id)->find());
                }else{
                    $data['status'] = '1';
                    $data['msg'] = '更新失败';
                }
            }elseif($files && !$files1){

                foreach ($files as $key => $file) {
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'static');
                    // $info = $file->move(ROOT_PATH . 'public/uploads');
                    $chart[] = '/public/static/' . $info->getSaveName();
                }
                $chart_img = implode(' ',$chart);
                $chart_img =$chart_img.' '.$old;
                $info = $user->save([
                    'title' => $title,
                    'price' => $price,
                    'original_price' => $original_price,
                    'inventory' => $inventory,
                    'instructions' => $instructions,
                    'created_up'=>date('Y-m-d'),
                    'chart_img' => $chart_img,
                    'details_img'=>$details_img,
                ], ['id' => $id]);
                if($info){
                    $data['status'] = '0';
                    $data['msg'] = json_encode(CommoditiesEdit::where('id',$id)->find());
                }else{
                    $data['status'] = '1';
                    $data['msg'] = '更新失败';
                }
            }else{

                foreach ($files1 as $key => $file1){
                    $info1 = $file1->move(ROOT_PATH . 'public' . DS . 'static');
                    // $info = $file->move(ROOT_PATH . 'public/uploads');
                    $details[] = '/public/static/' . $info1->getSaveName();
                }
                $details_img = implode(' ',$details);
                $details_img =$details_img.' '.$old1;
                $info = $user->save([
                    'title' => $title,
                    'price' => $price,
                    'original_price' => $original_price,
                    'inventory' => $inventory,
                    'instructions' => $instructions,
                    'created_up'=>date('Y-m-d'),
                    'chart_img' => $chart_img,
                    'details_img'=>$details_img,
                ], ['id' => $id]);
                if($info){
                    $data['status'] = '0';
                    $data['msg'] = json_encode(CommoditiesEdit::where('id',$id)->find());
                }else{
                    $data['status'] = '1';
                    $data['msg'] = '更新失败';
                }
            }
            return json($data);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Model\configs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class ConfigsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取配置信息
        $data = configs::orderBy('order' , 'asc')->get();

        //处理内容
        foreach ($data as $k => $v) {
            switch ($v->type) {
                case 'input':
                    $data[ $k ]->_html = '<input type="text" name="content['.$v->id.']" class="lg" value="' . $v->content . '">';
                    break;
                case 'textarea':
                    $data[ $k ]->_html = '<textarea class="lg" name="content['.$v->id.']">' . $v->content . '</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $str = '';
                    $arr = explode(',' , $v->value);
                    //1|开启
                    foreach ($arr as $m => $n) {
                        //判断默认选中
                        $checked = '';
                        if ($v->content == $n[0]) {
                            $checked = ' checked ';
                        }
                        $arr1 = explode('|' , $n);
                        $str .= '<input type="radio" name="content['.$v->id.']" value="' . $arr1[0] . '" '.$checked.'>' . $arr1[1] . '　　';
                    }
                    $data[ $k]->_html = $str;
                    break;
            }
        }

        return view('Admin/config/list' , array('configs' => $data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/config/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (configs::create($request->all())) {
            return redirect('admin/config')->with(array('alert' => '添加成功' , 'alertNum' => '1'));
        } else {
            return back()->with(array('alert' => '服务器正忙,请稍后重试' , 'alertNum' => '2'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取单条数据
        $data = configs::find($id);
        return view('Admin/config/edit' , array('data' => $data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\create_config $request , $id)
    {
        $data = $request->except('_token' , '_method');
        if (configs::where('id' , '=' , $id)->update($data)) {
            $this->putFile();
            return redirect('admin/config')->with(array('alert' => '更新成功~!' , 'alertNum' => '1'));
        } else {
            return back()->with(array('alert' => '服务正忙,请稍后重试~!' , 'alertNum' => '2'));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (configs::where('id' , '=' , $id)->delete()) {
            $this->putFile();
            return json_encode(array('status' => 1 , 'msg' => '删除成功~!'));
        } else {
            return json_encode(array('status' => 0 , 'msg' => '服务器正忙,请重试'));
        }
    }


    /**
     * 后台 configs AJAX 切换排序
     */
    public function changeOrder()
    {
        $data = Input::all();
        $nav = configs::find($data['id'])->update(array('order' => $data['order']));
        if ($nav) {
            echo json_encode(array('status' => 1 , 'msg' => '修改排序成功'));
        } else {
            echo json_encode(array('status' => 0 , 'msg' => '服务器正忙,请稍后重试'));
        }

    }

    /**
     * 更新 contnent
     */
    public function changeContent()
    {
        $data = Input::all()['content'];
        foreach ($data as $k=>$v){
            configs::where('id','=',$k)->update(array('content'=>$v));
        }
        $this->putFile();
        return redirect('admin/config')->with(array('alert'=>'修改内容成功','alertNum'=>'6'));
    }

    //把数据库里面的配置项写入文件当中
    public function putFile()
    {
        $config = configs::pluck('content','name')->all();
        $path = base_path().'/config/web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);

    }

}

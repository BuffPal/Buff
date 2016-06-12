  @extends('public.admin')
  @section('content')
      <!--- 引入 croppic css文件 croppic.css--->
      <link rel="stylesheet" href="{{ asset('org/croppic/css/croppic.css') }}"/>
      <style>
          em{
              color: red;
          }
      </style>
      <!--- 引入 validate表单验证 JS文件 --->
      <script language="JavaScript" type="text/javascript" src="{{ asset('org/validate/validate.js') }}"></script>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a> &raquo; <a href="{{ url('admin/article') }}">文章列表</a> &raquo; 添加文章
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/article') }}"><i class="fa fa-recycle"></i>文章列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{ url('admin/article').'/'.$data->id }}" method="post" name="article">
            <input type="hidden" name="_method" value="put">
            {{ csrf_field() }}
            <input type="hidden" name="time" value="0">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>分类：</th>
                        <td>
                            <select name="cid">
                                <option value="{{ url('admin/article') }}">==全部==</option>
                                @if($cate)
                                    @foreach($cate as $v)
                                        <optgroup label="{{ $v['name'] }}">
                                            @if(count($v['child']) >0)
                                                @foreach($v['child'] as $c)
                                                    <option value="{{ $c['id'] }}"
                                                        @if($c['id'] == $data->cid)
                                                           selected
                                                        @endif
                                                    >{{ $c['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    @endforeach
                                @else
                                    <option value="">暂时没有分类,无法添加</option>
                                @endif
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="title" value="{{ $data->title }}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>请保证在 255 位之内</span>
                        </td>
                    </tr>
                    <tr>
                        <th>编辑名称：</th>
                        <td>
                            <input type="text" name="editor" value="{{ $data->editor }}">
                        </td>
                    </tr>
                    <tr>
                        <th>简介：</th>
                        <td>
                            <textarea name="info" style="resize:none;line-height: 15px;">{{ $data->info }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>TAG标签：</th>
                        <td>
                            <input type="text" class="lg" name="tag" value="{{ $data->tag }}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>请用 , 隔开</span>
                        </td>
                    </tr>
                    <tr>
                        <th>关键词描述：</th>
                        <td>
                            <textarea name="description" style="resize:none;line-height: 15px;">{{ $data->description }}</textarea>
                        </td>
                    </tr>
                    <style>
                        .pictrue{
                            position: absolute;
                            left:600px;
                            top: -75px;
                            width: 175px;
                            height: 117px;
                            border:2px solid #d5d5d5;
                            box-shadow: 0px 0px 20px #c6c6c6;
                            border-radius: 3px;
                        }
                        #myOutputId{
                            margin-left:20px;
                            width:400px;
                        }
                    </style>
                    <tr>
                        <th><i class="require">*</i>缩略图：</th>
                        <td style="position: relative;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">点击上传</button>
                        <input type="text" id="myOutputId" readonly="readonly" name="thumb" value="{{ $data->thumb }}"><div class="pictrue"><img src="{{ asset($data->thumb) }}"></div></td>
                    </tr>


                    <tr>
                        <th>文章内容：</th>
                        <td>
                            <script type="text/javascript" charset="utf-8" src="{{ asset('org/ueditor/ueditor.config.js') }}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{ asset('org/ueditor/ueditor.all.min.js') }}"> </script>
                            <script type="text/javascript" charset="utf-8" src="{{ asset('org/ueditor/lang/zh-cn/zh-cn.js') }}"></script>
                            <script id="editor" type="text/plain" name='content' style="width:1024px;height:500px;">
                                 {!! $data->content !!}
                            </script>
                            <script type="text/javascript">
                                var ue = UE.getEditor('editor');
                            </script>
                            <style>
                                .edui-default{line-height: 28px;}
                                div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow: hidden; height:20px;}
                                div.edui-box{overflow: hidden; height:22px;}
                            </style>
                        </td>
                    </tr>



                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交" class="btn btn-primary">
                            <input type="button" class="back btn btn-default" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
      @if($errors->any())
          <ul class="list-group">
          @foreach($errors->all() as $error)
      	    <li class="list-group-item list-group-item-danger">{{ $error }}</li>
          @endforeach
          </ul>
      @endif
      @if(session('msg'))
          <li class="list-group-item list-group-item-danger text-center">{{ session('msg') }}</li>
      @endif

      <style>
          #warp{
              width: 100%;
              height: 100%;
              padding:50px 190px;
          }
          #warp>div{
              border:4px solid #eee;
              box-shadow: 0px 0px 20px #666;
              width: 183px;
              height: 125px;
              position: relative;
              background: #ddd;
          }
          .cropControls{
              top:-70px;
          }
      </style>
      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">上传图片</h4>
                  </div>
                  <div class="modal-body">
                      <div id="warp">
                        <div id="cropContainerEyecandy"></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!--- 引入 croppic.min.js JS文件  请确保之前已经引入jquery--->
      <script language="JavaScript" type="text/javascript" src="{{ asset('org/croppic/js/croppic.min.js') }}"></script>
      <!--初始化croppic-->
      <script>
          var eyeCandy = $('#cropContainerEyecandy');
          var croppedOptions = {
              uploadUrl:'{{ url('upload') }}',//点击上传的处理地址 保存为文件用于动态裁剪
              cropUrl: '{{ url('crop') }}',    //裁剪后发送的地址,用于保存,返回 图片保存的地址
              cropData:{
                  'width' : eyeCandy.width(),
                  'height': eyeCandy.height()
              },
              outputUrlId:'myOutputId',          //插件后的图像输出到这个Input
              onAfterImgCrop:function(){
                $('#myModal').modal('hide');
                layer.msg('上传成功', {icon: 6});
                //图片加载
                  var urlpath = $('#myOutputId').val();
                  $('div.pictrue img').attr('src',urlpath);
                  $('div.pictrue').fadeIn();

              },
              onError:function(){
                layer.msg('出错啦!!!', {icon: 5});
              }
          };
          var cropperBox = new Croppic('cropContainerEyecandy', croppedOptions);
          //这里提供了 点击裁剪时 img.src 地址 用jquery获取  $('img.croppedImg').attr('src')
      </script>
      <script>
          $('form[name=article]').validate({
              //错误提示信息放到span标签里面
              errorElement:'em',
              /*    success:function(label){
               label.addClass('success');
               },*/
              //验证规则编写
              rules : {
                  cid: {
                      required: true
                  },
                  title: {
                      required: true,
                      rangelength: [1, 255]
                  },
                  content: {
                      required: true
                  },
                  editor: {
                      required: true,
                      rangelength: [1, 30]
                  },
                  tag: {
                      required: true,
                      rangelength: [1, 100]
                  },
                  info: {
                      required: true,
                      rangelength: [1, 255]
                  },
                  description: {
                      required: true,
                      rangelength: [1, 255]
                  },
                  thumb: {
                      required: true
                  }
              },
              //显示方式
              messages:{
                  cid:{
                    required:'请选着栏目'
                  },
                  title: {
                      required: '请输入文章标题',
                      rangelength: '请保证文章标题在255位之内'
                  },
                  content: {
                      required: '亲输入文章内容'
                  },
                  editor: {
                      required: '亲填写编辑人员的名称',
                      rangelength: '编辑人员名称不得大于30位'
                  },
                  tag: {
                      required: '请填写tag标签',
                      rangelength: '请保证 tag 标签在100位之内'
                  },
                  info: {
                      required: '请填写文章简介',
                      rangelength: '请保证文章简介在255位之内'
                  },
                  description: {
                      required: '请填写关键字描述',
                      rangelength: '请保证关键字描述在255位之内'
                  },
                  thumb: {
                      required: '请上传您的缩略图'
                  }
              }

          });
      </script>
@stop

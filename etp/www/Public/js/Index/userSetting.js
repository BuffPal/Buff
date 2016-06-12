$(function() {

    //jquery Validate 表单基本信息验证
    jQuery.validator.addMethod("username1", function(value, element) { //改下函数名就行
        var tel = /^[\u4E00-\u9FA5\w]*?$/i;
        return this.optional(element) || (tel.test(value)); //不动
    }, "不能存在特殊字符!");

    jQuery.validator.addMethod("blog1", function(value, element) { //改下函数名就行
        var tel = /(?:http:\/\/)?([\w.]+[\w\/]*\.[\w.]+[\w\/]*\??[\w=\&\+\%]*)/i;
        return this.optional(element) || (tel.test(value)); //不动
    }, "请输入真确的博客地址!");

    jQuery.validator.addMethod("qq1", function(value, element) { //改下函数名就行
        var tel = /^\d{5,10}$/;
        return this.optional(element) || (tel.test(value)); //不动
    }, "请输入正确的QQ号!");


    $('form[name=save]').validate({
        //错误提示信息放到span标签里面
        errorElement: 'span',
        /*   success:function(label){
              label.addClass('success');
            },*/
        //验证规则编写
        rules: {
            //账号验证
            username: {
                required: true,
                rangelength: [2, 10],
                username1: true,
                //异步验证
                remote: {
                    url: checkUsernameUrl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        //这个传参方法有点另类  json格式为{account:$('#account').val()}
                        username: function() {
                            return $('#username').val();
                        }
                    }
                }
            },
            //真实名称验证
            truename: {
                rangelength: [2, 20],
                username1: true,
            },
            //一句话介绍自己验证
            intro: {
                rangelength: [1, 70]
            },
            //博客地址验证
            blog: {
                blog1: true
            },
            //MSN 我也不验证了,我也不会
            //QQ号验证
            qq: {
                qq1: true
            }
        },
        //显示方式
        messages: {
            username: {
                required: '昵称不能为空!',
                rangelength: '请保证昵称在2~10位之间',
                remote: '该昵称已被占用啦~'
            },
            truename: {
                rangelength: '真实名称应在2~20位之间'
            },
            //一句话介绍自己验证
            intro: {
                rangelength: '请不要超出70位.'
            },


        }

    });


    /**
     * 一下要注意的问题,因为validate用了ajax验证,所以不能用input:submit 提交表单.
     * 需要用下面一段函数来执行提交
     * 这里要注意的是 不能用Input来触发click 要用别的东西如 button 并且ID不能为submit
     */
    var validator = $("#save").validate({ meta: "validate" });
    // 点击“保存”按钮时先验证，验证通过后方能保存
    $("#submita").click(function() {
        if (validator.form()) { //若验证通过，则调用修改方法
            //提交表单
            document.getElementById('save').submit();
        }
    });
    /**
     * 到这里结束
     */


    /**
     * 修改密码validate 验证 不包含ajax
     */
    $('form[name=revisePW]').validate({
        //错误提示信息放到span标签里面
        errorElement: 'span',
        /*   success:function(label){
              label.addClass('success');
            },*/
        //验证规则编写
        rules: {
            oldPassword: {
                required: true,
                rangelength: [6, 20]
            },
            newPassword: {
                required: true,
                rangelength: [6, 20]
            },
            newNotPassword: {
                required: true,
                equalTo: "#newPassword"
            }
        },
        //显示方式
        messages: {
            oldPassword: {
                required: '您忘记输入旧密码啦.',
                rangelength: '旧密码也应该在6~20位之间哦'
            },
            newPassword: {
                required: '您忘记输入新密码啦~',
                rangelength: '新密码应该在6~20位之间哦'
            },
            newNotPassword: {
                required: '您忘记确认您的密码啦~',
                equalTo: "两次输入密码不一致"
            }
        }

    });



    //头像上传插件配置
    $(window).load(function() {
        var options = {
            thumbBox: '.thumbBox',
            spinner: '.spinner',
            imgSrc: '/' + path
        }
        var cropper = $('.imageBox').cropbox(options);
        $('#upload-file').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                options.imgSrc = e.target.result;
                cropper = $('.imageBox').cropbox(options);
            }
            reader.readAsDataURL(this.files[0]);
            this.files = [];
        })
        $('#btnCrop').on('click', function() {
            var img = cropper.getDataURL();
            //发送AJAX到后台
            $.post(uploadFaceUrl, { urlPic: img }, function(data) {
                if (data.status) {
                    //返回到前端的显示;  
                    $('.cropped').html('');
                    $('.cropped').append('<img src="/' + data.msg + '" align="absmiddle" style="width:64px;margin-top:4px;border-radius:64px;box-shadow:0px 0px 12px #7E7E7E;" ><p>64px*64px</p>');
                    $('.cropped').append('<img src="/' + data.msg + '" align="absmiddle" style="width:128px;margin-top:4px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"><p>128px*128px</p>');
                    $('.cropped').append('<img src="/' + data.msg + '" align="absmiddle" style="width:180px;margin-top:4px;border-radius:180px;box-shadow:0px 0px 12px #7E7E7E;"><p>180px*180px</p>');
                    //nav.html头像替换
                    $('img.navPic').attr('src', '/' + data.msg);
                    //usersession头像替换(就是最大的那张啦);
                    $('img.userpic').attr('src', '/' + data.msg);
                    //执行关闭模态框;
                    setTimeout(function() {
                        $('#modalPic').modal('hide');
                    }, 1500);
                    tishi('修改成功');
                } else {
                    tishi(data.mgs);
                }
            }, 'json');
        })
        $('#btnZoomIn').on('click', function() {
            cropper.zoomIn();
        })
        $('#btnZoomOut').on('click', function() {
            cropper.zoomOut();
        })
    });












})

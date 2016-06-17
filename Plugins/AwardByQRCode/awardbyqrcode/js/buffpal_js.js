jQuery(function(){
    //生成类型切换
    jQuery('input[name=type]').live('click',function(){
        //获取两个需要切换的对象
        var oPic = jQuery('#forpic');
        var oDec = jQuery('#fordec');
        //获取当前类型
        var type = jQuery(this).val();
        //进行判断
        if(type == 'pic'){
            oDec.fadeOut('',function(){
                oPic.fadeIn();
            });
        }else{
            oPic.fadeOut('',function(){
                oDec.fadeIn();
            });
        }

    })


    //点击上传图片
    jQuery(document).ready(function(){
        var ashu_upload_frame;
        var value_id;
        //<a id="ashu_upload" class="ashu_upload_button button" href="#">上传</a>
        jQuery('.ashu_upload_button').live('click',function(event){
            value_id =jQuery( this ).attr('id');
            event.preventDefault();
            if( ashu_upload_frame ){
                ashu_upload_frame.open();
                return;
            }
            ashu_upload_frame = wp.media({
                title: 'Insert image',
                button: {
                    text: 'Insert',
                },
                multiple: false
            });
            ashu_upload_frame.on('select',function(){
                attachment = ashu_upload_frame.state().get('selection').first().toJSON();
                //jQuery('#'+value_id+'_input').val(attachment.url).trigger('change');
                jQuery('input[name='+value_id+']').val(attachment.url).trigger('change');
            });

            ashu_upload_frame.open();
        });
    });





})


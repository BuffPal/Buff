$(function() {
    /**
     * nav样式 头部没地方写了
     */
    $('form.navbar-form input[type=submit]').click(function() {
        var keywordInput = $(this).parent('div.input-group-addon').siblings('input');
        if ($.trim(keywordInput.val()) == '') {
            flashingRed(keywordInput);
            return false;
        }
    });
    //nav头部 Active 选中样式
    var navTitle = $('#navTitle').val();
    var navLength = $('nav ul.nav>li').length;
    for (var i = 0; i < navLength; i++) {
        if ($('nav ul.nav>li').eq(i).find('a').html() == navTitle) {
            $('nav ul.nav>li').eq(i).addClass('active');
        }
    };
    /**
     * 定义ajax模态框的公用属性
     */
    var oProgress = $('#modalAjax div.progress>div');



    /**
     * 音乐播放器固定定位 + 配置 + 效果
     */
    //点击判断
    $('.musicBoxShift').find('button').click(function() {
        //获取 音乐播放器box
        var oMusicBox = $(this).closest('span').siblings('div.jAudio--player');
        var oSpan = $(this).closest('span');
        var width = oMusicBox.width();
        var oParent = $('#musicBox');
        //获取判断 当前是否已经显示
        if ($(this).attr('kaiguan') == '0') {
            oParent.animate({
                left: (width * -1)
            }, 500, 'easeInBack', function() {
                oSpan.addClass('buttonShadow');
            });
            $(this).attr('kaiguan', '1');
        } else {
            oParent.animate({
                left: 10
            }, 500, 'easeOutBack', function() {
                oSpan.removeClass('buttonShadow');
            });
            $(this).attr('kaiguan', '0');
        }

    });

    //定时器用来页面刷新时划出播放器框
    setTimeout(function() {
        var width = $('#musicBox').find('div.jAudio--player').width();
        var oButton = $('#musicBox>span');
        $('#musicBox').animate({
            left: 10
        }, 700, 'easeOutBack', function() {
            oButton.removeClass('buttonShadow');
            setTimeout(function() {
                $('#musicBox').animate({
                    left: (width * -1)
                }, 400, 'easeInBack', function() {
                    oButton.addClass('buttonShadow');
                    oButton.find('button').attr('kaiguan', '1');
                })
            }, 2000)
        })
    }, 2000)












    /**
     * 视屏模态框 AJAX请求
     */
    //点击传入 视频ID AJAX取数据
    $('[vid]').on('click', function() {
        var vid = $(this).attr('vid');
        $('#moreLook').attr('href', videoDetails + vid);
        $('#moreComment').attr('href', videoDetails + vid);
        // $('#modalAjax').modal('show');
        //发送ajax
        $.ajax({
            url: videoAjaxUrl,
            data: { 'vid': vid },
            type: 'post',
            dataType: 'json',
            cache:false,
            // beforeSend: function() { //加载中
            //     beforeSend(oProgress);
            // },
            success: function(data) {
                if (data.status) {
                    /**
                     * 这里很重要,你用firebug看这个video标签会看到他是用JS生产的,所以这里要对照着HTML的代码来写;
                     */
                    $('#video>video').attr({ 'poster': data.msg.videopicurl });
                    $('#video>video').attr({ 'src': data.msg.videourl });
                    $('#videoSource').attr({ 'src': data.msg.videourl });
                    $('#videonameModal').html(data.msg.videoname);
                    $('#modalVideo').modal('show');
                } else {
                    tishi(data.msg);
                }
            },
            // complete: function() { //完成
            //     complete(oProgress);
            // }
        });
    })

    //完全关闭时 删除视频链接 并且清空视频名
    $('#modalVideo').on('hidden.bs.modal', function() {
        $(this).find('video').attr('src','');
        $(this).find('source').attr('src','');
        $(this).find('h4').html('');
    });


    /**
     * 点击播放按钮的时暂停音乐播放
     */
    $('button.vjs-big-play-button').on('click',function(){
        $('div.jAudio--player').find('#btn-pause').trigger("click")
    })

    /**
     * 音乐播放器配置
     */
    $('[mid]').click(function() {
        //获取音乐播放器 节点
        var oJAudio = $('div.jAudio--player');
        //获取music的ID
        var mid = $(this).attr('mid');
        //发送ajax
        $.ajax({
            url: musicAjaxUrl,
            data: { 'mid': mid },
            type: 'post',
            dataType: 'json',
            beforeSend: function() { //执行之前先给他暂停了不然会出错
                oJAudio.find('#btn-pause').trigger("click");
            },
            success: function(data) {
                if (data.status) {
                    //这段貌似像重复代码 用于把音乐播放器拉出来
                    $('#musicBox').animate({
                        left: 10
                    }, 700, 'easeOutBack', function() {
                        $('#musicBox>span').removeClass('buttonShadow').find('button').attr('kaiguan', '0');
                    });
                    //切换音乐源
                    oJAudio.find('audio').attr('src',data.msg.musicurl);
                    //切换背景图
                    oJAudio.find('div.jAudio--thumb').css('background-image',"url(" + data.msg.musicbgurl + ")")
                    //切换歌曲名
                    oJAudio.find('div.jAudio--details>p').find('span').eq(0).html(data.msg.musicname);
                    //切换分类 & 作者
                    oJAudio.find('div.jAudio--details>p').find('span').eq(1).html(data.msg.classifyname+' & '+data.msg.author);
                    //模拟点击事件 就是自动播放trigger("click")
                    oJAudio.find('#btn-play').trigger("click");
                } else {
                    tishi('糟糕出错了~');
                }

            }
        });


    })



})

//首页轮播器配置
$('#myCarousel').carousel({
    interval: 8000,
})

/**
 * 轮播图文字动画加载效果
 */
//执行开始 隐藏文字
$('#myCarousel').on('slide.bs.carousel', function() {
    //这个其实没啥用只是减少手机端的代码运行数量吧
    var panduan = $('#myCarousel').find('h3').eq(0).css('display');
    if (panduan == 'none') {
        return true;
    }
    //获得总数量
    var count = $('#myCarousel .item').length;
    var oDivE = $('#myCarousel div.active'); //获取当前的事件源
    var nowNum = oDivE.index() + 1;
    //获取下一张马上要出来的 h3 p
    var oH3 = $('#myCarousel div.carousel-caption').eq(nowNum).find('h3');
    var oP = $('#myCarousel div.carousel-caption').eq(nowNum).find('p');
    //判断是否是最后一张图  如果是调第一张
    if (nowNum == count) {
        var oH3 = $('#myCarousel div.carousel-caption').eq(0).find('h3');
        var oP = $('#myCarousel div.carousel-caption').eq(0).find('p');
    }
    //执行动画
    stop(true, true);
    oH3.css({
        'margin-bottom': 300,
        'opacity': 0
    });
    oP.css({
        'opacity': 0
    });

});

//执行完成后 运行加载文字动画
$('#myCarousel').on('slid.bs.carousel', function() {
    //这个其实没啥用只是减少手机端的代码运行数量吧
    var panduan = $('#myCarousel').find('h3').eq(0).css('display');
    if (panduan == 'none') {
        return true;
    }
    //获得总数量
    var count = $('#myCarousel .item').length;
    var oDivE = $('#myCarousel div.active'); //获取当前的事件源
    var nowNum = oDivE.index();
    //获取下一张马上要出来的 h3 p
    var oH3 = $('#myCarousel div.carousel-caption').eq(nowNum).find('h3');
    var oP = $('#myCarousel div.carousel-caption').eq(nowNum).find('p');
    //判断是否是最后一张图  如果是调第一张
    if (nowNum == count) {
        var oH3 = $('#myCarousel div.carousel-caption').eq(0).find('h3');
        var oP = $('#myCarousel div.carousel-caption').eq(0).find('p');
    }
    //执行动画
    stop(true, true);
    oH3.animate({
        'opacity': 1,
        'margin-bottom': '10px'
    }, 1000, 'easeInOutBack', function() {
        oP.animate({
            'opacity': 1
        }, 2000);
    });

});









/**
 * 最新视频效果控制
 */
//鼠标放入后弹出 播放按钮
$(window).ready(function() {
    //视频区定义_______________________________________________________________________
    //视频图标动画
    var oNewsVHImg = $('#newsV blockquote h4>img');
    //视频图片动画 B是代表body就是所有的图片
    var oNewsVBImg = $('#newsV .vbody .row>div');
    var sNewsVBImgCount = oNewsVBImg.length;
    var kaiguan1 = true;
    //音乐区定义_______________________________________________________________________
    //获得动画元素事件触发对象
    var oMusicEvent = $('div.musicTitle').find('blockquote').eq(0); //最新推存的标题
    //获得需要加载动画的元素  这里有3个
    var aAnimateObjOne = $('#musicList div.list').eq(0).children('div');
    var aAnimateObjTwo = $('#musicList div.list').eq(1).children('div');
    var aAnimateObjThree = $('#musicList div.list').eq(2).children('div');
    var kaiguan2 = true;
    $(window).scroll(function() {
        //视频区_______________________________________________________________________
        gdjz(oNewsVHImg, 'animation', 60);
        //gdjzf是在Tool里面的用来判断滚动条动画 成功 return true 所以就执行下面的语句  这里是总图片
        if (kaiguan1) {
            if (gdjzf(oNewsVBImg.eq(0), 200)) {
                var i = 0;
                var timer = setInterval(function() {
                    oNewsVBImg.eq(i).addClass('animation');
                    //判断是否执行完毕
                    if (i == sNewsVBImgCount) {
                        clearInterval(timer);
                        kaiguan1 = false;
                    }
                    i++;
                }, 80)
            }
        }
        //监听时间插入 最新音乐监听事件
        //音乐区_______________________________________________________________________
        if (kaiguan2) {
            if (gdjzf(oMusicEvent, 200)) {
                var j = 0;
                //去的最大数(就是最后一个需要完成的动画)
                var array = [parseInt(aAnimateObjOne.length), parseInt(aAnimateObjTwo.length), parseInt(aAnimateObjThree.length)];
                var max = Math.max.apply(null, array);
                var timer2 = setInterval(function() {
                    aAnimateObjOne.eq(j).addClass('rotate');
                    aAnimateObjTwo.eq(j).addClass('rotate');
                    aAnimateObjThree.eq(j).addClass('rotate');
                    //判断是否执行完毕
                    if (j == max) {
                        clearInterval(timer2);
                        kaiguan2 = false;
                    }
                    j++;
                }, 50);
            }
        }

    })
});


/**
 * newsC 固定定位这里用的是jquery.pin插件
 */
$(document).ready(function() {
    //这里布局没考虑周到 导致.newsC不能用 height 100% 这里获取下每日散文的高度 
    var height = $('#read>div>div').eq(0).height();
    $('.newsC').css('height', height);
    $(".pinBox").pinBox({
        Top: '50px',
        Container: '.newsC',
    });
























})

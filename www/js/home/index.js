//ajax
// var demo=new Vue({
//     el:'#app',
//     data: {
//         message:'',
//         getImgUrl: 'http://192.168.0.100:5000/FreshWeather'    //存数据接口               
//     },
//     created: function(){
//         this.getImg()              //定义方法
//     },
//     methods: {
//         getImg: function(){
//             var that = this;      
// that.$http({           //调用接口
//     method:'GET',
//     url:this.getImgUrl  //this指data
// }).then(function(response){  //接口返回数据
//    this.message = response.body.HeWeather5[0].basic.city;                    
// },function(error){
// })
//         }
//     }
// })   
//for

// var httpStr = 'http://www.mxooc.site/index/';
var httpStr = 'http://www.mxooc.site/api/index/';
var oldKeyWord = '';//上一次刷新时的keyWord
var closeLoadAnimate=function(){
  $('.loadAnimate').hide();
  $('.loadAnimate').removeClass('ball-clip-rotate');
} //关闭商品加载动画
var showLoadAnimate =function(){
  $('.loadAnimate').addClass('ball-clip-rotate');
  $('.loadAnimate').show();
}  //开启商品加载动画
$(function () {


  //热词更新
  var example1 = new Vue({
    el: '#hotword',
    data: {
      items: [],
      getImgUrl: httpStr + 'getSearchKeyWords'
    },
    created: function () {
      this.getHotWords();
    },
    methods: {
      getHotWords: function () {
        var that = this;
        that.$http({           //调用接口
          method: 'GET',
          url: this.getImgUrl  //this指data
        }).then(function (response) {  //接口返回数据
          this.items = response.body;
        }, function (error) {
          if(error.status = 401){

          }

        })
      }
    }
  })
  //搜索刷新商品列表
  $('.searhInput').on('click', 'a', function () {
    getStoreList($(this).parent().find('input').val(), 1, 'search');
  })
  //点击热词刷新商品列表
  $('#hotword').on('click', 'li', function () {
    $("#search_box").val($(this).html());
    getStoreList($(this).html(), 1, 'search');
  })


  //获取商品列表
  var getStoreList = function (keyWord, curentpage, type) {  //关键词 ，是否刷新列表
    var keyWord = keyWord || '';
    oldKeyWord = keyWord;
    switch (type) {
      case 'downFresh': $('.storelist').pullToRefreshDone();
        page = 1;
        break;
      case 'search': page = 1;    showLoadAnimate();
        break;
    }

    $.ajax({
      url: httpStr + 'getGoods?keywords=' + keyWord+'&page='+curentpage,
      method: 'get',
      type: 'JSON',
      success: function (data) {
        closeLoadAnimate();
        var data = data.data, str = '';
        if (data.length > 0) {
          for (var c in data) {
            var reduceStr = data[c].coupon_value.split('减'),
                reduceHow = reduceStr[1] || '',
                reduceHdecoration =reduceStr[0] || '';
            str += '<li><div style="width:4rem;height:4.5rem"><img  class="storeImg" src= "' + data[c].image + '" /></div>' +
              '<div class="storeMessage"><p class="storeTitle">' + data[c].name + '</p>' +
              '<p ><label class="storePrice">原价￥<span>' + data[c].price + '</span></label></p>'
              + '<p><div class="minusPrice"><p>'+reduceHdecoration+'减<span>'+ reduceHow + '</span></p><a><img class="getYHQImg" src="/images/home/getYHQ.png" /></a></div></div></p></div>' +
              '</li>'
          }
          loading = false;
          if (curentpage == 1) $('#showStoreList').html(str);
          else if (curentpage > 1) {
            $('.weui-loadmore').addClass('displayNone');
            $('#showStoreList').append(str);
          }

        }
      },
      error: function (data) {
        closeLoadAnimate();
        if (data.responseJSON.error == '暂无数据') {
          if (curentpage == 1) $('#showStoreList').html('<p class="nothingTip">哦吼，没有更多商品了，关注微信号<br>【小小小】，获得更多商品资讯</p>');
          else if (curentpage > 1) {
            $('#showStoreList').append('<p class="nothingTip">哦吼，没有更多商品了，关注微信号<br>【小小小】，获得更多商品资讯</p>');
            $('.weui-loadmore').addClass('displayNone');
          }
        }
      }
    })
  }
  getStoreList('', true,'search');//刷新全部商品列表


  //商品列表内的领券按钮
  $('#showStoreList').on('click', '.getYHQImg', function (e) {
    e.stopPropagation();
    $.modal({
      title: "恭喜您获得优惠券",
      text: "点击复制在淘宝或者天猫app打开",
      buttons: [
        { text: "复制", onClick: function () { console.log(1) } },
      ]
    });
  })






  //商品列表li点击
  var   imgsrc  ='',imgHtmlstr='',wrapScroll;
  $('#showStoreList').on('click', 'li', function () {
    wrapScroll = $('.wrap').scrollTop();
    $('.swiperWrap').removeClass('displayNone').siblings().addClass('displayNone');
    $('.detailStoreBtn').removeClass('displayNone');


     imgsrc = $(this).find('.storeImg').attr('src');
     imgHtmlstr = '<div class="swiper-slide"><img class="swiper_img" src="'+imgsrc+'"/></div>'
     $(".swiper-container").html(imgHtmlstr);
    //商品图片轮播
    $(".swiper-container").swiper({
      loop: true,
      // autoplay: 3000,
      nextButton: '.swiper-button-next',
      prevButton: '.swiper-button-prev',
    });
  })




  FastClick.attach(document.body);//weui初始化
  // $(document.body).infinite();



  //滚动加载
  var loading = false, page = 1;
  $('.wrap').scroll(function () {

    var $this = $(this),
      viewH = $(this).height(),//可见高度
      contentH = $(this).get(0).scrollHeight,//内容高度
      scrollTop = $(this).scrollTop();//滚动高度
    if (scrollTop > 300) {
      $('.backToTop').fadeIn(1000);
    }
    else {
      $('.backToTop').fadeOut(1000);
    }
    if (loading) return;
    if (contentH - viewH - scrollTop <= 100) {
      loading = true;
      page += 1;
      $('.weui-loadmore').removeClass('displayNone');
      getStoreList(oldKeyWord, page, 'scrollFresh');
    }
  });

  //返回顶部
  $('.backToTop').click(function () {
    $('.wrap').animate({ scrollTop: 0 })
  })

  //商品详细信息----------------------------------------
  //返回列表
  $('.returnList a').click(function () {
    $('.swiperWrap').addClass('displayNone').siblings().removeClass('displayNone');
    $('.wrap').scrollTop(wrapScroll);
  })
  //领取优惠券
  $('.getYHQ').click(function () {
    $('.swiperWrap').addClass('displayNone').siblings().removeClass('displayNone');
    $('.returnList a').click();
    $.modal({
      title: "恭喜您获得优惠券",
      text: "点击复制在淘宝或者天猫app打开",
      buttons: [
        { text: "复制", onClick: function () { console.log(1) } },
      ]
    });
  })


})
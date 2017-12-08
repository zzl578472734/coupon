
jQuery(document).ready(function() {


    //登陆按钮
    $('#login').click(function(){
        var username = $('#username').val();
        var password = $('#password').val();
        if(username == '') {
            $('.error').fadeOut('fast', function(){
                $(this).parent().css('top', '27px');
            });
            $(this).find('.error').fadeIn('fast', function(){
                $('.username').focus();
            });
            return false;
        }
        if(password == '') {
            $('.error').fadeOut('fast', function(){
                $(this).parent().css('top', '96px');
            });
            $('.error').fadeIn('fast', function(){
                $('.password').focus();
            });
            return false;
        }

        $.ajax({
            url:'login',
            type:'post',
            dataType: "json",
            data:{
                username:username,
                password:password
            },
            success:function(data){
                $.cookie('token',data.token,{path:"/admin"});
                console.log( $.cookie('token'));
                var token = $.cookie('token');
                window.location.href = 'http://www.coupon.com/admin/index/index?token='+data.token;
            },
            error:function(data){
                if(data.status == 401){
                    alert('密码错了,你滚吧')
                }
            }
        })
    });

    //输入框键盘事件
    $('#username,#password').keyup(function(e){
        if(e.keyCode == 13){
            $('#login').click();
        }
    });

});

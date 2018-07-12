/**
 * 前端登录业务类
 * @author singwa
 */
var login = {
    check : function() {
        // 获取登录页面中的用户名 和 密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();
        if(!username) {
            dialog.error('用户名不能为空');
        }
        if(!password) {
            dialog.error('密码不能为空');
        }
        var url = "/admin.php?c=login&a=check";
        var data = {'username':username,'password':password};

        //执行异步请求  $.post
        $.post(url,data,function(result){
            if(result.status == 0) {
                return dialog.error(result.message);
            }
            else if(result.status == 1){
                return dialog.success(result.message, '/admin.php?c=index');
            }
            else if(result.status == 2) {

                return dialog.success(result.message, '/admin.php?m=platformadmin&c=index');
            }
            else if(result.status == 3){
                return dialog.success(result.message, '/admin.php?m=tenant&c=index');
            }
            else{
                return dialog.success(result.message, 'https://www.bilibili.com');
            }

        },'JSON');

    }

}


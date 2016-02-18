    <!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <title>管理员登陆</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Joychao <joy@joychao.cc>">    
  </head>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link class="bootstrap library" rel="stylesheet" type="text/css" href="<?=base_url()?>static/home/2.2.0/css/bootstrap.min.css">
    <script type="text/javascript" src="<?=base_url()?>static/home/Js/jquery.js"></script>
   <script type="text/javascript" src="<?=base_url()?>static/home/2.2.0/js/bootstrap.min.js"></script>
   <style>*{margin:0;padding: 0;}
    
      .loginBox{width:420px;height:230px;padding:0 20px;border:1px solid #fff; color:#000; margin-top:40px; border-radius:8px;background: white;box-shadow:0 0 15px #222; background: -moz-linear-gradient(top, #fff, #efefef 8%);background: -webkit-gradient(linear, 0 0, 0 100%, from(#f6f6f6), to(#f4f4f4));font:11px/1.5em 'Microsoft YaHei' ;position: absolute;left:50%;top:40%;margin-left:-210px;margin-top:-115px;}
      .loginBox h2{height:45px;font-size:20px;font-weight:normal;}
      .loginBox .left{border-right:1px solid #ccc;height:100%;padding-right: 20px; }
      .tips{ color:#FF0000}
</style>
  </head>
  <body>
    <div class="container">
    <form class="form-signin" method="post" action="<?=base_url()?>index.php/home/login/do_login">
            <section class="loginBox row-fluid">
                    <div class="tabbable" id="tabs-634549">
                        <ul class="nav nav-tabs">
<!--                            <li>
                                <a href="#panel-60560" data-toggle="tab">帐号登录</a>
                            </li>-->
                            <li class="active">
                                <a href="#panel-549981" data-toggle="tab">管理员登陆</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="panel-60560">
                            
                            </div>
                            <div class="tab-pane active" id="panel-549981">
                                <DIV>
                                <input type="text" name="username" id="username" placeholder="用户名"/>
                                <span class="tips" id="usernametip"></span>
                                </DIV>
                                <DIV>
                                    <input type="password" name="pawd" id="pawd" placeholder="密码"/>
                                    <span class="tips" id="pwdtip"></span>
                                </DIV>
                                 <DIV class="span6"><label><input type="checkbox" name="rememberme" />下次自动登录</label></DIV>
                                    <DIV class="span1"><input type="button" value=" 登录 " class="btn btn-primary" ></DIV>
                            </div>
                        </div>
                    </div>
        </section><!-- /loginBox -->
        </form>
    </div> <!-- /container -->
  </body>
  <script>
var hostname = "<?=base_url()?>";

 $(".btn-primary").bind("click", function() {
      var username = jQuery.trim($("#username").val());
      var pawd = jQuery.trim($("#pawd").val()); 
        if(username == ''){
            $("#usernametip").html("请填写用户名");
            return false;
         }else{
            $("#usernametip").html("");
         }
         if(pawd == ''){
            $("#pwdtip").html("请填写密码");
            return false;
         }else{
            $("#pwdtip").html("");
         }
         
          
      $(".btn-primary").text("登录中请稍等...");
      var aj = $.ajax( {
              url:hostname + 'index.php/home/login/do_login',
              data:{
                  username : username,
                  pawd : pawd,
              },
              contentType:"application/x-www-form-urlencoded; charset=utf-8",
              type:'post',
              cache:false,
              dataType:'json',
              success:function(data){
               // alert(data.msg);
                if(data.errcode != 0){
                    if(data.errcode == -1){
                        $("#usernametip").html(data.msg);
                    }else if(data.errcode == -2){  //账号不存在
                        $("#usernametip").html(data.msg);
                    }else if(data.errcode == -3){
                        $("#pwdtip").html(data.msg);
                    }else{
                      alert(data.msg);
                    }

                     $(".btn-primary").text("登陆");
                  
                  
                }else{
                    window.location = hostname+'index.php/home/index';
                }

              },
              error : function() {
                  alert("请求失败，请重试");
              }
          });
      });
</script>
</html>



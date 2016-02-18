<?php Widget::head();?>

<link rel="stylesheet" href="<?=base_url()?>static/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="<?=base_url()?>static/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="<?=base_url()?>static/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="<?=base_url()?>static/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="<?=base_url()?>static/kindeditor/plugins/code/prettify.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/uploadify/jquery.uploadify.min.js"></script>

<link rel="stylesheet" href="<?=base_url()?>static/widget/chosen.min.css">

<link href="<?=base_url()?>static/uploadify/uploadify.css" rel="stylesheet" type="text/css">
<script>
    KindEditor.ready(function(K) {
      var editor1 = K.create('textarea[name="newsContent"]', {
        cssPath : '<?=base_url()?>static/kindeditor/plugins/code/prettify.css',
        uploadJson : '<?=base_url()?>static/kindeditor/php/upload_json.php',
        fileManagerJson : '<?=base_url()?>static/kindeditor/php/file_manager_json.php',
        allowFileManager : true,
        filterMode: true,//是否开启过滤模式

      });

        var editor1 = K.create('textarea[name="intro"]', {
        cssPath : '<?=base_url()?>static/kindeditor/plugins/code/prettify.css',
        uploadJson : '<?=base_url()?>static/kindeditor/php/upload_json.php',
        fileManagerJson : '<?=base_url()?>static/kindeditor/php/file_manager_json.php',
        allowFileManager : true,
        filterMode: true,//是否开启过滤模式

      });
      prettyPrint();
    });

  var hostname = '<?=base_url()?>';
$(function(){

//网站logo

  var piclist = '';
  var idnum = 999;
  $('#uploadify').uploadify({
    
    'swf':hostname+'static/uploadify/uploadify.swf',//选择文件按钮
    'uploader':hostname+'index.php/userupload/upload',//处理文件上传的php文件
    //'buttonImage': hostname+"static/images/upload_btn.png",
    'buttonClass' : 'upload_img',
    'wmode': "transparent",
    'removeCompleted':false,
    'width':'130',//选择文件按钮的宽度
    'height':'26',//选择文件按钮的高度
    'debug':false,
    'multi':false,//设置为true时可以上传多个文件
    'auto' : true,
    'fileObjName':'uploadify',
    'postData' : {dir:'product'},
         'buttonText':"选择文件",
    'onUploadComplete':function(file,data,response){
      //alert(data);
      //$("#logo").attr('src',hostname+'uploads/test/');

    },

    'onUploadError':function(file,errorCode,errorMsg){
      alert('上传错误：错误代码：'+obj2string(errorCode)+'错误消息：'+obj2string(errorMsg));
    },
    'onInit': function () {                        //载入时触发，将flash设置到最小
               $("#uploadify-queue").hide();
         },
    onUploadSuccess:function(file,data,response){
      idnum++;
      piclist = "<li id=\"img_"+idnum+"\"><img src='"+hostname+"uploads/product/"+data+" '/><br/><a href='javascript:void(0);' onclick='delpic(\"img_"+idnum+"\");'>删除</a><input type='hidden' name='pic[]' value='"+data+"' /></li>";
     
      $("#piclist").append(piclist);
      
    }
  });


});

  function get_attr(id)
  {
         // alert(hostname);
          
          var aj = $.ajax( {
                url:hostname + 'index.php/home/product/get_attr',
                data:{
                    categoryid : id,
                },
                contentType:"application/x-www-form-urlencoded; charset=utf-8",
                type:'post',
                cache:false,
                dataType:'text',
                success:function(data){
                 
              
              // $("#info tr:eq(3)").after('<tr><td class="tableleft">属性</td><td>'+data+'</td></tr>');
                  $("#attr").html(data);
                 // $("#attrtr").css('display','block');
                 init();

                },
                error : function() {
                    alert("ERROR");
                }
            });

  }
</script>
<body>
	
<form name="form1" method="post" action="<?=base_url()?>index.php/home/product/add" enctype="multipart/form-data"/>
<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">基本信息</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">描述</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">图片</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">其他</a></li>
  </ul>
<table class="table definewidth m10">
    <tr>
        <td>
            
                          <!-- Tab panes -->
              <div class="tab-content">
              <!--基本信息-->
                <div role="tabpanel" class="tab-pane active" id="home">
                    
                    <table class="table table-bordered table-hover" id="info">
                        <thead>
                        <tr>

                            <th></th>      
                            <th></th>
                        </tr>
                        </thead>
                        <tr>
                            <td class="tableleft">产品名称</td>       
                           <td colspan="2">
                             <input type="text" class="form-control" name="p_name" placeholder="产品名称"> <span class="label label-danger">必填</span>
                           </td>
                      </tr>
                    <tr>
                            <td class="tableleft">品牌</td>       
                           <td colspan="2">
                             <!--<select class="form-control" name="brand_id">-->
                             <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="brand_id">
                              <option>请选择品牌</option>
                              <?php
                                foreach($brand as $k => $v){
                              ?>
                              <option value="<?=$v['id']?>"><?=$v['b_name']?></option>
                              <?php
                                }
                              ?>

                            </select>
                           </td>
                      </tr>

                        <tr>
                            <td class="tableleft">类别</td>       
                           <td colspan="2">
                            <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="category_id" onchange="get_attr(this.value);">
                          
                           <!--<select class="form-control" name="category_id" onchange="get_attr(this.value);"> -->
                              <option>请选择类别</option>
                              <?php
                                foreach($category as $k => $v){
                              ?>
                              <option value="<?=$v['id']?>"><?=$v['c_name']?></option>
                              <?php
                                }
                              ?>

                            </select>
                             
                           </td>
                      </tr>
                   <tr id="attrtr">
                            <td class="tableleft">属性</td>       
                           <td colspan="2" id="attr">
                           </td>
                      </tr>
                    <tr>
                            <td class="tableleft">数量</td>       
                           <td colspan="2">
                             <input type="text" class="form-control" name="total"  placeholder="数量"> <span class="label label-danger">必填</span>
                           </td>
                      </tr>
                    <tr>
                            <td class="tableleft">价格</td>       
                           <td colspan="2">
                             <input type="text" class="form-control" name="price"  placeholder="价格"> <span class="label label-danger">必填</span>
                           </td>
                      </tr>
                      <tr>
                            <td class="tableleft">折扣</td>       
                           <td colspan="2">
                             <input type="text" class="form-control" name="discount"  placeholder="折扣"> 
                           </td>
                      </tr>
                      <tr>
                            <td class="tableleft">支付方式</td>       
                           <td colspan="2">
                           <?php
                            foreach($pay as $k => $v){
                           ?>
                           <input type="checkbox"  value="<?=$v['id']?>" name="pay_id[]"> <?=$v['pay_name']?>   
                           <?php
                            }
                           ?>

                           </td>
                      </tr>
                    <tr>
                        <td class="tableleft">图片</td>   
                        <td><input type="file" name="userfile" /></td>      
                    </tr>
                    <tr>
                            <td class="tableleft">上下架</td>       
                           <td colspan="2">
                             <input type="radio" name="enabled" id="inlineCheckbox1" value="0">  <span class="label label-danger">下架</span>
                             <input type="radio" name="enabled" id="inlineCheckbox1" value="1">  <span class="label label-success">上架</span>
                           </td>
                      </tr>
                      <tr>
                            <td class="tableleft">划分</td>       
                           <td colspan="2">
                             <input type="radio" name="types" id="inlineCheckbox1" value="1"> 普通产品
                             <input type="radio" name="types" id="inlineCheckbox1" value="2"> 二手
                             <input type="radio" name="types" id="inlineCheckbox1" value="3"> 周边
                             <input type="radio" name="types" id="inlineCheckbox1" value="4"> 寄售
                           </td>
                      </tr>
                    </table>
                </div>
                <!--基本信息-->

                <!--描述-->
                <div role="tabpanel" class="tab-pane" id="profile">
                    <table class="table table-bordered  definewidth m10">


                        <tr>
                            <td class="tableleft">简介</td>   
                            <td>
                           <textarea name="intro" style="width:100%;height:400px;visibility:hidden;"></textarea>
                            </td>      
                        </tr>
                        <tr>
                          <td class="tableleft">详情</td>
                          <td colspan="2">
                       <!-- <?=$fcf?>-->
                        <textarea name="newsContent" style="width:100%;height:400px;visibility:hidden;"></textarea>
                        </td>
                        </tr>
                       
                    </table>
                </div>
                 <!--描述-->

                  <!--图片-->
                <div role="tabpanel" class="tab-pane" id="messages">
                    <input type="file" name="uploadify" id="uploadify" >
                    <br/>
                    <br/>
                    <ul id="piclist">
                    </ul>
                </div>
                 <!--图片-->

                  <!--其他-->
                <div role="tabpanel" class="tab-pane" id="settings">
                    
                </div>
                 <!--其他-->
              </div>

            </div>
        </td>       
    </tr>
    <tr>

        <td colspan="4"><input type="submit" class="btn btn-primary" value="提交"/></td>   
    </tr>
    </table>
</form>
  <script src="<?=base_url()?>static/widget/jquery.chosen.min.js"></script>
  <script type="text/javascript">
  function init()
  {
        var config = {
      '.chosen-select'           : {}

      }
      for (var selector in config) {
        $(selector).chosen(config[selector]);
      }
  }

  $(function(){

    init();
  })

  </script>
<script>

function delpic(id)
{
   $("#"+id).remove();
}
</script>


</body>
</html>

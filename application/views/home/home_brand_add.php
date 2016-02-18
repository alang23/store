<?php Widget::head();?>
<link rel="stylesheet" href="<?=base_url()?>static/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="<?=base_url()?>static/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="<?=base_url()?>static/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="<?=base_url()?>static/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="<?=base_url()?>static/kindeditor/plugins/code/prettify.js"></script>
<script>
    KindEditor.ready(function(K) {
      var editor1 = K.create('textarea[name="newsContent"]', {
        cssPath : '<?=base_url()?>static/kindeditor/plugins/code/prettify.css',
        uploadJson : '<?=base_url()?>static/kindeditor/php/upload_json.php',
        fileManagerJson : '<?=base_url()?>static/kindeditor/php/file_manager_json.php',
        allowFileManager : true,
        filterMode: true,//是否开启过滤模式

      });
      prettyPrint();
    });
</script>
<body>
	

<form name="form1" method="post" action="<?=base_url()?>index.php/home/brand/add" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">品牌名称</td>       
       <td colspan="2">
         <input type="text" name="b_name"> <span class="label label-danger">必填</span>
       </td>
  </tr>
    <tr>
        <td>图片</td>   
        <td><input type="file" name="userfile" /></td>      
    </tr>
    <tr>
      <td>品牌故事</td>
      <td colspan="2">
   <!-- <?=$fcf?>-->
    <textarea name="newsContent" style="width:100%;height:400px;visibility:hidden;"></textarea>
    </td>
    </tr>
    <tr>
	 	<td colspan="4"><input type="submit" value="提交"/></td>   
    </tr>
	</table>
</form>
</body>
</html>

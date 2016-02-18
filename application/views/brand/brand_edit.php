<?php Widget::head();?>

<body>
	<ol class="breadcrumb  definewidth m10">
  <li>品牌列表</li>
  <li>编辑</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php/brand/update" enctype="multipart/form-data"/>
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
         <input type="text" name="b_name" value="<?=$info['b_name']?>"> <span class="label label-danger">必填</span>
       </td>
  </tr>
    <tr>
        <td class="tableleft">图片</td>   
        <td><input type="file" name="userfile" /><img src="<?=base_url()?>uploads/brand/<?=$info['b_pic']?>" /></td>      
    </tr>
    <tr>
      <td class="tableleft">备注</td>
      <td colspan="2">
   <!-- <?=$fcf?>-->
    <textarea name="newsContent" class="form-control"><?=$info['b_story']?></textarea>
    </td>
    </tr>
    <tr>
    <input type="hidden" name="id" value="<?=$info['id']?>" />
	 	<td colspan="4"><input type="submit"  class="btn btn-primary" value="提交"/></td>   
    </tr>
	</table>
</form>
</body>
</html>

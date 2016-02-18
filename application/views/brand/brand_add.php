<?php Widget::head();?>

<body>
	<ol class="breadcrumb  definewidth m10">
  <li>品牌列表</li>
  <li>添加</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php/brand/add" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">品牌名称-中文</td>       
       <td colspan="2">
         <input type="text" name="b_name" class="form-control"  placeholder="品牌名称-中文"> <span class="label label-danger">必填</span>
       </td>
  </tr>
      <tr>
        <td class="tableleft">品牌名称-英文</td>       
       <td colspan="2">
         <input type="text" name="b_name_en" class="form-control"  placeholder="品牌名称-英文"> <span class="label label-danger">必填</span>
       </td>
  </tr>
    <tr>
        <td class="tableleft">图片</td>   
        <td><input type="file" name="userfile" /></td>      
    </tr>
    <tr>
      <td class="tableleft">备注</td>
      <td colspan="2">
   <!-- <?=$fcf?>-->
    <textarea name="newsContent" class="form-control"></textarea>
    </td>
    </tr>
    <tr>
	 	<td colspan="4"><input type="submit"  class="btn btn-primary" value="提交"/></td>   
    </tr>
	</table>
</form>
</body>
</html>

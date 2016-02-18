<?php Widget::head();?>
<body>
<ol class="breadcrumb  definewidth m10">
  <li>权限组</li>
  <li>添加</li>
</ol>   	

<form name="form1" method="post" action="<?=base_url()?>index.php/group/add" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">权限组名称</td>       
       <td colspan="2">
         <input type="text" name="g_name" class="form-control"  placeholder="权限组名称"> <span class="label label-danger">必填</span>
       </td>
  </tr>


        <tr>
        <td class="tableleft">备注</td>   
        <td>
            <textarea name="g_intro" class="form-control"></textarea>

        </td>      
    </tr>
    <tr>

	 	<td colspan="4"><input type="submit" class="btn btn-primary" value="提交"/></td>   
    </tr>
	</table>
</form>
</body>
</html>

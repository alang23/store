<?php Widget::head();?>

<body>
	<ol class="breadcrumb  definewidth m10">
  <li>买手</li>
  <li>添加</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php/buyer/add" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">昵称</td>       
       <td colspan="2">
         <input type="text" name="nickname" class="form-control"  placeholder="昵称"> 
       </td>
  </tr>
      <tr>
        <td class="tableleft">真实姓名</td>       
       <td colspan="2">
         <input type="text" name="realname" class="form-control"  placeholder="真实姓名"> 
       </td>
  </tr>
    <tr>
        <td class="tableleft">照片</td>   
        <td><input type="file" name="userfile" /></td>      
    </tr>
          <tr>
        <td class="tableleft">联系电话</td>       
       <td colspan="2">
         <input type="text" name="mobile" class="form-control"  placeholder="联系电话"> 
       </td>
  </tr>
            <tr>
        <td class="tableleft">邮箱</td>       
       <td colspan="2">
         <input type="text" name="email" class="form-control"  placeholder="邮箱"> 
       </td>
  </tr>

    <tr>
	 	<td colspan="4"><input type="submit"  class="btn btn-primary" value="提交"/></td>   
    </tr>
	</table>
</form>
</body>
</html>

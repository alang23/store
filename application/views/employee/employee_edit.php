<?php Widget::head();?>

<body>
	<ol class="breadcrumb  definewidth m10">
  <li>员工列表</li>
  <li>编辑</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php/employee/update" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">用户名</td>       
       <td colspan="2">
         <input type="text" name="username" class="form-control"  placeholder="用户名" value="<?=$info['username']?>"> 
       </td>
  </tr>
      <tr>
        <td class="tableleft">真实姓名</td>       
       <td colspan="2">
         <input type="text" name="realname" class="form-control"  placeholder="真实姓名" value="<?=$info['realname']?>"> 
       </td>
  </tr>
    <tr>
        <td class="tableleft">照片</td>   
        <td><input type="file" name="userfile" /></td>      
    </tr>
          <tr>
        <td class="tableleft">联系电话</td>       
       <td colspan="2">
         <input type="text" name="mobile" class="form-control"  placeholder="联系电话" value="<?=$info['mobile']?>"> 
       </td>
  </tr>
  <tr>
        <td class="tableleft">邮箱</td>       
       <td colspan="2">
         <input type="text" name="email" class="form-control"  placeholder="邮箱" value="<?=$info['email']?>"> 
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

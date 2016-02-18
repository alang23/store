<?php Widget::head();?>
<body>
<ol class="breadcrumb  definewidth m10">
  <li>仓库</li>
  <li>编辑</li>
</ol>	

<form name="form1" method="post" action="<?=base_url()?>index.php/pays/update" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">支付账号</td>       
       <td colspan="2">
         <input type="text" name="pay_name" value="<?=$info['pay_name']?>" class="form-control"  placeholder="支付账号"> <span class="label label-danger">必填</span>
       </td>
  </tr>


            <tr>
        <td class="tableleft">备注</td>   
        <td>
            <textarea name="pay_intro" class="form-control"><?=$info['pay_intro']?></textarea>

        </td>      
    </tr>
    <tr>
        <input type="hidden" name="id" value="<?=$info['id']?>" />
	 	<td colspan="4"><input type="submit" class="btn btn-primary" value="提交"/></td>   
    </tr>
	</table>
</form>
</body>
</html>

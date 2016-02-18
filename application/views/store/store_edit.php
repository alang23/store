<?php Widget::head();?>
<body>
<ol class="breadcrumb  definewidth m10">
  <li>仓库</li>
  <li>编辑</li>
</ol>	

<form name="form1" method="post" action="<?=base_url()?>index.php/store/update" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">仓库名称</td>       
       <td colspan="2">
         <input type="text" name="store_name" value="<?=$info['store_name']?>" class="form-control"  placeholder="仓库名称"> <span class="label label-danger">必填</span>
       </td>
  </tr>


            <tr>
        <td class="tableleft">简介</td>   
        <td>
            <textarea name="store_intro" class="form-control"><?=$info['store_intro']?></textarea>

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

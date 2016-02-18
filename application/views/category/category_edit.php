<?php Widget::head();?>
<body>
<ol class="breadcrumb  definewidth m10">
  <li>分类列表</li>
  <li>编辑</li>
</ol>	

<form name="form1" method="post" action="<?=base_url()?>index.php/category/update" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">规格名称</td>       
       <td colspan="2">
         <input type="text" name="c_name" value="<?=$info['c_name']?>" class="form-control"  placeholder="分类名称"> <span class="label label-danger">必填</span>
       </td>
  </tr>
    <tr>
        <td class="tableleft">图片</td>   
        <td>
        <input type="file" name="userfile" />

        <?php
            if(!empty($info['c_pic'])){
        ?>
        <img src="<?=base_url()?>uploads/category/<?=$info['c_pic']?>" width="80px" height="80px"/>
        <?php
            }
        ?>
        </td>      
    </tr>

            <tr>
        <td class="tableleft">简介</td>   
        <td>
            <textarea name="c_intro" class="form-control"><?=$info['c_intro']?></textarea>

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

<?php Widget::head();?>
<script>
function flush(msg,url){
	art.dialog(
		msg, 
		function () {
			
			window.location = url;
		},
		function(){
			
		}
	);
}



</script>
<body>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <a href="<?=base_url()?>index.php/color/add">
        <button type="button" class="btn btn-default navbar-btn" >添加</button>
        </a>      </ul>
      <form class="navbar-form navbar-left" role="search" action="#">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="button" class="btn btn-default">Submit</button>
      </form>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb  definewidth m10">
  <li>颜色列表</li>
</ol>

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>
      
         <th >颜色名称</th>
         <th >图</th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
        <td valign="middle"><?=$v['id']?></td>     
         <td valign="middle">
         <?=$v['color_name']?>

         </td>
       <td valign="middle">
        
        <?php
         if(!empty($v['img'])){
         ?>
         <img src="<?=base_url()?>uploads/color/<?=$v['img']?>" width="40px" height="40px"/>
         <?php
          }
         ?>
       </td>  
        <td>
        	
		<a href="<?=base_url()?>index.php/color/update?id=<?=$v['id']?>">编辑</a> | 
		<a href="javascript:void(0);" onclick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php/color/del?id=<?=$v['id']?>')">删除</a> 
		
    </td>
    </tr>

	<?php
	}
	?>
  <tr>
        <td colspan="8">
        <!--<?=$page?> -->
          <nav>       
            <ul class="pagination">
               <?=$page?>
            </ul>
          </nav>
        </td>
    </tr>
</table>

</body>
</html>

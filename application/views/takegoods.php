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
        
        <a href="<?=base_url()?>index.php/takegoods/add">
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


<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>
         <th>产品名称</th>
         <th>缩略图</th>
         <th>委托人</th>
         <th>联系电话</th>
         <th>检验结果</th>
         <th>处理结果</th>
         <th>管理操作</th>
    </tr>
    </thead>

	
    <tr>
         <td valign="middle"><?=$v['id']?></td>     
         <td valign="middle"><?=$v['goods_name']?></td>
         <td valign="middle"><?=$v['goods_name']?></td> 
         <td valign="middle"><?=$v['goods_name']?></td> 
         <td valign="middle"><?=$v['goods_name']?></td> 
         <td valign="middle"><?=$v['goods_name']?></td> 
         <td valign="middle"><?=$v['goods_name']?></td>  
         <td>      	
		      <a href="<?=base_url()?>index.php/home/category/update?id=<?=$v['id']?>">编辑</a> | 
		      <a href="javascript:void(0);" onclick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php/home/category/del?id=<?=$v['id']?>')">删除</a> 	
        </td>
    </tr>


  <tr>
        <td colspan="9">
        <!--<?=$page?> -->
          <nav>       
            <ul class="pagination">
             
            </ul>
          </nav>
        </td>
    </tr>
</table>

</body>
</html>

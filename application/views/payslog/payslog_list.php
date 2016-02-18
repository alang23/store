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
        
        <a href="<?=base_url()?>index.php/goods/add">
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
  <li>商品列表</li>
</ol>

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>订单号</th>   
         <th >产品名称</th>
         <th >市场价</th>
         <th >成交价</th>
         <th >已付</th>
         <th >价格</th>
         <th >状态</th>
         <th >时间</th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
        <td valign="middle"><a href="<?=base_url()?>index.php/goods/show?id=<?=$v['id']?>"><?=$v['order_no']?></a></td>     
        <td valign="middle"><?=$v['goods_name']?></td>
        <td valign="middle"><?=$v['price_market']?></td>
        <td valign="middle"><?=$v['deal_cost']?></td>
        <td valign="middle"><?=$v['done_cost']?></td>
        <td valign="middle"><?=$v['price_market']?></td>
        <td valign="middle"><?=$v['status']?></td>
       <td valign="middle"><?=date("Y-m-d H:i:s")?></td>  
        <td>
        	<!--
		<a href="<?=base_url()?>index.php/goods/update?id=<?=$v['id']?>">编辑</a> | 
		<a href="javascript:void(0);" onclick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php/goods/del?id=<?=$v['id']?>')">删除</a>
    -->
     
      <a href="<?=base_url()?>index.php/payslog/logs?id=<?=$v['id']?>">付款记录</a>
      
    </td>
    </tr>

	<?php
	}
	?>
  <tr>
        <td colspan="9">
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

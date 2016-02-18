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

        <th>编号</th>   
         <th >商品名称</th>
         <th >客户</th>
         <th >成交价</th>
         <th >业务员</th>
         <th >配送</th>
         <th >状态</th>
         <th >时间</th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
        <td valign="middle"><a href="<?=base_url()?>index.php/goods/show?id=<?=$v['goods_id']?>"><?=$v['order_no']?></a></td>     
        <td valign="middle"><a href="<?=base_url()?>index.php/goods/show?id=<?=$v['goods_id']?>"><?=$v['goods_name']?></a></td>
        <td valign="middle"><?=$v['customer_name']?></td>
        <td valign="middle"><?=$v['deal_cost']?></td>
        <td valign="middle"><?=$v['username']?></td>
        <td valign="middle">
          <?php
            if($v['exp'] == 0){
          ?>
          <font color="red">未配送</font>
          <?php
            }elseif($v['exp']==1){
          ?>
            <font color="green">已配送</font>
          <?php
            }
          ?>
        </td>
        <td valign="middle">
          
         <?php
            if($v['status'] == 0){
          ?>
          <font color="green">全款</font>
          <?php
            }elseif($v['status']==1){
          ?>
           <font color="red"> 未全款</font>
          <?php
            }
          ?>
        </td>
       <td valign="middle"><?=date("Y-m-d H:i:s",$v['createtime'])?></td>  
        <td>
        	
		  <?php
        if($v['exp'] == 0){
      ?> 
		    <a href="<?=base_url()?>index.php/orders/freight?id=<?=$v['id']?>">配送</a>
        <?php
          }
        ?>

        <?php
          if($v['status'] == 1){
        ?>
        <a href="<?=base_url()?>index.php/orders/pays?id=<?=$v['id']?>">付款</a>
        <?php
          }
        ?>
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

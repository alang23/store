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
<link rel="stylesheet" href="<?=base_url()?>static/widget/chosen.min.css">
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
      <form class="navbar-form navbar-left" role="search" action="<?=base_url()?>index.php/goods/index" method="get">
        <div class="form-group">
          名称：<input type="text" class="form-control" name="goods_name" placeholder="名称" value="<?=$goods_name?>">
        </div>
        <div class="form-group">
          编号<input type="text" class="form-control" name="goods_no" placeholder="编号" value="<?=$goods_no?>">
        </div>

         <div class="form-group">
      
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:100px;" tabindex="2" name="category_id" >

            <option value="0">-分类-</optin>
             <?php
              foreach($categorys as $k2 => $v2){
             ?>
              <option value="<?=$v2['id']?>" <?php if($category_id == $v2['id']){?> selected <?php } ?> ><?=$v2['c_name']?></optin>
                <?php
              }
                ?>
               
         </select>        
       </div>

                <div class="form-group">
      
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:100px;" tabindex="2" name="buyer_id" >

            <option value="0">-买手-</optin>
              <?php
              foreach($buyers as $k3 => $v3){
             ?>
              <option value="<?=$v3['id']?>" <?php if($buyer_id == $v3['id']){?> selected <?php } ?>><?=$v3['nickname']?></optin>
               <?php
             }
               ?>
         </select>        
       </div>
                <div class="form-group">
      
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:100px;" tabindex="2" name="goods_color" >

            <option value="0">-颜色-</optin>
                           <?php
              foreach($colors as $k4 => $v4){
             ?>
              <option value="<?=$v4['id']?>" <?php if($goods_color == $v4['id']){?> selected <?php } ?>><?=$v4['color_name']?></optin>
               <?php
             }
               ?>
         </select>        
       </div>
        <button type="submit" class="btn btn-primary">查询</button>
         <a href="<?=base_url()?>index.php/goods/index"><button type="button" class="btn btn-primary">全部</button></a>
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
         <th >名称</th>
         <th >分类</th>
         <th >材质</th>
         <th >尺寸</th>
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
        <td valign="middle"><a href="<?=base_url()?>index.php/goods/show?id=<?=$v['id']?>"><?=$v['goods_no']?></a></td>     
        <td valign="middle"><?=$v['goods_name']?></td>
        <td valign="middle"><?=$v['category_id']?></td>
        <td valign="middle"><?=$v['goods_caizhi']?></td>
        <td valign="middle"><?=$v['goods_size']?></td>
        <td valign="middle"><?=$v['price_market']?></td>
        <td valign="middle"><?=$v['status']?></td>
       <td valign="middle"><?=date("Y-m-d H:i:s")?></td>  
        <td>
        	<!--
		<a href="<?=base_url()?>index.php/goods/update?id=<?=$v['id']?>">编辑</a> | 
		<a href="javascript:void(0);" onclick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php/goods/del?id=<?=$v['id']?>')">删除</a>
    -->
      <?php
        if($v['status'] == '0'){
      ?>
      <a href="<?=base_url()?>index.php/goods/sales?id=<?=$v['id']?>">销售</a>
      <?php
        }elseif($v['status'] == '3'){

      ?>
      已出售
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
 <script src="<?=base_url()?>static/widget/jquery.chosen.min.js"></script>
  <script type="text/javascript">
  function init()
  {
        var config = {
      '.chosen-select'           : {}

      }
      for (var selector in config) {
        $(selector).chosen(config[selector]);
      }
  }

  $(function(){

    init();
  })

  </script>
</body>
</html>

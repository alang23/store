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

<ol class="breadcrumb  definewidth m10">
  <li>商品列表</li>
</ol>

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>支付方式</th>   
         <th >支付金额</th>
         <th >时间</th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
        <td valign="middle"><?=$v['pay_name']?></td>     
        <td valign="middle"><?=$v['pays_cost']?></td>
        <td valign="middle"><?=date("Y-m-d H:i:s",$v['createtime'])?></td>
       <td valign="middle">支付</td>  

    </tr>

	<?php
	}
	?>
  <tr>
        <td colspan="4">
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

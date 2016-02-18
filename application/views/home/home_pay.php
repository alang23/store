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
  <button class="btn btn-primary" type="button">
  支付管理 <span class="badge"><?=$count?></span>
</button>
</ol>

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>
      
         <th >支付方式</th>
         <th >设置</th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
        <td valign="middle"><?=$v['id']?></td>     
         <td valign="middle"><?=$v['pay_name']?></td>
       <td valign="middle"><a href="#">设置</a></td>  
        <td>
        	
    </td>
    </tr>

	<?php
	}
	?>
	<tr>
        <td colspan="8"><?=$page?></td>
    </tr>
</table>

</body>
</html>

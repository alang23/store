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


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb">
  <li>地区列表</li>
   
</ol>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>      
        <th>省份名称</th>
        <th>显示</th>
       
    </tr>
    </thead>
	<?php
		foreach($list as $k => $v){
	?>
    <tr>
	 	<td><?=$v['region_id']?></td>   
    <td><a href="<?=base_url()?>index.php?d=home&c=region&m=city&id=<?=$v['region_id']?>"><?=$v['region_name']?></a></td>      
    <td>
      <?php
        if($v['enabled'] == 1){
      ?>
      <a href="javascript:void(0);" onclick="changestatus(<?=$v['region_id']?>,0)">关闭</a>
      <?php
        }else{
      ?>
      <a href="javascript:void(0);" onclick="changestatus(<?=$v['region_id']?>,1)">打开</a>
      <?php
      }
      ?>
    </td>
 
    </tr>
	<?php
		}
	?>
    <tr>
	 	<td colspan="3">
      <nav>       
            <ul class="pagination">
               <?=$page?>
            </ul>
          </nav>


    </td>   
    </tr>
	</table>
<script>
  function changestatus(cid,status)
  {
          var aj = $.ajax( {
              url : '<?=base_url()?>index.php?d=home&c=region&m=changestatus',
              data:{
                  id : cid,
                  status : status,

              },
              contentType:"application/x-www-form-urlencoded; charset=utf-8",
              type:'post',
              cache:false,
              dataType:'json',
              success:function(data){
               // alert(data);
                if(data.err == 0){
                  alert(data.msg);
                   location.reload();
                }
                                 
              },
              error : function() {alert("ERROR");}
          });
      
  }
</script>
</body>
</html>

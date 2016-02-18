<?php Widget::head();?>
<link rel="stylesheet" href="<?=base_url()?>static/widget/chosen.min.css">
<body>
  <ol class="breadcrumb  definewidth m10">
  <li>员工列表</li>
  <li>添加</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php/orders/freight" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr class="breadcrumb  definewidth m10">

        <th colspan="8">
        

        </th>      
 

    </tr>
    </thead>
        <tr>
        <td class="tableleft">订单编号</td>       
       <td colspan="7">
          <?=$order_info['order_no']?>
       </td>
  </tr>
    <tr>
        <td class="tableleft">商品名称</td>       
       <td colspan="7">
        <?=$order_info['goods_name']?>
       </td>
  </tr>
      <tr>
        <td class="tableleft">收货信息</td>       
       <td colspan="7">
       <?=$order_info['address']?>
       </td>
  </tr>
        <tr>
        <td class="tableleft">输入快递单号</td>       
       <td colspan="7">
       <input type="text" name="code" class="form-control"  placeholder="输入快递单号"> 
       </td>
  </tr>



    <tr>
    <input type="hidden" name="id" value="<?=$order_info['id']?>" />
    <td colspan="9"><input type="submit"  class="btn btn-primary" value="提交"/></td>   
    </tr>
  </table>
</form>
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

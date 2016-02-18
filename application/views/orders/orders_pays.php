<?php Widget::head();?>
<link rel="stylesheet" href="<?=base_url()?>static/widget/chosen.min.css">
<body>
  <ol class="breadcrumb  definewidth m10">
  <li>员工列表</li>
  <li>添加</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php/orders/pays" enctype="multipart/form-data"/>
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
        <td class="tableleft">成交价</td>       
       <td colspan="7">
       <?=$order_info['deal_cost']?>
       </td>
  </tr>
        <tr>
        <td class="tableleft">已收款金额</td>       
       <td colspan="7">
       <?=$order_info['done_cost']?>
       </td>
  </tr>
        <tr>
        <td class="tableleft">收款方式</td>       
       <td colspan="7">
                 <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="pays_id" >

            <option value="0">-收款方式-</optin>
              <?php
                foreach($pays as $k => $v){
              ?>
              <option value="<?=$v['id']?>"><?=$v['pay_name']?></optin>
                <?php
                }
                ?>
         </select>
        
       </td>
  </tr>
        <tr>
        <td class="tableleft">收款金额</td>       
       <td colspan="7">

         <input type="text" name="pays_cost" class="form-control"  placeholder="收款金额" value="<?=$order_info['deal_cost']-$order_info['done_cost']?>">
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

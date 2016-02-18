<?php Widget::head();?>
<link rel="stylesheet" href="<?=base_url()?>static/widget/chosen.min.css">
<body>
	<ol class="breadcrumb  definewidth m10">
  <li>员工列表</li>
  <li>添加</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php/goods/sales" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>

    </tr>
    </thead>
    <tr>
        <td class="tableleft">选择商品</td>       
       <td colspan="7">
        <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="goods_id" >

            <option value="0">-选择商品-</optin>
              <?php
                foreach($goods as $k => $v){
              ?>
              <option value="<?=$v['id']?>"><?=$v['goods_name']?></optin>
                <?php
                }
                ?>
         </select>
       </td>
  </tr>
  <tr>
        <td class="tableleft">销售人员</td>       
       <td colspan="7">
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="sale_id" >

            <option value="0">-销售人员-</optin>
              <?php
                foreach($sales as $k8 => $v8){
              ?>
              <option value="<?=$v8['id']?>"><?=$v8['username']?>-<?=$v8['realname']?></optin>
                <?php
                }
                ?>
         </select>
       </td>
  </tr>
      <tr>
        <td class="tableleft">选择客户</td>       
       <td colspan="7">
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="customer_id" >

            <option value="0">-选择客户-</optin>
              <?php
                foreach($customer as $k2 => $v2){
              ?>
              <option value="<?=$v2['id']?>"><?=$v2['customer_name']?></optin>
                <?php
                }
                ?>
         </select>
       </td>
  </tr>


  <tr>
        <td class="tableleft">成交价</td>       
       <td colspan="7">
         <input type="text" name="deal_cost" class="form-control"  placeholder="成交价"> 
       </td>
  </tr>
        <tr>
        <td class="tableleft">收款方式</td>       
       <td colspan="7">
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="pays_id" >

            <option value="0">-收款方式-</optin>
              <?php
                foreach($pays as $k3 => $v3){
              ?>
              <option value="<?=$v3['id']?>"><?=$v3['pay_name']?></optin>
                <?php
                }
                ?>
         </select>
       </td>
  </tr>
  <tr>
        <td class="tableleft">已收金额</td>       
       <td colspan="7">
         <input type="text" name="done_cost" class="form-control"  placeholder="已收金额"> 
       </td>
  </tr>
        <tr>
        <td class="tableleft">配送方式</td>       
       <td colspan="7">
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="exp_type" >

            <option value="0">-配送方式-</optin>
              <option value="1">自提</optin>
              <option value="2">送货</optin>
              <option value="3">快递</optin>

         </select>
       </td>
  </tr>
    <tr>
        <td class="tableleft">配送地址</td>       
       <td colspan="7">
         <input type="text" name="address" class="form-control"  placeholder="配送地址"> 
       </td>
  </tr>
  <tr>
        <td class="tableleft">备注</td>       
       <td colspan="7">
        <textarea name="remark" class="form-control"  placeholder="备注"></textarea>
       </td>
  </tr>
    <tr>
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

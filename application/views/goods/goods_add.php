<?php Widget::head();?>
<link rel="stylesheet" href="<?=base_url()?>static/widget/chosen.min.css">
<body>
	<ol class="breadcrumb  definewidth m10">
  <li>员工列表</li>
  <li>添加</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php/goods/add" enctype="multipart/form-data"/>
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
        <td class="tableleft">商品名称</td>       
       <td colspan="7">
         <input type="text" name="goods_name" class="form-control"  placeholder="商品名称"> 
       </td>
  </tr>
      <tr>
        <td class="tableleft">买手</td>       
       <td colspan="7">
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="buyer_id" >

            <option value="0">-买手-</optin>
              <?php
                foreach($buys as $k => $v){
              ?>
              <option value="<?=$v['id']?>"><?=$v['nickname']?>(<?=$v['realname']?>)</optin>
                <?php
                }
                ?>
         </select>
       </td>
  </tr>
        <tr>
        <td class="tableleft">分类</td>       
       <td colspan="7">
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="category_id" >

            <option value="0">-分类-</optin>
              <?php
                foreach($categorys as $k2 => $v2){
              ?>
              <option value="<?=$v2['id']?>"><?=$v2['c_name']?></optin>
                <?php
                }
                ?>
         </select>
       </td>
  </tr>

          <tr>
        <td class="tableleft">品牌</td>       
       <td colspan="7">
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="brand_id" >

            <option value="0">-品牌-</optin>
              <?php
                foreach($brands as $k3 => $v3){
              ?>
              <option value="<?=$v3['id']?>"><?=$v3['b_name']?></optin>
                <?php
                }
                ?>
         </select>
       </td>
  </tr>
            <tr>
        <td class="tableleft">仓库</td>       
       <td colspan="7">
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="store_id" >

            <option value="0">-仓库-</optin>
              <?php
                foreach($stores as $k4 => $v4){
              ?>
              <option value="<?=$v4['id']?>"><?=$v4['store_name']?></optin>
                <?php
                }
                ?>
         </select>
       </td>
  </tr>
              <tr>
        <td class="tableleft">颜色</td>       
       <td colspan="7">
          <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="goods_color" >

            <option value="0">-颜色-</optin>
              <?php
                foreach($colors as $k5 => $v5){
              ?>
              <option value="<?=$v5['id']?>"><?=$v5['color_name']?></optin>
                <?php
                }
                ?>
         </select>
       </td>
  </tr>
    <tr>
        <td class="tableleft">年代</td>   
        <td><input type="text" name="goods_year" class="form-control"  placeholder="年代"> </td>  
                <td class="tableleft">尺寸 </td>   
        <td><input type="text" name="goods_size" class="form-control"  placeholder="尺寸"> </td>
                <td class="tableleft">材质 </td>   
        <td><input type="text" name="goods_caizhi" class="form-control"  placeholder="材质"> </td>  
                        <td class="tableleft">   </td>   
        <td> </td>   
    </tr>
          <tr>
        <td class="tableleft">市场价</td>       
       <td colspan="7">
         <input type="text" name="price_market" class="form-control"  placeholder="市场价"> 
       </td>
  </tr>
  <tr>
        <td class="tableleft">成本价</td>       
       <td colspan="7">
         <input type="text" name="price_cost" class="form-control"  placeholder="成本价"> 
       </td>
  </tr>
    <tr>
        <td class="tableleft">审核人</td>       
       <td colspan="7">
       <?php
        foreach($employee as $ek => $ev){
       ?>
         <?=$ev['username']?>(<?=$ev['realname']?>)<input type="checkbox" name="check_id[]" value="<?=$ev['id']?>" />  &nbsp;&nbsp;
         <?php
          }
         ?>
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

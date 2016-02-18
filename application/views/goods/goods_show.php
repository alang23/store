<?php Widget::head();?>
<link rel="stylesheet" href="<?=base_url()?>static/widget/chosen.min.css">
<body>
  <ol class="breadcrumb  definewidth m10">
  <li><a href="<?=base_url()?>index.php/goods/index">商品列表</a></li>
  <li>查看</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php/goods/update" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr class="breadcrumb  definewidth m10">

        <th colspan="8">
            <ol class="breadcrumb  definewidth m10">
            <li><a href="<?=base_url()?>index.php/goods/sales?id=<?=$info['id']?>"><input type="button"  class="btn btn-primary" value="销售"/></a></li>
            <li><a href="<?=base_url()?>index.php/goods/sales?id=<?=$info['id']?>"><input type="button"  class="btn btn-primary" value="图片"/></a></li>
            <li><a href="<?=base_url()?>index.php/goods/update?id=<?=$info['id']?>"><input type="button"  class="btn btn-primary" value="修改"/></a></li>
             <li><a href="<?=base_url()?>index.php/goods/del?id=<?=$info['id']?>"><input type="button"  class="btn btn-primary" value="删除"/></a></li>
          </ol>

        </th>      
 

    </tr>
    </thead>
        <tr>
        <td class="tableleft">编号</td>       
       <td colspan="7">
         <input type="text" name="goods_no" class="form-control"  placeholder="商品名称" value="<?=$info['goods_no']?>" readonly="true"> 
       </td>
  </tr>
    <tr>
        <td class="tableleft">商品名称</td>       
       <td colspan="7">
         <input type="text" name="goods_name" class="form-control"  placeholder="商品名称" value="<?=$info['goods_name']?>" readonly="true"> 
       </td>
  </tr>
      <tr>
        <td class="tableleft">买手</td>       
       <td colspan="7">
          <input type="text" name="store_name" class="form-control"  placeholder="品牌" value="<?=$info['nickname']?>(<?=$info['realname']?>)" readonly="true"> 
       </td>
  </tr>
        <tr>
        <td class="tableleft">分类</td>       
       <td colspan="7">
 <input type="text" name="store_name" class="form-control"  placeholder="品牌" value="<?=$info['c_name']?>" readonly="true"> 
       </td>
  </tr>

          <tr>
        <td class="tableleft">品牌</td>       
       <td colspan="7">
 <input type="text" name="store_name" class="form-control"  placeholder="品牌" value="<?=$info['b_name']?>" readonly="true"> 
       </td>
  </tr>
            <tr>
        <td class="tableleft">仓库</td>       
       <td colspan="7">
          <input type="text" name="store_name" class="form-control"  placeholder="市场价" value="<?=$info['store_name']?>" readonly="true"> 
       </td>
  </tr>
              <tr>
        <td class="tableleft">颜色</td>       
       <td colspan="7">
                <input type="text" name="price_market" class="form-control"  placeholder="市场价" value="<?=$info['color_name']?>" readonly="true"> 
       </td>
  </tr>
    <tr>
        <td class="tableleft">年代</td>   
        <td><input type="text" name="goods_year" class="form-control"  placeholder="年代" value="<?=$info['goods_year']?>" readonly="true"> </td>  
                <td class="tableleft">尺寸 </td>   
        <td><input type="text" name="goods_size" class="form-control"  placeholder="尺寸" value="<?=$info['goods_size']?>" readonly="true"> </td>
                <td class="tableleft">材质 </td>   
        <td><input type="text" name="goods_caizhi" class="form-control"  placeholder="材质" value="<?=$info['goods_caizhi']?>" readonly="true"> </td>  
                        <td class="tableleft">   </td>   
        <td> </td>   
    </tr>
          <tr>
        <td class="tableleft">市场价</td>       
       <td colspan="7">
         <input type="text" name="price_market" class="form-control"  placeholder="市场价" value="<?=$info['price_market']?>" readonly="true"> 
       </td>
  </tr>
  <tr>
        <td class="tableleft">成本价</td>       
       <td colspan="7">
         <input type="text" name="price_cost" class="form-control"  placeholder="成本价" value="<?=$info['price_cost']?>" readonly="true"> 
       </td>
  </tr>
    <tr>
        <td class="tableleft">审核人</td>       
       <td colspan="7">
          <?=$check_user_name?>  
       </td>
  </tr>
  <tr>
        <td class="tableleft">备注</td>       
       <td colspan="7">
        <textarea name="remark" class="form-control"  placeholder="备注" readonly="true"><?=$info['remark']?></textarea>
       </td>
  </tr>
    <tr>
    <input type="hidden" name="id" value="<?=$info['id']?>" />
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

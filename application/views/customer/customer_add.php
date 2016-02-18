<?php Widget::head();?>
<link rel="stylesheet" href="<?=base_url()?>static/widget/chosen.min.css">
<body>
	<ol class="breadcrumb  definewidth m10">
  <li>客户列表</li>
  <li>添加</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php/customer/add" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">客户姓名</td>       
       <td colspan="2">
         <input type="text" name="customer_name" class="form-control"  placeholder="客户姓名"> 
       </td>
  </tr>
      <tr>
        <td class="tableleft">手机</td>       
       <td colspan="2">
         <input type="text" name="mobile" class="form-control"  placeholder="手机"> 
       </td>
  </tr>

          <tr>
        <td class="tableleft">城市</td>       
       <td colspan="2" id="address_info">
            <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="province_id" onchange="get_address_info('city',this.value);">
                <option value="0">-省份-</option>
                <?php
                  foreach($province as $k => $v){
                ?>
                <option value="<?=$v['ProSort']?>"><?=$v['ProName']?></option>
                <?php
                  }
                ?>
            </select>
            <span id="city"></span>
            <span id="zone"></span>
       </td>
  </tr>
    <tr>
        <td class="tableleft">地址</td>       
       <td colspan="2">
         <input type="text" name="address" class="form-control"  placeholder="地址"> 
       </td>
  </tr>
  <tr>
        <td class="tableleft">服务专员</td>       
       <td colspan="2">
           <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="sale_id" >
                <option value="0">-服务专员-</option>
                <?php
                  foreach($employee as $k2 => $v2){
                ?>
                <option value="<?=$v2['id']?>"><?=$v2['username']?>-<?=$v2['realname']?></option>
                <?php
                  }
                ?>
            </select> 
       </td>
  </tr>
        <tr>
        <td class="tableleft">备注</td>   
        <td>
            <textarea name="remark" class="form-control"  placeholder="备注"></textarea>

        </td>
    <tr>
	 	<td colspan="4"><input type="submit"  class="btn btn-primary" value="提交"/></td>   
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
  <script>
  var hostname = '<?=base_url()?>';
  function get_address_info(type,id)
  {
          
          var aj = $.ajax( {
                url:hostname + 'index.php/customer/get_address_info',
                data:{
                    type : type,
                    id : id,
                },
                contentType:"application/x-www-form-urlencoded; charset=utf-8",
                type:'post',
                cache:false,
                dataType:'text',
                success:function(data){
                    if(type == 'city'){

                      $("#city").html(data);
                    }else if(type == 'zone'){
                       $("#zone").html(data);
                    }else{

                    }
                },
                error : function() {
                    alert("ERROR");
                }
            });


  }
  </script>
<script>
</body>
</html>

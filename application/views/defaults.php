<!DOCTYPE HTML>
<html>
 <head>
  <title>后台管理</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link href="<?=base_url()?>static/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>static/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <link href="<?=base_url()?>static/assets/css/main-min.css" rel="stylesheet" type="text/css" />
 </head>
 <body>

  <div class="header">
    
      <div class="dl-title">
       <!--<img src="/chinapost/Public/assets/img/top.png">-->
       润媛仓库管理系统
      </div>

    <div class="dl-log">欢迎您，<span class="dl-log-user"><?=$userinfo['username']?></span><a href="<?=base_url()?>index.php/home/login/logout" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
  </div>
   <div class="content">
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
      <ul id="J_Nav"  class="nav-list ks-clear">
      <!--<li class="nav-item dl-selected"><div class="nav-item-inner nav-home">收货管理</div></li>-->
        <li class="nav-item dl-selected"><div class="nav-item-inner nav-home">仓库管理</div></li>          
       <li class="nav-item dl-selected"><div class="nav-item-inner nav-order">业务管理</div></li>  
       <li class="nav-item dl-selected"><div class="nav-item-inner nav-order">财务管理</div></li>  
       <li class="nav-item dl-selected"><div class="nav-item-inner nav-order">统计报表</div></li>  
       <li class="nav-item dl-selected"><div class="nav-item-inner nav-order">设置</div></li>   
      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
   </div>
  <script type="text/javascript" src="<?=base_url()?>static/assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>static/assets/js/bui-min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>static/assets/js/common/main-min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>static/assets/js/config-min.js"></script>
  <script>
    BUI.use('common/main',function(){
      var config = [
      /*
      {id:'1',
        menu:
            [
                {text:'收货管理',
                    items:[
                            {id:'11',text:'收货记录',href:'<?=base_url()?>index.php/takegoods/index'},
                        ]
                    
                },
                    
            ]
                    
        },
    */
    {id:'2',
        menu:
            [
                /*
                {text:'申请',
                    items:[
                            {id:'40',text:'申请列表',href:'<?=base_url()?>index.php/home/orders'},                                          
                        ]
                    
                    },
                    */
                {text:'商品管理',
                    items:[
                            {id:'42',text:'商品列表',href:'<?=base_url()?>index.php/goods'},                                          
                        ]
                    
                    },

                    
            ]
                    
        },

     {id:'3',
        menu:
            [

                {text:'订单管理',
                    items:[
                            {id:'60',text:'订单列表',href:'<?=base_url()?>index.php/orders'},                                          
                        ]
                    
                    },
                    
            ]
                    
        },
    {id:'4',
        menu:
            [

                {text:'营销策略',
                    items:[
                            {id:'140',text:'支付记录',href:'<?=base_url()?>index.php/payslog'},                                            
                        ]
                    
                    },
                    
            ]
                    
        },

    {id:'5',
        menu:
            [
            /*
                {text:'日志管理',
                    items:[
                            {id:'80',text:'操作日志',href:'index.php/home/opr_log'},
                            
                            
                        ]
                    
                    },
                {text:'预警管理',
                    items:[
                            
                            
                        ]
                    
                    },
                {text:'系统配置',
                    items:[
                            {id:'82',text:'地区列表',href:'<?=base_url()?>index.php/home/region'},
                            {id:'83',text:'地区列表',href:'<?=base_url()?>index.php/home/region'},
                    
                            
                        ]
                    
                    },

*/
                    
            ]
                    
        },
        

    {id:'6',
        menu:
            [

                {text:'产品参数',
                    items:[
                            {id:'100',text:'买手',href:'<?=base_url()?>index.php/buyer/index'},
                            {id:'101',text:'品牌',href:'<?=base_url()?>index.php/brand/index'},
                            {id:'102',text:'分类',href:'<?=base_url()?>index.php/category/index'},
                            {id:'103',text:'颜色',href:'<?=base_url()?>index.php/color/index'},
                            {id:'104',text:'仓库',href:'<?=base_url()?>index.php/store/index'},
                            
                        ]
                    
                    },
   
                {text:'员工管理',
                    items:[

                            {id:'120',text:'员工列表',href:'<?=base_url()?>index.php/employee/index'},
                            {id:'121',text:'权限组',href:'<?=base_url()?>index.php/group/index'},
                        ]
                    
                    },
                    {text:'客户管理',
                    items:[

                            {id:'130',text:'客户列表',href:'<?=base_url()?>index.php/customer/index'},
                        ]
                    
                    },
                    {text:'支付',
                    items:[

                            {id:'150',text:'支付方式',href:'<?=base_url()?>index.php/pays/index'},
                        ]
                    
                    },
                    /*
                {text:'系统配置',
                    items:[
                            {id:'140',text:'地区列表',href:'<?=base_url()?>index.php/home/region'},
                            {id:'141',text:'自提地址',href:'<?=base_url()?>index.php/home/takeaway'},
                            {id:'142',text:'过滤关键字',href:'<?=base_url()?>index.php/home/filterwd'},
                            {id:'143',text:'密碼修改',href:'index.php/home/password'},
                            {id:'144',text:'备份数据库',href:'index.php/home/backupdb'},
                            
                        ]
                    
                    },   
                    */           
            ]
                    
        },
        
    {id:'7',
        menu:
            [


                {text:'栏目管理',
                    items:[
                            {id:'120',text:'导航设置',href:'<?=base_url()?>index.php/home/indexbanner'},
                            
                        ]
                    
                    },
                {text:'内容管理',
                    items:[
                            {id:'127',text:'BANNER',href:'<?=base_url()?>index.php/home/banner'},
                            {id:'121',text:'发现',href:'<?=base_url()?>index.php/home/discovery'},
                            {id:'122',text:'款式',href:'<?=base_url()?>index.php/home/style'},
                            {id:'123',text:'颜色分类',href:'<?=base_url()?>index.php/home/color'},
                            {id:'124',text:'皮质分类',href:'<?=base_url()?>index.php/home/cortex'},
                            {id:'125',text:'品牌学堂',href:'<?=base_url()?>index.php/home/school/lists'},
                            {id:'126',text:'街拍',href:'<?=base_url()?>index.php/home/taken'},        
                        ]
                    
                    },
                {text:'系统相关',
                    items:[
                            {id:'127',text:'意见反馈',href:'<?=base_url()?>index.php/home/feedback'},
                            {id:'128',text:'疑难帮助',href:'<?=base_url()?>index.php/home/doubttype'},      
                        ]
                    
                    },
                    
            ]
                    
        },
                    
    ];
                    
      new PageUtil.MainPage({
        modulesConfig : config
      });
    });
  </script>
 </body>
</html>
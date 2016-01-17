<?php
    $this->pageTitle = Yii::t('vcos','免税商城预定列表');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'goods_order_list';
?>
<?php 
    //navbar 挂件
    $this->widget('navbarWidget');
?>   
<div class="main-container" id="main-container">
        <script type="text/javascript">
			try{ace.settings.check('main-container' , 'fixed')}catch(e){}
        </script>

        <div class="main-container-inner">
                <a class="menu-toggler" id="menu-toggler" href="#">
                        <span class="menu-text"></span>
                </a>
                <?php
                //菜单挂件
                 $this->widget('menuWidget', array('menu_type'=>$menu_type));
                ?>
                <div class="main-content"> 
                    <?php
                        //面包屑挂件
                        $this->widget('breadcrumbWidget');
                    ?>
                    <div class="page-content">
                        <div class="page-header">
                            <h1>
                                <?php echo yii::t('vcos', '免税商城管理')?>
                                <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '免税商城预定列表')?>
                                </small>
                            </h1>
                        </div><!-- /.page-header -->
                            <div class="row">
                                <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="table-responsive">
                                                <form method="post" >
                                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo yii::t('vcos', '订单号')?></th>
                                                            <th><?php echo yii::t('vcos', '预定人')?></th>
                                                            <th><?php echo yii::t('vcos', '总价格')?></th>
                                                            <th><?php echo yii::t('vcos', '支付类型')?></th>
                                                            <th><?php echo yii::t('vcos', '订单校验码')?></th>
                                                            <th><?php echo yii::t('vcos', '订单创建时间')?></th>
                                                            <th><?php echo yii::t('vcos', '支付时间')?></th>
                                                            <th><?php echo yii::t('vcos', '阅读状态')?></th>
                                                            <th><?php echo yii::t('vcos', '状态')?></th>
                                                            <th><?php echo yii::t('vcos', '操作')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($result as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $row['order_serial_num'];?></td>
                                                            <td><?php echo $row['cn_name']['cn_name'];?></td>
                                                            <td><?php echo $row['totale_price'];?></td>
                                                            <td><?php if($row['pay_type'] == "1"){echo yii::t('vcos', '余额支付');}else if($row['pay_type'] == "2"){echo yii::t('vcos', '挂账支付');}else{echo yii::t('vcos', '货到付款');}?></td>
                                                            <td><?php echo $row['order_check_num'];?></td>
                                                            <td><?php echo $row['order_create_time'];?></td>
                                                            <td><?php echo $row['pay_time'];?></td>
                                                            <td><?php echo $row['is_read']? yii::t('vcos', '已读'):yii::t('vcos', '未读'); ?></td>
                                                            <td>
                                                                <select class="col-xs-12 col-sm-12 col-md-12 state" name="state" id="<?php echo $row['order_id']?>" title="<?php echo $row['order_state'];?>">
                                                                    <?php if($row['order_state'] == '0'){?>
                                                                    <option value="0" <?php if($row['order_state'] == '0'){echo 'selected';}?> ><?php echo yii::t('vcos', '已取消')?></option>
                                                                    <?php }else{?>
                                                                    <option value="1" <?php if($row['order_state'] == '1'){echo 'selected';}?> ><?php echo yii::t('vcos', '处理中')?></option>
                                                                    <option value="2" <?php if($row['order_state'] == '2'){echo 'selected';}?> ><?php echo yii::t('vcos', '送货中')?></option>
                                                                    <option value="3" <?php if($row['order_state'] == '3'){echo 'selected';}?> ><?php echo yii::t('vcos', '交易失败，暂无库存')?></option>
                                                                    <option value="4" <?php if($row['order_state'] == '4'){echo 'selected';}?> ><?php echo yii::t('vcos', '交易完成')?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                                                    <a href="<?php echo Yii::app()->createUrl("Dutyfreegoods/goods_order_edit?id={$row['order_id']}");?>" class="btn btn-xs btn-info" title="<?php echo yii::t('vcos', '修改订单');?>">
                                                                        <i class="icon-edit bigger-120"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                    <div class="inline position-relative">
                                                                        <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                            <i class="icon-cog icon-only bigger-110"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                                            <li>
                                                                                <a href="<?php echo Yii::app()->createUrl("Lifeservice/goods_order_edit?id={$row['order_id']}");?>" class="tooltip-info" data-rel="tooltip" title="<?php echo yii::t('vcos', '修改订单');?>">
                                                                                    <span class="green">
                                                                                        <i class="icon-edit bigger-120"></i>
                                                                                    </span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                                </form>
                                                <div class="center">
                                                    <?php
                                                    $this->widget('MyCLinkPager',array(
                                                        'pages'=>$pages,
                                                        'header'=>false,
                                                        'htmlOptions'=>array('class'=>'pagination'),
                                                        'firstPageLabel'=>yii::t('vcos', '首页'),
                                                        'lastPageLabel'=>yii::t('vcos', '尾页'),
                                                        'prevPageLabel'=>'«',
                                                        'nextPageLabel'=>'»',
                                                        'maxButtonCount'=>5,
                                                        'cssFile'=>false,
                                                        ));
                                                    ?>
                                                </div>
                                            </div><!-- /.table-responsive -->
                                        </div><!-- /span -->
                                    </div><!-- /row -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.page-content -->
                </div><!-- /.main-content -->
                <div id="dialog-confirm" class="hide">
                    <div class="alert alert-info bigger-110" id="dialog-confirm-content">
                        <?php echo yii::t('vcos', ' ')?>
                    </div>
                    <div class="space-6"></div>
                    <p class="bigger-110 bolder center grey">
                        <i class="icon-hand-right blue bigger-120"></i>
                        <?php echo yii::t('vcos', '确定吗?')?>
                    </p>
                </div><!-- #dialog-confirm -->
                <!-- /#ace-settings-container start-->
                <?php
                    //设置容器配置挂件
                    $this->widget('settingsContainerWidget');
                ?>
                <!-- /#ace-settings-container end-->
        </div><!-- /.main-container-inner -->
        
        <!-- scrool up widget start-->
        <?php
            $this->widget('scrollUpWidget');
        ?>
        <!-- scrool up widget end-->
        
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->

<script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
        if("ontouchend" in document) document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo $theme_url; ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.full.min.js"></script>
<script type="text/javascript">
jQuery(function($) {
    $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
    _title: function(title) {
        var $title = this.options.title || '&nbsp;'
        if( ("title_html" in this.options) && this.options.title_html == true )
            title.html($title);
        else title.text($title);
        }
    }));
    $( ".state" ).on('change', function(e) {
        e.preventDefault();
        $a = '<?php echo yii::t('vcos', '更改状态为')?>'+$(this).find("option:selected").text()+'？';
        $b = $(this).val();
        $c = $(this).attr('id');
        $d = $(this).attr('title');
        $('#dialog-confirm-content').html($a);
        $( "#dialog-confirm" ).removeClass('hide').dialog({
            closeOnEscape:false, 
            open:function(event,ui){$(".ui-dialog-titlebar-close").hide();} ,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '更改状态？')?></h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '确定？')?>",
                    "class" : "btn btn-danger btn-xs ",
                    click: function() {
                        $.post('<?php echo yii::app()->createUrl("Dutyfreegoods/changestate")?>',{state:$b,id:$c},function(data){
                            if(data > 0){
                                alert('<?php echo yii::t('vcos', '修改成功')?>');
                                $("#"+$c).parent().prev().text("<?php echo yii::t('vcos', '已读')?>");
                            }else{
                                alert('<?php echo yii::t('vcos', '修改失败')?>');
                            }
                        });
                        $( this ).dialog( "close" );
                    }
                },
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '取消？')?>",
                    "class" : "btn btn-xs ",
                    click: function() {
                        $("#"+$c).val($d);
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });
    });  
});
</script>

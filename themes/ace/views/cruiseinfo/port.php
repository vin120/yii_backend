<?php
    $this->pageTitle = Yii::t('vcos','目的地列表');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'port';
?>
<?php 
    //navbar 挂件
    $this->widget('navbarWidget');
    if(in_array('22', $auth) || $auth[0] == '0'){
        $canadd = TRUE;
    }  else {
        $canadd = False;
    }
    if(in_array('23', $auth) || $auth[0] == '0'){
        $canedit = TRUE;
    }  else {
        $canedit = False;
    }
    if(in_array('24', $auth) || $auth[0] == '0'){
        $candelete = TRUE;
    }  else {
        $candelete = FALSE;
    }
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
                                <?php echo yii::t('vcos', '目的地管理')?>
                                <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '目的地列表')?>
                                </small>
                            </h1>
                        </div><!-- /.page-header -->
                            <div class="row">
                                <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="table-responsive">
                                                <form method="post" id="del">
                                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo yii::t('vcos', '序号')?></th>
                                                            <th><?php echo yii::t('vcos', '港口名')?></th>
                                                            <th><?php echo yii::t('vcos', '描述')?></th>
                                                            <th><?php echo yii::t('vcos','港口图')?></th>
                                                            <th><?php echo yii::t('vcos', '状态')?></th>
                                                            <th><?php echo yii::t('vcos', '操作')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($port as $key=>$row) { ?>
                                                        <tr>
                                                            <td><?php echo ++$key;?></td>
                                                            <td><?php echo $row['port_name'];?></td>
                                                            <td><?php echo Helper::truncate_utf8_string($row['describe'], 30);?></td>
                                                            <td><img src="<?php echo Yii::app()->params['imgurl'].$row['img_url'];?>" width="50"/></td>
                                                            <td><?php echo $row['port_state']?yii::t('vcos', '启用'):yii::t('vcos', '禁用');?></td>
                                                            <td>
                                                                <?php
                                                                    //操作挂件
                                                                    $this->widget('ManipulateWidget',array(
                                                                        'ControllerName'=>'Cruiseinfo',
                                                                        'MethodName'=>'port_edit',
                                                                        'id'=>$row['port_id'],
                                                                        'canedit'=>$canedit,
                                                                        'candelete'=>$candelete,
                                                                    ));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                                </form>
                                                <div class="center">
                                                    <?php
                                                        //底部操作挂件
                                                        $this->widget('BotWidget',array(
                                                            'ControllerName'=>'Cruiseinfo',
                                                            'MethodName'=>'port_add',
                                                            'canadd'=>$canadd,
                                                        ));
                                                    ?>
                                                </div>
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
                <?php
                    //删除确认框
                    $this->widget('ConfirmWidget',array(
                        'div_id'=>'dialog-confirm',
                        'title_id'=>'dialog-confirm-content',
                        'title_content'=>yii::t('vcos', '这条记录将被永久删除，并且无法恢复。'),
                        'confirm_id'=>'confirm',
                    ));
                ?>
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
    $( ".delete" ).on('click', function(e) {
        var $a = $(this).attr("id");
        e.preventDefault();
        $.post('checkport',{pid:$a},function(data){
            if(data==1){
                $('#danger1').hide();
                $('.widget-header h4').html("<i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '不能删除！')?>");
                $('#dialog-confirm-content').html("<?php echo yii::t('vcos', '这个条记录正在使用，不能删除。')?>");
                $('#confirm').hide();
            }
        });
        $( "#dialog-confirm" ).removeClass('hide').dialog({
            closeOnEscape:false, 
            open:function(event,ui){$(".ui-dialog-titlebar-close").hide();} ,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '删除这条记录？')?></h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '删除？')?>",
                    "class" : "btn btn-danger btn-xs",
                    "id" : "danger1",
                    click: function() {
                        location.href="<?php echo Yii::app()->createUrl("Cruiseinfo/port");?>"+"?id="+$a;
                        $( this ).dialog( "close" );
                    }
                }
                ,
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '取消？')?>",
                    "class" : "btn btn-xs ",
                    click: function() {
                        $('#danger1').show();
                        $('.widget-header h4').html("<i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '删除这条记录？')?>");
                        $('#dialog-confirm-content').html("<?php echo yii::t('vcos', '这条记录将被永久删除，并且无法恢复。')?>");
                        $('#confirm').show();
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });
    });
});
</script>

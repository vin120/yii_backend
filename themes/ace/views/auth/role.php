<?php
    $this->pageTitle = Yii::t('vcos','权限分组列表');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'role';
?>
<?php 
    //navbar 挂件
    $this->widget('navbarWidget');
    if(in_array('119', $auth) || $auth[0] == '0'){
        $canadd = TRUE;
    }  else {
        $canadd = False;
    }
    if(in_array('120', $auth) || $auth[0] == '0'){
        $canedit = TRUE;
    }  else {
        $canedit = False;
    }
    if(in_array('121', $auth) || $auth[0] == '0'){
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
                                <?php echo yii::t('vcos', '权限管理')?>
                                <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '权限分组列表')?>
                                </small>
                            </h1>
                        </div><!-- /.page-header -->
                            <div class="row">
                                <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="table-responsive">
                                                <form method="post" name="del">
                                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%"><?php echo yii::t('vcos', '序号')?></th>
                                                            <th><?php echo yii::t('vcos', '分组名')?></th>
                                                            <th><?php echo yii::t('vcos', '分组说明')?></th>
                                                            <th style="width: 5%"><?php echo yii::t('vcos', '状态')?></th>
                                                            <th style="width: 7%"><?php echo yii::t('vcos', '操作')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($role as $key=>$row) { ?>
                                                        <tr>
                                                            <td><?php echo ++$key;?></td>
                                                            <td><?php echo $row['role_name'];?></td>
                                                            <td><?php echo $row['role_desc'];?></td>
                                                            <td><?php echo $row['role_state']? yii::t('vcos', '启用'): yii::t('vcos', '禁用');?></td>
                                                            <td>
                                                                <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                                                    <?php if($canedit){?>
                                                                    <a href="#" id="<?php echo $row['role_id'];?>" class="edit btn btn-xs btn-info" title="<?php echo yii::t('vcos', '编辑');?>">
                                                                        <i class="icon-edit bigger-120"></i>
                                                                    </a>
                                                                    <?php } ?>
                                                                    <?php if($candelete){?>
                                                                    <a href="#" class="btn btn-xs btn-warning delete" id="<?php echo $row['role_id'];?>" title="<?php echo yii::t('vcos', '删除');?>">
                                                                        <i class="icon-trash bigger-120"></i>
                                                                    </a>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                    <div class="inline position-relative">
                                                                        <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                            <i class="icon-cog icon-only bigger-110"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                                            <?php if($canedit){?>
                                                                            <li>
                                                                                <a href="#" id="<?php echo $row['role_id'];?>" class="edit tooltip-info" data-rel="tooltip" title="<?php echo yii::t('vcos', '编辑');?>">
                                                                                    <span class="green">
                                                                                        <i class="icon-edit bigger-120"></i>
                                                                                    </span>
                                                                                </a>
                                                                            </li>
                                                                            <?php } ?>
                                                                            <?php if($candelete){?>
                                                                            <li>
                                                                                <a href="#" class="tooltip-info delete" id="<?php echo $row['role_id'];?>" data-rel="tooltip" title="<?php echo yii::t('vcos', '删除');?>">
                                                                                    <span class="red">
                                                                                        <i class="icon-trash bigger-120"></i>
                                                                                    </span>
                                                                                </a>
                                                                            </li>
                                                                            <?php } ?>
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
                                                    <?php if($canadd){?>
                                                    <a href="<?php echo Yii::app()->createUrl('Auth/role_add');?>" class="btn btn-xs">
                                                        <i class="icon-pencil align-top bigger-125"></i>
                                                        <span class="bigger-110 no-text-shadow"><?php echo yii::t('vcos', yii::t('vcos', '添加'))?></span>
                                                    </a>
                                                    <?php } ?>
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
                <div id="dialog-confirm" class="hide">
                    <div class="alert alert-info bigger-110" id="dialog-confirm-content">
                        <?php echo yii::t('vcos', '这条记录将被永久删除，并且无法恢复.')?>
                    </div>
                    <div class="space-6"></div>
                    <p class="bigger-110 bolder center grey" id="confirm">
                        <i class="icon-hand-right blue bigger-120"></i>
                        <?php echo yii::t('vcos', '确定吗?')?>
                    </p>
                </div><!-- #dialog-confirm -->
                <form action="<?php echo Yii::app()->createUrl("Auth/role_edit");?>" method="post">
                    <input type="hidden" name="edit_id" value="" id="sendtoedit"/>
                </form>
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
<script src="<?php echo $theme_url; ?>/assets/js/typeahead-bs2.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.full.min.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('table th input:checkbox').on('click' , function(){
                var that = this;
                $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                        this.checked = that.checked;
                        $(this).closest('tr').toggleClass('selected');
                });
        });
        
        $('.isclick').click( function(){
            $a = $(this).val();
            $b = $(this).index('.isclick');
            $.post("checkadmin",{id:$a},function(data){
                if(data > 0){
                    alert("<?php echo yii::t('vcos', '这个权限分组有管理员正在使用,不能勾选！')?>");
                    $('.isclick').eq($b).prop("checked",false);
                }
            });
        });
        
        $(".edit").click(function(){
            var $b = $(this).attr("id");
            $("#sendtoedit").val($b);
            jQuery("form").last().submit();
        });
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
            $.post("checkadmin",{id:$a},function(data){
                if(data > 0){
                    $('#danger').hide();
                    $('.widget-header h4').html("<i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '不能删除！')?>");
                    $('#dialog-confirm-content').html("<?php echo yii::t('vcos', '这个权限分组有管理员正在使用，不能删除。')?>");
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
                        "class" : "btn btn-danger btn-xs ",
                        "id" : "danger",
                        click: function() {
                            location.href="<?php echo Yii::app()->createUrl("Auth/role");?>"+"?id="+$a;
                            $( this ).dialog( "close" );
                        }
                    }
                    ,
                    {
                        html: "<i class='icon-remove bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '取消？')?>",
                        "class" : "btn btn-xs ",
                        click: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                ]
            });
            $('.widget-header h4').html("<i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '删除这条记录？')?>");
            $('#dialog-confirm-content').html("<?php echo yii::t('vcos', '这条记录将被永久删除，并且无法恢复。')?>");
            $('#confirm').show();
        }); 
    });
</script>

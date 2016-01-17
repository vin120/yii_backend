<?php
    $this->pageTitle = Yii::t('vcos','添加安全定位分类');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'location_category_add';
?>
<link rel="stylesheet" href="<?php echo $theme_url?>/assets/css/colorpicker.css" />
<?php 
    //navbar 挂件
    $disable = 1;
    $this->widget('navbarWidget',array('disable'=>$disable));
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
                            <?php echo yii::t('vcos', '安全定位管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '添加安全定位分类')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <form class="form-horizontal" role="form" method="post" action="" id="add" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '安全定位分类名称')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="name" placeholder="<?php echo yii::t('vcos', '安全定位分类名称')?>" class="col-xs-10 col-sm-8 col-md-8" name="name" maxlength="16" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" checked="checked" class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '跳转地址')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="url" type="text" name="url" placeholder="<?php echo yii::t('vcos', '跳转地址')?>" maxlength="80"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '背景颜色')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <div class="bootstrap-colorpicker">
                                            <input id="bgcolor" name="bgcolor" type="text" class="input-small" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="file" name="photo" id="photo"/>
                                    </div>
                                </div>
                                <input type="submit" value="<?php echo yii::t('vcos', '提交')?>" id="submit" class="btn btn-primary" style="margin-left: 45%"/>
                            </form>
                        </div><!-- /.col-xs-12 -->
                    </div><!-- /.row -->
                </div><!-- /.page-content -->
            </div><!-- /.main-content -->
             <?php
                    //设置容器配置挂件
                    $this->widget('settingsContainerWidget');
            ?>
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery.validate.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/uncompressed/additional-methods.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    $("#add").validate({
        rules: {
            name: {required:true,stringCheckAll:true},
            url:"required",
            bgcolor:"required",
            photo:"required",
        },
        messages:{
            name:"<?php echo yii::t('vcos', '请输入网络通信分类名称')?>",
            url:"<?php echo yii::t('vcos', '请输入跳转地址')?>",
            bgcolor:"<?php echo yii::t('vcos', '请选择背景颜色')?>",       
            photo:"<?php echo yii::t('vcos', '请上传图片')?>",
        }
    });
    $('#bgcolor').colorpicker();
    var $form = $('#add');
    var file_input = $form.find('input[type=file]');
    var upload_in_progress = false;

    file_input.ace_file_input({
        style : 'well',
        btn_choose : '<?php echo yii::t('vcos', '点击选择或者拖拽图片到这里')?>',
        btn_change: null,
        droppable: true,
        thumbnail: 'large',

        before_remove: function() {
            if(upload_in_progress)
                return false;//if we are in the middle of uploading a file, don't allow resetting file input
            return true;
        },

        before_change: function(files, dropped) {
            var file = files[0];
            if(typeof file == "string") {//files is just a file name here (in browsers that don't support FileReader API)
                if(! (/\.(jpe?g|png|gif)$/i).test(file) ) {
                    alert('<?php echo yii::t('vcos', '你选择的不是图片文件!')?>');
                    return false;
                }
            }
            else {
                var type = $.trim(file.type);
                if((type.length > 0 && ! (/^image\/(jpe?g|png|gif)$/i).test(type))||( type.length == 0 && ! (/\.(jpe?g|png|gif)$/i).test(file.name))){
                    alert('<?php echo yii::t('vcos', '你选择的不是图片文件!')?>');
                    return false;
                }
                if( file.size > 3*1024*1024 ) {//~100Kb
                    alert('<?php echo yii::t('vcos', '文件大小不能超过3MB!')?>')
                    return false;
                }
            }
            return true;
        }

    });
});
</script>




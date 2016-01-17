<?php
    $this->pageTitle = Yii::t('vcos','修改密码');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'admin';
?>
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
                            <?php echo yii::t('vcos', '修改资料')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '修改密码')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <form class="form-horizontal" role="form" method="post" action="" id="edit">
                                <input type="password" name="password" style="display: none" />
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '原密码')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="password" id="old_password" class="col-xs-10 col-sm-8 col-md-8" name="old_password" placeholder="<?php echo yii::t('vcos', '请输入原密码')?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '新密码')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="password" id="new_password" class="col-xs-10 col-sm-8 col-md-8" name="new_password" placeholder="<?php echo yii::t('vcos', '请输入新密码')?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '确认密码')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="password" id="new_password2" class="col-xs-10 col-sm-8 col-md-8" name="new_password2" placeholder="<?php echo yii::t('vcos', '请再次输入密码')?>" />
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
    jQuery(function($){
        $("#edit").validate({
            rules: {
                old_password:{required:true},
                new_password:{
                    required:true,
                    rangelength:[6,12],
                    remote: {
                        url: "checkpasswordajax", 
                        type: "post",
                        dataType: "json", 
                        data: {
                            id:"<?php echo Yii::app()->user->id;?>",
                            password: function() {
                                return $("#new_password").val();
                            }
                        }
                    }
                },
                new_password2:{equalTo:'#new_password'}
            },
            messages:{
                old_password:"<?php echo yii::t('vcos','请输入原密码')?>",
                new_password:{
                    required:"<?php echo yii::t('vcos', '请输入密码')?>",
                    remote:"<?php echo yii::t('vcos', '密码与原密码相同')?>",
                    rangelength: "<?php echo yii::t('vcos', '限制为6-18位')?>"
                },
                new_password2:{
                    equalTo: "<?php echo yii::t('vcos','两次输入密码不一致')?>"
                }
            }
        });
});
</script>
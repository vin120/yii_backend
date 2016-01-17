<?php
    $this->pageTitle = Yii::t('vcos','新增管理员');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'admin_add';
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
                            <?php echo yii::t('vcos', '权限管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '新增管理员')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <form class="form-horizontal" role="form" method="post" action="" id="add" autocomplete="off">
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '管理员账号')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="name" placeholder="<?php echo yii::t('vcos', '管理员账号')?>" class="col-xs-10 col-sm-8 col-md-8" name="name" value="" maxlength='80'/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '管理员昵称')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="real_name" class="col-xs-10 col-sm-8 col-md-8" name="real_name" maxlength="80" placeholder="<?php echo yii::t('vcos', '管理员昵称')?>" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '管理员密码')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="password" style="display: none"/>
                                        <input type="password" id="password" placeholder="<?php echo yii::t('vcos', '管理员密码')?>" class="col-xs-10 col-sm-8 col-md-8" name="password" maxlength='80'/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '确认密码')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <!-- <input type="password" style="display: none"/> -->
                                        <input type="password" id="cfpassword" placeholder="<?php echo yii::t('vcos', '确认密码')?>" class="col-xs-10 col-sm-8 col-md-8" name="cfpassword" maxlength='80'/>
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
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '管理员邮箱')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="email" class="col-xs-10 col-sm-8 col-md-8" name="email" maxlength="80" placeholder="<?php echo yii::t('vcos', '管理员邮箱')?>" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right" for="form-field-select-1"><?php echo yii::t('vcos', '管理员分组')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="role">
                                            <?php foreach ($role as $row){ ?>
                                            <option value="<?php echo $row['role_id']?>"><?php echo $row['role_name'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
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
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    
    $("#add").validate({
        rules: {
            name: {
                required:true,
                username:true,
                rangelength:[6,18],
                remote: {
                    url: "checknameajax", 
                    type: "post",
                    dataType: "json", 
                    data: {
                        name: function() {
                            return $("#name").val();
                        }
                    }
                }
            },
            real_name:{required:true,stringCheckAll:true},
            password:{required:true,rangelength:[6,12]},
            cfpassword:{equalTo:'#password'},
            email:{required:true, email:true}
        },
        messages:{
            name:{
                required:"<?php echo yii::t('vcos', '请输入管理员账号')?>",
                remote:"<?php echo yii::t('vcos', '此用户名已被使用')?>",
                rangelength: "<?php echo yii::t('vcos', '限制为6-18位')?>"
            },
            real_name:"<?php echo yii::t('vcos', '请输入管理员呢称')?>",
            password:{
                required: "<?php echo yii::t('vcos', '请输入密码')?>",
                rangelength: "<?php echo yii::t('vcos', '密码限制为6-12位')?>"
            },
            cfpassword:{
                equalTo:"<?php echo yii::t('vcos', '两次输入的密码不一致')?>"
            },
            email:{
                required: "<?php echo yii::t('vcos', '请输入管理员邮箱')?>",
                email: "<?php echo yii::t('vcos', '请输入正确的电子邮箱')?>"
            },
        }
    });
});
</script>
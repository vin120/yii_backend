<?php
    $this->pageTitle = Yii::t('vcos','编辑WiFi配置模式');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'wifi_config_add';
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
                            <?php echo yii::t('vcos', '网络通信管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑WiFi配置模式')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <form class="form-horizontal" role="form" method="post" action="" id="edit">
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '模式说明')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="describe" placeholder="<?php echo yii::t('vcos', '模式说明')?>" class="col-xs-10 col-sm-8 col-md-8" name="describe" maxlength="80" value="<?php echo $wifi['config_describe'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '登录网址')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="loginurl" placeholder="<?php echo yii::t('vcos', '登录网址')?>" class="col-xs-10 col-sm-8 col-md-8" name="loginurl" maxlength="80" value="<?php echo $wifi['config_login_url'];?>" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '主动登出网址')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="logouturl" type="text" name="logouturl" placeholder="<?php echo yii::t('vcos', '主动登出网址')?>" maxlength="80" value="<?php echo $wifi['config_logout_url'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '改变时长')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="change" placeholder="<?php echo yii::t('vcos', '改变时长')?>" class="col-xs-10 col-sm-8 col-md-8" name="change" maxlength="80" value="<?php echo $wifi['config_change_url'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '被动登出网址')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="notice" placeholder="<?php echo yii::t('vcos', '被动登出网址')?>" class="col-xs-10 col-sm-8 col-md-8" name="notice" maxlength="80" value="<?php echo $wifi['config_notice'];?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '政策')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="policy" class="col-xs-10 col-sm-8 col-md-8" name="policy" placeholder="<?php echo yii::t('vcos', '政策')?>" maxlength="80" value="<?php echo $wifi['config_policy'];?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', 'SSID')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="ssid" type="text" name="ssid" placeholder="<?php echo yii::t('vcos', 'SSID')?>" maxlength="80" value="<?php echo $wifi['config_ssid'];?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', 'ACIP')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="acip" type="text" placeholder="<?php echo yii::t('vcos', 'ACIP')?>" name="acip" maxlength="80" value="<?php echo $wifi['config_acip'];?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', 'APmac')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="apmac" type="text" name="apmac" placeholder="<?php echo yii::t('vcos', 'APmac')?>" maxlength="80" value="<?php echo $wifi['config_apmac'];?>"/>
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
<script type="text/javascript">
jQuery(function($){
    $("#edit").validate({
        rules: {
            describe:{required:true,stringCheckAll:true},
            loginurl: {required:true,url:true},
            logouturl:{required:true,url:true},
            change:{required:true,stringCheckAll:true},
            notice:{required:true,url:true},
            policy:{required:true,stringCheckAll:true},
            ssid:{required:true,stringCheckAll:true},
            acip:{required:true,stringCheckAll:true},
            apmac:{required:true,stringCheckAll:true},
        },
        messages:{
            describe:"<?php echo yii::t('vcos', '请输入模式说明')?>",
            loginurl:"<?php echo yii::t('vcos', '请输入登陆地址')?>",
            logouturl:"<?php echo yii::t('vcos', '请输入主动登出地址')?>",
            change:"<?php echo yii::t('vcos', '请输入改变时长')?>",
            notice:"<?php echo yii::t('vcos', '请输入被动登出地址')?>",
            policy:"<?php echo yii::t('vcos', '请输入策略')?>",
            ssid:"<?php echo yii::t('vcos', '请输入SSID')?>",
            acip:"<?php echo yii::t('vcos', '请输入ACIP')?>",
            apmac:"<?php echo yii::t('vcos', '请输入APMAC')?>",
        }
    });
});
</script>



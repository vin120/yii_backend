<?php
    $this->pageTitle = Yii::t('vcos','查看用户意见');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'user_comment';
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
                            <?php echo yii::t('vcos', '评价与帮助管理 ')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '查看用户意见')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11" style="padding-left: 5%">
                            <div class="form-group">
                                <label class="col-xs-8 col-sm-8 col-md-8 control-label no-padding-right"><?php echo yii::t('vcos', '发布人').' : ';?><a href="<?php echo Yii::app()->createUrl("User/user_detail")."?id=".$user['member_id'];?>"><?php echo $user['cn_name'];?></a>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-8 col-sm-8 col-md-8 control-label no-padding-right"><?php echo yii::t('vcos', '意见类型').' : '.$comment['comment_type_name'];?>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-8 col-sm-8 col-md-8 control-label no-padding-right"><?php echo yii::t('vcos', '发布时间').' : '.$comment['comment_time'];?>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-8 col-sm-8 col-md-8 control-label no-padding-right"><?php echo yii::t('vcos', '内容').' : '.$comment['comment_content'];?>
                            </div>
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<?php
    $this->pageTitle = Yii::t('vcos','禁止访问');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = '';
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
                <div class="row">
                    <div class="col-xs-12">
                        <div class="error-container">
                            <div class="well">
                                <h1 class="grey lighter smaller">
                                    <span class="blue bigger-125">
                                        <i class="icon-sitemap"></i>
                                        <?php echo yii::t('vcos', '禁止访问')?>
                                    </span>
                                </h1>
                                <hr />
                                <div>
                                    <div class="space"></div>
                                    <ul class="list-unstyled spaced inline bigger-110 margin-15">
                                        <li>
                                            <?php echo yii::t('vcos', '服务器拒绝了你的请求')?>
                                        </li>
                                        <li>
                                            <?php echo yii::t('vcos', '请确认你拥有所需的访问权限')?>
                                        </li>
                                    </ul>
                                </div>
                                <hr />
                                <div class="space"></div>
                                <div class="center">
                                    <a href="#" class="btn btn-grey" id="back">
                                        <i class="icon-arrow-left"></i>
                                        <?php echo yii::t('vcos', '返回上一页')?>
                                    </a>
                                    <a href="<?php echo Yii::app()->createUrl("Site/index");?>" class="btn btn-primary">
                                        <i class="icon-dashboard"></i>
                                        <?php echo yii::t('vcos', '首页')?>
                                    </a>
                                </div>
                            </div>
                        </div><!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div><!-- /.main-content -->
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
<script>
jQuery(function($){
    $("#back").click(function(){
        history.go(-1)
    });
})
</script>

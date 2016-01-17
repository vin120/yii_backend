<?php
    $this->pageTitle = Yii::t('vcos','毕升邮轮管理系统');
    $theme_url = Yii::app()->theme->baseUrl;
    $menu_type = 'aaaa';
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
                                        <?php echo Yii::t('vcos','欢迎登录毕升邮轮管理系统')?>
                                    </h1>
                            </div><!-- /.page-header -->

                            <div class="row">
                                    <div class="col-xs-12">
                                            <!-- PAGE CONTENT BEGINS -->

                                            <table id="grid-table"></table>

                                            <div id="grid-pager"></div>

                                            <script type="text/javascript">
                                                    var $path_base ="<?php echo Yii::app()->request->hostInfo; ?>";//this will be used in gritter alerts containing images
                                            </script>

                                            <!-- PAGE CONTENT ENDS -->
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
<script src="<?php echo $theme_url; ?>/assets/js/typeahead-bs2.min.js"></script>

<!-- page specific plugin scripts -->

<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jqGrid/i18n/grid.locale-en.js"></script>
                
<!-- ace scripts
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
 -->

<!-- inline scripts related to this page -->

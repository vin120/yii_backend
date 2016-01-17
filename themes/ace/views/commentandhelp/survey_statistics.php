<?php
    $this->pageTitle = Yii::t('vcos','评价统计');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type =  'survey';
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
                        <?php echo yii::t('vcos', '评价与帮助管理')?>
                        <small>
                            <i class="icon-double-angle-right"></i>
                            <?php echo yii::t('vcos', '评价统计')?>
                        </small>
                    </h1>
                </div><!-- /.page-header -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <th><?php echo yii::t('vcos', '栏目名')?></th>
                                            <?php foreach($grade as $row){?>
                                            <th><?php echo $row['survey_choose_name']?></th>
                                            <?php } ?>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $title['survey_title']?></td>
                                                <?php foreach ($result as $row) {?>
                                                <td><?php echo $row; ?></td>
                                                <?php }?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.table-responsive -->
                            </div><!-- /.col-xs-12 -->
                        </div><!-- /.row -->
                    </div><!-- /.col-xs-12 -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div><!-- /.main-conttent -->
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
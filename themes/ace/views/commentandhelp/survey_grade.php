<?php
    $this->pageTitle = Yii::t('vcos','评价选项');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'survey_grade';
?>
<?php 
    //navbar 挂件
    $this->widget('navbarWidget');
    if(in_array('93', $auth) || $auth[0] == '0'){
        $canedit = TRUE;
    }  else {
        $canedit = False;
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
                        <?php echo yii::t('vcos', '评价与帮助管理')?>
                        <small>
                            <i class="icon-double-angle-right"></i>
                            <?php echo yii::t('vcos', '评价选项')?>
                        </small>
                    </h1>
                </div><!-- /.page-header -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <form method="post" name="survey">
                                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <th><?php echo yii::t('vcos', '序号')?></th>
                                                <th><?php echo yii::t('vcos', '评价栏目标题')?></th>
                                                <th><?php echo yii::t('vcos', '评价栏目状态')?></th>
                                                <th><?php echo yii::t('vcos', '操作')?></th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($grade as $key=>$row) {?>
                                                <tr>
                                                    <td><?php echo ++$key; ?></td>
                                                    <td><?php echo $row['survey_choose_name']; ?></td>
                                                    <td><?php echo $row['survey_choose_state']?yii::t('vcos', '启用'):yii::t('vcos', '禁用')?></td>
                                                    <td>
                                                        <?php
                                                            //操作挂件
                                                            $this->widget('ManipulateWidget',array(
                                                                'ControllerName'=>'Commentandhelp',
                                                                'MethodName'=>'survey_grade_edit',
                                                                'id'=>$row['survey_choose_id'],
                                                                'canedit'=>$canedit,
                                                            ));
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
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
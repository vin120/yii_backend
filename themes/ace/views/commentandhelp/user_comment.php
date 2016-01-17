<?php
    $this->pageTitle = Yii::t('vcos','用户意见');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type =  'user_comment';
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
                                    <?php echo yii::t('vcos', '用户意见')?>
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
                                                        <th><?php echo yii::t('vcos', '序号')?></th>
                                                        <th><?php echo yii::t('vcos', '意见类型')?></th>
                                                        <th><?php echo yii::t('vcos', '发布人')?></th>
                                                        <th><?php echo yii::t('vcos', '发布时间')?></th>
                                                        <th><?php echo yii::t('vcos', '内容')?></th>
                                                        <th><?php echo yii::t('vcos', '操作')?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($comment as $key=>$row) { ?>
                                                    <tr>
                                                        <td><?php echo ++$key;?></td>
                                                        <td><?php echo $row['comment_type_name'];?></td>
                                                        <td><?php echo $row['cn_name'];?></td>
                                                        <td><?php echo $row['comment_time'];?></td>
                                                        <td><?php echo Helper::truncate_utf8_string($row['comment_content'],20);?></td>
                                                        <td>
                                                            <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                                                <a href="<?php echo Yii::app()->createUrl("Commentandhelp/user_comment_detail?id={$row['comment_id']}");?>" class="btn btn-xs btn-success" title="<?php echo yii::t('vcos', '查看详情');?>">
                                                                    <i class="icon-zoom-in bigger-120"></i>
                                                                </a>
                                                            </div>
                                                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                <div class="inline position-relative">
                                                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                        <i class="icon-cog icon-only bigger-110"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                                        <li>
                                                                            <a href="<?php echo Yii::app()->createUrl("Commentandhelp/user_comment_detail?id={$row['comment_id']}");?>" class="tooltip-info" data-rel="tooltip" title="<?php echo yii::t('vcos', '查看详情');?>">
                                                                                <span class="blue">
                                                                                    <i class="icon-zoom-in bigger-120"></i>
                                                                                </span>
                                                                            </a>
                                                                        </li>
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
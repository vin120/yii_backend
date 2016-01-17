<?php
    $this->pageTitle = Yii::t('vcos','编辑休闲服务预定');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'service_booking_list';
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
                            <?php echo yii::t('vcos', '休闲服务管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑休闲服务预定')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <form class="form-horizontal" role="form" method="post" action="" id="edit" >
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '订单号').' : ';?></label>
                                    <label class="col-xs-8 col-sm-8 col-md-8 "><?php echo $detail['id'];?></label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '预定人').' : ';?></label>
                                    <label class="col-xs-8 col-sm-8 col-md-8 "><?php echo $user['cn_name'];?></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '预定项目').' : ';?></label>
                                    <label class="col-xs-8 col-sm-8 col-md-8 "><?php echo $detail['ls_title'];?></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '预定时间').' : ';?></label>
                                    <label class="col-xs-8 col-sm-8 col-md-8 "><?php echo $detail['booking_time'];?></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '预定人数')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-6 col-sm-6 col-md-6" name="num">
                                            <?php for($i=1;$i<=10;$i++){?>
                                            <option value="<?php echo $i;?>" <?php if($detail['booking_num'] == $i){echo "selected";}?>><?php echo $i;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '备注')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <textarea rows="10" cols="50" id="remark" name="remark"><?php echo $detail['remark'];?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-6 col-sm-6 col-md-6" name="state">
                                            <?php if($detail['state'] == '0'){?>
                                            <option value="0" <?php if($detail['state'] == '0'){echo 'selected';}?> class="state"><?php echo yii::t('vcos', '已取消')?></option>
                                            <?php }else{?>
                                            <option value="1" <?php if($detail['state'] == '1'){echo 'selected';}?> class="state"><?php echo yii::t('vcos', '处理中')?></option>
                                            <option value="2" <?php if($detail['state'] == '2'){echo 'selected';}?> class="state"><?php echo yii::t('vcos', '预定成功')?></option>
                                            <option value="3" <?php if($detail['state'] == '3'){echo 'selected';}?> class="state"><?php echo yii::t('vcos', '预定失败，人数已满')?></option>
                                            <option value="4" <?php if($detail['state'] == '4'){echo 'selected';}?> class="state"><?php echo yii::t('vcos', '完成服务')?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" value="<?php echo yii::t('vcos', '保存')?>" id="submit" class="btn btn-primary" style="margin-left: 45%"/>
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
            remark:"required"
        },
        messages:{
            remark:"<?php echo yii::t('vcos', '请输入备注')?>"
        }
    });
});
</script>
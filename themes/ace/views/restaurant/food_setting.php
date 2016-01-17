<?php
    $this->pageTitle = Yii::t('vcos','套餐设置');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'food_setting';
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
                            <?php echo yii::t('vcos', '餐饮服务管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '套餐设置')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                            <form class="form-horizontal" role="form" method="post" action="" id="add" >
                    <div class="row" style="margin-left: 20%">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <div class="form-group">
                                <label class="col-xs-2 col-sm-2 col-md-2 control-label"><?php echo yii::t('vcos', '请选择餐厅')?>：</label>
                                <div class="col-xs-8 col-sm-8 col-md-7">
                                    <select class="col-xs-10 col-sm-8 col-md-8" id="type" name="type">
                                        <option value=""><?php echo yii::t('vcos', '请选择餐厅')?></option>
                                        <?php foreach ($restaurant as $row){ ?>
                                        <option value="<?php echo $row['restaurant_id']?>" <?php if(isset($_GET['id'])){if($row['restaurant_id']==$_GET['id']){echo "selected";}}?>><?php echo $row['restaurant_name'];?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div style="clear: both"></div>
                                <div class="col-xs-8 col-sm-8 col-md-7" style="margin-top: 3%">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                        <?php foreach ($food as $row){?>
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type="checkbox" <?php if(is_array($setting)){if(in_array($row['food_id'], $setting)){echo 'checked="checked"';}}?>class="ace isclick" name="ids[]" value="<?php echo $row['food_id'];?>"/>
                                                    <span class="lbl"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <?php echo yii::t('vcos', $row['main_title']);?>
                                            </td>
                                            <td>
                                                <?php echo '￥ '.$row['food_price']/100;?>
                                            </td>
                                            <td>
                                                <img src="<?php echo Yii::app()->params['imgurl'].$row['food_img_url'];?>" width="70"/>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="clear: both"></div>
                                <input type="submit" value="<?php echo yii::t('vcos', '提交')?>" id="submit" class="btn btn-primary" style="margin-left: 25%"/>
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
    $("#add").validate({
        rules: {
            type:"required"
        },
        messages:{
            type:"<?php echo yii::t('vcos','请选择餐厅')?>"
        }
    });
    
    $('#type').change(function(){
        location.href="<?php echo Yii::app()->createUrl("Restaurant/food_setting");?>"+"?id="+$(this).val();
    });
    
    $("form").submit( function () {
        <?php if(isset($_GET['id'])){?>
        <?php if($_GET['id']!=''){?>
        if(!$('.isclick').is(':checked')){
            alert('<?php echo yii::t('vcos','未分配套餐')?>');
            return false;
        }
        <?php }?>
        <?php }?>
    });
    
 
});
</script>




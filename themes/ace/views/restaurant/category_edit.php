<?php
    $this->pageTitle = Yii::t('vcos','编辑食物分类');
    $this->pageTag = 'category_list';
    
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'category_add';
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
                                    <?php echo yii::t('vcos', '编辑食物分类')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <?php  
                            //使用小物件生成form元素  
                            $form=$this->beginWidget('CActiveForm',array(
                                'htmlOptions'=>array(
                                    'class'=>'form-horizontal',
                                    'role'=>'form',
                                    'id'=>'edit',
                                ),
                            ));  
                            ?> 
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '添加外语')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="radio" check='no' class="iso_choose" name="language" value="en" />English
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '餐厅名')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="restaurant">
                                            <?php foreach ($restaurant_sel as $row){ ?>
                                            <option value="<?php echo $row['restaurant_id']?>" <?php if($row['restaurant_id'] == $food_category['restaurant_id']){ echo 'selected';}?>><?php echo $row['restaurant_name'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分类名')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="category" value="<?php echo $food_category_language['food_category_name'];?>" placeholder="<?php echo yii::t('vcos', '分类名')?>" class="col-xs-10 col-sm-8 col-md-8" name="category" maxlength="16" />
                                        <?php echo $form->error($food_category_language,'food_category_name'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_category">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分类名').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="category2" placeholder="<?php echo yii::t('vcos', '分类名').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="category_iso" maxlength="16" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                               
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($food_category['food_category_state']){echo 'checked="checked"';}?> class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '顺序')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8"  value="<?php echo $food_category['list_order'];?>" id="sequence" maxlength="4" type="text" name="sequence" placeholder="<?php echo yii::t('vcos', '顺序')?>"/>
                                        <?php echo $form->error($food_category,'list_order'); ?> 
                                    </div>
                                </div>
                                <input type="hidden" value="" id="judge" name="judge">
                                <input type="submit" value="<?php echo yii::t('vcos', '提交')?>" id="submit" class="btn btn-primary" style="margin-left: 45%"/>
                            <?php  
                                $this->endWidget();  
                            ?>
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
    
    $(".iso_choose").click(function(){
        $check = $(this).attr('check');
        if($check == 'no'){
            $(this).attr('check','yes');
            $a = $(this).val();
            $b = '<?php echo $_GET['id']?>';
            $.post("<?php echo Yii::app()->createUrl("Restaurant/getiso_category")?>",{iso:$a,id:$b},function(data){
                if(data != 0){
                    var result = jQuery.parseJSON(data);
                    $(".iso input:text").val('');
                    $(".iso_category input:text").val(result['food_category_name']);
                    $(".iso").removeClass('hidden'); 
                    $(".iso input:text").addClass('required');
                    $("#judge").val(result['id']);
                }else{
                    $(".iso").removeClass('hidden');
                    $(".iso input:text").addClass('required');
                    $("#judge").val('add');
                }
            });
        }else if($check == 'yes'){
            $(this).attr('check','no');
            $(this).removeAttr('checked');
            $(".iso").addClass('hidden');
            $(".iso input:text").removeClass('required');
            $("#judge").val('');
        }
    });
    
    $("#edit").validate({
        rules: {
            category:{required:true,stringCheckAll:true},
            category_iso:{stringCheckAll:true},
            sequence:{required:true, digits:true},
            photo:"required"
        },
        messages:{
            category:{
                stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
            },
            category_iso:{
                stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
            }
        }
    });
    
   
});
</script>




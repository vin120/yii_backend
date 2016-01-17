<?php
    $this->pageTitle = Yii::t('vcos','编辑美食');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'food_add';
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
                                    <?php echo yii::t('vcos', '编辑美食')?>
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
                                    'enctype'=>'multipart/form-data',
                                ),
                            ));  
                            ?> 
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '编辑外语')?>：</label>
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
                                            <option value="<?php echo $row['restaurant_id']?>" <?php if($row['restaurant_id'] == $food['restaurant_id']){echo 'selected';}?>><?php echo $row['restaurant_name'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '所属分类')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="food_category">
                                            <?php foreach ($category_sel as $row){ ?>
                                            <option value="<?php echo $row['food_category_id']?>" <?php if($food['food_category_id']==$row['food_category_id']){echo 'selected';}?>><?php echo $row['food_category_name'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                    
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '主标题')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="main_title" placeholder="<?php echo yii::t('vcos', '主标题')?>" class="col-xs-10 col-sm-8 col-md-8" name="main_title" maxlength="80" value="<?php echo $food_language['main_title'];?>" />
                                        <?php echo $form->error($food_language,'main_title'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_maintitle">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '主标题').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="main_title2" placeholder="<?php echo yii::t('vcos', '主标题').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="main_title_iso" maxlength="80" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '副标题')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="food_title" type="text" name="food_title" placeholder="<?php echo yii::t('vcos', '副标题')?>" maxlength="80" value="<?php echo $food_language['food_title'];?>" />
                                        <?php echo $form->error($food_language,'food_title'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_foodtitle">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '副标题').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="food_title2" type="text" name="food_title_iso" placeholder="<?php echo yii::t('vcos', '副标题').yii::t('vcos','(外语)')?>" maxlength="80"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '套餐价格')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="price"  placeholder="<?php echo yii::t('vcos', '套餐价格')?>" class="col-xs-10 col-sm-8 col-md-8" name="price" maxlength="10" value="<?php echo $food['food_price']/100;?>" />
                                        <?php echo $form->error($food,'food_price'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '最大购买数')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="max_buy"  placeholder="<?php echo yii::t('vcos', '最大购买数')?>" class="col-xs-10 col-sm-8 col-md-8" name="max_buy" maxlength="3" value="<?php echo $food['max_buy'];?>"/>
                                        <?php echo $form->error($food,'max_buy'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($food['food_state']){echo 'checked="checked"';}?> class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right" ><?php echo yii::t('vcos', '图片')?>：</label>
                                    <img src="<?php echo Yii::app()->params['imgurl'].$food['food_img_url'];?>" class="col-xs-3 col-sm-3 col-md-3" title="<?php echo yii::t('vcos', '原图片')?>" />
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <input type="file" name="photo" id="photo"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
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
<script src="<?php echo $theme_url; ?>/assets/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    $("#edit").validate({
        rules: {
            main_title:{required:true,stringCheckAll:true},
            food_title:{required:true,stringCheckAll:true},
            price:{required:true, isFloatGtZero:true},
            max_buy:{digits:true,required:true,isIntGtZero:true},
            main_title_iso:{stringCheckAll:true},
            food_title_iso:{stringCheckAll:true}
        },
        messages:{
            main_title:{
            isIntGtZero: "<?php echo yii::t('vcos', '整数必须大于0')?>",
            },
            main_title:{
                 stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
            },
            main_title_iso:{
                stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
            },
            food_title:{
                 stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
            },
            food_title_iso:{
                stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
            }
        }
        
    });
    
    $(".iso_choose").click(function(){
        $check = $(this).attr('check');
        if($check == 'no'){
            $(this).attr('check','yes');
            $a = $(this).val();
            $b = '<?php echo $_GET['id']?>';
            $.post("<?php echo Yii::app()->createUrl("restaurant/getiso_food")?>",{iso:$a,id:$b},function(data){
                if(data != 0){
                    var result = jQuery.parseJSON(data);
                    $(".iso input:text").val('');
                    $(".iso_maintitle input:text").val(result['main_title']);
                    $(".iso_foodtitle input:text").val(result['food_title']);
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
    <?php $path_url = Yii::app()->createUrl('Restaurant/RestaurantGetCategory');?>

    $("select[name='restaurant']").change(function(){
        var str = '';
        var restaurant = $(this).val();
        $.ajax({
            url:"<?php echo $path_url;?>",
            type:'get',
            data:'restaurant='+restaurant,
            dataType:'json',
            success:function(data){
                $.each(data,function(key){  
                    str += "<option value="+data[key]['food_category_id']+">"+data[key]['food_category_name']+"</option>"; 
                });
                $("select[name='food_category']").html(str);
            }
        });   
    });
    
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'edit'));
    ?>
});
</script>



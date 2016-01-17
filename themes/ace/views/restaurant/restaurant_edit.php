<?php
    $this->pageTitle = Yii::t('vcos','编辑餐厅');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'restaurant_add';
?>
<link rel="stylesheet" href="<?php echo $theme_url?>/assets/css/colorpicker.css" />
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
                                    <?php echo yii::t('vcos', '编辑餐厅')?>
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
                                        <input type="radio" check="no" class="iso_choose" name="language" value="en" />English
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '餐厅名')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="titles" placeholder="<?php echo yii::t('vcos', '餐厅名')?>" class="col-xs-10 col-sm-8 col-md-8" name="title" maxlength="80" value="<?php echo $restaurant_language['restaurant_name'];?>" />
                                        <?php echo $form->error($restaurant_language,'restaurant_name'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_title">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '餐厅名').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="titles2" placeholder="<?php echo yii::t('vcos', '餐厅名').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="title_iso" maxlength="80" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '地址')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="address" type="text" maxlength="80" name="address" placeholder="<?php echo yii::t('vcos', '地址')?>" value="<?php echo $restaurant_language['restaurant_address'];?>" />
                                        <?php echo $form->error($restaurant_language,'restaurant_address'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_address">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '地址').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="address2" type="text" maxlength="80" name="address_iso" placeholder="<?php echo yii::t('vcos', '地址').yii::t('vcos','(外语)')?>" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '特色')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="feature" placeholder="<?php echo yii::t('vcos', '特色')?>" class="col-xs-10 col-sm-8 col-md-8" name="feature" maxlength="80" value="<?php echo $restaurant_language['restaurant_feature'];?>" />
                                        <?php echo $form->error($restaurant_language,'restaurant_feature'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_feature">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '特色').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="feature2" placeholder="<?php echo yii::t('vcos', '特色').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="feature_iso" maxlength="80" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '营业时间')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="time" class="col-xs-10 col-sm-8 col-md-8" name="time" maxlength="80" placeholder="<?php echo yii::t('vcos', '营业时间')?>" value="<?php echo $restaurant_language['restaurant_opening_time'];?>"/>
                                        <?php echo $form->error($restaurant_language,'restaurant_opening_time'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_time">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '营业时间').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="time2" class="col-xs-10 col-sm-8 col-md-8" name="time_iso" maxlength="80" placeholder="<?php echo yii::t('vcos', '营业时间').yii::t('vcos','(外语)')?>" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '电话')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="tel" type="text" name="tel" placeholder="<?php echo yii::t('vcos', '电话')?>" value="<?php echo $restaurant['restaurant_tel'];?>"/>
                                        <?php echo $form->error($restaurant,'restaurant_tel'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($restaurant['restaurant_state']){echo 'checked="checked"';}?> class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '是否支持送餐')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($restaurant['can_delivery']){echo 'checked="checked"';}?> class="ace ace-switch ace-switch-5" name="delivery" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '是否支持预定')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($restaurant['can_book']){echo 'checked="checked"';}?> class="ace ace-switch ace-switch-5" name="book" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '顺序')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" onKeyUp="this.value=this.value.replace(/[^\d$]/g,'');" id="sequence" type="text" name="sequence" maxlength="10" value="<?php echo $restaurant['restaurant_sequence'];?>"/>
                                        <?php echo $form->error($restaurant,'restaurant_sequence'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '背景颜色')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <div class="bootstrap-colorpicker">
                                            <input id="bgcolor" name="bgcolor" type="text" class="input-small" value="<?php echo $restaurant['bg_color'];?>" />
                                            <?php echo $form->error($restaurant,'bg_color'); ?> 
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '餐厅分类')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="type">
                                            <option value="1" <?php if($restaurant['restaurant_type']=='1'){echo 'selected';}?> ><?php echo yii::t('vcos', '免费餐厅')?></option>
                                            <option value="2" <?php if($restaurant['restaurant_type']=='2'){echo 'selected';}?> ><?php echo yii::t('vcos', '收费餐厅')?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right" ><?php echo yii::t('vcos', '图片1')?>：</label>
                                    <img src="<?php echo Yii::app()->params['imgurl'].$restaurant['restaurant_img_url'];?>" class="col-xs-3 col-sm-3 col-md-3" title="<?php echo yii::t('vcos', '原图片')?>" />
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <input type="file" name="photo1" id="photo1"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right" ><?php echo yii::t('vcos', '图片2')?>：</label>
                                    <img src="<?php echo Yii::app()->params['imgurl'].$restaurant['restaurant_img_url2'];?>" class="col-xs-3 col-sm-3 col-md-3" title="<?php echo yii::t('vcos', '原图片')?>" />
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <input type="file" name="photo2" id="photo2"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '描述')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<?php 
		                                $msg = $restaurant_language['restaurant_describe'];
		                                $img_ueditor_old = Yii::app()->params['img_ueditor_old'];
		                                $count = preg_replace($img_ueditor_old,Yii::app()->params['img_ueditor'],$msg);
		                                ?>
                                        <!-- <input type="text" id="describe" placeholder="<php echo yii::t('vcos', '描述')?>" class="col-xs-10 col-sm-8 col-md-8" name="describe" maxlength="100" value="<php echo $restaurant_language['restaurant_describe'];?>"/> -->
                                        <textarea id="describe" name="describe" placeholder="<?php echo yii::t('vcos', '描述')?>"><?php echo $count;?></textarea>
                                        <?php echo $form->error($restaurant_language,'restaurant_describe'); ?>
                                        <label id="describe-error" class=" hidden" ><?php echo yii::t('vcos', '必填字段')?></label> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_describe">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '描述').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <!-- <input type="text" id="describe2" placeholder="<php echo yii::t('vcos', '描述').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="describe_iso" maxlength="100" /> -->
                                        <textarea id="describe2" placeholder="<?php echo yii::t('vcos', '描述').yii::t('vcos','(外语)')?>" name="describe_iso"></textarea>
                                        <label id="describe2-error" class=" hidden" ><?php echo yii::t('vcos', '必填字段')?></label>
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
<script src="<?php echo $theme_url; ?>/assets/js/ueditor.config.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ueditor.all.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
	UE.getEditor('describe');
    //UE.getEditor('describe2');
    
    $(".iso_choose").click(function(){
        $check = $(this).attr('check');
        if($check == 'no'){
            $(this).attr('check','yes');
        	$a = $(this).val();
            $b = '<?php echo $_GET['id']?>';
            $ueditor_url = "<?php echo Yii::app()->params['img_ueditor'];?>";
	        $img_ueditor_old = <?php echo Yii::app()->params['img_ueditor_old_js'];?>;
            $.post("<?php echo Yii::app()->createUrl("restaurant/getiso")?>",{iso:$a,id:$b},function(data){
                if(data != 0){
                    var result = jQuery.parseJSON(data);
                    $(".iso input:text").val('');
                    $(".iso_title input:text").val(result['restaurant_name']);
                    $(".iso_address input:text").val(result['restaurant_address']);
                    $(".iso_feature input:text").val(result['restaurant_feature']);
                    var msg = result['restaurant_describe'];
	                var reg = $img_ueditor_old;
	                msg= msg.replace(reg,$ueditor_url);
                    $(".iso_describe textarea").html(msg);
                    UE.getEditor('describe2');
                    $(".iso_time input:text").val(result['restaurant_opening_time']);
                    $(".iso").removeClass('hidden'); 
                    $(".iso input:text").addClass('required');
                    $("#judge").val(result['id']);
                }else{
                    $(".iso").removeClass('hidden');
                    $(".iso input:text").addClass('required');
                    $("#judge").val('add');
                    UE.getEditor('describe2');
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

    $('form').submit(function(){
        var a = 1;
        if($('#describe').next().val()==''){
           $('#describe').next().next().show();
           a = 0;
        }
        if(!$(".iso_describe").hasClass("hidden")){
            if($('#describe2').next().val()==''){
                $('#describe2').next().next().show();
                a = 0;
            }
        }
       if(a == 0){
           return false;
       }
    });
   
    
    $("#edit").validate({
        rules: {
            title: {required:true,stringCheckAll:true},
            address:{required:true,stringCheckAll:true},
            feature:{required:true,stringCheckAll:true},
            time:{required:true,stringCheckAll:true},
            tel:{required:true, isTel:true},
            sequence:{required:true, digits:true},
            bgcolor:"required",
            title_iso: {stringCheckAll:true},
            address_iso:{stringCheckAll:true},
            feature_iso:{stringCheckAll:true},
            time_iso:{stringCheckAll:true}
        },
        messages:{
            isTel:{
	            stringCheckAll: "<?php echo yii::t('vcos', '请正确填写您的联系方式')?>",
			},
			title:{
	            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			},
			title_iso:{
		        stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			},
			address:{
	            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			},
			address_iso:{
		        stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			},
			feature:{
	            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			},
			feature_iso:{
		        stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			},
			time:{
	            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			},
			time_iso:{
		        stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			}
			
		}
    });
    $('#bgcolor').colorpicker();
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'edit'));
    ?>
});
</script>



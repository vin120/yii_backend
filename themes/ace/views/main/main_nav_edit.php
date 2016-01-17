<?php
    $this->pageTitle = Yii::t('vcos','编辑导航');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'main_nav_add';
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
                            <?php echo yii::t('vcos', '首页管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑导航')?>
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
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '添加外语')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="radio" check='no' class="iso_choose" name="language" value="en" />English
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '所属分类')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                   
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="category">
                                            <?php foreach ($category_sel as $str){ ?>
                                            <option value="<?php echo $str['main_id']?>" <?php if($str['main_id'] == $main_nav['category_id']){echo "selected='selected'";}?>><?php echo $str['name']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '导航名')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="name" placeholder="<?php echo yii::t('vcos', '导航名')?>" class="col-xs-10 col-sm-8 col-md-8" name="name" maxlength="6" value="<?php echo $main_nav_language['name'];?>" />
                                        <?php echo $form->error($main_nav_language,'name'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_name">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '导航名').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="name2" placeholder="<?php echo yii::t('vcos', '导航名').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="name_iso" maxlength="6" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '顺序')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="sequence" placeholder="<?php echo yii::t('vcos', '顺序')?>" class="col-xs-10 col-sm-8 col-md-8" name="sequence" maxlength="4" value="<?php echo $main_nav['sequence'];?>" />
                                        <?php echo $form->error($main_nav,'sequence'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="state">
                                            <option value="0" <?php if($main_nav['state'] == 0){echo "selected='selected'";}?>><?php echo yii::t('vcos', '不用')?></option>
                                            <option value="1" <?php if($main_nav['state'] == 1){echo "selected='selected'";}?>><?php echo yii::t('vcos', '可用')?></option>
                                            <option value="2" <?php if($main_nav['state'] == 2){echo "selected='selected'";}?>><?php echo yii::t('vcos', '置灰')?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '背景颜色')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <div class="bootstrap-colorpicker">
                                            <input id="bgcolor" name="bgcolor" type="text" class="input-small" value="<?php echo $main_nav_language['bg_color'];?>" />
                                        </div>
                                    </div>
                                    <?php echo $form->error($main_nav_language,'bg_color'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_bgcolor">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '背景颜色').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <div class="bootstrap-colorpicker">
                                            <input id="bgcolor2" name="bgcolor_iso" type="text" class="input-small" />
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <img src="<?php echo Yii::app()->params['imgurl'].$main_nav_language['img_url'];?>" class="col-xs-3 col-sm-3 col-md-3" title="<?php echo yii::t('vcos', '原图片')?>" />
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <input type="file" name="photo" id="photo"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group  hidden iso iso_img">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片').yii::t('vcos','(外语)')?>：</label>
                                    <img src="" class="col-xs-3 col-sm-3 col-md-3" title="<?php echo yii::t('vcos', '原图片')?>" />
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <input type="file" name="photo_iso" id="photo1"/>
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
            name:{required:true,stringCheckAll:true},
            name_iso:{stringCheckAll:true},
            sequence:{required:true, digits:true},
            category:{required:true, digits:true},
            state:{required:true, digits:true},
            bgcolor:"required"
        },
        messages:{
            name:{
			    stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			},
			name_iso:{
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
	        $img_url = '<?php echo Yii::app()->params['imgurl'];?>';
	        $.post("<?php echo Yii::app()->createUrl("Main/getiso_nav")?>",{iso:$a,id:$b},function(data){
	            if(data != 0){
	                var result = jQuery.parseJSON(data);
	                $(".iso input:text").val('');
	                $(".iso_name input:text").val(result['name']);
	                $(".iso_bgcolor input:text").html(result['bg_color']);
	                $img_url = $img_url + result['img_url'];
                    $(".iso_img > img").attr('src',$img_url);     
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

    $('#bgcolor').colorpicker();
    $('#bgcolor2').colorpicker();
 
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'edit'));
    ?>
});
</script>



<?php
    $this->pageTitle = Yii::t('vcos','编辑店铺分类');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'shop_category_add';
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
                            <?php echo yii::t('vcos', '店铺管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑店铺分类')?>
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
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '店铺')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="shop">
                                    		<?php foreach($shop as $row){?>
                                            <option value="<?php echo $row['shop_id']?>" <?php if($shop_category['shop_id']==$row['shop_id']){echo "selected='selected'";}?>><?php echo $row['shop_title']?></option>
                                            <?php }?>
                                        </select>
                                        <?php echo $form->error($shop_category,'shop_id'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品分类')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<?php if($layer_1){?>
                                    	<select style="width:30%;" id="category_one" name="category_1">
                                          <?php foreach($layer_1 as $lay1){?>  
                                            <option value="<?php echo $lay1['category_code']?>" <?php if($layer_cat==$lay1['category_code']){echo "selected='selected'";}?>><?php echo $lay1['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                        <?php if($layer_2){?>
                                    	<select style="width:30%;" id="category_two" name="category_2">
                                          <?php foreach($layer_2 as $lay2){?>  
                                            <option value="<?php echo $lay2['category_code']?>" <?php if($layer_cat2==$lay2['category_code']){echo "selected='selected'";}?>><?php echo $lay2['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                        <?php if($layer_3){?>
                                    	<select style="width:30%;" id="category_three" name="category_3">
                                          <?php foreach($layer_3 as $lay3){?>  
                                            <option value="<?php echo $lay3['category_code']?>" <?php if($shop_category['category_code']==$lay3['category_code']){echo "selected='selected'";}?>><?php echo $lay3['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                        <?php echo $form->error($shop_category,'category_code'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '排序')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="sort" placeholder="<?php echo yii::t('vcos', '排序')?>" class="col-xs-10 col-sm-8 col-md-8" name="sort" maxlength="10" value="<?php echo $shop_category['sort_order']?>" />
                                        <?php echo $form->error($shop_category,'sort_order'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <input type="hidden" value="" id="judge" name="judge">
                                <input type="submit" value="提交" id="submit" class="btn btn-primary" style="margin-left: 45%"/>
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
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/moment.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/daterangepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
jQuery(function($){

    $("#edit").validate({
        rules: {
        	code:{required:true,stringCheckAll:true},
            name:{required:true,stringCheckAll:true},
            desc:{required:true,stringCheckAll:true},
            num:{required:true,isIntGtZero:true},
            price:{required:true,isFloatGtZero:true},
            mprice:{required:true,isFloatGtZero:true}
        }
    });

    /**查看该港口名是否已经存在**/
    $('form').submit(function(){
    	var a=1;
    	var date = $("#time").val();
    	if(date == ''){
        	alert("<?php echo Yii::t('vcos','请输入有效日期');?>");
        	a = 0;
        }
        date = date.split(' - ');
        if(date[0] == date[1]){
           //日期为同一天需判断结束时间不能大于开始时间
            var stime = $("#stime").val();
            var etime = $("#etime").val();
            if(stime > etime){
                alert("<?php echo Yii::t('vcos','请输入正确的结束时间');?>");
                a = 0;
            }
        }
       if(a == 0){
           return false;
       }
    });
    $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#time').daterangepicker({
        dateFormat:'yy-mm-dd'
    });

    $('#stime').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
	}).next().on(ace.click_event, function(){
	        $(this).prev().focus();
	});
	$('#etime').timepicker({
	        minuteStep: 1,
	        showSeconds: true,
	        showMeridian: false
	}).next().on(ace.click_event, function(){
	        $(this).prev().focus();
	});
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'edit'));
    ?>
    /**改变商品分类一级,获取二级**/
    $('#category_one').change(function(){
        var this_code = $(this).val();
        var str = '';
        var str_ch = '';
        <?php $path_url = Yii::app()->createUrl('Shop/GetCategoryChild');?>
        $.ajax({
            url:"<?php echo $path_url;?>",
            type:'get',
            data:'parent_code='+this_code,
         	dataType:'json',
        	success:function(data){
        		$.each(data,function(key){  
                   str += "<option value="+data[key]['category_code']+">"+data[key]['name']+"</option>"; 
                });
        		$("select[name='category_2']").html(str);
        		$.ajax({
                    url:"<?php echo $path_url;?>",
                    type:'get',
                    data:'parent_code='+data[0]['category_code'],
                 	dataType:'json',
                	success:function(data){
                		$.each(data,function(key){  
                           str_ch += "<option value="+data[key]['category_code']+">"+data[key]['name']+"</option>"; 
                        });
                		$("select[name='category_3']").html(str_ch);
                	}        
                });
        	}        
        });
    });

    /**改变商品分类一级,获取二级**/
    $('#category_two').change(function(){
        var this_code = $(this).val();
        var str = '';
        <?php $path_url = Yii::app()->createUrl('Shop/GetCategoryChild');?>
        $.ajax({
            url:"<?php echo $path_url;?>",
            type:'get',
            data:'parent_code='+this_code,
         	dataType:'json',
        	success:function(data){
        		$.each(data,function(key){  
                   str += "<option value="+data[key]['category_code']+">"+data[key]['name']+"</option>"; 
                });
        		$("select[name='category_3']").html(str);
        	}      
        });
    });
});
</script>

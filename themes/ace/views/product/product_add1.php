<?php
    $this->pageTitle = Yii::t('vcos','添加商品');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'product_add';
?>
<link rel="stylesheet"  href="<?php echo $theme_url; ?>/assets/css/daterangepicker.css" />  
<link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/bootstrap-timepicker.css" />           
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
                            <?php echo yii::t('vcos', '商品管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '添加商品')?>
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
                                    'id'=>'add',
                                    'enctype'=>'multipart/form-data',
                                ),
                            ));  
                            ?> 
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品编码')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="code" placeholder="<?php echo yii::t('vcos', '商品编码')?>" class="col-xs-10 col-sm-8 col-md-8" name="code" maxlength="32" />
                                        <?php echo $form->error($product,'product_code'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品名')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="name" placeholder="<?php echo yii::t('vcos', '商品名')?>" class="col-xs-10 col-sm-8 col-md-8" name="name" maxlength="42" />
                                        <?php echo $form->error($product,'product_name'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '产地')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="origin" placeholder="<?php echo yii::t('vcos', '产地')?>" class="col-xs-10 col-sm-8 col-md-8" name="origin" maxlength="30" />
                                        <?php echo $form->error($product,'origin'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品描述')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<textarea id="desc" style=" overflow:auto; width: 66.6666%;height: 60px;resize: none;" placeholder="<?php echo yii::t('vcos', '描述')?>" name="desc" maxlength=80></textarea>
                                        <?php echo $form->error($product,'product_desc'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品库存')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<input type="text" id="num" placeholder="<?php echo yii::t('vcos', '商品库存')?>" class="col-xs-10 col-sm-8 col-md-8" name="num" maxlength="10" />
                                        <?php echo $form->error($product,'inventory_num'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品销售价')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<input type="text" id="price" placeholder="<?php echo yii::t('vcos', '商品销售价')?>" class="col-xs-10 col-sm-8 col-md-8" name="price" maxlength="10" />
                                        <?php echo $form->error($product,'sale_price'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品原价')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<input type="text" id="mprice" placeholder="<?php echo yii::t('vcos', '商品原价')?>" class="col-xs-10 col-sm-8 col-md-8" name="mprice" maxlength="10" />
                                        <?php echo $form->error($product,'standard_price'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品分类')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<?php if($layer_1){?>
                                    	<select style="width:30%;" id="category_one" name="category_1">
                                          <?php foreach($layer_1 as $lay1){?>  
                                            <option value="<?php echo $lay1['category_code']?>"><?php echo $lay1['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                        <?php if($layer_2){?>
                                    	<select style="width:30%;" id="category_two" name="category_2">
                                          <?php foreach($layer_2 as $lay2){?>  
                                            <option value="<?php echo $lay2['category_code']?>"><?php echo $lay2['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                        <?php if($layer_3){?>
                                    	<select style="width:30%;" id="category_three" name="category_3">
                                          <?php foreach($layer_3 as $lay3){?>  
                                            <option value="<?php echo $lay3['category_code']?>"><?php echo $lay3['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                        <?php echo $form->error($product,'category_code'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品店铺')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="shop">
                                            <option value="0">自营产品</option>
                                            <?php foreach($shop as $row){?>
                                            <option value="<?php echo $row['shop_id']?>" <?php if($product['shop_id']==$row['shop_id']){echo "selected='selected'";}?>><?php echo $row['shop_title']?></option>
                                            <?php }?>
                                        </select>
                                        <?php echo $form->error($product,'shop_id'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品品牌')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="brand">
                                    		<?php foreach($brand as $row){?>
                                            <option value="<?php echo $row['brand_id'];?>"><?php echo $row['brand_cn_name']?></option>
                                            <?php }?>
                                        </select>
                                        <?php echo $form->error($product,'brand_id'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '有效日期')?>：</label>
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="icon-calendar bigger-110"></i>
                                                </span>
                                                <input class="form-control" type="text" name="time" id="time" data-rel="tooltip" title="开始时间为当天00:00:00,结束时间为当天23:59:59" data-placement="bottom"/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo $form->error($product,'sale_start_time'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '开始时间')?>：</label>
                                    <div class="col-xs-5 col-sm-5 col-md-5 input-group bootstrap-timepicker">
                                        <input id="stime" name="stime" type="text" class="form-control col-xs-8 col-sm-8 col-md-8" maxlength="100" placeholder="<?php echo yii::t('vcos', '开始时间')?>"/>
                                        <span class="input-group-addon">
                                            <i class="icon-time bigger-110"></i>
                                        </span>
                                    </div>
                                    <?php echo $form->error($product,'sale_start_time'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '结束时间')?>：</label>
                                    <div class="col-xs-5 col-sm-5 col-md-5 input-group bootstrap-timepicker">
                                        <input id="etime" name="etime" type="text" class="form-control col-xs-6 col-sm-6 col-md-6" maxlength="100" placeholder="<?php echo yii::t('vcos', '结束时间')?>"/>
                                        <span class="input-group-addon">
                                            <i class="icon-time bigger-110"></i>
                                        </span>
                                    </div>
                                    <?php echo $form->error($product,'sale_end_time'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="file" name="photo" id="photo"/>
                                        <font style="color: red; display: none"><?php echo yii::t('vcos', '请上传图片')?></font>
                                        <?php echo $form->error($product,'product_img'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" checked="checked" class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
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
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/moment.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/daterangepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'add'));
    ?>
    
    
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
    
    $("#add").validate({
        rules: {
            code:{required:true,stringCheckAll:true},
            name:{required:true,stringCheckAll:true},
            origin:{required:true,stringCheckAll:true},
            desc:{required:true,stringCheckAll:true},
            num:{required:true,isIntGtZero:true},
            price:{required:true,isFloatGtZero:true},
            mprice:{required:true,isFloatGtZero:true},
            photo:{required:true}
            
        }
    });

    /**改变商品分类一级,获取二级**/
    $('#category_one').change(function(){
        var this_code = $(this).val();
        var str = '';
        var str_ch = '';
        <?php $path_url = Yii::app()->createUrl('Product/GetCategoryChild');?>
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
        <?php $path_url = Yii::app()->createUrl('Product/GetCategoryChild');?>
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
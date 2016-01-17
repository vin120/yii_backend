<?php
    $this->pageTitle = Yii::t('vcos','编辑商品图文');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'product_graphic_add';
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
                            <?php echo yii::t('vcos', '商品管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑商品图文')?>
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
                                <div class="form-group product_sel">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<?php if($layer_1){?>
                                    	<select style="width:20%;" id="category_one" name="category_1">
                                          <?php foreach($layer_1 as $lay1){?>  
                                            <option value="<?php echo $lay1['category_code']?>" <?php if($layer_cat==$lay1['category_code']){echo "selected='selected'";}?>><?php echo $lay1['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                        <?php if($layer_2){?>
                                    	<select style="width:20%;" id="category_two" name="category_2">
                                          <?php foreach($layer_2 as $lay2){?>  
                                            <option value="<?php echo $lay2['category_code']?>" <?php if($layer_cat2==$lay2['category_code']){echo "selected='selected'";}?>><?php echo $lay2['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                        <?php if($layer_3){?>
                                    	<select style="width:20%;" id="category_three" name="category_3">
                                          <?php foreach($layer_3 as $lay3){?>  
                                            <option value="<?php echo $lay3['category_code']?>" <?php if($category_code==$lay3['category_code']){echo "selected='selected'";}?>><?php echo $lay3['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                    	<select style="width:35%;" id="form-field-select-1" name="product">
                                    		<?php foreach($product as $row){?>
                                            <option value="<?php echo $row['product_id'];?>" <?php if($product_graphic['product_id']==$row['product_id']){echo "selected='selected'";}?>><?php echo $row['product_name']?></option>
                                            <?php }?>
                                        </select>
                                        <?php echo $form->error($product_graphic,'product_id'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '描述')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<textarea id="desc" style=" overflow:auto; width: 66.6666%;height: 60px;resize: none;" placeholder="<?php echo yii::t('vcos', '描述')?>" name="desc" maxlength=80><?php echo $product_graphic['graphic_desc']?></textarea>
                                        <?php echo $form->error($product_graphic,'graphic_desc'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '排序')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="sort" placeholder="<?php echo yii::t('vcos', '排序')?>" class="col-xs-10 col-sm-8 col-md-8" name="sort" maxlength="10" value="<?php echo $product_graphic['sort_order'];?>" />
                                        <?php echo $form->error($product_graphic,'sort_order'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <img src="<?php echo Yii::app()->params['imgurl'].$product_graphic['img_url'];?>" class="col-xs-3 col-sm-3 col-md-3" title="<?php echo yii::t('vcos', '原图片')?>" />
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <input type="file" name="photo" id="photo"/>
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
	<?php
	        $this->widget('UploadjsWidget',array('form_id'=>'edit'));
	    ?>
    $("#edit").validate({
        rules: {
        	sort:{required:true,isIntGtZero:true},
        	product:{required:true, digits:true},
        	//desc:{required:true,stringCheckAll:true}
            //photo:"required"
        }
    });
    /**改变商品分类一级,获取二级**/
    $('#category_one').change(function(){
        var this_code = $(this).val();
        var str = '';
        var str_ch = '';
        var str_pr = '';
        <?php $path_url = Yii::app()->createUrl('Activity/GetCategoryChild');?>
        <?php $path_url_product = Yii::app()->createUrl('Activity/GetCategoryProduct');?>
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
                		$.ajax({
                         url:"<?php echo $path_url_product;?>",
                         type:'get',
                         data:'parent_code='+data[0]['category_code'],
                      	dataType:'json',
                     	success:function(data){
                     		$.each(data,function(key){  
                                str_pr += "<option value="+data[key]['product_id']+">"+data[key]['product_name']+"</option>"; 
                             });
                     		$("select[name='product']").html(str_pr);
                     	}        
                  });
                	}        
             });
        	}        
        });
    });

    /**改变商品分类二级,获取三级**/
    $('#category_two').change(function(){
        var this_code = $(this).val();
        var str = '';
        var str_pr = '';
        <?php $path_url = Yii::app()->createUrl('Activity/GetCategoryChild');?>
        <?php $path_url_product = Yii::app()->createUrl('Activity/GetCategoryProduct');?>
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
        		$.ajax({
                 url:"<?php echo $path_url_product;?>",
                 type:'get',
                 data:'parent_code='+data[0]['category_code'],
              	dataType:'json',
             	success:function(data){
             		$.each(data,function(key){  
                        str_pr += "<option value="+data[key]['product_id']+">"+data[key]['product_name']+"</option>"; 
                     });
             		$("select[name='product']").html(str_pr);
             	}        
          });
        	}      
        });
    });

    /**改变商品分类三级,获取商品**/
    $('#category_three').change(function(){
        var this_code = $(this).val();
        var str_pr = '';
        <?php $path_url_product = Yii::app()->createUrl('Activity/GetCategoryProduct');?>
        $.ajax({
            url:"<?php echo $path_url_product;?>",
            type:'get',
            data:'parent_code='+this_code,
 	        dataType:'json',
 	       	success:function(data){
 	       		$.each(data,function(key){  
 	       			str_pr += "<option value="+data[key]['product_id']+">"+data[key]['product_name']+"</option>"; 
 	               });
 	       		$("select[name='product']").html(str_pr);
 	       		
 	       	}      
        });
    });

});
</script>

<?php
    $this->pageTitle = Yii::t('vcos','店铺资质');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'shop_operation_add';
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
                                    <?php echo yii::t('vcos', '店铺资质')?>
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
                            <style>
                            	.category_div {margin-top:20px;}
                            	.category_div > ul{list-style:none;width:25%;border:1px solid #ccc;float:left;margin-right:10px;min-height:450px;}
                            	.category_div > ul .op{float:right;}
                            	.category_div > ul li{padding-left:8px;cursor:pointer;color:#696969;}
                            	.category_div > ul li .text{width:93%;display:inline-block;}
                            	.category_div  .input_op{margin-right:2px;}
                            	.category_div .color {background:#B0E0E6;color:blue;}
                            	
                            </style>
                             <label>请选择店铺：</label>
                             <select name='shop'>
                             	<?php foreach($shop as $row){?>
                             	<option value="<?php echo $row['shop_id']?>"><?php echo $row['shop_title']?></option>
                             	<?php }?>
                             </select>
                             
                             <div class="category_div">
                             	<ul class="cat1_ul">
                             	<?php foreach($cat1_sel as $row){?>
                             	<li class="<?php if($row['category_code']==$cat1_but){echo 'color';}?>"><input class="input_op" type="checkbox" name="code[]" value="<?php echo $row['category_code']?>" /><span class="text"><?php echo $row['name']?><span class="op">〉</span></span></li>
                             	<?php }?>
                             	</ul>
                             	
                             	<ul class="cat2_ul">
                             	<?php foreach($cat2_sel as $row){?>
                             	<li parent="<?php echo $row['parent_cid']?>" class="<?php if($row['category_code']==$cat2_but){echo 'color ';} if($row['parent_cid']!=$cat1_sel[0]['category_code']){echo "hidden";}?>"><input class="input_op" type="checkbox" name="code[]" value="<?php echo $row['category_code']?>" /><span class="text"><?php echo $row['name']?><span class="op">〉</span></span></li>
                             	<?php }?>
                             	</ul>
                             	
                             	<ul class="cat3_ul">
                             	<?php foreach($cat3_sel as $row){?>
                             	<li parent="<?php echo $row['parent_cid']?>" class="<?php if($row['parent_cid']!=$cat2_sel[0]['category_code']){echo "hidden";}?>"><input class="input_op" type="checkbox" name="code[]" value="<?php echo $row['category_code']?>" /><span class="text"><?php echo $row['name']?></span></li>
                             	<?php }?>
                             	</ul>
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
<script type="text/javascript">
jQuery(function($){
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'add'));
    ?>
   

    //$(document).on('click','.show_click',function(e){
    /*
    $(".category_div li").hover(function(){
        $(this).css('background','#B0E0E6');//#99BBFF
        $(this).css('color','blue');
    },function(){
    	$(this).css('background','#fff');	
    	$(this).css('color','#696969');
    });*/
    /**选择一级分类**/
    $(document).on('click',"ul[class='cat1_ul']>li>.text",function(e){
        var this_code = $(this).parent().find('input').val();
        $("ul.cat1_ul").find(".color").removeClass('color');
        $(this).parent().addClass('color');
        $("ul.cat2_ul>li").addClass('hidden');
        $("ul.cat2_ul>li").removeClass('color');
        $("ul.cat2_ul").find("li[parent='"+this_code+"']").removeClass('hidden');
        $("ul.cat2_ul").find("li[parent='"+this_code+"']:first").addClass('color');
        var cat2_code = $("ul.cat2_ul").find("li[parent='"+this_code+"']:first").find("input").val();
        $("ul.cat3_ul>li").addClass('hidden');
        $("ul.cat3_ul").find("li[parent='"+cat2_code+"']").removeClass('hidden');
    });
	/**选择二级分类**/
    $(document).on('click',"ul[class='cat2_ul']>li>.text",function(e){
        var this_code = $(this).parent().find('input').val();
        $("ul.cat2_ul").find(".color").removeClass('color');
        $(this).parent().addClass('color');
        $("ul.cat3_ul>li").addClass('hidden');
        $("ul.cat3_ul").find("li[parent='"+this_code+"']").removeClass('hidden');
    });

    /**一级复选框选择**/
	$(document).on('click',"ul[class='cat1_ul']>li>input",function(e){
		var this_code = $(this).val();			//获取当前选中code
		var checked = $(this).is(':checked');	//查看用户是选中还是取消选中
		if(checked){
			//选中，将子类一起全部选择
			$("ul[class='cat2_ul']>li[parent='"+this_code+"']>input").prop('checked','checked');
			$('ul.cat2_ul>li>input:checked').each(function(){
				$("ul[class='cat3_ul']>li[parent='"+$(this).val()+"']>input").prop('checked','checked');
			}); 
		}else{
			//取消选中，取消子类全部选择
			$('ul.cat2_ul>li>input:checked').each(function(){
				$("ul[class='cat3_ul']>li[parent='"+$(this).val()+"']>input").removeAttr('checked','checked');
			});
			$("ul[class='cat2_ul']>li[parent='"+this_code+"']>input").removeAttr('checked','checked');
		}
	});

	/**二级复选框选择**/
	$(document).on('click',"ul[class='cat2_ul']>li>input",function(e){
		var this_code = $(this).val();			//获取当前选中code
		var checked = $(this).is(':checked');	//查看用户是选中还是取消选中
		var this_parent = $(this).parent().attr('parent');	//获取父类code
		var level_2count = $("ul[class='cat2_ul']>li[parent='"+this_parent+"']>input").length;	//获取点击分类父级分类共几个子类
		var level_2count_checked = $("ul[class='cat2_ul']>li[parent='"+this_parent+"']>input:checked").length; //获取点击分类父级分类的子类共选中几个
		
		if(checked){
			//选中，将子类一起全部选择，若选中了全部父级应选中
			$("ul[class='cat3_ul']>li[parent='"+this_code+"']>input").prop('checked','checked');
			if(level_2count == level_2count_checked){
				$("ul[class='cat1_ul']>li").find("input[value='"+this_parent+"']").prop('checked','checked');
			}
		}else{
			//取消选中，取消子类全部选择,并把一级取消选中
			$("ul[class='cat3_ul']>li[parent='"+this_code+"']>input").removeAttr('checked','checked');
			$("ul[class='cat1_ul']>li").find("input[value='"+this_parent+"']").removeAttr('checked','checked');
		}
	});

	/**三级复选框选择**/
	$(document).on('click',"ul[class='cat3_ul']>li>input",function(e){
		var this_code = $(this).val();			//获取当前选中code
		var checked = $(this).is(':checked');	//查看用户是选中还是取消选中
		var this_parent = $(this).parent().attr('parent');	
		var level_3count = $("ul[class='cat3_ul']>li[parent='"+this_parent+"']>input").length;	//获取点击分类父级分类共几个子类
		var level_3count_checked = $("ul[class='cat3_ul']>li[parent='"+this_parent+"']>input:checked").length; //获取点击分类父级分类的子类共选中几个
		
		if(checked){
			//选中，将子类一起全部选择
			//$("ul[class='cat3_ul']>li[parent='"+this_code+"']>input").prop('checked','checked');
			if(level_3count == level_3count_checked){
				$("ul[class='cat2_ul']>li").find("input[value='"+this_parent+"']").prop('checked','checked');
				var parent_code = $("ul[class='cat2_ul']>li").find("input[value='"+this_parent+"']").parent().attr('parent');
				var level_2count = $("ul[class='cat2_ul']>li[parent='"+parent_code+"']>input").length;	//获取点击分类父级分类共几个子类
				var level_2count_checked = $("ul[class='cat2_ul']>li[parent='"+parent_code+"']>input:checked").length; //获取点击分类父级分类的子类共选中几个
				if(level_2count == level_2count_checked){
					$("ul[class='cat1_ul']>li").find("input[value='"+parent_code+"']").prop('checked','checked');
				}
			}
		}else{
			//取消选中，取消子类全部选择,并把一级取消选中
			$("ul[class='cat2_ul']>li").find("input[value='"+this_parent+"']").removeAttr('checked','checked');
			var level_1_code = $("ul[class='cat2_ul']>li").find("input[value='"+this_parent+"']").parent().attr('parent');
			$("ul[class='cat1_ul']>li").find("input[value='"+level_1_code+"']").removeAttr('checked','checked');
		}
	});

	$('form').submit(function(){
        var msg = checkShop();
	    if(msg == 0){
		    alert('店铺已存在资质,请更换店铺!');
	       return false;
	    }
    });

});

function checkShop(){
    flag = 1;
    $shop = $("select[name='shop']").val();
	$url = "<?php echo Yii::app()->createUrl("Shop/CheckShopExites")?>";
	$.ajax({
		type:'post',
		data:'shop='+$shop,
		url:$url,
		async: false,
		success:function(data){
		    if(data == 1){
				flag =  1;
		    }else{
				flag =  0;
			}
		}
	});
	return flag;
}
</script>
<?php
    $this->pageTitle = Yii::t('vcos','添加商品');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'product_add_category_add';
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
                                    <?php echo yii::t('vcos', '添加商品')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <form id="add" action="<?php echo Yii::app()->createUrl('Product/product_add')?>" method="get">
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
                             	<?php foreach($shop_sel as $row){?>
                             	<option value="<?php echo $row['shop_id']?>"><?php echo $row['shop_title']?></option>
                             	<?php }?>
                             </select>
                             <div class="category_div">
                             	<ul class="cat1_ul">
                             	<?php foreach($cat1_sel as $row){?>
                             	<li val="<?php echo $row['category_code'];?>" class="<?php if($row['category_code']==$cat1_but){echo 'color';}?>"><?php echo $row['name']?><span class="op">〉</span></li>
                             	<?php }?>
                             	</ul>
                             	
                             	<ul class="cat2_ul">
                             	<?php foreach($cat2_sel as $row){?>
                             	<li val="<?php echo $row['category_code'];?>" parent="<?php echo $row['parent_catogory_code']?>" class="<?php if($row['category_code']==$cat2_but){echo 'color ';} if($row['parent_catogory_code']!=$cat1_sel[0]['category_code']){echo "hidden";}?>"><?php echo $row['name']?><span class="op">〉</span></li>
                             	<?php }?>
                             	</ul>
                             	
                             	<ul class="cat3_ul">
                             	<?php foreach($cat3_sel as $row){?>
                             	<li val="<?php echo $row['category_code'];?>" parent="<?php echo $row['parent_catogory_code']?>" class="<?php if($row['category_code']==$cat3_but){echo 'color ';} if($row['parent_catogory_code']!=$cat2_sel[0]['category_code']){echo "hidden";}?>"><?php echo $row['name']?></li>
                             	<?php }?>
                             	</ul>
                              </div>
                             
                                <input type="hidden" name="category" value="<?php echo $cat3_but;?>"/>
                                <div class="space-4"></div>
                                <input type="submit" value="<?php echo yii::t('vcos', '下一步，填写详细信息')?>" id="submit" class="btn btn-primary" style="margin-left: 45%"/>
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
<script src="<?php echo $theme_url; ?>/assets/js/uncompressed/additional-methods.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'add'));
    ?>
   
	/**改变店铺，资质改变**/
	$("select[name='shop']").change(function(){
		var this_id = $(this).val();
		<?php $path_url = Yii::app()->createUrl('Product/GetOperationCategory');?>
        $.ajax({
            url:"<?php echo $path_url;?>",
            type:'get',
            data:'shop_id='+this_id,
         	dataType:'json',
        	success:function(data){
            	var $str = '';
            	var $str2 = '';
            	var  $str3 = '';
            	if(data != 0){
        		$.each(data[0],function(key){ 
        			if(data[0][key]['category_code']==data[3]){color = 'color ';}else{color = '';}
        			$str += "<li val='"+data[0][key]['category_code']+"' class='"+color+"'>"+data[0][key]['name']+"<span class='op'>〉</span></li>";
        		});
        		$("ul.cat1_ul").html($str);
        		$.each(data[1],function(key){ 
        			if(data[1][key]['category_code']==data[4]){color = 'color ';}else{color = '';}
        			if(data[1][key]['parent_catogory_code']!=data[0][0]['category_code']){hid = 'hidden ';}else{hid = '';}
        			$str2 += "<li val='"+data[1][key]['category_code']+"' parent='"+data[1][key]['parent_catogory_code']+"' class='"+color+" "+hid+"'>"+data[1][key]['name']+"<span class='op'>〉</span></li>";
        		});
        		$("ul.cat2_ul").html($str2);
        		$.each(data[2],function(key){ 
        			if(data[2][key]['category_code']==data[5]){color = 'color ';}else{color = '';}
        			if(data[2][key]['parent_catogory_code']!=data[1][0]['category_code']){hid = 'hidden ';}else{hid = '';}
        			$str3 += "<li val='"+data[2][key]['category_code']+"' parent='"+data[2][key]['parent_catogory_code']+"' class='"+color+" "+hid+"'>"+data[2][key]['name']+"</li>";
        		});
        		$("ul.cat3_ul").html($str3);
            	}else{
            		$("ul.cat1_ul").html('');
            		$("ul.cat2_ul").html('');
            		$("ul.cat3_ul").html('');
                }
        	}      
        });
	});
    /**选择一级分类**/
    $(document).on('click',"ul[class='cat1_ul']>li",function(e){
        var this_code = $(this).attr('val');
        $("ul.cat1_ul").find(".color").removeClass('color');
        $(this).addClass('color');
        $("ul.cat2_ul>li").addClass('hidden');
        $("ul.cat2_ul>li").removeClass('color');
        $("ul.cat2_ul").find("li[parent='"+this_code+"']").removeClass('hidden');
        $("ul.cat2_ul").find("li[parent='"+this_code+"']:first").addClass('color');
        var cat2_code = $("ul.cat2_ul").find("li[parent='"+this_code+"']:first").attr('val');
        $("ul.cat3_ul>li").addClass('hidden');
        $("ul.cat3_ul").find("li[parent='"+cat2_code+"']").removeClass('hidden');
        $("ul.cat3_ul>li").removeClass('color');
        $("ul.cat3_ul").find("li[parent='"+cat2_code+"']:first").addClass('color');
        var code = $("ul.cat3_ul").find("li[parent='"+cat2_code+"']:first").attr('val');
        $("input[name='category']").val(code);
    });
	/**选择二级分类**/
    $(document).on('click',"ul[class='cat2_ul']>li",function(e){
        var this_code = $(this).attr('val');
        $("ul.cat2_ul").find(".color").removeClass('color');
        $(this).addClass('color');
        $("ul.cat3_ul>li").addClass('hidden');
        $("ul.cat3_ul").find("li[parent='"+this_code+"']").removeClass('hidden');
        $("ul.cat3_ul>li").removeClass('color');
        $("ul.cat3_ul").find("li[parent='"+this_code+"']:first").addClass('color');
        var code = $("ul.cat3_ul").find("li[parent='"+this_code+"']:first").attr('val');
        $("input[name='category']").val(code);
    });

    /**选择三级分类**/
    $(document).on('click',"ul[class='cat3_ul']>li",function(e){
        var this_code = $(this).attr('val');
        $("ul.cat3_ul").find(".color").removeClass('color');
        $(this).addClass('color');
        $("input[name='category']").val(this_code);
    });


	$('form').submit(function(){
        var msg = $("input[name='category']").val();
	    if(msg == ''){
		    alert('请选择三级分类!');
	       return false;
	    }
    });

});

</script>
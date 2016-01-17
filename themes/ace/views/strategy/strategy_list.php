<?php
    $this->pageTitle = Yii::t('vcos','攻略管理');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'strategy_list';
    
?>
<?php 
    //navbar 挂件
    $this->widget('navbarWidget');
    if(in_array('201', $auth) || $auth[0] == '0'){
        $canadd = TRUE;
    }  else {
        $canadd = False;
    }
    if(in_array('203', $auth) || $auth[0] == '0'){
        $canedit = TRUE;
    }  else {
        $canedit = False;
    }
    if(in_array('205', $auth) || $auth[0] == '0'){
        $candelete = TRUE;
    }  else {
        $candelete = FALSE;
    }
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
                                <?php echo yii::t('vcos', '邮轮攻略管理')?>
                                <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '攻略管理')?>
                                </small>
                            </h1>
                        </div><!-- /.page-header -->
                            <div class="row">
                                <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
                                    <div class="row">
                                        <div class="col-xs-12">
                                        <style>
                                        .list_select_option{margin-bottom:10px;}
                                        .city_sel{margin-left:20px;width:250px;}
                                        </style>
                                            <div class="table-responsive">
                                             	<div class="list_select_option">
                                             	  <label><?php echo yii::t('vcos', '请选择城市')?>:</label>
                                             	  <select class='city_sel' name='city_all_sel'>
                                             	  <?php
                                             	   $path_url_first = Yii::app()->createUrl('Strategy/strategy_list',array('res'=> $res,'city'=> 0,'category'=>$category_but));
                                             	  ?>
                                             	  	<option value="<?php echo $path_url_first;?>" <?php if($res_but == 0){echo 'selected';}?>><?php echo yii::t('vcos', '全部')?></option>
                                             	  <?php
                                             	  if($city_sel != ''){
                                             	  foreach($city_sel as $row){
                                             	  	$path_url = Yii::app()->createUrl('Strategy/strategy_list',array('res'=> $res,'city'=> $row['city_id'],'category'=>$category_but));
                                             	  ?>
                                             	  	<option value="<?php echo $path_url;?>" <?php if($row['city_id'] == $res_but){echo 'selected';}?>><?php echo $row['city_name']?></option>
                                             	  <?php }}?>
                                             	  </select>
                                             	  
                                             	  <label><?php echo yii::t('vcos', '请选择分类')?>:</label>
                                             	  <select class='city_sel' name='category_all_sel'>
                                             	  <?php
                                             	  $path_life_url_first = Yii::app()->createUrl('Strategy/strategy_list',array('res'=> $res,'city'=>$res_but,'category'=> 0));
                                             	  ?>
                                             	  	<option value="<?php echo $path_life_url_first;?>" <?php if($category_but == 0){echo 'selected';}?>><?php echo yii::t('vcos', '全部')?></option>
                                             	    <?php
                                             	    if($category_sel != ''){
                                             	    foreach($category_sel as $str){
                                             	  	$path_life_url = Yii::app()->createUrl('Strategy/strategy_list',array('res'=> $res,'city'=>$res_but,'category'=> $str['strategy_category_id']));
                                             	  ?>
                                             	  	<option value="<?php echo $path_life_url;?>" <?php if($str['strategy_category_id'] == $category_but){echo 'selected';}?>><?php echo $str['category_name']?></option>
                                             	  <?php }}?>
                                             	  </select>
                                             	  
                                             	  <label><?php echo yii::t('vcos', '请选择语言')?>:</label>
                                             	  <select class='city_sel' name='lang_all_sel'>
                                             	  <?php $path_url_all = Yii::app()->createUrl('Strategy/strategy_list',array('res'=> 'all','city'=>$res_but,'category'=>$category_but));?>
                                             	  	<option value="<?php echo $path_url_all;?>" <?php if($res == 'all'){echo "selected='selected'";}?>><?php echo yii::t('vcos', '全部')?></option>
                                             	  <?php $path_url_zh = Yii::app()->createUrl('Strategy/strategy_list',array('res'=> 'zh_cn','city'=>$res_but,'category'=>$category_but));?>
                                             	  	<option value="<?php echo $path_url_zh;?>" <?php if($res == 'zh_cn'){echo "selected='selected'";}?>><?php echo yii::t('vcos', '中文')?></option>
                                             	  <?php $path_url_en = Yii::app()->createUrl('Strategy/strategy_list',array('res'=> 'en','city'=>$res_but,'category'=>$category_but));?>
                                             	  	<option value="<?php echo $path_url_en;?>" <?php if($res == 'en'){echo "selected='selected'";}?>><?php echo yii::t('vcos', '英文')?></option>
                                             	  </select>
                                             	</div>
                                                <form method="post" name="del">
                                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo yii::t('vcos', '序号')?></th>
                                                            <th><?php echo yii::t('vcos', '所属城市')?></th>
                                                            <th><?php echo yii::t('vcos', '所属分类')?></th>
                                                            <th><?php echo yii::t('vcos', '攻略名')?></th>
                                                            <th><?php echo yii::t('vcos', '描述')?></th>
                                                            <th><?php echo yii::t('vcos', '人均价格')?></th>
                                                            <th><?php echo yii::t('vcos', '地址')?></th>
                                                            <th><?php echo yii::t('vcos', '类别')?></th>
                                                            <th><?php echo yii::t('vcos', '状态')?></th>
                                                            <th><?php echo yii::t('vcos', '操作')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($strategy as $key=>$row) { ?>
                                                        <tr>
                                                            <td><?php echo ++$key;?></td>
                                                            <td><?php echo $row['city_name']?></td>
                                                            <td><?php echo $row['category_name'];?></td>
                                                            <td><?php echo $row['strategy_name'];?></td>
                                                            <td><?php echo Helper::truncate_utf8_string($row['strategy_describe'], 10);?></td>
                                                            <td><?php echo $row['avg_price']/100;?></td>
                                                            <td><?php echo $row['address']?></td>
                                                            <td><?php echo $row['strategy_type']?></td>
                                                            <td><?php echo $row['strategy_state']?yii::t('vcos', '启用'):yii::t('vcos', '禁用');?></td>
                                                            <td>
                                                                <?php
                                                                    //操作挂件
                                                                    $this->widget('ManipulateWidget',array(
                                                                        'ControllerName'=>'Strategy',
                                                                        'MethodName'=>'strategy_edit',
                                                                        'id'=>$row['strategy_id'],
                                                                        'canedit'=>$canedit,
                                                                        'candelete'=>$candelete,
                                                                    ));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                                </form>
                                                <div class="center">
                                                    <?php
                                                        //底部操作挂件
                                                        $this->widget('BotWidget',array(
                                                            'ControllerName'=>'Strategy',
                                                            'MethodName'=>'strategy_add',
                                                            'canadd'=>$canadd,
                                                        ));
                                                    ?>
                                                </div>
                                                <div class="center">
                                                    <?php
                                                    $this->widget('MyCLinkPager',array(
                                                        'pages'=>$pages,
                                                        'header'=>false,
                                                        'htmlOptions'=>array('class'=>'pagination'),
                                                        'firstPageLabel'=>yii::t('vcos', '首页'),
                                                        'lastPageLabel'=>yii::t('vcos', '尾页'),
                                                        'prevPageLabel'=>'«',
                                                        'nextPageLabel'=>'»',
                                                        'maxButtonCount'=>5,
                                                        'cssFile'=>false,
                                                        ));
                                                    ?>
                                                </div>
                                            </div><!-- /.table-responsive -->
                                        </div><!-- /span -->
                                    </div><!-- /row -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.page-content -->
                </div><!-- /.main-content -->
                <?php
                    //删除确认框
                    $this->widget('ConfirmWidget',array(
                        'div_id'=>'dialog-confirm',
                        'title_id'=>'dialog-confirm-content',
                        'title_content'=>yii::t('vcos', '这条记录将被永久删除，并且无法恢复。'),
                        'confirm_id'=>'confirm',
                    ));
                ?>
                <!-- /#ace-settings-container start-->
                <?php
                    //设置容器配置挂件
                    $this->widget('settingsContainerWidget');
                ?>
                <!-- /#ace-settings-container end-->
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.full.min.js"></script>
<script type="text/javascript">
jQuery(function($) {
    $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
    _title: function(title) {
        var $title = this.options.title || '&nbsp;'
        if( ("title_html" in this.options) && this.options.title_html == true )
            title.html($title);
        else title.text($title);
        }
    }));
    $( ".delete" ).on('click', function(e) {
        var $a = $(this).attr("id");
        e.preventDefault();
       
        $( "#dialog-confirm" ).removeClass('hide').dialog({
            closeOnEscape:false, 
            open:function(event,ui){$(".ui-dialog-titlebar-close").hide();} ,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '删除这条记录？')?></h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '删除？')?>",
                    "class" : "btn btn-danger btn-xs ",
                    "id" : "danger",
                    click: function() {
                        location.href="<?php echo Yii::app()->createUrl("Strategy/strategy_list");?>"+"?id="+$a;
                        $( this ).dialog( "close" );
                    }
                }
                ,
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '取消？')?>",
                    "class" : "btn btn-xs ",
                    click: function() {
                        $('.widget-header h4').html("<i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '删除这条记录？')?>");
                        $('#dialog-confirm-content').html("<?php echo yii::t('vcos', '这条记录将被永久删除，并且无法恢复。')?>");
                        $('#confirm').show();
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });
    });

    $(".list_select_option select[name='city_all_sel']").change(function(){
    	var path = $(this).val();
		window.location.href=path;
	});
    
    $(".list_select_option select[name='category_all_sel']").change(function(){
    	var path = $(this).val();
		window.location.href=path;
	});
    $(".list_select_option select[name='lang_all_sel']").change(function(){
    	var path = $(this).val();
		window.location.href=path;
	});
    
});
</script>

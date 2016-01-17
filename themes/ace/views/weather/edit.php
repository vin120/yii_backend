<?php
    $this->pageTitle = Yii::t('vcos','编辑天气预告');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'report_post';
?>
<link rel="stylesheet"  href="<?php echo $theme_url; ?>/assets/css/daterangepicker.css" />
<?php 
    //navbar 挂件
    $this->widget('navbarWidget');
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
                            <?php echo yii::t('vcos', '天气管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑天气预告')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <form class="form-horizontal" role="form" method="post" action="" id="edit" >
                            	<div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '添加外语')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="radio" check="<?php if($record['iso']=='zh_cn'){echo 'no';}else{echo 'yes';}?>" class="iso_choose" name="language" value="en" <?php if($record['iso']=='en'){echo "checked='checked'";}?>/>English
                                    </div>
                                </div>
                                <div class="space-4"></div>
                            	<div class="form-group <?php if($record['iso']=='en'){echo 'hidden';}?>  un_iso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '城市')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="city">
                                            <?php foreach ($city_sel as $row){
                                            	if($row['iso']=='zh_cn'){
                                            ?>
                                            <option value="<?php echo $row['city_id']?>" <?php if($record['city_id']==$row['city_id']){echo "selected='selected'";}?>><?php echo $row['city_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='zh_cn'){echo 'hidden';}?> iso iso_city">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '城市').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="citys" name="city_iso">
                                            <?php foreach ($city_sel as $row){
                                            	if($row['iso']=='en'){
                                            ?>
                                            <option value="<?php echo $row['city_id']?>" <?php if($record['city_id']==$row['city_id']){echo "selected='selected'";}?>><?php echo $row['city_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='en'){echo 'hidden';}?> un_iso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '天气名称')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="weather" name="weather">
                                            <?php foreach ($weather as $row){
                                            	if($row['iso']=='zh_cn'){
                                            ?>
                                            <option value="<?php echo $row['id'].'-'.$row['weather_name']?>" <?php if($record['weather_id']==$row['id']){echo 'selected';}?> ><?php echo yii::t('vcos', $row['weather_name']);?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='zh_cn'){echo 'hidden';}?> iso iso_weather">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '天气名称').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="weathers" name="weather_iso">
                                            <?php foreach ($weather as $row){
                                            	if($row['iso'] == 'en'){
                                            ?>
                                            <option value="<?php echo $row['id'].'-'.$row['weather_name']?>" <?php if($record['weather_id']==$row['id']){echo 'selected';}?> ><?php echo yii::t('vcos', $row['weather_name']);?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='en'){echo 'hidden';}?> un_iso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '显示时间')?>：</label>
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="icon-calendar bigger-110"></i>
                                                </span>
                                                <input class="form-control" type="text" name="time" id="time" value="<?php if($record['iso']=='zh_cn'){echo substr($record['record_start_time'],0,10).' - '.substr($record['record_end_time'],0,10);}?>" data-rel="tooltip" title="开始时间为当天00:00:00,结束时间为当天23:59:59" data-placement="bottom"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='zh_cn'){echo 'hidden';}?> iso iso_time">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '显示时间').yii::t('vcos','(外语)')?>：</label>
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="icon-calendar bigger-110"></i>
                                                </span>
                                                <input class="form-control" type="text" name="time_iso" id="times" value="<?php if($record['iso']=='en'){echo substr($record['record_start_time'],0,10).' - '.substr($record['record_end_time'],0,10);}?>" data-rel="tooltip" title="开始时间为当天00:00:00,结束时间为当天23:59:59" data-placement="bottom"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='en'){echo 'hidden';}?> un_iso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '风速')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="scale" name="scale">
                                            <?php foreach ($wind_scale as $row){
                                            	if($row['iso'] == 'zh_cn'){
                                            ?>
                                            <option value="<?php echo $row['wind_scale_name']?>" <?php if($row['wind_scale_name']==$record['wind_scale']){echo "selected='selected'";}?>><?php echo $row['wind_scale_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='zh_cn'){echo 'hidden';}?> iso iso_scale">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '风速').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="scales" name="scale_iso">
                                            <?php foreach ($wind_scale as $row){
                                            	if($row['iso']=='en'){
                                            ?>
                                            <option value="<?php echo $row['wind_scale_name']?>" <?php if($row['wind_scale_name']==$record['wind_scale']){echo "selected='selected'";}?>><?php echo $row['wind_scale_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='en'){echo 'hidden';}?> un_iso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '风向')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="direction" name="direction">
                                            <?php foreach ($wind_direction as $row){
                                            	if($row['iso']=='zh_cn'){
                                            ?>
                                            <option value="<?php echo $row['wind_direction_name']?>" <?php if($row['wind_direction_name']==$record['wind_direction']){echo "selected='selected'";}?>><?php echo  $row['wind_direction_name']?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='zh_cn'){echo 'hidden';}?> iso iso_direction">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '风向').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="directions" name="direction_iso">
                                            <?php foreach ($wind_direction as $row){
                                            	if($row['iso']=='en'){
                                            ?>
                                            <option value="<?php echo $row['wind_direction_name']?>" <?php if($row['wind_direction_name']==$record['wind_direction']){echo "selected='selected'";}?>><?php echo  $row['wind_direction_name']?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='en'){echo 'hidden';}?> un_iso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '最低温度')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="min_temp" type="text"  name="min_temp" value="<?php if($record['iso']=='zh_cn'){echo $record['record_temperature_min'];}?>" placeholder="<?php echo yii::t('vcos', '单位:摄氏度')?>" maxlength='80'/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group  <?php if($record['iso']=='zh_cn'){echo 'hidden';}?> iso iso_min_temp">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '最低温度').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="min_temps" type="text"  name="min_temp_iso" value="<?php if($record['iso']=='en'){echo $record['record_temperature_min'];};?>" placeholder="<?php echo yii::t('vcos', '单位:摄氏度')?>" maxlength='80'/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group <?php if($record['iso']=='en'){echo 'hidden';}?> un_iso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '最高温度')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="max_temp" type="text"  name="max_temp" value="<?php if($record['iso']=='zh_cn'){echo $record['record_temperature_max'];}?>" placeholder="<?php echo yii::t('vcos', '单位:摄氏度')?>" maxlength='80'/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group  <?php if($record['iso']=='zh_cn'){echo 'hidden';}?> iso iso_max_temp">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '最高温度').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="max_temps" type="text"  name="max_temp_iso" value="<?php if($record['iso']=='en'){echo $record['record_temperature_max'];}?>" placeholder="<?php echo yii::t('vcos', '单位:摄氏度')?>" maxlength='80'/>
                                    </div>
                                </div>
                                <input type="submit" value="<?php echo yii::t('vcos', '提交')?>" id="submit" class="btn btn-primary" style="margin-left: 45%"/>
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/moment.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/daterangepicker.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    $(".iso_choose").click(function(){
    	$check = $(this).attr('check');
        if($check == 'no'){
            $(this).attr('check','yes');
	        $(".iso").removeClass('hidden');
	        $(".un_iso").addClass('hidden');
	        $(".iso input:text").addClass('required');
	        $(".un_iso input:text").removeClass('required');
        }else if($check == 'yes'){
        	$(this).attr('check','no');
            $(this).removeAttr('checked');
            $(".iso").addClass('hidden');
            $(".un_iso").removeClass('hidden');
	        $(".iso input:text").removeClass('required');
        }
    });
    $("#edit").validate({
        rules: {
            time:"required",
            min_temp:{required:true,number:true,range:[-20,50]},
            max_temp:{required:true,number:true,range:[-20,50]},
            min_temp_iso:{required:true,number:true,range:[-20,50]},
            max_temp_iso:{required:true,number:true,range:[-20,50]}
        },
        messages:{
            time:"<?php echo yii::t('vcos', '请输入显示时间')?>",
            min_temp:{
                required: "<?php echo yii::t('vcos', '请输入当天最低温度')?>",
                number: "<?php echo yii::t('vcos', '这里只能输入数字,单位符号将自动添加')?>",
                range: "<?php echo yii::t('vcos', '请输入正确的温度')?>"
            },
            max_temp:{
                required: "<?php echo yii::t('vcos', '请输入当天最高温度')?>",
                number: "<?php echo yii::t('vcos', '这里只能输入数字,单位符号将自动添加')?>",
                range: "<?php echo yii::t('vcos', '请输入正确的温度')?>"
            },
            min_temp_iso:{
                required: "<?php echo yii::t('vcos', '请输入当天最低温度')?>",
                number: "<?php echo yii::t('vcos', '这里只能输入数字,单位符号将自动添加')?>",
                range: "<?php echo yii::t('vcos', '请输入正确的温度')?>"
            },
            max_temp_iso:{
                required: "<?php echo yii::t('vcos', '请输入当天最高温度')?>",
                number: "<?php echo yii::t('vcos', '这里只能输入数字,单位符号将自动添加')?>",
                range: "<?php echo yii::t('vcos', '请输入正确的温度')?>"
            }
            
        }
    });
    $('#max_temp').change(function(){
        if($('#min_temp').val()!=''){
            if($(this).val() < $('#min_temp').val()){
                alert("最高温度不能小于最低温度!");
                $('#submit').hide();
            }else{
                $('#submit').show();   
            }
        }
    });
    
    $('#min_temp').blur(function(){
       if($('#max_temp').val()!=''){
           if($(this).val() > $('#max_temp').val()){
                alert("最高温度不能小于最低温度!"); 
                $('#submit').hide();
           }
       } 
    });
    $('#max_temps').change(function(){
        if($('#min_temps').val()!=''){
            if($(this).val() < $('#min_temps').val()){
                alert("最高温度不能小于最低温度!");
                $('#submit').hide();
            }else{
                $('#submit').show();   
            }
        }
    });
    
    $('#min_temps').blur(function(){
       if($('#max_temps').val()!=''){
           if($(this).val() > $('#max_temps').val()){
                alert("最高温度不能小于最低温度!"); 
                $('#submit').hide();
           }
       } 
    });
    $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#id-date-range-picker-1').daterangepicker({
        dateFormat:'yy-mm-dd'
    });
    $('#time').daterangepicker({
        dateFormat:'yy-mm-dd'
    });
    $('#times').daterangepicker({
        dateFormat:'yy-mm-dd'
    });
});
</script>

<?php
    $this->pageTitle = Yii::t('vcos','编辑权限分组');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'role_add';
?>
<?php 
    //navbar 挂件
    $disable = 1;
    $this->widget('navbarWidget',array('disable'=>$disable));
?>
<link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace.css" />
<!DOCTYPE html>
<div class="main-container">
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
                        <?php echo yii::t('vcos', '权限管理')?>
                        <small>
                            <i class="icon-double-angle-right"></i>
                            <?php echo yii::t('vcos', '编辑权限分组')?>
                        </small>
                    </h1>
                </div><!-- /.page-header -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-11">
                        <form class="form-horizontal" role="form" method="post" action="" id="edit">
                        <div class="form-group">
                            <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分组名')?>：</label>
                            <div class="col-xs-8 col-sm-8 col-md-7">
                                <input type="hidden" id="role_id" name ="role_id" value="<?php echo $role['role_id'] ?>" />
                                <input type="text" id="role" placeholder="<?php echo yii::t('vcos', '分组名')?>" class="col-xs-10 col-sm-8 col-md-8" name="role" maxlength="80" value="<?php echo $role['role_name'] ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                            <label style="margin-left: 10px;">
                                <input id="id-button-borders" type="checkbox" <?php if($role['role_state']){echo 'checked="checked"';}?> class="ace ace-switch ace-switch-5" name="state" value="1" />
                                <span class="lbl"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分组说明')?>：</label>
                            <div class="col-xs-8 col-sm-8 col-md-7">
                                <input class="col-xs-10 col-sm-8 col-md-8" id="describe" type="text" name="describe" maxlength='80' placeholder="<?php echo yii::t('vcos', '分组说明')?>" value="<?php echo $role['role_desc'] ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分配权限')?>：</label>
                            <div class="widget-box transparent col-xs-8 col-sm-8 col-md-8">
                                <div class="widget-body">
                                    <div class="widget-main padding-8">
                                        <div id="treeview" class="tree"></div>
                                    </div>
                                    <input type="hidden" value="" id="hidden_parent" name="hidden_parent" />
                                    <input type="hidden" value="" id="hidden" name="hidden" />
                                </div>
                            </div>
                        </div>
                            <input type="hidden" value="<?php echo $id?>" name="edit_id2" />
                        <input type="submit" value="<?php echo yii::t('vcos', '提交')?>" id="submit" class="btn btn-primary" style="margin-left: 45%"/>      
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- basic scripts -->
<!--[if !IE]> -->
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery.js'>"+"<"+"/script>");
</script>
<!-- <![endif]-->
<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='../assets/js/jquery-1.10.2.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script src="<?php echo $theme_url; ?>/assets/js/bootstrap.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery.validate.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/uncompressed/additional-methods.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/fuelux/fuelux.tree.js"></script>
<!-- ace scripts -->
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.js"></script>
        
<script type="text/javascript">
$(function() {
    //construct the data source object to be used by tree
    var remoteUrl = 'menu_permission';
    var remoteDateSource = function(options, callback) {
        var parent_id = null
        if( !('text' in options || 'type' in options) ){
            parent_id = 0;//load first level data
        }
        else if('type' in options && options['type'] == 'folder') {//it has children
            if('additionalParameters' in options && 'children' in options.additionalParameters)
                parent_id = options.additionalParameters['id']
        }

        if(parent_id !== null) {
            $.ajax({
                url: remoteUrl,
                data: 'id='+parent_id+'&<?php echo 'role='.$role['permission_menu'];?>',
                type: 'POST',
                dataType: 'json',
                success : function(response) {
                    if(response.status == "OK"){
                        callback({ data: response.data });
                    }
                },
                error: function(response) {
                       // console.log(response);
                }
            })
        }
    }
    $('#treeview').ace_tree({
        dataSource: remoteDateSource ,
        multiSelect: true,
        loadingHTML: '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
        'open-icon' : 'ace-icon tree-minus',
        'close-icon' : 'ace-icon tree-plus',
        'selectable' : true,
        'selected-icon' : 'ace-icon fa fa-check',
        'unselected-icon' : 'ace-icon fa fa-times',
        cacheItems: true,
        folderSelect: true
    });
    //show selected items inside a modal
    $('#submit').on('click', function() {
        var output = '';
        var show = '';
        var items = $('#treeview').tree('selectedItems');
        var unitems = $('#treeview').tree('unselectItems');
        
        for(var i in items) if (items.hasOwnProperty(i)) {
            var item = items[i];
            output += item.additionalParameters['id'] + ",";
            show += item.additionalParameters['id'] + ":"+ item.text+"\n";
        }
        //output = output.substr(0,output.length-1);
        var unshow = '';

        /**获取打开过了分组父级id***/
        for(var j in unitems) /*if (!items.hasOwnProperty(j))*/ {
            var unitem = unitems[j];
            $.each(unitem,function(n,value) {   
                if(n == 'additionalParameters'){
                    unshow += value['id'] + ',';
                }  
            });
           
        }
        unshow = unshow.substr(0,unshow.length-1);
        //alert(output);
        //alert(show);
        //alert(unshow);
        //return false;
        $('#hidden').val(output);
        $('#hidden_parent').val(unshow);
        $('#modal-tree-items').modal('show');
        $('#tree-value').css({'width':'98%', 'height':'200px'}).val(show);
    });
    
    if(location.protocol == 'file:') alert("For retrieving data from server, you should access this page using a webserver.");
    
    $("#edit").validate({
        rules: {
            role: {
                required:true,
                stringCheckAll:true,
                remote: {
                    url: "checkroleajax", 
                    type: "post",
                    dataType: "json", 
                    data: {
                        role: function() {
                            return $("#role").val()+'|'+$("#role_id").val();
                        }
                    }
                }
            },
            describe: {required:true,stringCheckAll:true}
        },
        messages:{
            role:{
                required:"<?php echo yii::t('vcos', '请输入分组名')?>",
                remote:"<?php echo yii::t('vcos', '此分组名已被使用')?>"
            },
            describe:"<?php echo yii::t('vcos', '请正确输入分组描述')?>"
        }
    });
});
</script>
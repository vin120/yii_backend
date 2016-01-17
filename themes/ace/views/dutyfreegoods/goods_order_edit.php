<?php
    $this->pageTitle = Yii::t('vcos','编辑免税商城预定');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'goods_order_list';
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
                            <?php echo yii::t('vcos', '免税商城管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑免税商城预定')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <form class="form-horizontal" role="form" method="post" action="" id="edit" >
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '订单号').' : ';?></label>
                                    <label class="col-xs-8 col-sm-8 col-md-8 "><?php echo $detail['order_serial_num'];?></label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '预定人').' : ';?></label>
                                    <label class="col-xs-8 col-sm-8 col-md-8 "><?php echo $user['cn_name'];?></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '订单创建时间').' : ';?></label>
                                    <label class="col-xs-8 col-sm-8 col-md-8 "><?php echo $detail['order_create_time'];?></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '支付时间').' : ';?></label>
                                    <label class="col-xs-8 col-sm-8 col-md-8 "><?php echo $detail['pay_time'];?></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '订单备注')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <textarea rows="2" cols="50" id="remark" name="remark"><?php echo $detail['order_remark'];?></textarea>
                                    </div>
                                </div>
                                <?php if($sub_detail){?>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品清单').' : ';?></label>
                                    <div class="col-xs-10 col-sm-10 col-md-10">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><?php echo yii::t('vcos', '序号')?></th>
                                                    <th><?php echo yii::t('vcos', '商品名')?></th>
                                                    <th><?php echo yii::t('vcos', '商品数量')?></th>
                                                    <th><?php echo yii::t('vcos', '商品单价')?></th>
                                                    <th><?php echo yii::t('vcos', '商品图片')?></th>
                                                    <th><?php echo yii::t('vcos', '商品备注')?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $total_price = '';?>
                                                <?php foreach ($sub_detail as $key=>$row) { ?>
                                                <tr>
                                                    <td><?php echo ++$key;?></td>
                                                    <td><?php echo $row['goods_name'];?></td>
                                                    <td><?php echo $row['goods_num'];?></td>
                                                    <td><?php echo $row['goods_price']/100;?></td>
                                                    <?php 
                                                        $price = $row['goods_num']*$row['goods_price'];
                                                        $total_price = $total_price + $price;
                                                    ?>
                                                    <td><img src="<?php echo Yii::app()->params['imgurl'].$row['goods_img_url'];?>" width="50"/></td>
                                                    <td><?php echo $row['sub_goods_remark'];?></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th colspan="5" style="text-align: right"><?php echo yii::t('vcos', '总价格')?></th>
                                                    <td><?php echo $total_price/100;?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php }else{echo Yii::t('vcos', '系统错误，该订单清单无法正常显示，请确认是否有删除过该订单的商品！');}?>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-6 col-sm-6 col-md-6" name="state">
                                            <?php if($detail['order_state'] == '0'){?>
                                            <option value="0" <?php if($detail['order_state'] == '0'){echo 'selected';}?> ><?php echo yii::t('vcos', '已取消')?></option>
                                            <?php }else{?>
                                            <option value="1" <?php if($detail['order_state'] == '1'){echo 'selected';}?> ><?php echo yii::t('vcos', '处理中')?></option>
                                            <option value="2" <?php if($detail['order_state'] == '2'){echo 'selected';}?> ><?php echo yii::t('vcos', '送货中')?></option>
                                            <option value="3" <?php if($detail['order_state'] == '3'){echo 'selected';}?> ><?php echo yii::t('vcos', '交易失败，暂无库存')?></option>
                                            <option value="4" <?php if($detail['order_state'] == '4'){echo 'selected';}?> ><?php echo yii::t('vcos', '交易完成')?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" value="<?php echo yii::t('vcos', '保存')?>" id="submit" class="btn btn-primary" style="margin-left: 45%"/>
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
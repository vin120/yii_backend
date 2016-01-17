<?php if($candelete){?>
<button class="btn btn-xs btn-warning" id="submit">
    <i class="icon-trash bigger-125"></i>
    <span class="bigger-110 no-text-shadow"><?php echo yii::t('vcos', '删除选中')?></span>
</button>
<?php } ?>
<?php if($canadd){?>
<a href="<?php echo Yii::app()->createUrl("$ControllerName/$MethodName");?>" class="btn btn-xs">
    <i class="icon-pencil align-top bigger-125"></i>
    <span class="bigger-110 no-text-shadow"><?php echo yii::t('vcos', '添加')?></span>
</a>
<?php } ?>
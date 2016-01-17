<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
    <?php if($canedit){?>
    <a href="<?php echo Yii::app()->createUrl("$ControllerName/$MethodName?id={$id}");?>" class="btn btn-xs btn-info" title="<?php echo yii::t('vcos', '编辑');?>">
        <i class="icon-edit bigger-120"></i>
    </a>
    <?php } ?>
    <?php if($candelete){?>
    <a href="#" class="btn btn-xs btn-warning delete" id="<?php echo $id;?>" title="<?php echo yii::t('vcos', '删除');?>">
        <i class="icon-trash bigger-120"></i>
    </a>
    <?php } ?>
</div>
<div class="visible-xs visible-sm hidden-md hidden-lg">
    <div class="inline position-relative">
        <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
            <i class="icon-cog icon-only bigger-110"></i>
        </button>
        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
            <?php if($canedit){?>
            <li>
                <a href="<?php echo Yii::app()->createUrl("$ControllerName/$MethodName?id={$id}");?>" class="tooltip-info" data-rel="tooltip" title="<?php echo yii::t('vcos', '编辑');?>">
                    <span class="green">
                        <i class="icon-edit bigger-120"></i>
                    </span>
                </a>
            </li>
            <?php } ?>
            <?php if($candelete){?>
            <li>
                <a href="#" class="tooltip-info delete" id="<?php echo $id;?>" data-rel="tooltip" title="<?php echo yii::t('vcos', '删除');?>">
                    <span class="red">
                        <i class="icon-trash bigger-120"></i>
                    </span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
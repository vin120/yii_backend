<div id="<?php echo $div_id?>" class="hide">
    <div class="alert alert-info bigger-110" <?php echo $title_id?"id='$title_id'":'';?>>
        <?php echo $title_content?>
    </div>
    <div class="space-6"></div>
    <p class="bigger-110 bolder center grey" <?php echo $confirm_id?"id='$confirm_id'":'';?>>
        <i class="icon-hand-right blue bigger-120"></i>
        <?php echo yii::t('vcos', '确定吗？')?>
    </p>
</div><!-- #dialog-confirm -->
<?php
/**
 * CLinkPager class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CLinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CLinkPager.php 2799 2011-01-01 19:31:13Z qiang.xue $
 * @package system.web.widgets.pagers
 * @since 1.0
 */
class MyCLinkPager extends CLinkPager
{
    const CSS_SELECTED_PAGE='active';
    
    protected function createPageButton($label,$page,$class,$hidden,$selected)
    {
            if($hidden || $selected)
                    $class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
            return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page)).'</li>';
    }
}

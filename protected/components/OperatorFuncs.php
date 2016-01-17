<?php
class OperatorFuncs
{
    public static function setOperator($filters_object)
    {
        //获得操作符
        
        $funcs = self::getFuncs();
        
        $groupOp = $filters_object->groupOp;
        $rules_array = $filters_object->rules;
            
        $res_value_array = array();
        foreach ($rules_array as $rules)
        {
            $field = $rules->field;
            $op = $rules->op;
            $_data = $rules->data;
            if ('myac'!= $field && '' != $_data)
            {
                if(0==strcasecmp('Yes',$_data) || 0==strcasecmp('Y',$_data)||0==strcasecmp('0',$_data))
                {
                    $_data=0;
                }
                else
                {
                    $_data=1;
                }
                switch ($op)
                {
                    case 'bw':
                        $res_value_array[]='admin.'.$field . $funcs[$op] .'\''. $_data . '%'.'\'';
                        break;
                    case 'bn':
                        $res_value_array[]='admin.'.$field . $funcs[$op] .'\''. $_data . '%'.'\'';
                        break;
                    case 'ew':
                        $res_value_array[]='admin.'.$field . $funcs[$op] .'\''. '%' . $_data.'\'';
                        break;
                    case 'en':
                        $res_value_array[]='admin.'.$field . $funcs[$op] .'\''. '%' . $_data.'\'';
                        break;
                    case 'cn':
                        $res_value_array[]='admin.'.$field . $funcs[$op] .'\''. '%' . $_data . '%'.'\'';
                        break;
                    case 'nc':
                        $res_value_array[]='admin.'.$field . $funcs[$op] .'\''. '%' . $_data . '%'.'\'';
                        break;
                    case 'in':
                         $res_value_array[]='admin.'.$field . $funcs[$op] .'(\''. $_data.'\')';
                        break;
                    case 'ni':
                         $res_value_array[]='admin.'.$field . $funcs[$op] .'(\''. $_data.'\')';
                        break;
                    default:
                        $res_value_array[]='admin.'.$field . $funcs[$op] .'\''. $_data.'\'';
                        break;
                }
            }
        }
        $res_str = join(' '.$groupOp.' ', $res_value_array);
        
        if (!empty($res_str))
        {
            $res_str = ' AND ('.$res_str.')';
        }
        return $res_str;
    }
    
    private static function getFuncs()
    {
        $funcs = array(
                'eq' => ' = ',
                'ne' => ' != ',
                'bw' => ' like ',
                'bn' => ' not like ',
                'ew' => ' like ',
                'en' => ' not like ',
                'cn' => ' like ',
                'nc' => ' not like ',
                'in' => ' in ',
                'ni' => ' not in ',
        );
        
        return $funcs;
    }
}
?>

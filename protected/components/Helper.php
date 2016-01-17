<?php
    class Helper extends CController
    {  
	    public static function truncate_utf8_string($string, $length, $etc = '...')   
	    {       
		    $result = '';       
		    $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
		    $strlen = strlen($string);       
		    for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)
		    {       
		        if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
		        {
		            if ($length < 1.0)
		            {           
		                break;     
		            }
		            $result .= substr($string, $i, $number);           
		            $length -= 1.0;          
		            $i += $number - 1;      
		            }
		            else
		            {           
		                $result .= substr($string, $i, 1);           
		                $length -= 0.5;
		            }
		        }       
		        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');       
		        if ($i < $strlen)
		        {       
		            $result .= $etc;
		        }       
		        return $result;  
	    }
    
	    public static function upload_file($input_name, $file_path='./', $type='image', $allow_size=2)
	    {
		    // 上传的文件
		    $file=$_FILES[$input_name];
			
			// 错误信息
			$error='';
		     
		    // 允许上传的文件类型数组
		    $allow_type=array(
		        'image'=>array(
		            'jpg'=>'image/jpeg', 
		            'png'=>'image/png', 
		            'gif'=>'image/gif',
		        ),
		        // 这里可以继续添加文件类型
		    );
		 
		    // 检查上传文件的类型是否在允许的文件类型数组里
		    if( !in_array($file['type'], $allow_type[$type]) )
		    {
		        $error="请上传".implode('、', array_keys($allow_type[$type]) )."格式的文件";
		            Helper::show_message($error);die;
		    }
		 
		    // 检查上传文件的大小是否超过指定大小
		    $size=$allow_size*1024*1024;
		    if( $file['size'] > $size )
		    { 
		        $error="你上传的文件大小请不要超过{$allow_size}MB";
				Helper::show_message($error);die;
		    }
		 
		    // 错误状态
		    switch($file['error'])
		    {
		        case 1:
		            $error='你所上传的文件大小超过了服务器配置的大小';
					Helper::show_message($error);die;
		        case 2:
		            $error='你所上传的文件大小超过了表单设置的大小';
					Helper::show_message($error);die;
		        case 3:
		            $error='网络出现问题，请检查你的网络是否连接？';
					Helper::show_message($error);die;
		        case 4:
		            $error='请选择你要上传的文件';
					Helper::show_message($error);die;
		    }
		 
		    // 自动生成目录
		    if ( !file_exists($file_path) ) 
		    {
		        mkdir($file_path, 0777, true);
		    }
			
			if($error){
				return array(
					'error'=>1,
					'warning'=>$error,
				);
			}	
		        
		    // 生成保存到服务器的文件名
		    $filename=date('YmdHis').mt_rand(1000,9999).".".array_search($file['type'], $allow_type[$type]); 
		    // 保存上传文件到本地目录
		    if( move_uploaded_file($file['tmp_name'], $file_path."/".$filename) )
		    {
		        return array(
					'error'=>0,
					'filename'=>$filename,
				);
		    }
		}

		public static function show_message($info, $url='')
		{
		    header('Content-Type:text/html;charset=utf-8');
			if($url && $url !='#')
			{
		        echo "<script>alert('{$info}');location='{$url}';</script>";
			}
			else if($url == '#')
			{
		        echo "<script>alert('{$info}');</script>";
		    }
		    else
		    {
		        echo "<script>alert('{$info}');history.back();</script>";
		    }
		}
		public static function getIp() 
		{ 
		    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
		    	$ip = getenv("HTTP_CLIENT_IP"); 
		    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
		    	$ip = getenv("HTTP_X_FORWARDED_FOR"); 
		    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
		    	$ip = getenv("REMOTE_ADDR"); 
		    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
		    	$ip = $_SERVER['REMOTE_ADDR']; 
		    else 
		    	$ip = "unknown"; 
		    return ($ip); 
		} 
    
	}   

?>

<?php
/**多图片上传***/
class UploaderController extends Controller
{
     public $layout = false;
     
     
     //WebUploader图片上传后台接收方法,可优化至断点
     public function actionImgFileUpload(){
     	//传参，判断图片分类上传至不同目录
     	$data = isset($_GET[0])?$_GET[0]:'images_images';

     	/**
		 * upload.php
		 *
		 * Copyright 2013, Moxiecode Systems AB
		 * Released under GPL License.
		 *
		 * License: http://www.plupload.com/license
		 * Contributing: http://www.plupload.com/contributing
		 */
		
		#!! IMPORTANT:
		#!! this file is just an example, it doesn't incorporate any security checks and
		#!! is not recommended to be used in production environment as it is. Be sure to
		#!! revise it and customize to your needs.
		
		
		// Make sure file is not cached (as it happens for example on iOS devices)
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		
		// Support CORS
		// header("Access-Control-Allow-Origin: *");
		// other CORS headers if any...
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		    exit; // finish preflight CORS requests here
		}
		
		
		if ( !empty($_REQUEST[ 'debug' ]) ) {
		    $random = rand(0, intval($_REQUEST[ 'debug' ]) );
		    if ( $random === 0 ) {
		        header("HTTP/1.0 500 Internal Server Error");
		        exit;
		    }
		}
		
		// header("HTTP/1.0 500 Internal Server Error");
		// exit;
		
		
		// 5 minutes execution time
		@set_time_limit(5 * 60);
		
		// Uncomment this one to fake upload time
		usleep(5000);
		
		// Settings
		// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		//$targetDir = "upload/upload_part";
		//$uploadDir = "upload/upload_tmp/" .date('Y_m',time());
		$target_Dir = Yii::app()->params['img_save_url'].$data;
		$upload_Dir = Yii::app()->params['img_save_url'].$data;
		
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
		
		
		// Create target dir
		if (!file_exists($target_Dir)) {
		    @mkdir($target_Dir);
		}
		
		// Create target dir
		if (!file_exists($upload_Dir)) {
		    @mkdir($upload_Dir);
		}
		
		$targetDir = $target_Dir.'/'.Yii::app()->params['month'];
		$uploadDir = $upload_Dir.'/'.Yii::app()->params['month'];
		
		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}
		
		// Create target dir
		if (!file_exists($uploadDir)) {
			@mkdir($uploadDir);
		}
		/**随机获取6位字母***/
		$str = array_merge(range('a','z'),range('A','Z'));
		shuffle($str);
		$str = implode('',array_slice($str,0,6));
		
		// Get a file name
		if (isset($_REQUEST["name"])) {
		    $fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
		    //$fileName = $_FILES["fileList"]["name"];
			$file = substr(strrchr($_FILES["fileList"]["name"], '.'), 1);
		    $fileName = $str.time().'.'.$file;
		} else {
		    $fileName = uniqid("file_");
		}
		
		$md5File = @file('md5list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$md5File = $md5File ? $md5File : array();
		
		if (isset($_REQUEST["md5"]) && array_search($_REQUEST["md5"], $md5File ) !== FALSE ) {
		    die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "exist": 1}');
		}
		
		
		$filePath = $targetDir . '/'.$fileName;
		//$uploadPath = $uploadDir .'/' .$str .substr(time(), -6) . $fileName;
		$uploadPath = $uploadDir .'/' .$fileName;
		
		
		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
		
		
		// Remove old temp files
		if ($cleanupTargetDir) {
		    if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
		        die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
		    }
		
		    while (($file = readdir($dir)) !== false) {
		        $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
		
		        // If temp file is current file proceed to the next
		        if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
		            continue;
		        }
		
		        // Remove temp file if it is older than the max age and is not the current file
		        if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
		            @unlink($tmpfilePath);
		        }
		    }
		    closedir($dir);
		}
		
		
		// Open temp file
		if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
		    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}
		
		if (!empty($_FILES)) {
		    if ($_FILES["fileList"]["error"] || !is_uploaded_file($_FILES["fileList"]["tmp_name"])) {
		        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		    }
		
		    // Read binary input stream and append it to temp file
		    if (!$in = @fopen($_FILES["fileList"]["tmp_name"], "rb")) {
		        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
		    }
		} else {
		    if (!$in = @fopen("php://input", "rb")) {
		        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
		    }
		}
		
		while ($buff = fread($in, 4096)) {
		    fwrite($out, $buff);
		}
		
		@fclose($out);
		@fclose($in);
		
		rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");
		
		$index = 0;
		$done = true;
		for( $index = 0; $index < $chunks; $index++ ) {
		    if ( !file_exists("{$filePath}_{$index}.part") ) {
		        $done = false;
		        break;
		    }
		}
		if ( $done ) {
		    if (!$out = @fopen($uploadPath, "wb")) {
		        die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		    }
		
		    if ( flock($out, LOCK_EX) ) {
		        for( $index = 0; $index < $chunks; $index++ ) {
		            if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
		                break;
		            }
		
		            while ($buff = fread($in, 4096)) {
		                fwrite($out, $buff);
		            }
		
		            @fclose($in);
		            @unlink("{$filePath}_{$index}.part");
		        }
		
		        flock($out, LOCK_UN);
		    }
		    @fclose($out);
		}
		
		/**截取字符串**/
		$path_arr = explode("/",$uploadPath);
		$path_arr = array_slice($path_arr, -3, 3);
		$upload_path = $path_arr[0].'/'.$path_arr[1].'/' . $path_arr[2];
		
		
		
		// Return Success JSON-RPC response
		//die('{"jsonrpc" : "2.0", "result" : null,"filePath"=>$uploadPath, "id" : "id"}');
		//exit(json_encode(array('jsonrpc'=>'2.0','result'=>'null','upload_path'=>$upload_path,'filePath'=>$uploadPath,'id'=>'id')));
		exit(json_encode(array('jsonrpc'=>'2.0','result'=>'null','filePath'=>$upload_path,'id'=>'id')));
     }

}
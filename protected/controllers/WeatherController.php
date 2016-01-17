<?php

class WeatherController extends Controller
{
    public function actionReport_list()
    {
        $this->setauth();//检查有无权限

        $country_but = 0;
        $city_but = 0;
        $city = 1;
        $where = 1;
        $city_sel = '';
        $res = 'all';
        $la_where = 1;
        
        if(isset($_GET['country']) && $_GET['country'] != ''){
        	if($_GET['country'] == 0){
        		$where = 1;
        		$country_but = 0;
        	}else{
        		$city_sql = "SELECT a.city_id,b.city_name FROM `vcos_strategy_city` a LEFT JOIN `vcos_strategy_city_language` b ON a.city_id = b.city_id WHERE a.state = '1' AND b.iso = '".Yii::app()->language."' AND a.country_id = ".$_GET['country'];
        		$city_sel = Yii::app()->m_db->createCommand($city_sql)->queryAll();
        		$str = '';
        		foreach ($city_sel as $row){
        			$str .= $row['city_id'].',';
        		}
        		$str = trim($str,",");
        		$where = "a.city_id in ( ".$str.")";
        		$country_but = $_GET['country'];
        	}
        }
        if(isset($_GET['city']) && $_GET['city'] != ''){
        	if($_GET['city'] == 0){
        		$city = 1;
        		$city_but = 0;
        	}else{
        		$city = "a.city_id = ". $_GET['city'];
        		$city_but = $_GET['city'];
        		$where = "a.city_id = ".$_GET['city'];
        	}
        }
        if(isset($_GET['res']) && $_GET['res'] != ''){
        	if($_GET['res'] == 'all'){
        		$la_where = 1;
        		$res = 'all';
        	}elseif($_GET['res'] == 'zh_cn'){
        		$la_where = "a.iso = 'zh_cn'";
        		$res = 'zh_cn';
        	}elseif($_GET['res'] == 'en'){
        		$la_where = "a.iso = 'en'";
        		$res = 'en';
        	}
        }
        
        
        if($_POST){
            $a = count($_POST['ids']);
            $result = VcosWeatherRecord::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            $count=VcosWeatherRecord::model()->deleteAll("record_id in('$ids')");
            if ($count>0){
                Helper::show_message(yii::t('vcos', '删除成功'), Yii::app()->createUrl("Weather/Report_list"));
            }else{
                Helper::show_message(yii::t('vcos', '删除失败'));
            }
        }
        if(isset($_GET['id'])){
            $result = VcosWeatherRecord::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            $count=VcosWeatherRecord::model()->deleteByPk($did);
            if ($count>0){
                Helper::show_message(yii::t('vcos', '删除成功'), Yii::app()->createUrl("Weather/Report_list"));
            }else{
                Helper::show_message(yii::t('vcos', '删除失败'));
            }
        }
        
        $count_sql = "SELECT count(*) count FROM vcos_weather_record a
		LEFT JOIN (SELECT c.city_id,d.city_name FROM `vcos_strategy_city` c LEFT JOIN `vcos_strategy_city_language` d ON c.city_id = d.city_id WHERE d.iso = '".Yii::app()->language."') e ON a.city_id = e.city_id
		WHERE ".$where." AND ".$la_where."
        		ORDER BY a.record_start_time DESC";
        $count = Yii::app()->m_db->createCommand($count_sql)->queryRow();
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        
        $sql = "SELECT * FROM vcos_weather_record a
		LEFT JOIN (SELECT c.city_id,d.city_name FROM `vcos_strategy_city` c LEFT JOIN `vcos_strategy_city_language` d ON c.city_id = d.city_id WHERE d.iso = '".Yii::app()->language."') e ON a.city_id = e.city_id
		WHERE ".$where." AND ".$la_where."
        		ORDER BY a.record_start_time DESC LIMIT {$criteria->offset}, 10";
        $record = Yii::app()->m_db->createCommand($sql)->queryAll();
        $country_sql = "SELECT a.country_id,b.country_name  FROM `vcos_strategy_country` a LEFT JOIN `vcos_strategy_country_language` b ON a.country_id = b.country_id WHERE a.state = '1' AND b.iso = '".Yii::app()->language."'";
        $country_sel = Yii::app()->m_db->createCommand($country_sql)->queryAll();;
        
        $this->render('index',array('country_sel'=>$country_sel,'res'=>$res,'city_sel'=>$city_sel,'country_but'=>$country_but,'city_but'=>$city_but,'pages'=>$pager,'auth'=>$this->auth,'record'=>$record));
    }

    public function actionReport_post()
    {
        $this->setauth();//检查有无权限
        $record = new VcosWeatherRecord(); 
        if($_POST){
        	$iso = isset($_POST['language'])?$_POST['language']:'zh_cn';
        	//判断语言
        	if(isset($_POST['language']) && $_POST['language'] != ''){
        		//外语，保存后缀为iso的数据
        		$time=  explode(" - ", $_POST['time_iso']);
        		$stime = date('Y/m/d H:i:s',strtotime($time[0]));
        		$etime = date('Y/m/d H:i:s',strtotime($time[1])+"86399");
        		$weathers=  explode("-", $_POST['weather_iso']);
        		$record->weather_id = $weathers[0];
        		$record->weather_name = $weathers[1];
        		$record->record_start_time = $stime;
        		$record->city_id = $_POST['city_iso'];
        		$record->record_end_time = $etime;
        		$record->record_temperature_min = $_POST['min_temp_iso'];
        		$record->record_temperature_max = $_POST['max_temp_iso'];
        		$record->wind_direction = $_POST['direction_iso'];
        		$record->wind_scale = $_POST['scale_iso'];
        		$record->iso = $iso;
        		if($record->save ()>0){
        			Helper::show_message(yii::t('vcos', '添加成功'), Yii::app()->createUrl("Weather/Report_list"));
        		}else{
        			Helper::show_message(yii::t('vcos', '添加失败'));
        		}
        	}else{
        		//中文状态，
        		$time=  explode(" - ", $_POST['time']);
        		$stime = date('Y/m/d H:i:s',strtotime($time[0]));
        		$etime = date('Y/m/d H:i:s',strtotime($time[1])+"86399");
        		$weathers=  explode("-", $_POST['weather']);
        		$record->weather_id = $weathers[0];
        		$record->weather_name = $weathers[1];
        		$record->record_start_time = $stime;
        		$record->city_id = $_POST['city'];
        		$record->record_end_time = $etime;
        		$record->record_temperature_min = $_POST['min_temp'];
        		$record->record_temperature_max = $_POST['max_temp'];
        		$record->wind_direction = $_POST['direction'];
        		$record->wind_scale = $_POST['scale'];
        		$record->iso = $iso;
        		if($record->save ()>0){
        			Helper::show_message(yii::t('vcos', '添加成功'), Yii::app()->createUrl("Weather/Report_list"));
        		}else{
        			Helper::show_message(yii::t('vcos', '添加失败'));
        		}
        	}
        
        }
        $sql = "SELECT a.city_id,b.city_name,b.iso FROM `vcos_strategy_city` a LEFT JOIN `vcos_strategy_city_language` b ON a.city_id = b.city_id WHERE a.state = '1'";
        $city_sel = Yii::app()->db->createCommand($sql)->queryAll();
        $sql = "SELECT a.id,b.weather_name,b.iso FROM `vcos_weather` a LEFT JOIN `vcos_weather_language` b ON a.id=b.weather_id";
        $weather = Yii::app()->db->createCommand($sql)->queryAll();
        //风速
        $sql = "SELECT a.id,b.wind_scale_name,b.iso  FROM `vcos_wind_scale` a LEFT JOIN `vcos_wind_scale_language` b ON a.id=b.wind_scale_id";
        $wind_scale = Yii::app()->db->createCommand($sql)->queryAll();
        //风向
        $sql = "SELECT a.id,b.wind_direction_name,b.iso FROM `vcos_wind_direction` a LEFT JOIN `vcos_wind_direction_language` b ON a.id=b.wind_direction_id";
        $wind_direction = Yii::app()->db->createCommand($sql)->queryAll();
        $this->render('add',array('weather'=>$weather,'city_sel'=>$city_sel,'wind_scale'=>$wind_scale,'wind_direction'=>$wind_direction));
    }

    public function actionReport_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $record = VcosWeatherRecord::model()->findByPk($id);
        if($_POST){
        	$iso = isset($_POST['language'])?$_POST['language']:'zh_cn';
        	//判断语言
            if(isset($_POST['language']) && $_POST['language'] != ''){
            	//外语
                $time=  explode(" - ", $_POST['time_iso']);
                $stime = date('Y/m/d H:i:s',strtotime($time[0]));
                $etime = date('Y/m/d H:i:s',strtotime($time[1])+"86399");;
                $record->record_id = $id;
                $weathers=  explode("-", $_POST['weather_iso']);
                $record->weather_id = $weathers[0];
                $record->weather_name = $weathers[1];
                $record->city_id = $_POST['city_iso'];
                $record->record_start_time = $stime;
                $record->record_end_time = $etime;
                $record->record_temperature_min = $_POST['min_temp_iso'];
                $record->record_temperature_max = $_POST['max_temp_iso'];
                $record->wind_direction = $_POST['direction_iso'];
                $record->wind_scale = $_POST['scale_iso'];
                $record->iso = $iso;
                $count=$record->update('record_id','weather_id','weather_name','record_start_time','record_end_time','record_temperature_min','record_temperature_max','wind_direction','wind_scale','iso');
                if($count>0){
                    Helper::show_message(yii::t('vcos', '修改成功'), Yii::app()->createUrl("Weather/Report_list"));
                }else{
                    Helper::show_message(yii::t('vcos', '修改失败'));
                }
            }else{
            	//中文
            $time=  explode(" - ", $_POST['time']);
                $stime = date('Y/m/d H:i:s',strtotime($time[0]));
                $etime = date('Y/m/d H:i:s',strtotime($time[1])+"86399");;
                $record->record_id = $id;
                $weathers=  explode("-", $_POST['weather']);
                $record->weather_id = $weathers[0];
                $record->weather_name = $weathers[1];
                $record->city_id = $_POST['city'];
                $record->record_start_time = $stime;
                $record->record_end_time = $etime;
                $record->record_temperature_min = $_POST['min_temp'];
                $record->record_temperature_max = $_POST['max_temp'];
                $record->wind_direction = $_POST['direction'];
                $record->wind_scale = $_POST['scale'];
                $record->iso = $iso;
                $count=$record->update('record_id','weather_id','weather_name','record_start_time','record_end_time','record_temperature_min','record_temperature_max','wind_direction','wind_scale','iso');
                if($count>0){
                    Helper::show_message(yii::t('vcos', '修改成功'), Yii::app()->createUrl("Weather/Report_list"));
                }else{
                    Helper::show_message(yii::t('vcos', '修改失败'));
                }
            }
        }
        $sql = "SELECT a.city_id,b.city_name,b.iso FROM `vcos_strategy_city` a LEFT JOIN `vcos_strategy_city_language` b ON a.city_id = b.city_id WHERE a.state = '1' ";
        $city_sel = Yii::app()->db->createCommand($sql)->queryAll();
        $sql = "SELECT a.id,b.weather_name,b.iso FROM `vcos_weather` a LEFT JOIN `vcos_weather_language` b ON a.id=b.weather_id";
        $weather = Yii::app()->db->createCommand($sql)->queryAll();
        //风速
        $sql = "SELECT a.id,b.wind_scale_name,b.iso  FROM `vcos_wind_scale` a LEFT JOIN `vcos_wind_scale_language` b ON a.id=b.wind_scale_id";
        $wind_scale = Yii::app()->db->createCommand($sql)->queryAll();
        //风向
        $sql = "SELECT a.id,b.wind_direction_name,b.iso FROM `vcos_wind_direction` a LEFT JOIN `vcos_wind_direction_language` b ON a.id=b.wind_direction_id";
        $wind_direction = Yii::app()->db->createCommand($sql)->queryAll();
        $this->render('edit',array('city_sel'=>$city_sel,'record'=>$record,'weather'=>$weather,'wind_scale'=>$wind_scale,'wind_direction'=>$wind_direction));
    }

}
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrCActiveRecord
 * @author Rock.Lei
 */
class PrCActiveRecord extends CActiveRecord
{
	static $database = array();
	
    public $dbname='p_db';
    
    public function getDbConnection()
    {
            if(self::$db!==null){
                    return self::$db;
            }
            else
            {
				$dbname=$this->dbname;
				if ($this->dbname == 'db')  
				{  
					self::$database[$dbname] = Yii::app()->getDb();  
				}  
				else   
				{  
					self::$database[$dbname] = Yii::app()->$dbname;  
				} 
				
				if(self::$database[$dbname] instanceof CDbConnection)  
				{  
					self::$database[$dbname]->setActive(true);  
					return self::$database[$dbname];  
				}  
				else  {
					throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));  
				} 
            }
    }
}

?>

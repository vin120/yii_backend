<?php 

class MyCActiveRecord extends CActiveRecord
{
	static $database = array();

	public $dbname = 'm_db';

	public function getDbConnection()
	{
		if(self::$db !== null)
		{
			return self::$db;
		}
		else
		{
			$dbname = $this->dbname;
			if($this->dbname == 'db')
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
			else
			{
				throw new CDbException(Yii::t('yii','Active Record rquires a "db" CDbConnection application component.'));
			}
		}
	}
}
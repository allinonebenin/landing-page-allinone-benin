<?php

use Core\Config;
use Core\Database\MysqlDatabase;
	class App
	{
		public $title = "All in one - Benin";

		private $db_instance;

		private static $_instance;

		public static function getInstance()
		{
			if(is_null(self::$_instance))
			{
				self::$_instance = new App();
			}
			return self::$_instance;
		}

		public static function load()
		{
			session_start();
			require ROOT . '/app/Autoloader.php';
			App\Autoloader::register();

			require ROOT . '/core/Autoloader.php';
			Core\Autoloader::register();

		}
		public function getTable($name)
		{
			$class_name='\\App\\Table\\' . ucfirst($name) . 'Table';
			return new $class_name($this->getDb());
		}

		public function getDb()
		{
			$config=Config::getInstance(ROOT . '/config/config.php');
			if (is_null($this->db_instance))
			{
				$this->db_instance =  new MysqlDatabase($config->get('db_name'),$config->get('db_user')
													,$config->get('db_pass'),$config->get('db_host'));
			}
			return $this->db_instance;
		}

		public function forbidden()
		{
			header('Location: admin.php');
		}

		public function notFound()
		{
			header('HTTP/1.0 404 Not FOund');
			die('Page introuvable');
		}

		public static function get_ip() 
	    {
	        // IP si internet partagé
	        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
	            return $_SERVER['HTTP_CLIENT_IP'];
	        }
	        // IP derrière un proxy
	        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	            return $_SERVER['HTTP_X_FORWARDED_FOR'];
	        }
	        // Sinon : IP normale
	        else {
	            return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	        }
	    }

		public static function ctrlDate($ladate)
		{
			if($ladate->a==date('Y') && $ladate->m==date('m') && $ladate->j==date('d')) return "today";
			elseif ($ladate->a==date('Y') && $ladate->m==date('m') && $ladate->j==date('d', strtotime('-1 day'))) return "yesterday";
			else return $ladate->a . '/'. $ladate->m . '/' . App::jour($ladate->j);
		}

		public static function jour($unjour)
		{
			if ($unjour==1) return '01';
			elseif ($unjour==2) return '02';
			elseif ($unjour==3) return '03';
			elseif ($unjour==4) return '04';
			elseif ($unjour==5) return '05';
			elseif ($unjour==6) return '06';
			elseif ($unjour==7) return '07';
			elseif ($unjour==8) return '08';
			elseif ($unjour==9) return '09';
			else return $unjour;
		}

		public static function mois($unmois, $long=null)
		{
			if ($long)
			{
				if ($unmois==1)
				{
					return "January";
				}
				else if ($unmois==2)
				{
					return "February";
				}
				else if ($unmois==3)
				{
					return "March";
				}
				else if ($unmois==4)
				{
					return "April";
				}
				else if ($unmois==5)
				{
					return "May";
				}
				else if ($unmois==6)
				{
					return "June";
				}
				else if ($unmois==7)
				{
					return "July";
				}
				else if ($unmois==8)
				{
					return "August";
				}
				else if ($unmois==9)
				{
					return "September";
				}
				else if ($unmois==10)
				{
					return "October";
				}
				else if ($unmois==11)
				{
					return "November";
				}
				else if ($unmois==12)
				{
					return "December";
				}
			}
			else
			{
				if ($unmois==1)
				{
					return "Jan";
				}
				else if ($unmois==2)
				{
					return "Feb";
				}
				else if ($unmois==3)
				{
					return "Mar";
				}
				else if ($unmois==4)
				{
					return "Apr";
				}
				else if ($unmois==5)
				{
					return "May";
				}
				else if ($unmois==6)
				{
					return "Jun";
				}
				else if ($unmois==7)
				{
					return "Jul";
				}
				else if ($unmois==8)
				{
					return "Aug";
				}
				else if ($unmois==9)
				{
					return "Sep";
				}
				else if ($unmois==10)
				{
					return "Oct";
				}
				else if ($unmois==11)
				{
					return "Nov";
				}
				else if ($unmois==12)
				{
					return "Dec";
				}
			}

		}
	}
?>

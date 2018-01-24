<?php
	namespace Core\Database;

	use \PDO;

	class MysqlDatabase extends Database
	{
		private $db_name;
		private $db_user;
		private $db_pass;
		private $db_host;
		private $pdo;

		public function __construct($db_name='bd_aiolanding', $db_user='root', $db_pass='root', $db_host='localhost')
		{
			$this->db_name=$db_name;
			$this->db_user=$db_user;
			$this->db_pass=$db_pass;
			$this->db_host=$db_host;
		}
		/*
$pdo=new PDO('mysql:dbname=aiobase;host=localhost','user_aio','Ali@2018#');
$db_name='aiobase', $db_user='user_aio', $db_pass='Ali@2018#', $db_host='localhost'

$pdo=new PDO('mysql:dbname=bd_aiolanding;host=localhost','root','root');
$db_name='bd_aiolanding', $db_user='root', $db_pass='root', $db_host='localhost'
*/
		private function getPDO()
		{
			if($this->pdo===null)
			{
				$pdo=new PDO('mysql:dbname=bd_aiolanding;host=localhost','root','root');
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo=$pdo;
			}
			return $this->pdo;
		}

		public function query($statement, $class_name = null, $one = false)
		{
			$req = $this->getPDO()->query($statement);
			if (
				strpos($statement, 'UPDATE')===0||
				strpos($statement, 'INSERT')===0||
				strpos($statement, 'DELETE')===0
				)
				{
					return $req ;
				}
			if ($class_name === null)
			{
				$req->setFetchMode(PDO::FETCH_OBJ);
			}
			else
			{
				$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
			}
			if ($one)
			{
				$datas=$req->fetch();
			}
			else
			{
				$datas = $req->fetchAll();
			}
			return $datas;
		}

		public function prepare($statement, $attributes, $class_name=null, $one=false)
		{
			$req = $this->getPDO()->prepare($statement);
			$res= $req->execute($attributes);
			if (
				strpos($statement, 'UPDATE')===0||
				strpos($statement, 'INSERT')===0||
				strpos($statement, 'DELETE')===0
				)
				{
					return $res;
				}
			if ($class_name === null)
			{
				$req->setFetchMode(PDO::FETCH_OBJ);
			}
			else
			{
				$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
			}
			if ($one)
			{
				$datas=$req->fetch();
			}
			else
			{
				$datas = $req->fetchAll();
			}

			return $datas;
		}
		public function preparons($statement, $recherc, $attributes, $class_name, $one=false)
		{
			$recherc="id";
			$req = $this->getPDO()->prepare($statement);
			$req->bindValue($recherc, $attributes);
			$req->execute();
			$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
			if ($one)
			{
				$datas=$req->fetch();
			}
			else
			{
				$datas = $req->fetchAll();
			}

			return $datas;
		}
		public function lastInsertId()
		{
			return $this->getPDO()->lastInsertId();
		}
	}
?>

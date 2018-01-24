<?php
namespace Core\Table;
use Core\Database\Database;
	class Table
	{
		protected $table;

		protected $db;

		public function __construct(Database $db)
		{
			$this->db=$db;
			if (is_null($this->table))
			{
				$part = explode('\\', get_class($this));
				$class_name=end($part);
				$this->table= strtolower(str_replace(('Table'), '', $class_name));
			}
		}

		public function all($val='id', $ord = null)
		{
			if ($ord) return $this->query("SELECT * FROM " . $this->table . " ORDER BY ".$val." ASC");
			else return $this->query("SELECT * FROM " . $this->table . " ORDER BY ".$val." DESC");
		}

		public function allwhere($att, $valatt, $ord='id')
		{
				return $this->query("
				SELECT *
				FROM " . $this->table . "
				WHERE " . $att . "= ?
				ORDER BY ".$ord." DESC",
				[$valatt], false);
		}

		public function aff($desc="datepub")
		{
			return $this->query("SELECT * FROM " . $this->table . " ORDER BY ".$desc." DESC");
		}

		public function page($premiereEntree, $messagesParPage, $val='id', $ord = null)
		{
			if ($ord)
				return $this->query("
					SELECT *
					FROM " . $this->table . "
					ORDER BY ".$val." ASC
					LIMIT ".$premiereEntree.", ".$messagesParPage."");
			else
				return $this->query("
					SELECT *
					FROM " . $this->table . "
					ORDER BY ".$val." DESC
					LIMIT ".$premiereEntree.", ".$messagesParPage."");
		}

		public function last($limite)
		{
			return $this->query("SELECT *
								FROM " . $this->table ."
								ORDER BY id DESC
                LIMIT " . $limite);
		}

		public function compte()
		{
            return $this->query("SELECT COUNT(*) as tot FROM " . $this->table,null,true);

		}

		public function compteattr($nomid, $id)
		{
            return $this->query("SELECT COUNT(*) as tot
                                FROM " . $this->table . "
                                WHERE ". $nomid . "= ?",
                                [$id], true);
		}

		public function query($statement, $attributes = null, $one=false)
		{
			if ($attributes)
			{
				return $this->db->prepare(
                        $statement,
                        $attributes,
                        str_replace('Table', 'Entites', get_class($this)),
                        $one
						);
			}
			else
			{
				return $this->db->query(
                        $statement,
                        str_replace('Table', 'Entites', get_class($this)),
                        $one
						);
			}
		}

		public function find($id, $nameid='id')
		{
			return $this->query(
			   "SELECT *
				FROM {$this->table}
				WHERE ".$nameid." = ?
			", [$id], true);
		}

		public function findattr($nameattr, $id, $nameid='id')
		{
			return $this->query(
			   "SELECT " . $nameattr . "
				FROM {$this->table}
				WHERE ".$nameid." = ?
			", [$id], true);
		}

		public function firstattr($nameattr="id", $ordvalue="id")
		{
			return $this->query(
			   "SELECT " . $nameattr . "
				FROM {$this->table}
				ORDER BY " . $ordvalue . " DESC
			", null, true);
		}

		public function create($fields)
		{
			$sql_parts=[];
			$attributes=[];
			foreach ($fields as $k => $v) {
				$sql_parts[]="$k = ?";
				$attributes[]=$v;
			}
			$sql_part=implode(', ', $sql_parts);
			return $this->query(
			   "INSERT INTO {$this->table}
				  SET $sql_part
				", $attributes, true);
		}

		public function update($id, $fields)
		{
				$nameids=[];
				$attributesid=[];
				$sql_parts=[];
				$attributes=[];
				foreach($fields as $k => $v) {
					$sql_parts[]="$k = ?";
					$attributes[]=$v;
				}
				foreach($id as $key => $value) {
					$nameids[]="$key = ?";
					$attributesid[]=$value;
				}
				foreach($attributesid as $att) {
					$attributes[]=(string)$att;
				}
				$sql_part=implode(', ', $sql_parts);
				$nameid=implode('AND ', $nameids);
				return $this->query(
				   "UPDATE {$this->table}
					  SET $sql_part
						WHERE ".$nameid."
					", $attributes, true);
		}

		public function delete($nameid, $valueid="id")
		{
			return $this->query(
			   "DELETE FROM {$this->table}
					WHERE {$valueid} = ?
				", [$nameid], true);
		}


    public function extractAttr($attr, $id, $date)
    {
        if ($attr=="j")
        {
            return $this->query(
               "SELECT DAY(".$date.") as j
                FROM {$this->table}
                WHERE id=?
                ", [$id], true);
        }
        else if ($attr=="m")
        {
            return $this->query(
               "SELECT MONTH(".$date.") as m
                FROM {$this->table}
                WHERE id=?
                ", [$id], true);

        }
        else if ($attr=="a")
        {
            return $this->query(
               "SELECT YEAR(".$date.") as a
                FROM {$this->table}
                WHERE id=?
                ", [$id], true);

        }
        else if ($attr=="h")
        {
            return $this->query(
               "SELECT HOUR(".$date.") as h
                FROM {$this->table}
                WHERE id=?
                ", [$id], true);

        }
        else if ($attr=="mi")
        {
            return $this->query(
               "SELECT MINUTE(".$date.") as mi
                FROM {$this->table}
                WHERE id=?
                ", [$id], true);

        }
        else if ($attr=="s")
        {
            return $this->query(
               "SELECT SECOND(".$date.") as s
                FROM {$this->table}
                WHERE id=?
                ", [$id], true);

        }
    }
	}

	?>

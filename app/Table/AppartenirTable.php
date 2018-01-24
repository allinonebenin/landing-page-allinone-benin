<?php
namespace App\Table;
use Core\Table\Table;
	class AppartenirTable extends Table
	{        
        public function getNbr($id)
        {
            return $this->query(
               "SELECT COUNT(*) as nbr
                FROM appartenir 
                WHERE typeprojet_id=? 
               ", [$id], true);
        }
	}
?>
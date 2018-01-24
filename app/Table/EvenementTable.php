<?php
namespace App\Table;
use Core\Table\Table;
	class EvenementTable extends Table
	{
		 public function afficher()
        {
            return $this->query(
               "SELECT nom, description, DAY(datepub) as j, MONTH(datepub) as m, YEAR(datepub) as a, HOUR(datepub) as h, MINUTE(datepub) as mi, SECOND(datepub) as s
                FROM evenement
               ");
        }
		 public function getDate($id)
	      {
	          return $this->query(
	             "SELECT DAY(datepub) as j, MONTH(datepub) as m, YEAR(datepub) as a
	              FROM evenement
								WHERE id=?
	             ", [$id], true);
	      }
	}
?>

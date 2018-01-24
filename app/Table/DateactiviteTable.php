<?php
namespace App\Table;
use Core\Table\Table;
	class DateactiviteTable extends Table
	{
		public function afficher()
		{
			return $this->query("SELECT id, DAY(datepub) as j, MONTH(datepub) as m, YEAR(datepub) as a, datepub
													FROM dateactivite
													ORDER BY datepub DESC
					                ");
		}
	}
?>

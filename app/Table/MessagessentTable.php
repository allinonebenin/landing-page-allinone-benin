<?php
namespace App\Table;
use Core\Table\Table;
	class MessagessentTable extends Table
	{
		public function afficherPage($premiereEntree, $messagesParPage)
		{
			return $this->query("SELECT id, mail, contenu, DAY(datepub) as j, MONTH(datepub) as m, YEAR(datepub) as a
								FROM messagessent
								ORDER BY datepub DESC
								LIMIT ".$premiereEntree.", ".$messagesParPage."");
		}
	}
?>

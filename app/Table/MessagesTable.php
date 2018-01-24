<?php
namespace App\Table;
use Core\Table\Table;
	class MessagesTable extends Table
	{
		public function lastUnread()
		{
			return $this->query("SELECT id, nom, contenu, DAY(datepub) as j, MONTH(datepub) as m, YEAR(datepub) as a
													FROM messages
													ORDER BY etat ASC, id DESC
                          LIMIT 6");
		}

		public function afficher()
		{
			return $this->query("SELECT id, nom, mail, contenu, DAY(datepub) as j, MONTH(datepub) as m, YEAR(datepub) as a, etat
													FROM messages
													ORDER BY datepub DESC
					                ");
		}

		public function afficherPage($premiereEntree, $messagesParPage)
		{
			return $this->query("SELECT id, nom, mail, contenu, DAY(datepub) as j, MONTH(datepub) as m, YEAR(datepub) as a, etat
								FROM messages
								ORDER BY datepub DESC
								LIMIT ".$premiereEntree.", ".$messagesParPage."");
		}
	}
?>

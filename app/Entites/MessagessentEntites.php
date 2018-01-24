<?php
namespace App\Entites;
	class MessagessentEntites
	{
		public function getUrl()
		{
			return "admin.php?p=sentmail&id=" . $this->id;
		}
	}

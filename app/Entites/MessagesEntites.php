<?php
namespace App\Entites;
	class MessagesEntites
	{
		public function getUrl()
		{
			return "admin.php?p=readmail&id=" . $this->id;
		}
	} 
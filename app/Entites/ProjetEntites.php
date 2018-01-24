<?php
namespace App\Entites;
	class ProjetEntites
	{
		public function getUrl($lequel=null)
		{
			if($lequel==1) return "admin.php?p=portfolio&id=" . $this->id;
			else return "portfolio.php?p=portfolio&id=" . $this->id;
		}
	} 

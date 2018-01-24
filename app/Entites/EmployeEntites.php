<?php
namespace App\Entites;
	class EmployeEntites
	{
		public function getUrl()
		{
			return "admin.php?p=employee&id=" . $this->id;
		}
	}

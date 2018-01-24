<?php
namespace App\Entites;
	class ArticleEntites
	{
        public function getUrl($lequel=null)
		{
			if($lequel==1) return "admin.php?p=post&id=" . $this->id;
			else return "article.php?p=article&id=" . $this->id;
		}
	} 
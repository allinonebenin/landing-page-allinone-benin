<?php
namespace App\Table;
use Core\Table\Table;
	class ImageTable extends Table
	{
      public function getIdPp($projet_id)
      {
          return $this->query(
             "SELECT id
              FROM image i
              WHERE i.typeimage_id=1
              AND projet_id=?
             ", [$projet_id], true);
      }
	}
?>

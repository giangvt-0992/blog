<?php 
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Model\Tag;

class TagRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Tag();
    }

}

?>
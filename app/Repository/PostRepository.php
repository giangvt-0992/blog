<?php 
namespace App\Repositories;

use App\Model\Post;

class PostRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Post();
    }

    public function getPost($condition = [], $perPage = 10){
        $query = $this->model->where([
            $condition
        ]);
        return $query->with(['user', 'tags', 'comment'])->get();

    }
}

?>
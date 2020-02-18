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

    public function getAll()
    {
        return Tag::all();
    }

    public function search($where = [], $orWhere = [])
    {
        return Tag::where([
            $where
        ])->get();
    }

    public function attachTags($taggable,$tags = [])
    {
        $taggable->tags()->attach($tags);
    }

    public function syncTags($taggable,$tags = [])
    {
        $taggable->tags()->sync($tags);
    }

    public function toggleTags($taggable, $tags =[])
    {
        $taggable->tags()->toggle($tags);
    }
    
    public function detachTags($taggable, $tags =[])
    {
        $taggable->tags()->detach($tags);
    }
}

?>
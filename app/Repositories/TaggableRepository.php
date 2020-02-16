<?php 
namespace App\Repositories;

use App\Model\Taggable;

class TaggableRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Taggable();
    }

    public function store($tags = [], $post_id){
        // if($tags->isEmpty()){
            $list_tag = array();
            foreach($tags as $tag){
                $list_tag[] = [
                    'tag_id' => $tag,
                    'taggable_type' => 'App\Model\Post',
                    'taggable_id' => $post_id
                ];
            }
            Taggable::insert($list_tag);
        // }
        
    }

    public function delete($taggables){
        $taggables->delete();
    }
}

?>
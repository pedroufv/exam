<?php

namespace App;

use App\Traits\RequestQueryBuildable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SubCategory extends Model
{
    use RequestQueryBuildable;

    protected $guarded = ['id'];

    
    
    /**
     * Get the category of SubCategory.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @inheritDoc
     */
    public static function searchable(): array
    {
        return [
            'id' => '=',
            'name' => 'like',
            'description' => 'like',
            'category_id' => 'like',
        ];
    }

}

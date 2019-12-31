<?php

namespace App;

use App\Traits\RequestQueryBuildable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subject extends Model
{
    use RequestQueryBuildable;

    protected $guarded = ['id'];

    
    
    /**
     * Get the subcategory of Subject.
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
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
            'subcategory_id' => 'like',
        ];
    }

}

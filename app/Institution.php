<?php

namespace App;

use App\Traits\RequestQueryBuildable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Institution extends Model
{
    use RequestQueryBuildable;

    protected $guarded = ['id'];

    
    
    /**
     * @inheritDoc
     */
    public static function searchable(): array
    {
        return [
            'id' => '=',
            'name' => 'like',
            'acronym' => 'like',
        ];
    }

}

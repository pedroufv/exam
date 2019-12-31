<?php

namespace App;

use App\Traits\RequestQueryBuildable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contest extends Model
{
    use RequestQueryBuildable;

    protected $guarded = ['id'];

    
    
    /**
     * Get the institution of Contest.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

            
    /**
     * Get the applicator of Contest.
     */
    public function applicator()
    {
        return $this->belongsTo(Applicator::class);
    }

    /**
     * @inheritDoc
     */
    public static function searchable(): array
    {
        return [
            'id' => '=',
            'name' => 'like',
            'year' => 'like',
            'number' => 'like',
            'institution_id' => 'like',
            'applicator_id' => 'like',
        ];
    }

}

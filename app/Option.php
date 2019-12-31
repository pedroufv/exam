<?php

namespace App;

use App\Traits\RequestQueryBuildable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Option extends Model
{
    use RequestQueryBuildable;

    protected $guarded = ['id'];

    
    
    /**
     * Get the question of Option.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @inheritDoc
     */
    public static function searchable(): array
    {
        return [
            'id' => '=',
            'statement' => 'like',
            'correct' => 'like',
            'question_id' => 'like',
        ];
    }

}

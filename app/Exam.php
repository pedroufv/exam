<?php

namespace App;

use App\Traits\RequestQueryBuildable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Exam extends Model
{
    use RequestQueryBuildable;

    protected $guarded = ['id'];

    public function setFinishedAtAttribute($value)
    {
        $this->attributes['finished_at'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getFinishedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    
    /**
     * Get the user of Exam.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @inheritDoc
     */
    public static function searchable(): array
    {
        return [
            'id' => '=',
            'amount' => 'like',
            'user_id' => 'like',
        ];
    }

}

<?php

namespace App;

use App\Traits\RequestQueryBuildable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Question extends Model
{
    use RequestQueryBuildable;

    protected $guarded = ['id'];



    /**
     * Get the subject of Question.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }


    /**
     * Get the user of Question.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get the contest of Question.
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    /**
     * Get the exams of question.
     */
    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }

    /**
     * @inheritDoc
     */
    public static function searchable(): array
    {
        return [
            'id' => '=',
            'statement' => 'like',
            'subject_id' => 'like',
            'user_id' => 'like',
        ];
    }

}

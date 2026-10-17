<?php

namespace App\Models;

use Database\Factories\InterviewFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends Model
{
    /** @use HasFactory<InterviewFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'applicant_id',
        'interviewer',
        'interviewed_at',
        'communication',
        'motivation',
        'vocational_clarity',
        'comments',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'interviewed_at' => 'date',
            'communication' => 'integer',
            'motivation' => 'integer',
            'vocational_clarity' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Applicant, $this>
     */
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    /**
     * The mean of the three interview ratings.
     *
     * @return Attribute<float, never>
     */
    protected function averageScore(): Attribute
    {
        return Attribute::get(fn (): float => round(
            ($this->communication + $this->motivation + $this->vocational_clarity) / 3,
            1,
        ));
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Therapy
 *
 * @property string $id
 * @property string $patient_id
 * @property string $hospital_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Hospital $hospital
 * @property-read \App\Models\Patient $patient
 * @method static \Database\Factories\TherapyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Therapy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Therapy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Therapy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Therapy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Therapy whereHospitalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Therapy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Therapy whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Therapy wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Therapy whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Therapy extends Model
{
    use HasFactory;

    public $incrementing = false;

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InsuranceInstitute
 *
 * @property string $id
 * @property string $name
 * @property string $short_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\InsuranceInstituteFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceInstitute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceInstitute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceInstitute query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceInstitute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceInstitute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceInstitute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceInstitute whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceInstitute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InsuranceInstitute extends Model
{
    use HasFactory;

    public $incrementing = false;
}

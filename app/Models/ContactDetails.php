<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\ContactDetails
 *
 * @property string $id
 * @property string $communicable_type
 * @property string $communicable_id
 * @property string $type
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $communicable
 * @method static \Database\Factories\ContactDetailsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactDetails whereCommunicableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactDetails whereCommunicableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactDetails whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactDetails whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactDetails extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'phone',
        'mobile',
        'email',
    ];

    public function communicable(): MorphTo
    {
        return $this->morphTo();
    }
}

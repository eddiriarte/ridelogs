<?php

declare(strict_types=1);

namespace App\Models;

use App\Events\Patient\AddressAdded;
use App\Events\Patient\AddressRemoved;
use App\Events\Patient\AddressUpdated;
use App\Events\Patient\InsuranceInstituteAssigned;
use App\Events\Patient\PatientCreated;
use App\Events\Patient\PatientUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Ramsey\Uuid\Uuid;

/**
 * App\Models\Patient
 *
 * @property string $id
 * @property string $insurance_institute_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $date_of_birth
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContactDetails[] $contactDetails
 * @property-read int|null $contact_details_count
 * @property-read \App\Models\InsuranceInstitute|null $insuranceInstitute
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Therapy[] $therapies
 * @property-read int|null $therapies_count
 * @method static \Database\Factories\PatientFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereInsuranceInstituteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Patient extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'date_of_birth',
    ];

    /*
     |  RELATIONSHIPS
     */

    public function contactDetails(): MorphMany
    {
        return $this->morphMany(ContactDetails::class, 'communicable');
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function insuranceInstitute(): HasOne
    {
        return $this->hasOne(InsuranceInstitute::class);
    }

    public function therapies(): HasMany
    {
        return $this->hasMany(Therapy::class);
    }

    /*
     |  Actions
     */

    public static function createWithAttributes(array $attributes): self
    {
        $attributes['id'] = (string) Uuid::uuid4();

        PatientCreated::dispatch($attributes);

        return static::find($attributes['id']);
    }

    public function updateWithAttributes(array $attributes): self
    {
        PatientUpdated::dispatch($this->id, collect($attributes)->except('id')->toArray());

        return $this->fresh();
    }

    public function assignInsuranceInstitute(InsuranceInstitute $insurance): void
    {
        InsuranceInstituteAssigned::dispatch($this->id, $insurance);
    }

    public function addAddress(array $addressAttributes, string $subject = 'Standard')
    {
        AddressAdded::dispatch($this->id, $addressAttributes, $subject);
    }

    public function updateAddress(Address $address, array $addressAttributes, string $subject = 'Standard')
    {
        AddressUpdated::dispatch($this->id, $address->id, $addressAttributes, $subject);
    }

    public function removeAddress(Address $address)
    {
        AddressRemoved::dispatch($this->id, $address->id);
    }
}

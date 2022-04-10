<?php

declare(strict_types=1);

namespace App\Projectors\Patient;

use App\Events\Patient\AddressAdded;
use App\Events\Patient\AddressRemoved;
use App\Events\Patient\AddressUpdated;
use App\Events\Patient\PatientCreated;
use App\Events\Patient\PatientUpdated;
use App\Models\Address;
use App\Models\Patient;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class PatientProjector extends Projector
{
    public function onPatientCreated(PatientCreated $event)
    {
        Patient::create($event->patientAttributes);
    }

    public function onPatientUpdated(PatientUpdated $event)
    {
        $patient = Patient::find($event->patientId);
        $patient->update($event->patientAttributes);
    }

    public function onAddressAdded(AddressAdded $event)
    {
        $patient = Patient::find($event->patientId);
        $patient->addresses()
            ->create($event->addressAttributes + ['subject' => $event->subject]);
    }

    public function onAddressUpdated(AddressUpdated $event)
    {
        $address = Address::find($event->addressId);
        $address->update($event->addressAttributes + ['subject' => $event->subject]);
    }

    public function onAddressRemoved(AddressRemoved $event)
    {
        Address::destroy($event->addressId);
    }
}

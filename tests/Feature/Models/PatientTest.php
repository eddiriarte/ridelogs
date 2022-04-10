<?php

declare(strict_types=1);

use App\Models\Patient;

it('creates patient with passed attributes', function (array $attributes) {
    $patient = Patient::createWithAttributes($attributes);

    expect($patient)->first_name->toEqual($attributes['first_name']);
    expect($patient)->last_name->toEqual($attributes['last_name']);

    $date = isset($attributes['date_of_birth']) ? $attributes['date_of_birth'] . ' 00:00:00' : null;

    expect($patient)->date_of_birth->toEqual($date);
})->with(function () {
    yield [['first_name' => 'Helga', 'last_name' => 'O\'Brian']];
    yield [['first_name' => 'Helga', 'last_name' => 'O\'Brian', 'date_of_birth' => '1980-01-15']];
});

it('updates patient with passed attributes', function (Patient $patient, array $attributes) {
    $patient->updateWithAttributes($attributes);

    $patient->refresh();

    expect($patient)->first_name->toEqual($attributes['first_name']);
    expect($patient)->last_name->toEqual($attributes['last_name']);

    if (isset($attributes['date_of_birth'])) {
        expect($patient)->date_of_birth->toEqual($attributes['date_of_birth'] . ' 00:00:00');
    }
})->with(function () {
    yield fn () => Patient::factory()->createOne();
})->with(function () {
    yield [['first_name' => 'Helga', 'last_name' => 'O\'Brian']];
    yield [['first_name' => 'Helga', 'last_name' => 'O\'Brian', 'date_of_birth' => '1980-01-15']];
});

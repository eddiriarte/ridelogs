<?php

declare(strict_types=1);

namespace App\Providers;

use App\Projectors\Patient\PatientProjector;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function register()
    {
        Projectionist::addProjectors([
            PatientProjector::class,
        ]);
    }
}

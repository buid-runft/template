<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\VerifyMlmMemberListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            VerifyMlmMemberListener::class,
        ],
        \App\Events\ProductApproved::class => [
            \App\Listeners\SendProductApprovalNotification::class,
        ],
        'Illuminate\Queue\Events\JobFailed' => [
            'App\Listeners\JobFailedListener',
        ],
    ];

    public function boot(): void
    {
        //
    }
}

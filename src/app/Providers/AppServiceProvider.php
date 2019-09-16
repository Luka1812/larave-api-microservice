<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\DBAL\Types\Type;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function register()
    {
        $this->registerDoctrineDBALTypes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application class bindings
     *
     * @return void
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    private function registerDoctrineDBALTypes()
    {
        if (false === Type::hasType('enum_nextpertise_email_status')) {
            Type::addType('enum_nextpertise_email_status', \App\Enums\DBALTypes\NextpertiseEmailStatusEnumType::class);
        }

        if (false === Type::hasType('enum_nextpertise_order_status')) {
            Type::addType('enum_nextpertise_order_status', \App\Enums\DBALTypes\NextpertiseOrderStatusEnumType::class);
        }

        if (false === Type::hasType('enum_message_log_status')) {
            Type::addType('enum_message_log_status', \App\Enums\DBALTypes\MessageLogStatusEnumType::class);
        }
    }
}

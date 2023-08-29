<?php

namespace AppModule\Core\Providers;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Core\Models\Channel::class,
        \AppModule\Core\Models\CoreConfig::class,
        \AppModule\Core\Models\Country::class,
        \AppModule\Core\Models\CountryTranslation::class,
        \AppModule\Core\Models\CountryState::class,
        \AppModule\Core\Models\CountryStateTranslation::class,
        \AppModule\Core\Models\Currency::class,
        \AppModule\Core\Models\CurrencyExchangeRate::class,
        \AppModule\Core\Models\Locale::class,
        \AppModule\Core\Models\Slider::class,
        \AppModule\Core\Models\SubscribersList::class,
    ];
}
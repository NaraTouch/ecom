<?php

namespace AppModule\Velocity\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen([
            'module.admin.catalog.category.edit_form_accordian.description_images.controls.after',
            'module.admin.catalog.category.create_form_accordian.description_images.controls.after',
        ], function($viewRenderEventManager) {
                $viewRenderEventManager->addTemplate(
                    'velocity::admin.catelog.categories.category-icon'
                );
            }
        );

        Event::listen([
            'module.admin.settings.slider.edit.after',
            'module.admin.settings.slider.create.after',
        ], function($viewRenderEventManager) {
                $viewRenderEventManager->addTemplate(
                    'velocity::admin.settings.sliders.velocity-slider'
                );
            }
        );

        Event::listen('module.admin.layout.head', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('velocity::admin.layouts.style');
        });

        Event::listen([
            'catalog.category.create.after',
            'catalog.category.update.after',
        ], 'AppModule\Velocity\Helpers\AdminHelper@storeCategoryIcon');

        Event::listen([
            'core.settings.slider.create.after',
            'core.settings.slider.update.after',
        ], 'AppModule\Velocity\Helpers\AdminHelper@storeSliderDetails');

        Event::listen('checkout.order.save.after', 'AppModule\Velocity\Helpers\Helper@topBrand');
    }
}

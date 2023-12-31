<?php

namespace AppModule\Core\Console\Commands;

use Illuminate\Console\Command;

class AppPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish { --force : Overwrite any existing files }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the available assets';

    /**
     * List of providers.
     *
     * @var array
     */
    protected $providers = [
        /**
         * App providers.
         */
        [
            'name'     => 'Admin',
            'provider' => \AppModule\Admin\Providers\AdminServiceProvider::class,
        ],
        [
            'name'     => 'UI',
            'provider' => \AppModule\Ui\Providers\UiServiceProvider::class,
        ],
        [
            'name'     => 'Core',
            'provider' => \AppModule\Core\Providers\CoreServiceProvider::class,
        ],
        [
            'name'     => 'Shop',
            'provider' => \AppModule\Shop\Providers\ShopServiceProvider::class,
        ],
        [
            'name'     => 'Product',
            'provider' => \AppModule\Product\Providers\ProductServiceProvider::class,
        ],
        [
            'name'     => 'Velocity',
            'provider' => \AppModule\Velocity\Providers\VelocityServiceProvider::class,
        ],
        [
            'name'     => 'Booking Product',
            'provider' => \AppModule\BookingProduct\Providers\BookingProductServiceProvider::class,
        ],
        [
            'name'     => 'Social',
            'provider' => \AppModule\SocialLogin\Providers\SocialLoginServiceProvider::class,
        ],
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->publishAllPackages();
    }

    /**
     * Publish all packages.
     *
     * @return void
     */
    public function publishAllPackages(): void
    {
        collect($this->providers)->each(function ($provider) {
            $this->publishPackage($provider);
        });
    }

    /**
     * Publish package.
     *
     * @param  array  $provider
     * @return void
     */
    public function publishPackage(array $provider): void
    {
        $this->line('');
        $this->line('-----------------------------------------');
        $this->info('Publishing ' . $provider['name']);
        $this->line('-----------------------------------------');

        $this->call('vendor:publish', [
            '--provider' => $provider['provider'],
            '--force'    => $this->option('force'),
        ]);
    }
}

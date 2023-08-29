<?php

namespace AppModule\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use AppModule\Category\Database\Seeders\DatabaseSeeder as CategorySeeder;
use AppModule\Attribute\Database\Seeders\DatabaseSeeder as AttributeSeeder;
use AppModule\Core\Database\Seeders\DatabaseSeeder as CoreSeeder;
use AppModule\User\Database\Seeders\DatabaseSeeder as UserSeeder;
use AppModule\Customer\Database\Seeders\DatabaseSeeder as CustomerSeeder;
use AppModule\Inventory\Database\Seeders\DatabaseSeeder as InventorySeeder;
use AppModule\CMS\Database\Seeders\DatabaseSeeder as CMSSeeder;
use AppModule\SocialLogin\Database\Seeders\DatabaseSeeder as SocialLoginSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(CoreSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(CMSSeeder::class);
        $this->call(SocialLoginSeeder::class);
    }
}

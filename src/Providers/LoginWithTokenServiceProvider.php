<?php

namespace MicroweberPackages\Modules\LoginWithToken\Providers;

use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use MicroweberPackages\Module\Facades\ModuleAdmin;
use MicroweberPackages\Modules\Logo\Http\Livewire\LogoSettingsComponent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;


class LoginWithTokenServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('microweber-module-login-with-token');
        $package->hasViews('microweber-module-login-with-token');
    }


    public function register(): void
    {
        parent::register();

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

    }
}

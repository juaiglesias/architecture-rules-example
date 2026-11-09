<?php

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Selector\SelectorInterface;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

/**
 * Rules between the Laravel component types inside every module.
 */
class LayersTest
{
    public function test_controllers_do_not_use_models(): Rule
    {
        return PHPat::rule()
            ->classes(self::layer('Http'))
            ->shouldNot()->dependOn()
            ->classes(self::layer('Models'))
            ->because('controllers go through services');
    }

    public function test_services_do_not_use_http(): Rule
    {
        return PHPat::rule()
            ->classes(self::layer('Services'))
            ->shouldNot()->dependOn()
            ->classes(self::layer('Http'), Selector::inNamespace('Illuminate\Http'))
            ->because('services must be usable outside of an HTTP request');
    }

    public function test_models_do_not_use_services_or_http(): Rule
    {
        return PHPat::rule()
            ->classes(self::layer('Models'))
            ->shouldNot()->dependOn()
            ->classes(self::layer('Services'), self::layer('Http'));
    }

    public function test_contracts_are_interfaces(): Rule
    {
        return PHPat::rule()
            ->classes(self::layer('Contracts'))
            ->should()->beInterface();
    }

    public function test_contracts_only_depend_on_contracts(): Rule
    {
        return PHPat::rule()
            ->classes(self::layer('Contracts'))
            ->shouldNot()->dependOn()
            ->classes(self::layer('Models'), self::layer('Services'), self::layer('Http'), self::layer('Providers'));
    }

    public function test_controllers_are_named_controller(): Rule
    {
        return PHPat::rule()
            ->classes(self::layer('Http\\\\Controllers'))
            ->should()->beNamed('/Controller$/', true);
    }

    /**
     * Selects the given layer namespace of any module, e.g. App\Modules\*\Models.
     */
    private static function layer(string $layer): SelectorInterface
    {
        return Selector::inNamespace('/^App\\\\Modules\\\\[^\\\\]+\\\\'.$layer.'(\\\\|$)/', true);
    }
}

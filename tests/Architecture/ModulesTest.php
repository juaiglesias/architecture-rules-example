<?php

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

/**
 * Rules between the modules and between the modules and the base app.
 */
class ModulesTest
{
    private const MODULES = ['Orders', 'Inventory', 'Payment', 'Shipping'];

    /**
     * @return iterable<string, Rule>
     */
    public function test_modules_only_use_other_modules_contracts(): iterable
    {
        foreach (self::MODULES as $module) {
            $others = array_map(
                fn (string $other) => Selector::AllOf(
                    Selector::inNamespace("App\\Modules\\$other"),
                    Selector::Not(Selector::inNamespace("App\\Modules\\$other\\Contracts")),
                ),
                // Orders -> Inventory is covered by test_orders_only_uses_inventory_contracts.
                array_diff(self::MODULES, $module === 'Orders' ? [$module, 'Inventory'] : [$module]),
            );

            yield $module => PHPat::rule()
                ->classes(Selector::inNamespace("App\\Modules\\$module"))
                ->shouldNot()->dependOn()
                ->classes(...$others)
                ->because('modules talk to each other only through their Contracts');
        }
    }

    public function test_orders_only_uses_inventory_contracts(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Modules\Orders'))
            ->shouldNot()->dependOn()
            ->classes(Selector::inNamespace('App\Modules\Inventory'))
            ->excluding(Selector::inNamespace('App\Modules\Inventory\Contracts'))
            ->because('Orders solo puede usar los Contracts de Inventory');
    }

    public function test_downstream_modules_do_not_know_orders(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('App\Modules\Inventory'),
                Selector::inNamespace('App\Modules\Payment'),
                Selector::inNamespace('App\Modules\Shipping'),
            )
            ->shouldNot()->dependOn()
            ->classes(Selector::inNamespace('App\Modules\Orders'));
    }

    public function test_base_app_does_not_depend_on_modules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::AllOf(
                Selector::inNamespace('App'),
                Selector::Not(Selector::inNamespace('App\Modules')),
            ))
            ->shouldNot()->dependOn()
            ->classes(Selector::inNamespace('App\Modules'));
    }
}

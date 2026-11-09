# Architecture rules example

Proyecto Laravel 13 (PHP 8.5, SQLite) mínimo para probar reglas de arquitectura con [phpat](https://github.com/carlosas/phpat).

## Levantar

```sh
docker compose up --build
```

El container ejecuta `composer setup` (install, `.env`, key, sqlite, migraciones + seed) y sirve la app en http://localhost:8000.

```sh
curl localhost:8000/api/products
curl -X POST localhost:8000/api/orders -H 'Accept: application/json' -d sku=MONITOR -d quantity=1 -d address='Calle 1'
curl localhost:8000/api/orders/1
```

## Reglas de arquitectura y tests

```sh
docker compose run --rm app composer phpstan   # reglas phpat
docker compose run --rm app php artisan test   # tests funcionales
```

Las reglas están en `tests/Architecture` y se registran en `phpstan.neon`.

## Estructura

```
app/
  Http/Controllers/Controller.php    base de Laravel
  Models/User.php
  Modules/
    Orders/      Http/Controllers, Models, Services, Providers, Database
    Inventory/   Contracts, Http/Controllers, Models, Services, Providers, Database
    Payment/     Contracts, Models, Services, Providers, Database
    Shipping/    Contracts, Models, Services, Providers, Database
```

`POST /api/orders` lo maneja `Orders`, que usa los `Contracts` de `Inventory` (precio y reserva de stock), `Payment` (cobro) y `Shipping` (envío). Cada módulo registra sus bindings y migraciones en su propio `ServiceProvider` (`bootstrap/providers.php`).

### Reglas incluidas

Entre componentes (`LayersTest`), dentro de cada módulo:

- Los controllers no usan Models (pasan por Services).
- Los Services no dependen de la capa HTTP.
- Los Models no dependen de Services ni HTTP.
- Los Contracts son interfaces y solo dependen de otros Contracts.
- Las clases en `Http\Controllers` terminan en `Controller`.

Entre módulos (`ModulesTest`):

- Un módulo solo puede usar los `Contracts` de otro módulo.
- `Orders` solo puede usar los `Contracts` de `Inventory` (versión explícita de la regla anterior para ese par).
- `Inventory`, `Payment` y `Shipping` no conocen `Orders`.
- La app base (`App\Http`, `App\Models`, `App\Providers`) no depende de los módulos.

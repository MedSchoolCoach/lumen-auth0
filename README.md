# Install

1. register `MedSchoolCoach\LumenAuth0\Auth0ServiceProvider::class`
2. config auth.php:
```php
'defaults' => [
    'guard' => 'api',
],

'guards' => [
    'api' => [
        'driver' => 'jwt',
    ],
]
```

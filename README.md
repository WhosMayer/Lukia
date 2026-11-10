# Lukia

Gestor de finanzas personales desarrollado por **Mayer Gómez** y **Milton Muñoz** para la asignatura Diseño de Contenido para Interfaces de Usuario.

Lukia permite registrar ingresos y gastos, organizar movimientos por categorías y consultar el balance de un mes. Cada cuenta administra sus propios datos de forma independiente.

## Funciones implementadas

- Registro, inicio y cierre de sesión.
- Categorías personales.
- Creación, edición y eliminación de ingresos y gastos.
- Filtro y resumen financiero mensual.
- Paginación de movimientos.
- Protección de los datos entre cuentas.
- Interfaz adaptable en español.

## Tecnologías

- Laravel 12 y PHP 8.2 o superior.
- MySQL o MariaDB mediante XAMPP.
- Blade, Bootstrap y CSS.
- PHPUnit para pruebas automatizadas.

## Arquitectura MVC

```text
app/
├── Http/Controllers/
│   ├── AuthController.php
│   ├── CategoryController.php
│   ├── DashboardController.php
│   └── TransactionController.php
└── Models/
    ├── User.php
    ├── Category.php
    └── Transaction.php

resources/views/
├── auth.blade.php
├── edit.blade.php
├── layout.blade.php
├── panel.blade.php
└── transaction-form.blade.php
```

Los modelos utilizan relaciones de Eloquent para representar los usuarios, sus categorías y sus movimientos. Los controladores separan la autenticación, el panel financiero, las categorías y las transacciones.

## Instalación local

1. Inicia MySQL desde XAMPP.
2. Crea en phpMyAdmin una base de datos llamada `lukia`.
3. Abre una terminal en la carpeta del proyecto y ejecuta:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve --host=127.0.0.1 --port=8000
```

4. Abre [http://127.0.0.1:8000](http://127.0.0.1:8000) y crea una cuenta.

La configuración de ejemplo utiliza MySQL en `127.0.0.1:3306`, la base `lukia`, el usuario `root` y una contraseña vacía. Ajusta `.env` si tu instalación es diferente. Nunca publiques ese archivo.

## Pruebas

```powershell
php artisan test
```

La primera entrega cuenta con **8 pruebas y 49 verificaciones** sobre autenticación, privacidad, validación de montos, balance mensual, edición y eliminación de movimientos.

## Próximas funciones

- Presupuestos y metas de ahorro.
- Gráficos comparativos.
- Recuperación de contraseña.
- Asistente de inteligencia artificial.

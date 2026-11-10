# Lukia

Gestor de finanzas personales de Mayer Gómez y Milton Muñoz para Diseño de Contenido para Interfaces de Usuario.

## Estado de esta primera versión

Código implementado: registro e inicio de sesión, cierre de sesión, categorías personales, creación, edición y eliminación de ingresos y gastos, filtro mensual, balance y paginación. Interfaz en español con Bootstrap almacenado localmente.

La aplicación fue verificada con MySQL/MariaDB y también mediante pruebas automatizadas. La primera entrega cuenta con 8 pruebas y 49 verificaciones aprobadas. El código está publicado en GitHub.

El asistente de IA, presupuestos, metas, gráficos y recuperación de contraseña quedan para siguientes entregas.

## Arranque en Windows

1. Abre XAMPP y activa MySQL. Activa Apache si vas a usar phpMyAdmin.
2. En phpMyAdmin crea una base vacía llamada `lukia` con cotejamiento `utf8mb4_unicode_ci`. No borres ni reemplaces una base existente.
3. Abre PowerShell en esta carpeta y ejecuta:

```powershell
composer install
php artisan key:generate
php artisan migrate
php artisan test
php artisan serve --host=127.0.0.1 --port=8000
```

4. Abre http://127.0.0.1:8000 y crea tu cuenta. No hay usuarios ni contraseñas predeterminados.

El archivo `.env` está preparado para MySQL/MariaDB en 127.0.0.1:3306, base `lukia`, usuario local `root` y contraseña vacía. Ajusta esos datos si tu instalación es diferente. Esta configuración es únicamente para desarrollo local. Nunca publiques `.env`.

Si PHP no se reconoce, usa `C:\xampp\php\php.exe` en lugar de `php`. No se requiere compilar recursos con npm para estas primeras pantallas: Bootstrap y el CSS están en public. Node y npm quedan disponibles para las próximas iteraciones.

## Comprobación funcional

Registra una cuenta, agrega una categoría, registra un ingreso de 100000 y un gasto de 15000 en el mismo mes. El balance esperado es 85000 COP. Edita el gasto y comprueba el nuevo balance. Elimina un movimiento y revisa la confirmación. Cierra sesión y crea otra cuenta: los movimientos de la primera no deben aparecer.

Los importes se almacenan en centavos enteros para evitar errores de coma flotante. El balance representa los movimientos registrados durante el mes, no un saldo bancario ni un saldo acumulado.

Las pruebas de `tests/Feature/FinanceTest.php` utilizan SQLite en memoria para comprobar el acceso por usuario, validación de montos, edición, eliminación, autenticación y filtros mensuales. No alteran la base MariaDB. Además hay que comprobar la aplicación con MariaDB antes de presentarla.

## Repositorio

https://github.com/WhosMayer/Lukia

El repositorio contiene el código fuente de la primera entrega. `.env`, `vendor`, `node_modules`, bases locales y archivos de sesión están excluidos mediante `.gitignore`.

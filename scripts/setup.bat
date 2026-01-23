@echo off
setlocal
set TARGET_DIR=golden-perfume-shop

where composer >nul 2>nul
if errorlevel 1 (
  echo Composer not found. Install Composer then run again.
  exit /b 1
)

echo 1) Creating Laravel project: %TARGET_DIR%
composer create-project laravel/laravel %TARGET_DIR%

echo 2) MANUAL STEP:
echo    Copy folders app, routes, resources, database, public, config and file .env.example from this zip into %TARGET_DIR% and replace.

echo 3) Then run:
echo    cd %TARGET_DIR%
echo    copy .env.example .env
echo    php artisan key:generate
echo    php artisan migrate --seed
echo    php artisan serve
pause

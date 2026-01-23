@echo off
set TARGET_DIR=golden-perfume
if not "%1"=="" set TARGET_DIR=%1

where composer >nul 2>&1
if errorlevel 1 (
  echo Composer غير مثبت. ثبّت Composer ثم أعد المحاولة.
  exit /b 1
)

composer create-project laravel/laravel %TARGET_DIR%

xcopy /E /I /Y app %TARGET_DIR%\app
xcopy /E /I /Y config %TARGET_DIR%\config
xcopy /E /I /Y database %TARGET_DIR%\database
xcopy /E /I /Y public %TARGET_DIR%\public
xcopy /E /I /Y resources %TARGET_DIR%\resources
xcopy /E /I /Y routes %TARGET_DIR%\routes
copy /Y .env.example %TARGET_DIR%\.env.example
copy /Y README.md %TARGET_DIR%\README.md

echo تم التركيب داخل: %TARGET_DIR%

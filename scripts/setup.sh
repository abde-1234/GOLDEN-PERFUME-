#!/usr/bin/env bash
set -euo pipefail

TARGET_DIR="golden-perfume-shop"

if ! command -v composer >/dev/null 2>&1; then
  echo "Composer غير مثبت. ثبّته ثم أعد المحاولة." >&2
  exit 1
fi

echo "1) إنشاء مشروع Laravel جديد: ${TARGET_DIR}"
composer create-project laravel/laravel "$TARGET_DIR"

echo "2) نسخ ملفات Golden Perfume إلى داخل المشروع (مع الاستبدال)"
# يفترض تشغيل السكربت من داخل مجلد الـ ZIP بعد فك الضغط
rsync -a \
  --exclude 'scripts' \
  --exclude '.git' \
  --exclude '.idea' \
  --exclude 'node_modules' \
  --exclude 'vendor' \
  ./ "$TARGET_DIR"/

cd "$TARGET_DIR"

echo "3) تهيئة البيئة و قاعدة البيانات"
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed

echo "تم ✅ شغل الآن: php artisan serve"

#!/usr/bin/env bash
set -e

if ! command -v composer >/dev/null 2>&1; then
  echo "Composer غير مثبت. ثبّت Composer ثم أعد المحاولة." >&2
  exit 1
fi

TARGET_DIR=${1:-golden-perfume}

composer create-project laravel/laravel "$TARGET_DIR"

# Copy overlay contents into the new project
SCRIPT_DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)
OVERLAY_ROOT=$(cd "$SCRIPT_DIR/.." && pwd)

rsync -a --exclude "scripts" "$OVERLAY_ROOT/" "$TARGET_DIR/"

echo "تم التركيب داخل: $TARGET_DIR"

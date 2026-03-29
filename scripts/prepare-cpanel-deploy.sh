#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DEPLOY_DIR="${ROOT_DIR}/deploy-dist"
WORK_DIR="${ROOT_DIR}/deploy-dist.tmp"
OLD_DIR="${ROOT_DIR}/deploy-dist.old"

echo "Preparing deploy bundle in: ${DEPLOY_DIR}"
rm -rf "${WORK_DIR}" "${OLD_DIR}" >/dev/null 2>&1 || true
mkdir -p "${WORK_DIR}"

if command -v rsync >/dev/null 2>&1; then
  rsync -a \
    --exclude '.git/' \
    --exclude '.github/' \
    --exclude 'node_modules/' \
    --exclude 'tests/' \
    --exclude 'deploy-dist/' \
    --exclude 'deploy-dist.tmp/' \
    --exclude 'deploy-dist.old/' \
    --exclude '.env' \
    --exclude '.ftp-deploy-sync-state.json' \
    "${ROOT_DIR}/" "${WORK_DIR}/"
else
  tar \
    --exclude='.git' \
    --exclude='.github' \
    --exclude='node_modules' \
    --exclude='tests' \
    --exclude='deploy-dist' \
    --exclude='deploy-dist.tmp' \
    --exclude='deploy-dist.old' \
    --exclude='.env' \
    --exclude='.ftp-deploy-sync-state.json' \
    -C "${ROOT_DIR}" -cf - . | tar -C "${WORK_DIR}" -xf -
fi

if [[ ! -d "${WORK_DIR}/public" ]]; then
  echo "public directory is missing from deploy bundle"
  exit 1
fi

# cPanel document root is /public_html, so copy public/ contents to deploy root.
if command -v rsync >/dev/null 2>&1; then
  rsync -a "${WORK_DIR}/public/" "${WORK_DIR}/"
else
  cp -a "${WORK_DIR}/public/." "${WORK_DIR}/"
fi

if [[ ! -f "${WORK_DIR}/index.php" ]]; then
  echo "index.php was not copied to deploy root"
  exit 1
fi

sed -i "s#__DIR__.'/../vendor/autoload.php'#__DIR__.'/vendor/autoload.php'#g" "${WORK_DIR}/index.php"
sed -i "s#__DIR__.'/../bootstrap/app.php'#__DIR__.'/bootstrap/app.php'#g" "${WORK_DIR}/index.php"
sed -i "s#__DIR__.'/../storage/framework/maintenance.php'#__DIR__.'/storage/framework/maintenance.php'#g" "${WORK_DIR}/index.php"

# Recreate runtime directories cleanly for production deploy.
rm -rf \
  "${WORK_DIR}/storage/logs" \
  "${WORK_DIR}/storage/framework/cache" \
  "${WORK_DIR}/storage/framework/sessions" \
  "${WORK_DIR}/storage/framework/views"

mkdir -p \
  "${WORK_DIR}/storage/logs" \
  "${WORK_DIR}/storage/framework/cache/data" \
  "${WORK_DIR}/storage/framework/sessions" \
  "${WORK_DIR}/storage/framework/views" \
  "${WORK_DIR}/bootstrap/cache"

touch \
  "${WORK_DIR}/storage/logs/.gitignore" \
  "${WORK_DIR}/storage/framework/cache/.gitignore" \
  "${WORK_DIR}/storage/framework/cache/data/.gitignore" \
  "${WORK_DIR}/storage/framework/sessions/.gitignore" \
  "${WORK_DIR}/storage/framework/views/.gitignore"

# Protect production environment file.
rm -f "${WORK_DIR}/.env"

if [[ -d "${DEPLOY_DIR}" ]]; then
  mv "${DEPLOY_DIR}" "${OLD_DIR}" || true
fi
mv "${WORK_DIR}" "${DEPLOY_DIR}"
rm -rf "${OLD_DIR}" >/dev/null 2>&1 || true

echo "Deploy bundle is ready."

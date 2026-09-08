#!/bin/bash
# Install as root:root 0755 at /usr/local/libexec/diggityjr-deploy.
# This installed copy must not be writable by the deployment user.
set -euo pipefail
[ "$#" -eq 1 ] || exit 2
case "$1" in --deploy|--check) ;; *) exit 2 ;; esac
[ "$(id -un)" = diggityjr ] || { echo 'Run through the configured sudo deployment command.' >&2; exit 1; }
export HOME=/var/lib/diggityjr
export PATH=/usr/local/bin:/usr/bin:/bin
export GIT_SSH_COMMAND='ssh -F /var/lib/diggityjr/.ssh/config'
export GIT_TERMINAL_PROMPT=0
umask 0022
cd /var/www/DiggityJr.com
exec 9>.git/diggityjr-deploy.lock
flock -n 9 || { echo 'Another deployment is running.' >&2; exit 1; }
[ "$(git branch --show-current)" = master ] || { echo 'Production must be on master.' >&2; exit 1; }
[ -z "$(git status --porcelain)" ] || { echo 'Production has local changes; reconcile them first.' >&2; git status --short; exit 1; }
for command in git composer wp tar curl; do command -v "$command" >/dev/null; done
[ -w .git ] && [ -w wp-content/plugins ] && [ -w vendor ]
git -c url.https://github.com/JoeSRocha/Diggity-Jr.git.insteadOf=git@github.com:JoeSRocha/Diggity-Jr.git fetch origin master
target=$(git rev-parse origin/master)
previous=$(git rev-parse HEAD)
git merge-base --is-ancestor HEAD "$target" || { echo 'Production has diverged from origin/master.' >&2; exit 1; }
printf 'Production: %s\nTarget:     %s\n' "$previous" "$target"
git diff --stat HEAD "$target"
# Composer needs access to the custom plugin repository as the deployment user.
git ls-remote git@github.com:JoeSRocha/payment-intelligence-for-woocommerce.git HEAD >/dev/null
if [ "$1" = --check ]; then
  echo 'Preflight passed. Deploy uses pushed origin/master and its composer.lock.'
  exit 0
fi
if wp maintenance-mode is-active >/dev/null 2>&1; then
  echo 'Production is already in maintenance mode; investigate before deploying.' >&2
  exit 1
fi
backup="$HOME/db-backups/diggityjr/$(date -u +%Y%m%dT%H%M%SZ)"
mkdir -p "$backup"
chmod 700 "$HOME/db-backups/diggityjr" "$backup"
printf '%s\n' "$previous" > "$backup/commit"
wp db export "$backup/database.sql" --single-transaction --skip-lock-tables --skip-plugins --skip-themes
# Preserve the deployed application, dependencies, configuration, and core.
# Live uploads and caches are not changed by this deployment.
tar -czf "$backup/files.tar.gz" --exclude=./.git --exclude=./wp-content/uploads --exclude=./wp-content/cache .
echo "Backup: $backup"
maintenance=0
failed() {
  status=$?
  if [ "$status" -ne 0 ]; then
    echo "Deployment failed. Backup: $backup; previous commit: $previous" >&2
    if [ "$maintenance" -eq 1 ]; then
      echo 'Maintenance remains enabled. Repair or restore the application, then run wp maintenance-mode deactivate.' >&2
    fi
  fi
}
trap failed EXIT
wp maintenance-mode activate
maintenance=1
git merge --ff-only "$target"
composer install --no-dev --prefer-dist --no-interaction --no-scripts --optimize-autoloader
composer check-platform-reqs --no-dev
wp core update-db --skip-plugins --skip-themes
wp eval 'echo "WordPress loaded successfully.\n";'
wp maintenance-mode deactivate
maintenance=0
for route in / /shop/ /cart/ /checkout/ /wp-login.php; do
  status=$(curl --fail --silent --show-error --location --max-time 60 --output /dev/null --write-out '%{http_code}' "https://diggityjr.com$route")
  [ "$status" = 200 ] || { echo "Unexpected HTTP $status for $route" >&2; exit 1; }
  printf '%s HTTP %s\n' "$route" "$status"
done
printf 'Deployed %s\nBackup: %s\n' "$target" "$backup"

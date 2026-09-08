# DDEV Project Template
```
$ ddev config --project-type=wordpress --docroot=.
$ ddev start
$ ddev wp core download --skip-content --force
$ ddev composer install
$ cp .env.example .env
```

## Production deployment

Commit and push your changes to `master`, then run **Terminal → Run Task → Deploy**
in VS Code. **Deploy: Check** fetches and checks the target without changing deployed
files. The equivalent terminal command is `bash scripts/deploy.sh [--check]`.
The script always deploys the fetched `origin/master`; uncommitted or unpushed local
changes are not included.

Production is `/var/www/DiggityJr.com` through the existing SSH alias `ww` (user
`joe`). The task invokes the root-owned `/usr/local/libexec/diggityjr-deploy`
as `diggityjr` through a sudo rule limited to `--deploy` and `--check`. Application
and Git files belong to `diggityjr`, with existing groups and modes preserved.
Direct `git pull` as `joe` is not the deployment workflow. WordPress core upgrades
remain separate.

The deployment command uses `/var/lib/diggityjr` for its private credentials,
Composer cache, and backups. The public site repository is fetched over HTTPS;
the private plugin uses a dedicated read-only GitHub deploy key. It must be added
to the plugin repository's Settings → Deploy keys before the first deployment.
Changes to `scripts/deploy-production.sh` require an administrator to review and
reinstall that file at `/usr/local/libexec/diggityjr-deploy` (root:root, mode 0755);
Git updates do not replace the privileged entry point.

Deploy refuses a dirty/diverged production checkout, creates private database and
application backups under `/var/lib/diggityjr/db-backups/diggityjr/`, enables maintenance mode,
fast-forwards Git, and installs exact locked production dependencies. Composer
scripts are disabled; the configured Composer installer plugin is allowed. It
checks PHP requirements, WordPress loading, and HTTP responses for storefront and
login routes. It does not activate newly installed plugins or exercise payments.
Uploads, caches, and the production `.env` are not replaced by deployment.

This is an in-place deployment with a brief maintenance window, not an atomic
release switch. A failure during installation leaves maintenance enabled and
prints the backup location. Inspect the failure before restoring application files
from `files.tar.gz` and the saved Git commit; do not blindly restore the database,
which could discard newer orders. After repair, run `wp maintenance-mode deactivate`
as `diggityjr` from the production directory using an administrator account. Backups contain secrets and customer data;
keep them private and remove old backups according to your retention needs.

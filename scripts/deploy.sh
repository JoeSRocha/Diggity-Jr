#!/usr/bin/env bash
set -euo pipefail
mode=${1:---deploy}
case "$mode" in --deploy|--check) ;; *) echo "Usage: $0 [--check]" >&2; exit 2 ;; esac
# Only the fixed, root-owned deployment entry point is permitted by sudo.
ssh -o BatchMode=yes -o ConnectTimeout=15 ww sudo -n -u diggityjr /usr/local/libexec/diggityjr-deploy "$mode"

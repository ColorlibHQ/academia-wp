#!/bin/sh
# Build the distributable zips: the theme, and the companion plugin separately.
#
# WordPress unpacks an update zip and uses its top-level directory as the
# install directory, so the theme zip must contain exactly one root folder named
# `academia` — hence staging into a temp directory rather than zipping the tree
# in place.
#
# The companion plugin is a SEPARATE zip, never bundled inside the theme: a
# plugin inside a theme zip is reinstalled on every theme update, overwriting
# whatever version the user has.
#
# Development material is excluded: .dev (the generators), the docs and the
# plugin directory are all part of the repository but none of them belongs
# inside the theme a user installs.
set -e

ROOT=$(cd "$(dirname "$0")/.." && pwd)
VERSION=$(sed -n 's/^Version: *//p' "$ROOT/style.css" | head -1)
OUT=${1:-/tmp/academia-build}

rm -rf "$OUT"
mkdir -p "$OUT/academia"

cd "$ROOT"
rsync -a --quiet \
	--exclude '.git' \
	--exclude '.gitignore' \
	--exclude '.dev' \
	--exclude '.claude' \
	--exclude 'CLAUDE.md' \
	--exclude 'docs' \
	--exclude 'plugin' \
	--exclude '.DS_Store' \
	./ "$OUT/academia/"

cd "$OUT"
zip -qr "academia-$VERSION.zip" academia
echo "theme:  $OUT/academia-$VERSION.zip"

# The plugin carries its own version.
PLUGIN_VERSION=$(sed -n 's/^ \* Version: *//p' "$ROOT/plugin/academia-library/academia-library.php" | head -1)
rm -rf "$OUT/academia-library"
rsync -a --quiet --exclude '.DS_Store' "$ROOT/plugin/academia-library/" "$OUT/academia-library/"
zip -qr "academia-library-$PLUGIN_VERSION.zip" academia-library
echo "plugin: $OUT/academia-library-$PLUGIN_VERSION.zip"

# The theme zip must not contain the plugin, or WordPress reinstalls it on
# every theme update.
if unzip -l "academia-$VERSION.zip" | grep -q 'academia/plugin/'; then
	echo "ERROR: the theme zip contains plugin/" >&2
	exit 1
fi
echo "verified: theme zip excludes plugin/"

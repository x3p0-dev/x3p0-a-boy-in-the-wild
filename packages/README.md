# `packages/`

First-party packages that are authored and published in their own repositories,
then copied into this theme so they ship as part of it. This folder never holds
third-party code.

## Do not edit these files here

The contents of this folder are **generated**. The [Prelude](https://github.com/x3p0-dev/x3p0-prelude) tool copies
each package in and rewrites its namespace on `composer install` and
`composer update` (`post-install-cmd` / `post-update-cmd`). Any change made
directly here is overwritten the next time those run.

To change a package, edit it in its upstream repository and re-run the install.

## How it works

Configured under `extra.x3p0.prelude` in `composer.json`. Each listed package is
copied to this folder (`output-path`) and re-namespaced under the theme's prefix
so it can't collide with another copy shipped by a different plugin or theme.

For example, `x3p0-dev/x3p0-framework` is copied to
`packages/x3p0-dev/x3p0-framework/` with its `X3P0\` namespace replaced by
`{ProjectNamespace}\Framework\`. It is then loaded via the `classmap` autoload
entry, not as authored PSR-4 source.

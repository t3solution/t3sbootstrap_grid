# TYPO3 Extension `t3sbootstrap_grid`

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/t3sbootstrap)
[![Latest Stable Version](https://poser.pugx.org/t3sbs/t3sbootstrap_grid/v/stable)](https://packagist.org/packages/t3sbs/t3sbootstrap_grid)
[![Monthly Downloads](https://poser.pugx.org/t3sbs/t3sbootstrap_grid/d/monthly)](https://packagist.org/packages/t3sbs/t3sbootstrap_grid)
[![License](https://poser.pugx.org/t3sbs/t3sbootstrap_grid/license)](https://packagist.org/packages/t3sbs/t3sbootstrap_grid)

A startup extension that brings the Bootstrap grid system to TYPO3. Editors get ready-to-use container content elements — 2-, 3-, 4- and 6-columns plus a flexible row-columns layout — configurable directly through the content element.

## Features

- Ready-to-use Bootstrap grid containers: 2-, 3-, 4-, 6-columns and row-columns
- Per-breakpoint column widths (xs, sm, md, lg, xl, xxl) configured via FlexForm
- Optional container wrapper, custom gutters and extra CSS classes per column
- Built on top of EXT:container for nested content
- Site Sets support using the modern TYPO3 Site Settings approach
- The required Bootstrap styles are loaded by default.

## Requirements

- TYPO3 v14
- [EXT:container](https://extensions.typo3.org/extension/container) (`b13/container`)

## Installation

### With Composer (recommended)

In the root of your Composer-based TYPO3 project, run:

```bash
composer require t3sbs/t3sbootstrap_grid
```

### From the TYPO3 Extension Repository (TER)

Download and install the extension through the Extension Manager in the TYPO3 backend.

## Setup

The extension uses Site Sets (TYPO3 v13+), so configuration is applied per site rather than through legacy static templates.

1. Open your site configuration and add the `t3sbootstrap_grid` set as a dependency.

By default the required Bootstrap styles are loaded. If you ship your own Bootstrap assets, disable the "Required Bootstrap styles" option in the Site Sets.

## License

Released under the GPL-2.0-or-later license. See the [LICENSE](LICENSE) file for details.

## Support

If you find this extension useful, consider supporting its development:
[Donate via PayPal](https://www.paypal.me/t3sbootstrap)

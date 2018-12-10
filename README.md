# AWIN Affiliate Marketing Integration for Magento2

A Magento2 Module providing integration with the
[AWIN](https://www.awin.com/) Affiliate Marketing Programme.

## Installation

This module can be installed via composer and the Magento2 command-line tool.
For example:

    composer require do-it-well/magento2-module-awin
    ./bin/magento module:enable DIW_AWIN
    ./bin/magento setup:upgrade

## Configuration

By default, the module will be "enabled", but inactive. The module will not
output anything to your site until it has been configured. If nothing else,
you will need to fill in the "Advertiser Programme ID" field. The defaults
should be acceptable for all other fields.

Module configuration can be found under the Magento2 Admin Panel, in the
section:

**Stores** > **Settings** > **Configuration** > **Sales** > **AWIN** >
**AWIN Tracking**

Configuration options are:

| Option | Description                                       | Default |
|--------|---------------------------------------------------|---------|
| Enable | Allows module output to be completely toggled on/off | Yes |
| Advertiser Programme ID | Identifier for your AWIN account. This may be sometimes be called "merchant code", "advertiser id", or similar. Nothing will be output unless this option has been configured. | (none) |
| Commission Group | Default commission group which sales are assigned to | "Default" |
| Channel | AWIN Tracking Channel (this probably won't ever change) | "aw" |
| Test Mode | Sets the "test mode" flag when sending AWIN Tracking data. Use this when performing initial test transactions | No |

## License

All module code within this repository is licensed under the MIT license. See
the LICENSE.md file for details.

Do It Well Limited is not in any way affiliated with AWIN. This module has been
developed independently, without any direction or explicit or implicit
endorsement or vetting on the part of those services to which it attempts to
integrate.

## Support

If you encounter any problems with this module, you may open an issue on GitHub
at https://github.com/do-it-well/magento2-module-awin/issues

Premium support, assistance in module installation or configuration, or other
development services, can be obtained by contacting
[Do It Well Limited](https://do-it-well.co.uk/)

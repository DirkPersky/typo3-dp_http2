# DP HTTP2 Push / Preload
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg?style=for-the-badge)](https://www.paypal.me/dirkpersky)
[![Latest Stable Version](https://img.shields.io/packagist/v/dirkpersky/typo3-dp_http2?style=for-the-badge)](https://packagist.org/packages/dirkpersky/typo3-dp_http2)
[![TYPO3](https://img.shields.io/badge/TYPO3-dp__http2-%23f49700?style=for-the-badge)](https://extensions.typo3.org/extension/dp_http2/)
[![License](https://img.shields.io/packagist/l/dirkpersky/typo3-dp_http2?style=for-the-badge)](https://packagist.org/packages/dirkpersky/typo3-dp_http2)

This Plugin add HTTP2 Push header or preloads links for your performance optimization.
If you use it together with Scriptmerger take care to install this plugin after Scriptmerger.

## Config
### Constants
```
plugin.tx_dp_http2 {
    settings {
        # cat=plugin.http2; type=options[true,false]; label = Enable HTTP2 Push
        enabled = true

        # cat=plugin.http2; type=int+; label= Maximum Files that shoud pushed
        maxFiles =

        # cat=plugin.http2; type=options[http2push,preload]; label = Push Modus
        modus = http2push
    }
}
```
| Property                  | Description                                   | Options                                   | Default |
| ------------------------- | --------------------------------------------- | ----------------------------------------- | -------:|
| enabled                   | Enable the PlugIn handling                    | true|false                                | true |
| maxFiles                  | Maximum Files that shoud pushed or preloaded  | empty|numeric                             |    |
| modus                     | Switch betweend Optimisation modes            | http2push|preload                         | http2push |

## Please give me feedback
I would appreciate any kind of feedback or ideas for further developments to keep improving the extension for your needs.

## Say thanks! and support me
You like this extension? Get something for me (surprise!) from my wishlist on [Amazon](https://www.amazon.de/hz/wishlist/ls/15L17XDFBEYFL/r) or [![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/dirkpersky) the next pizza. Thanks a lot!

### Contact us
- [E-Mail](mailto:info@dp-wired.de)
- [GitHub](https://github.com/DirkPersky/typo3-dp_http2)
- [Homepage](http:/dp-wired.de)
- [TYPO3.org](https://extensions.typo3.org/extension/dp_http2/)
- [Packagist.org (composer)](https://packagist.org/packages/dirkpersky/typo3-dp_http2)

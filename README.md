<h1 align="center">KygekEasyGamemode</h1>

<p align="center">
<a href="https://github.com/thebigcrafter/KygekEasyGamemode/blob/pm4/LICENSE"><img src="https://img.shields.io/github/license/thebigcrafter/KygekEasyGamemode?style=for-the-badge" alt="license" /></a>
<a href="https://discord.gg/PykBfE2TZ9"><img src="https://img.shields.io/discord/1087729577004122112?color=7289DA&label=discord&logo=discord&style=for-the-badge" alt="discord" /></a>
</p>

# 📖 About

A PocketMine-MP API 5 plugin for quickly changing between gamemodes. It is
maintained by thebigcrafter and is useful for servers where operators switch
gamemodes frequently.

# Requirements

- PocketMine-MP API 5.0.0 or newer.
- PHP 8.1 or newer.

Compatibility checks in this campaign use
[Axolotl-PM](https://github.com/NhanAZ/Axolotl-PM), a PocketMine-MP-compatible
server distribution.

# 🧩 Features

- Works in console.
- Invalid player name detection.
- Customizable message.

# ⬇️ Installation

1. Download the latest version (It is recommended to always download the latest version for the best experience, except you're having compatibility issues) in [here](https://github.com/thebigcrafter/KygekEasyGamemode/releases).
2. Put the KygekEasyGamemode.phar file to the plugins folder.
3. Restart the server.
4. Done!

# 🚢 Other Versions
- [Nukkit](https://github.com/KygekTeam/KygekEasyGamemode-Nukkit) 

# 🧪 Build and test

The build process uses [DevTools](https://github.com/NhanAZ/DevTools) to package
and validate the plugin PHAR. Development checks use Composer, PHPStan and
PHP-CS-Fixer:

    composer install
    composer analyse
    vendor/bin/php-cs-fixer check --diff

The packaged plugin must retain plugin.yml, resources/ and the PHP source under
src/.

# ⚖️ License
Licensed under the [GNU General Public License v3.0](LICENSE).

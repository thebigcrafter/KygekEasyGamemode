<?php

/*
* A PocketMine-MP plugin to quickly change gamemodes
* Copyright (C) 2020-2022 Kygekraqmak, KygekTeam
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

namespace Kygekraqmak\KygekEasyGamemode;

use KygekTeam\KtpmplCfs\KtpmplCfs;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase {

    private const IS_DEV = false;
    private const DEFAULT_PREFIX = TF::GREEN . "[KygekEasyGamemode] " . TF::RESET;
    private const DEFAULT_MESSAGES = [
        "no-permission" => TF::RED . "You do not have permission to use this command",
        "sender-not-player" => "Usage: /\$command <player>",
        "success.self" => TF::YELLOW . "Successfully changed your gamemode to \$gamemode",
        "success.other.sender" => TF::YELLOW . "Successfully changed \$target's gamemode to \$gamemode",
        "success.other.target" => TF::YELLOW . "Your gamemode was changed to \$gamemode by \$sender",
        "invalid-player" => TF::RED . "Player \$name was not found",
    ];

    protected function onEnable() : void {
        $this->saveDefaultConfig();
        $ktpmplCfs = new KtpmplCfs($this);
        /** @phpstan-ignore-next-line */
        if (self::IS_DEV) {
            $ktpmplCfs->warnDevelopmentVersion();
        }
        $ktpmplCfs->checkConfig("2.1");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        switch ($cmd = strtolower($command->getName())) {
            case "gmds":
            case "gmdc":
            case "gmda":
            case "gmdsp":
                $this->reloadConfig();
                $this->changeGamemode($sender, $cmd, $args);
        }
        return true;
    }

    private function changeGamemode(CommandSender $sender, string $cmd, array $args) {
        if (
            !$sender->hasPermission("kygekeasygmd." . $cmd) &&
            !$sender->hasPermission("kygekeasygmd")
        ) {
            $sender->sendMessage($this->getMessage("no-permission"));
            return;
        }

        if (!isset($args[0])) {
            if (!$sender instanceof Player) {
                $sender->sendMessage($this->getMessage("sender-not-player", ["command" => $cmd]));
            } else {
                $gamemode = $this->setGamemode($sender, $cmd);
                $sender->sendMessage($this->getMessage("success.self", ["gamemode" => $gamemode]));
            }
            return;
        }

        $player = $this->getServer()->getPlayerByPrefix($args[0]);
        if (is_null($player)) {
            $sender->sendMessage($this->getMessage("invalid-player", ["name" => $args[0]]));
            return;
        }

        $gamemode = $this->setGamemode($player, $cmd);
        $sender->sendMessage($this->getMessage("success.other.sender", ["target" => $player->getName(), "gamemode" => $gamemode]));
        $player->sendMessage($this->getMessage("success.other.target", ["sender" => $sender->getName(), "gamemode" => $gamemode]));
    }

    private function setGamemode(Player $player, string $cmd) : string {
        switch ($cmd) {
            case "gmds":
                $gamemode = GameMode::SURVIVAL();
                break;
            case "gmdc":
                $gamemode = GameMode::CREATIVE();
                break;
            case "gmda":
                $gamemode = GameMode::ADVENTURE();
                break;
            case "gmdsp":
                $gamemode = GameMode::SPECTATOR();
                break;
            default:
                return "";
        }

        $player->setGamemode($gamemode);
        return $gamemode->getTranslatableName()->getText();
    }

    /**
     * @param string $key
     * @param string[] $vars
     * @return string
     */
    private function getMessage(string $key, array $vars = []) : string {
        $config = $this->getConfig();

        // Add '$' prefix to all keys in $vars
        foreach ($vars as $var => $value) {
            $vars["$" . $var] = $value;
            unset($vars[$var]);
        }

        $message = "";

        if (($prefix = $config->getNested("messages.prefix", false)) !== false) {
            if (!empty($prefix)) {
                $prefix .= " ";
            }
            $message .= $prefix;
        } else {
            $message .= self::DEFAULT_PREFIX;
        }

        $message .= TextFormat::colorize(str_ireplace(
            array_keys($vars),
            array_values($vars),
            empty($message = $config->getNested("messages." . $key, self::DEFAULT_MESSAGES[$key])) ?
                self::DEFAULT_MESSAGES[$key] :
                $message
        ));

        return $message;
    }
    
}

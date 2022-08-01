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
use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase {

    private const IS_DEV = false;
    private const PREFIX = TF::GREEN . "[KygekEasyGamemode] ";

    protected function onEnable() : void {
        /** @phpstan-ignore-next-line */
        if (self::IS_DEV) {
            (new KtpmplCfs($this))->warnDevelopmentVersion();
        }

        $this->saveDefaultConfig();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        switch ($cmd = strtolower($command->getName())) {
            case "gmds":
            case "gmdc":
            case "gmda":
            case "gmdsp":
                $this->changeGamemode($sender, $cmd, $args);
        }
        return true;
    }

    private function changeGamemode(CommandSender $sender, string $cmd, array $args) {
        if (!$sender->hasPermission("kygekeasygmd." . $cmd)) {
            $sender->sendMessage(self::PREFIX . $this->getConfig()->get("NoPermisisonMessage"));
            return;
        }

        if (!isset($args[0])) {
            if (!$sender instanceof Player) {
                $sender->sendMessage(self::PREFIX . TF::WHITE . "Usage: /$cmd <player>");
            } else {
                $gamemode = $this->setGamemode($sender, $cmd);
                $sender->sendMessage(self::PREFIX . str_replace("{{gamemode}}", $gamemode, $this->getConfig()->get("SelfChangeGamemodeSuccessfully")));
            }
            return;
        }

        $player = $this->getServer()->getPlayerByPrefix($args[0]);
        if (is_null($player)) {
            $sender->sendMessage(self::PREFIX . $this->getConfig()->get("PlayerNotFound"));
            return;
        }

        $gamemode = $this->setGamemode($player, $cmd);
        $sender->sendMessage(self::PREFIX . str_replace("{{gamemode}}", $gamemode, str_replace("{{player}}", $player->getName(), $this->getConfig()->get("PlayerChangeGamemodeSuccessfully"))));
        $player->sendMessage(self::PREFIX . str_replace("{{gamemode}}", $gamemode, str_replace("{{player}}", $sender->getName(), $this->getConfig()->get("GamemodeChangedAlert"))));
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
        return $gamemode->getEnglishName();
    }
    
}

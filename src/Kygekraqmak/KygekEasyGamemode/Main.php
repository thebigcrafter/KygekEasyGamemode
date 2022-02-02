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
            $this->getLogger()->warning("This plugin is running on a development version. There might be some major bugs. If you found one, please submit an issue in https://github.com/KygekTeam/KygekEasyGamemode/issues.");
        }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        switch (strtolower($command->getName())) {
            case "gmds":
                $this->changeGamemode($sender, "gmds", $args);
                break;
            case "gmdc":
                $this->changeGamemode($sender, "gmdc", $args);
                break;
            case "gmda":
                $this->changeGamemode($sender, "gmda", $args);
                break;
            case "gmdsp":
                $this->changeGamemode($sender, "gmdsp", $args);
        }
        return true;
    }

    private function changeGamemode(CommandSender $sender, string $cmd, array $args) {
        if (!$sender->hasPermission("kygekeasygmd." . $cmd)) {
            $sender->sendMessage(self::PREFIX . TF::RED . "You do not have permission to use this command");
            return;
        }

        if (!isset($args[0])) {
            if (!$sender instanceof Player) {
                $sender->sendMessage(self::PREFIX . TF::WHITE . "Usage: /$cmd <player>");
            } else {
                $gamemode = $this->setGamemode($sender, $cmd);
                $sender->sendMessage(self::PREFIX . TF::YELLOW . "Successfully changed your gamemode to $gamemode");
            }
            return;
        }

        $player = $this->getServer()->getPlayerByPrefix($args[0]);
        if (is_null($player)) {
            $sender->sendMessage(self::PREFIX . TF::RED . "Player was not found");
            return;
        }

        $gamemode = $this->setGamemode($player, $cmd);
        $sender->sendMessage(self::PREFIX . TF::YELLOW . "Successfully changed {$player->getName()}'s gamemode to $gamemode");
        $player->sendMessage(self::PREFIX . TF::YELLOW . "Your gamemode was changed to $gamemode by {$sender->getName()}");
    }

    private function setGamemode(Player $player, string $cmd) : string {
        switch ($cmd) {
            case "gmds":
                $player->setGamemode(GameMode::SURVIVAL());
                $gamemode = "Survival";
                break;
            case "gmdc":
                $player->setGamemode(GameMode::CREATIVE());
                $gamemode = "Creative";
                break;
            case "gmda":
                $player->setGamemode(GameMode::ADVENTURE());
                $gamemode = "Adventure";
                break;
            case "gmdsp":
                $player->setGamemode(GameMode::SPECTATOR());
                $gamemode = "Spectator";
                break;
            default:
                $gamemode = "";
        }

        return $gamemode;
    }
    
}

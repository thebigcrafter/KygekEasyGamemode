<?php

/*
* A PocketMine-MP plugin to quickly change gamemodes
* Copyright (C) 2020 Kygekraqmak
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

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

class Main extends PluginBase {

  public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
    $self = $this->getServer()->getPlayer($sender->getName());
    $other = $this->getServer()->getPlayer($args[0]);
    $server = $this->getServer();
    $nopermall = TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::RED . "You do not have permission to use this command";
    $nopermself = TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::RED . "You do not have permission to change your gamemode";
    $nopermother = TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::RED . "You do not have permission to change others' gamemode";
    $notfound = TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::RED . "Player " . $other->getName() . "was not found";
    switch ($cmd->getName()) {

      case "gmdc":
        if (!$sender instanceof Player) {
          if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::WHITE . "Usage: /gmdc <player>");
          } elseif (isset($args[0])) {
            if (!$other) {
              $sender->sendMessage($notfound);
            } else {
              $other->setGamemode(1);
              $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Creative");
              $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Creative by CONSOLE");
            }
          }
        } else {
          if (!$sender->hasPermission("kygekeasygmd.gmdc")) {
            if (count($args) < 1) {
              if (!$sender->hasPermission("kygekeasygmd.gmdc.self") and $sender->hasPermission("kygekeasygmd.gmdc.other")) {
                $sender->sendMessage($nopermall);
              } elseif (!$sender->hasPermission("kygekeasygmd.gmdc.self")) {
                $sender->sendMessage($nopermself);
              } elseif ($sender->hasPermission("kygekeasygmd.gmdc.self")) {
                $self->setGamemode(1);
                $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed your gamemode to Creative");
              }
            } elseif (isset($args[0])) {
              if (!$sender->hasPermission("kygekeasygmd.gmdc.self") and $sender->hasPermission("kygekeasygmd.gmdc.other")) {
                $sender->sendMessage($nopermall);
              } elseif (!$sender->hasPermission("kygekeasygmd.gmdc.other")) {
                $sender->sendMessage($nopermother);
              } elseif ($sender->hasPermission("kygekeasygmd.gmdc.other")) {
                if (!$other) {
                  $sender->sendMessage($notfound);
                } else {
                  $other->setGamemode(1);
                  $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Creative");
                  $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Creative by " . $sender->getName());
                }
              }
            }
          } else {
            if (count($args) < 1) {
              $self->setGamemode(1);
              $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed your gamemode to Creative");
            } elseif (isset($args[0])) {
              if (!$other) {
                $sender->sendMessage($notfound);
              } else {
                $other->setGamemode(1);
                $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Creative");
                $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Creative by " . $sender->getName());
              }
            }
          }
        }
      break;

      case "gmds":
        if (!$sender instanceof Player) {
          if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::WHITE . "Usage: /gmds <player>");
          } elseif (isset($args[0])) {
            if (!$other) {
              $sender->sendMessage($notfound);
            } else {
              $other->setGamemode(0);
              $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Survival");
              $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Survival by CONSOLE");
            }
          }
        } else {
          if (!$sender->hasPermission("kygekeasygmd.gmds")) {
            if (count($args) < 1) {
              if (!$sender->hasPermission("kygekeasygmd.gmds.self") and $sender->hasPermission("kygekeasygmd.gmds.other")) {
                $sender->sendMessage($nopermall);
              } elseif (!$sender->hasPermission("kygekeasygmd.gmds.self")) {
                $sender->sendMessage($nopermself);
              } elseif ($sender->hasPermission("kygekeasygmd.gmds.self")) {
                $self->setGamemode(0);
                $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed your gamemode to Survival");
              }
            } elseif (isset($args[0])) {
              if (!$sender->hasPermission("kygekeasygmd.gmds.self") and $sender->hasPermission("kygekeasygmd.gmds.other")) {
                $sender->sendMessage($nopermall);
              } elseif (!$sender->hasPermission("kygekeasygmd.gmds.other")) {
                $sender->sendMessage($nopermother);
              } elseif ($sender->hasPermission("kygekeasygmd.gmds.other")) {
                if (!$other) {
                  $sender->sendMessage($notfound);
                } else {
                  $other->setGamemode(0);
                  $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Survival");
                  $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Survival by " . $sender->getName());
                }
              }
            }
          } else {
            if (count($args) < 1) {
              $self->setGamemode(0);
              $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed your gamemode to Survival");
            } elseif (isset($args[0])) {
              if (!$other) {
                $sender->sendMessage($notfound);
              } else {
                $other->setGamemode(0);
                $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Survival");
                $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Survival by " . $sender->getName());
              }
            }
          }
        }
      break;

      case "gmda":
        if (!$sender instanceof Player) {
          if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::WHITE . "Usage: /gmda <player>");
          } elseif (isset($args[0])) {
            if (!$other) {
              $sender->sendMessage($notfound);
            } else {
              $other->setGamemode(2);
              $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Adventure");
              $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Adventure by CONSOLE");
            }
          }
        } else {
          if (!$sender->hasPermission("kygekeasygmd.gmda")) {
            if (count($args) < 1) {
              if (!$sender->hasPermission("kygekeasygmd.gmda.self") and $sender->hasPermission("kygekeasygmd.gmda.other")) {
                $sender->sendMessage($nopermall);
              } elseif (!$sender->hasPermission("kygekeasygmd.gmda.self")) {
                $sender->sendMessage($nopermself);
              } elseif ($sender->hasPermission("kygekeasygmd.gmda.self")) {
                $self->setGamemode(2);
                $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed your gamemode to Adventure");
              }
            } elseif (isset($args[0])) {
              if (!$sender->hasPermission("kygekeasygmd.gmda.self") and $sender->hasPermission("kygekeasygmd.gmda.other")) {
                $sender->sendMessage($nopermall);
              } elseif (!$sender->hasPermission("kygekeasygmd.gmda.other")) {
                $sender->sendMessage($nopermother);
              } elseif ($sender->hasPermission("kygekeasygmd.gmda.other")) {
                if (!$other) {
                  $sender->sendMessage($notfound);
                } else {
                  $other->setGamemode(2);
                  $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Adventure");
                  $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Adventure by " . $sender->getName());
                }
              }
            }
          } else {
            if (count($args) < 1) {
              $self->setGamemode(2);
              $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed your gamemode to Adventure");
            } elseif (isset($args[0])) {
              if (!$other) {
                $sender->sendMessage($notfound);
              } else {
                $other->setGamemode(2);
                $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Adventure");
                $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Adventure by " . $sender->getName());
              }
            }
          }
        }
      break;

      case "gmdsp":
        if (!$sender instanceof Player) {
          if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::WHITE . "Usage: /gmdsp <player>");
          } elseif (isset($args[0])) {
            if (!$other) {
              $sender->sendMessage($notfound);
            } else {
              $other->setGamemode(3);
              $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Spectator");
              $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Spectator by CONSOLE");
            }
          }
        } else {
          if (!$sender->hasPermission("kygekeasygmd.gmdsp")) {
            if (count($args) < 1) {
              if (!$sender->hasPermission("kygekeasygmd.gmdsp.self") and $sender->hasPermission("kygekeasygmd.gmdsp.other")) {
                $sender->sendMessage($nopermall);
              } elseif (!$sender->hasPermission("kygekeasygmd.gmdsp.self")) {
                $sender->sendMessage($nopermself);
              } elseif ($sender->hasPermission("kygekeasygmd.gmdsp.self")) {
                $self->setGamemode(3);
                $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed your gamemode to Spectator");
              }
            } elseif (isset($args[0])) {
              if (!$sender->hasPermission("kygekeasygmd.gmdsp.self") and $sender->hasPermission("kygekeasygmd.gmdsp.other")) {
                $sender->sendMessage($nopermall);
              } elseif (!$sender->hasPermission("kygekeasygmd.gmdsp.other")) {
                $sender->sendMessage($nopermother);
              } elseif ($sender->hasPermission("kygekeasygmd.gmdsp.other")) {
                if (!$other) {
                  $sender->sendMessage($notfound);
                } else {
                  $other->setGamemode(3);
                  $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Spectator");
                  $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Spectator by " . $sender->getName());
                }
              }
            }
          } else {
            if (count($args) < 1) {
              $self->setGamemode(3);
              $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed your gamemode to Spectator");
            } elseif (isset($args[0])) {
              if (!$other) {
                $sender->sendMessage($notfound);
              } else {
                $other->setGamemode(3);
                $sender->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Successfully changed " . $other->getName() . "'s gamemode to Spectator");
                $other->sendMessage(TextFormat::GREEN . "[KygekEasyGamemode] " . TextFormat::YELLOW . "Your gamemode was changed to Spectator by " . $sender->getName());
              }
            }
          }
        }
      break;

    }
  }

}

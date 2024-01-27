<?php

namespace wockkinmycup\utilitycore\addons\warps;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\Position;
use wockkinmycup\utilitycore\Loader;
use wockkinmycup\utilitycore\utils\Utils;

class WarpAPI
{

    public static Config $data;

    public function __construct(PluginBase $loader)
    {
        self::$data = Utils::getConfiguration($loader, "warpsData.json");
    }

    public static function getAllWarps(): array
    {
        $warps = [];
        foreach (self::$data->getAll() as $name => $pos) {
            $warps[] = $name;
        }
        return $warps;
    }

    public static function existWarp(string $name): bool
    {
        return in_array($name, self::getAllWarps());
    }

    public static function addWarp(Player $pos, string $name): void
    {
        self::$data->set($name, [$pos->getPosition()->getX(), $pos->getPosition()->getY(), $pos->getPosition()->getZ(), $pos->getWorld()->getDisplayName()]);
    }

    public static function getWarp(string $name): Position
    {
        $pos = self::$data->get($name);
        return new Position($pos[0], $pos[1], $pos[2], Server::getInstance()->getWorldManager()->getWorldByName($pos[3]));
    }

    public static function delWarp(string $name): void
    {
        self::$data->remove($name);
    }
}
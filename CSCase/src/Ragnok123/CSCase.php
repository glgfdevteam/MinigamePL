<?php

namespace Ragnok123;

use pocketmine\item\Item;
use Fireworks\Fireworks;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\level\Level;
use pocketmine\block\Chest;
use pocketmine\event\Listener;
use pocketmine\math\Vector3 as Vector3;
use pocketmine\block\Block;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\player\PlayerInteractEvent;

class CSCase extends PluginBase implements Listener {
	private $inventory;
	
	public function onEnable() {
		$this->enabled = true;
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );				
		$this->inventory = new ChestInventory($this);
		$this->getLogger ()->info ( TextFormat::GREEN . "CSCase is enabled" );
	}
	
	public function handlePlayerInteractWithChest(PlayerInteractEvent $event) {
		$player = $event->getPlayer ();

		if ($event->getBlock ()->getId () == Item::CHEST) {
			if ($player->getInventory ()->getItemInHand ()->getId () == Item::STICK) {
				$player->sendMessage ( "[GLGF] Opening Quà..." );				
				$this->inventory->refillRandomItems ( $player->level, $event->getBlock () );
          		$player->getInventory ()->removeItem ( Item::get(280, 0, 1) );
			} else {
				$player->sendMessage ( "[GLGF] Bạn Không Có Key,\n[GLGF] Tìm Trong Túi Stick Hoặc Có Thể Mua Ở Shop !" );
				$event->setCancelled ( true );
			}
		}
	}
	public function onDisable() {
		$this->getLogger ()->info ( TextFormat::RED . "CSCase is disabled" );
		$this->enabled = false;
	}
}
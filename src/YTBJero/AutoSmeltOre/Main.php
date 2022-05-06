<?php

namespace YTBJero\AutoSmeltOre;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\item\ItemIds;
use pocketmine\item\StringToItemParser;

class Main extends PluginBase implements Listener{

      public function onEnable() : void{
            $this->getServer()->getPluginManager()->registerEvents($this, $this);
            $this->saveDefaultConfig();
      }

      public function onBreak(BlockBreakEvent $event) : void{
            $item = $event->getItem();
            $block = $event->getBlock();
            $player = $event->getPlayer();
            if($item->hasEnchantment(VanillaEnchantments::SILK_TOUCH())){
                  return;
            }
            if($this->getConfig()->get("Permission", true) and $player->hasPermission("autosmeltore.action.allow")){
                  $ores = [
                        ItemIds::COAL_ORE => StringToItemParser::getInstance()->parse("coal"),
                        ItemIds::IRON_ORE => StringToItemParser::getInstance()->parse("iron_ingot"),
                        ItemIds::GOLD_ORE => StringToItemParser::getInstance()->parse("gold_ingot"),
                        ItemIds::REDSTONE_ORE => StringToItemParser::getInstance()->parse("redstone"),
                        ItemIds::LIT_REDSTONE_ORE => StringToItemParser::getInstance()->parse("redstone"),
                        ItemIds::DIAMOND_ORE => StringToItemParser::getInstance()->parse("diamond"),
                        ItemIds::EMERALD_ORE => StringToItemParser::getInstance()->parse("emerald"),
                        ItemIds::QUARTZ_ORE => StringToItemParser::getInstance()->parse("quartz")
                  ];
                  if($this->getConfig()->get(str_replace(" ", "_", $block->getName()))){
                        $event->setDrops(array_map(function ($item) use ($ores) {
                        return in_array($item->getId(), array_keys($ores)) ? $ores[$item->getId()] : $item;
                        }, $event->getDrops()));
                  }
            }
      }
}
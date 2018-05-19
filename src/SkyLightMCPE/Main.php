<?php

namespace SkyLightMCPE;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as C;
use pocketmine\event\entity\EntityDamageEvent;
class Main extends PluginBase implements Listener{
    
    public $iswildin = [];
    
    public function onEnable(){
              $this->getServer()->getPluginManager()->registerEvents($this, $this);
              $this->getLogger()->info(C::GREEN . "Wild enabled!");
    }
    public function onDisable(){
              $this->getLogger()->info(C::RED . "Wild disabled!");
    }
    
    public function onCommand(CommandSender $s, Command $cmd, string $label, array $args) : bool{
    if(strtolower($cmd->getName() == "wild")){
        if($s->hasPermission("wild.command")){
        if($s instanceof Player){
            $x = rand(1,999);
            $y = 128;
            $z = rand(1,999);
            $s->teleport($s->getLevel()->getSafeSpawn(new Vector3($x, $y, $z)));
            $s->addTitle(TF::AQUA . "§a§lTeleporting...");
			$s->sendMessage(TF::AQUA . "§dYou have teleported to a random spot.");
            $this->iswildin[$s->getName()] = true;
        
        }
        }else{
            $s->sendMessage(C::RED."You dont have permission");
        }
        return true;
    }
        
    public function onDamage(EntityDamageEvent $event){
       if($event->getEntity() instanceof Player){
           if(isset($this->iswildin[$event->getEntity->getName()])){
               $p = $event->getEntity();
               unset($this->iswildin[$p->getName()]);
                     $event->setCancelled();
           }
       }
    }
}

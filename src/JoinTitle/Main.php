<?php
/**
 * Created with PHPStorm
 * 
 * 
 * Cool Huh
 */
namespace JoinTitle;

use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

    public $usage = "§c/jointitle title|subtitle|fadein|stay|fadeout";

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function onJoin(PlayerJoinEvent $e)
    {
        $p = $e->getPlayer();
        $c = $this->getConfig();
        $ti = str_replace("&", "§", $c->get("title"));
        $title = str_replace("%p", $p->getName(), $ti);
        $subtitle = str_replace("&", "§", $c->get("subtitle"));
        $fadein = $c->get("fadein")*20;
        $stay = $c->get("stay")*20;
        $fadeout = $c->get("fadeout")*20;

        $p->addTitle($title, $subtitle, $fadein, $stay, $fadeout);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch($command->getName()) {
            case "jointitle":
                if(isset ($args[0]) && isset($args[1])) {
                    if($args[0] === "title" || $args[0] === "subtitle" || $args[0] === "fadein" || $args[0] === "stay" || $args[0] === "fadeout") {
                        $thing = array_splice($args, 1, 99999);
                        $idk = implode(" ", $thing);
                        $this->getConfig()->set($args[0], $idk);
                        $sender->sendMessage("§c".$args[0]." §ehas been successfully set to §a".$idk."§e!");
                        //$this->getConfig()->save();
                        return true;
                    }
                } else {
                    $sender->sendMessage($this->usage);
                    return false;
                }
            break;
        }
        return false;
    }

    /*public function onDisable()
    {
        $this->getConfig()->save();
    }*/
}

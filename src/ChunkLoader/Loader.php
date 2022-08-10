<?php

namespace ChunkLoader;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase implements Listener {
    public function onEnable(): void {
        // We do this because this assbangs
        // the default memory limit and will
        // probably stop exeuction midway
        // if set to the default one.
        // This 2000M one was able to load a
        // 2kx2k world so it's probably good enough.
        ini_set('memory_limit', '2000M');
        $w = $this->getServer()->getWorldManager()->getWorldByName("hcf");
        if ($w) {
            $ar = $w->getProvider()->getAllChunks(true, $this->getLogger());
            foreach ($ar as $coords => $chunk) {
                [$x, $z] = $coords;
                $w->loadChunk($x, $z);
                $w->getProvider()->saveChunk($x, $z, $chunk);
                $this->getLogger()->info("Manually loaded chunk: ($x, $z)");
            }
        }
    }
}
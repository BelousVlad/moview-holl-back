<?php

namespace App\Service\Interfaces;

interface XmlEngineInterface {
    
    /**
     * @param string $path
     * 
     * @return self
     */
    public function load(string $path): self;

}
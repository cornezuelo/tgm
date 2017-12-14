<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Manager\Effects;

/**
 * Description of EffectAbstract
 *
 * @author msk
 */
abstract class EffectAbstract {
    protected $multiplier=1;
    
    function getMultiplier() {
        return $this->multiplier;
    }

    function setMultiplier($multiplier) {
        $this->multiplier = $multiplier;
    }
}

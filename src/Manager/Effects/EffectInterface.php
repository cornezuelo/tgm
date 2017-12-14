<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Manager\Effects;

/**
 * Description of EffectInterface
 *
 * @author msk
 */
interface EffectInterface {
    public function applyEffect($content);
    public function getMultiplier();
    public function setMultiplier($multiplier);
}

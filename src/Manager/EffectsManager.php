<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Manager;

/**
 * Description of EffectsManager
 *
 * @author msk
 */
class EffectsManager {
    public function applyEffect($id, $content) {
        $id = "App\Manager\Effects\lib\\".$id."Effect";
        if (class_exists($id)) {
            $effect = new $id();
            return ['res' => true, 'content' => $effect->applyEffect($content)];
        } else  {
            return ['res' => false, 'error' => "The effect doesn't exist."];
        }
    }
}

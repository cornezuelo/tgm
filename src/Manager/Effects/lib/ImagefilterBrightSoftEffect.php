<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Manager\Effects\lib;

/**
 * Description of NegateEffect
 *
 * @author msk
 */
class ImagefilterBrightSoftEffect extends \App\Manager\Effects\EffectAbstract {
    protected $multiplier = 3;
    protected $family = 'bright';
    
    public function applyEffect($content) {
        $path = uniqid().'_tmp_'.rand(1,9999).'.jpg';
        file_put_contents($path,$content);
        $im = imagecreatefromjpeg($path);
        $chances = rand(0,100);
        if ($chances >= 50) {
            $i = 1;
        } else {
            $i = -1;
        }
        imagefilter($im, IMG_FILTER_BRIGHTNESS, rand(20,60)*$i);
        imagejpeg($im, $path, 100);
        $content = file_get_contents($path);
        unlink($path);
        imagedestroy($im);
	return $content;
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Manager\Effects\lib;

/**
 * Description of GrayScaleImagefilterEffect
 *
 * @author msk
 */
class ImagefilterGrayScaleEffect extends \App\Manager\Effects\EffectAbstract {
    protected $family = 'fxs';
    
    public function applyEffect($content) {
        $path = uniqid().'_tmp_'.rand(1,9999).'.jpg';
        file_put_contents($path,$content);
        $im = imagecreatefromjpeg($path);
        imagefilter($im, IMG_FILTER_GRAYSCALE);
        imagejpeg($im, $path, 100);
        $content = file_get_contents($path);
        unlink($path);
	return $content;
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Manager\Effects\lib;

/**
 * Description of GlitchMutationsSoftEffect
 *
 * @author msk
 */
class GlitchMutationsSoftEffect extends \App\Manager\Effects\EffectAbstract {
    protected $family = 'glitch';
    
    public function applyEffect($content) {	
	$content_glitched = $content;
	$mutations = mt_rand(1,3);
	for($i = 0; $i < $mutations; $i++) {
		$rand = substr(md5(microtime()),rand(0,26),5);
	  	$content_glitched = substr_replace($content_glitched, str_shuffle($rand."t98wfh9p8w3th98w3tsetf9wgt98hgt98rzt98hwz"), rand(strlen($content_glitched)/10, strlen($content_glitched)), 0);		  	
	}		
	// Read image path, convert to base64 encoding
	$imageData = base64_encode($content_glitched);
	return $imageData;
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Manager\EffectsManager;
use App\Manager\RedditCrawlerManager;
/**
 * Description of DebugController
 *
 * @author msk
 */
class DebugController {
    public function index(EffectsManager $effectsManager, RedditCrawlerManager $redditCrawlerManager) {
        $response = '';
        $crawl = $redditCrawlerManager->crawl();
        $uri = $crawl['uri'];
        $aux_content = $crawl['content'];
        $pathinfo = pathinfo($uri);
        $path = uniqid();
        if (isset($pathinfo['extension'])) {
          $path .= '.'.$pathinfo['extension'];  
        }
        
        file_put_contents($path, $aux_content);
        $effectsManager->convertImageToJPG($path, $path.'.jpg', 100);
        $content = file_get_contents($path.'.jpg');
        unlink($path);
        unlink($path.'.jpg');
        
        $aux = $effectsManager->applyEffectsRandom($content,rand(1,3),false);
        $response .= '<h2>'.  implode(',', $aux['fxs']).'</h2>';
        $response .= '<img src="data: image/jpeg;base64,'.base64_encode($aux['content']).'"><hr>';
        
        $fxs = $effectsManager->getEffects();       
        foreach ($fxs as $fx) {
            $response .= '<h2>'.$fx.'</h2>';
            $src = $effectsManager->applyEffect($fx,$content);
            if (isset($src['res']) && $src['res'] === false && isset($src['error'])) {           
                $response .= '<p style="color:red"><b>Error:</b> ';
                $response .= $src['error'];
                $response .= '</p>';
            }
            elseif (isset($src['content'])) {
                $response .= '<img src="data: image/jpeg;base64,'.base64_encode($src['content']).'">';
            }
            else {
                $response .= '<p style="color:red"><b>Unknown Error.</b></p>';
            }            
            $response .= '<hr>';
        }
        
        return new Response($response);
    }
}

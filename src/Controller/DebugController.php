<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Manager\EffectsManager;
/**
 * Description of DebugController
 *
 * @author msk
 */
class DebugController {
    public function index(EffectsManager $effectsManager) {
        $response = '';
        $uri = "http://www.indiewire.com/wp-content/uploads/2017/07/rick-and-morty.png";
        $aux_content = file_get_contents($uri);
        $ex = pathinfo($uri)['extension'];
        $path = uniqid().'.'.$ex;
        file_put_contents($path, $aux_content);
        $this->convertImage($path, $path.'.jpg', 100);
        $content = file_get_contents($path.'.jpg');
        $fxs = ['GlitchMutationsSoft','GlitchMutationsNormal','GlitchMutationsHard'];
        foreach ($fxs as $fx) {
            $response .= '<h2>'.$fx.'</h2>';
            $src = $effectsManager->applyEffect($fx,$content);
            if (isset($src['res']) && $src['res'] === false && isset($src['error'])) {           
                $response .= '<p style="color:red"><b>Error:</b> ';
                $response .= $src['error'];
                $response .= '</p>';
            }
            elseif (isset($src['content'])) {
                $response .= '<img src="data: image/jpeg;base64,'.$src['content'].'">';
            }
            else {
                $response .= '<p style="color:red"><b>Unknown Error.</b></p>';
            }            
            $response .= '<hr>';
        }
        return new Response($response);
    }
    
    public function convertImage($originalImage, $outputImage, $quality)
    {
        // jpg, png, gif or bmp?
        $exploded = explode('.',$originalImage);
        $ext = $exploded[count($exploded) - 1]; 

        if (preg_match('/jpg|jpeg/i',$ext))
            $imageTmp=imagecreatefromjpeg($originalImage);
        else if (preg_match('/png/i',$ext))
            $imageTmp=imagecreatefrompng($originalImage);
        else if (preg_match('/gif/i',$ext))
            $imageTmp=imagecreatefromgif($originalImage);
        else if (preg_match('/bmp/i',$ext))
            $imageTmp=imagecreatefrombmp($originalImage);
        else
            return 0;

        // quality is a value from 0 (worst) to 100 (best)
        imagejpeg($imageTmp, $outputImage, $quality);
        imagedestroy($imageTmp);

        return 1;
    }
}

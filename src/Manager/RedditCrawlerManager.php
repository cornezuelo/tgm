<?php

/*
 * The MIT License
 *
 * Copyright 2017 msk.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace App\Manager;

/**
 * Description of RedditCrawlerManager
 *
 * @author msk
 */
class RedditCrawlerManager {
    public function crawl() {
        $section = array("Astrophotography", "spaceporn", "earthporn", "StarshipPorn", "AuroraPorn", "SeaPorn", "DiamondPorn", "BeachPorn", "JunglePorn", "LakePorn", "ImaginaryLandscapes", "ImaginaryWildlands", "Astrophotography","videogamewallpapers");
        $r = rand(0, count($section)-1);
        $sectionchosen = $section[$r];
      
        $url="https://www.reddit.com/r/$sectionchosen/top.json?sort=top&t=month&count=100";
        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        //echo '<pre>';print_r(curl_getinfo($ch));print_r($result);die();
        // Closing
        curl_close($ch);

        // Get image
        $array = json_decode($result, true);
        $tries = 0;
        $rand = rand(0,24);
        while (!isset($array["data"]["children"][$rand]["data"]["url"])) {
                $rand = rand(0,24);
                $tries++;
                if ($tries >= 5) return $this->crawl();
        }
        $img = $array["data"]["children"][$rand]["data"]["url"];
        $content_original = @file_get_contents($img);
        if (empty($content_original)) {
            return $this->crawl();
        }        
        return ['uri' => $img, 'content' => $content_original];
    }
}

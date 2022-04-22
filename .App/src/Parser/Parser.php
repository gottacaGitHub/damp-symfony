<?php

namespace App\Parser;

use Symfony\Component\HttpFoundation\File\File;

class Parser
{
    private const CATALOG = "http://podtrade.ru/product/";
    private const SITE = "http://podtrade.ru";
    private const NUMBER = 66001;
    private const FILE_PATH = "/(\/upload\/)(.+)\.(jpg|png)/";
    private const FILE_NAME = "/([^\/][a-zA-Z0-9_-]+)(\.)(jpg|png)/";


    private string $name;

    private string $filename;

    private string $fullpath;

    public function create(int $i): bool
    {
        $upload = (dirname(__DIR__,2).'/public/images/');
        $link = self::NUMBER + $i;

        $response = $this->getContent($link);
        if ($response)
        {
            $title = $this->Parse((string)$response, '<div class="trigran__detail_mob_title"', '</div>');
            if (!$title)
            {
                return false;
            }

            $image = $this->Parse($response, '<img class="swiper-img"');
            if ($image) {
                $this->name = $title;
                $this->filename = $image;
                $file = file_get_contents(self::SITE.$this->getFullPath());
                file_put_contents($upload.$this->getFilename(),$file);
                return true;
            }
        }
        return false;
    }

    private function Parse(string $DOM, string $tag1, string $tag2 = '>')
    {
        $num1 = strpos($DOM, $tag1);
        if ($num1 === false) {
            return false;
        }
        $num2 = substr($DOM, $num1);
        if ($tag2 === '>') {
            $img = substr($num2, 0, strpos($num2, $tag2));
            if (preg_match(self::FILE_PATH, $img, $m))
            {
                $this->fullpath = $m[0];
                if (preg_match(self::FILE_NAME, $m[0], $matches))
                {
                    return $matches[0];
                }
            }
            return false;

        }
        return strip_tags(substr($num2, 0, strpos($num2, $tag2)));
    }

    private function getContent(string $link, bool $upload = false)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_URL, self::CATALOG.$link);
        curl_setopt($ch, CURLOPT_REFERER, self::SITE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;

    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    private function getFullPath():string
    {
        return $this->fullpath;
    }

}
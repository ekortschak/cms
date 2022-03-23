<?php

/**
 * TextToImage class
 * This class converts text to image
 *
 * @author    CodexWorld Dev Team
 * @link    http://www.codexworld.com
 * @license    http://www.codexworld.com/license/
 */
class TextToImage {
    private $img;

    /**
     * Create image from text
     * @param string text to convert into image
     * @param int font size of text
     * @param int width of the image
     * @param int height of the image
     */
    function createImage($text, $fontSize = 20, $imgWidth = 400, $imgHeight = 80){

        //text font path
        $font = 'fonts/the_unseen.ttf';

        //create the image
        $this->img = imagecreatetruecolor($imgWidth, $imgHeight);

        //create some colors
        $white = imagecolorallocate($this->img, 255, 255, 255);
        $grey  = imagecolorallocate($this->img, 128, 128, 128);
        $black = imagecolorallocate($this->img, 0, 0, 0);
        imagefilledrectangle($this->img, 0, 0, $imgWidth - 1, $imgHeight - 1, $white);

        //break lines
        $splitText = explode ( "\\n" , $text );
        $lines = count($splitText);

        foreach($splitText as $txt){
            $textBox = imagettfbbox($fontSize,$angle,$font,$txt);
            $textWidth = abs(max($textBox[2], $textBox[4]));
            $textHeight = abs(max($textBox[5], $textBox[7]));
            $x = (imagesx($this->img) - $textWidth)/2;
            $y = ((imagesy($this->img) + $textHeight)/2)-($lines-2)*$textHeight;
            $lines = $lines-1;

            //add some shadow to the text
            imagettftext($this->img, $fontSize, $angle, $x, $y, $grey, $font, $txt);

            //add the text
            imagettftext($this->img, $fontSize, $angle, $x, $y, $black, $font, $txt);
        }
	return true;
    }

    /**
     * Display image
     */
    function showImage(){
        header('Content-Type: image/png');
        return imagepng($this->img);
    }

    /**
     * Save image as png format
     * @param string file name to save
     * @param string location to save image file
     */
    function saveAsPng($fileName = 'text-image', $location = ''){
        $fileName = $fileName.".png";
        $fileName = !empty($location)?$location.$fileName:$fileName;
        return imagepng($this->img, $fileName);
    }

    /**
     * Save image as jpg format
     * @param string file name to save
     * @param string location to save image file
     */
    function saveAsJpg($fileName = 'text-image', $location = ''){
        $fileName = $fileName.".jpg";
        $fileName = !empty($location)?$location.$fileName:$fileName;
        return imagejpeg($this->img, $fileName);
    }
}

<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Dtos;

use JuanchoSL\ImageTools\Dtos\Color;

class WaterMark extends EmptyImage
{
    protected string $text = '';
    //protected string $font = __DIR__ . DIRECTORY_SEPARATOR.'..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'ididthis.ttf';
    protected float $angle = 0;
    protected Color $text_color;
    public function setColor(Color $color): static
    {
        $this->text_color = $color;
        return $this;
    }
    public function setText(string $text): static
    {
        $this->text = $text;
        return $this;
    }
    public function setAngle(float $angle): static
    {
        $this->angle = $angle;
        return $this;
    }
    public function __invoke(): mixed
    {
        $this->image = parent::__invoke();
        $new_color = imagecolorallocate(
            $this->image,
            intval((string) $this->text_color->getRed()),
            intval((string) $this->text_color->getGreen()),
            intval((string) $this->text_color->getBlue())
        );
        //$top = (isset($this->top)) ? $this->top : ($height / 2);
        //echo "<pre>" . print_r(__DIR__, true);exit;
        //$this->font = realpath($this->font);
        if (isset($this->font) && file_exists($this->font)) {
            $font = imageloadfont($this->font);
            echo "<pre>" . print_r($font, true);exit;
            //	$top += $this->fontSize;
            $width = imagefontwidth($font);
            $height = imagefontheight($font);
            echo $width;
            exit;
            imagettftext($this->image, $this->fontSize, $this->angle, $this->left, $top, $color, $this->font, $this->text);
        } else {
            //$font_size = intval($this->getWidth() / strlen($this->text));
            //imagestring($this->image, $font_size / 3, 10, intval($this->getHeight() / 2) - $font_size, $this->text, $new_color);
            $font_size = 5;
            imagestring($this->image, $font_size, 0, 0, $this->text, $new_color);
            //$this->image = imagerotate($this->image, $this->angle, 125);
        }
        return $this->image;
    }
}
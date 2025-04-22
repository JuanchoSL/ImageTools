<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Dtos;

use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\Engines\GifImage;

class TextLabel extends EmptyImage
{
    protected ?string $font = null;
    protected string $text = '';
    protected float $angle = 0;
    protected int $size = 5;
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
        $new_color = imagecolorallocatealpha(
            $this->image,
            intval((string) $this->text_color->getRed()),
            intval((string) $this->text_color->getGreen()),
            intval((string) $this->text_color->getBlue()),
            intval((string) $this->text_color->getAlpha())
        );

        if (is_null($this->font)) {

            imagestring(
                $this->image,
                $this->size,
                0,
                0,
                $this->text,
                $new_color
            );
        } else {

            $caja_texto = imagettfbbox($this->size, 0, $this->font, $this->text);
            imagettftext(
                $this->image,
                $this->size,
                0,
                0,
                0,
                $new_color,
                $this->font,
                $this->text
            );
        }



        /*
                $new_color = imagecolorallocate(
                    $this->image,
                    intval((string) $this->text_color->getRed()),
                    intval((string) $this->text_color->getGreen()),
                    intval((string) $this->text_color->getBlue())
                );
                //$top = (isset($this->top)) ? $this->top : ($height / 2);
                if (isset($this->font) && file_exists($this->font)) {
                    //	$top += $this->fontSize;
                    //	imagettftext($this->image, $this->fontSize, $this->angle, $this->left, $top, $color, $this->font, $this->text);
                } else {
                    //$font_size = intval($this->getWidth() / strlen($this->text));
                    //imagestring($this->image, $font_size / 3, 10, intval($this->getHeight() / 2) - $font_size, $this->text, $new_color);
                    $font_size = 4;
                    imagestring($this->image, $font_size, 0, 0, $this->text, $new_color);
                    //imagestring($this->image, $font_size, 0, 0, $this->text, $this->colorTransparencia);
                    //$this->image = imagerotate($this->image, $this->angle, $this->colorTransparencia);
                }
                return $this->image = imagecropauto($this->image, IMG_CROP_SIDES);
                //return $this->image = imagecropauto($this->image, IMG_CROP_TRANSPARENT);
                //return $this->image = imagecropauto($this->image, IMG_CROP_THRESHOLD,0.5, $new_color);
                return $image = imagecropauto($this->image, IMG_CROP_THRESHOLD, 0.5, $this->colorTransparencia);
                if (false) {
                    echo $height = imagesy($image);
                    exit;
                    echo $width = imagesx($image);
                    exit;
                }
                return imagecrop($this->image, ['x' => 0, 'y' => 0, 'width' => imagesx($image), 'height' => imagesy($image) + 5]);
                */
        return $this->image;
    }
}
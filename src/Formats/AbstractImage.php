<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Formats;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ApplicableInterface;
use JuanchoSL\ImageTools\Contracts\EditableInterface;
use JuanchoSL\ImageTools\Contracts\InvokableInterface;
use JuanchoSL\ImageTools\Contracts\ReadableInterface;
use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Elements\Line;
use JuanchoSL\ImageTools\Dtos\Size;
use JuanchoSL\ImageTools\Traits\PositionerTrait;
use JuanchoSL\ImageTools\ValueObjects\ColorLevel;

abstract class AbstractImage implements EditableInterface, ReadableInterface, InvokableInterface
{

    use PositionerTrait;

    const int START = 0;
    const int END = -1;
    const ?int CENTER = null;
    protected $resource;
    protected $modified;

    public function __construct($resource = null)
    {
        if (!is_null($resource)) {
            $this->load($resource);
        }
    }

    public function load($resource)
    {
        $this->resource = $resource;
        $this->reset();
    }

    public function reset(): void
    {
        $this->modified = $this->resource;
    }

    public function getWidth(): int
    {
        return imagesx($this->modified);
    }

    public function getHeight(): int
    {
        return imagesy($this->modified);
    }

    public function add(ApplicableInterface $applyer)
    {
        $this->load($applyer->apply($this));
    }
    /*
    public function addTextWithFont(string $text, Color $color, ?string $font_path = null, ?int $x = null, ?int $y = null)
    {
        $font_path ??= __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'ididthis.ttf';

        $new_color = imagecolorallocatealpha(
            $this->modified,
            intval((string) $color->getRed()),
            intval((string) $color->getGreen()),
            intval((string) $color->getBlue()),
            intval((string) $color->getAlpha())
        );
        $font_size = 18;
        $caja_texto = imagettfbbox($font_size, 0, $font_path, $text);
        imagettftext(
            $this->modified,
            $font_size,
            0,
            $this->calculateStartPosition($this->getWidth(), $caja_texto[0] + $caja_texto[2], $x),
            $this->calculateStartPosition($this->getHeight(), $caja_texto[3] + $caja_texto[7], $y),
            $new_color,
            $font_path,
            $text
        );
    }
    public function addText(string $text, Color $color, ?int $x = null, ?int $y = null)
    {
        $new_color = imagecolorallocatealpha(
            $this->modified,
            intval((string) $color->getRed()),
            intval((string) $color->getGreen()),
            intval((string) $color->getBlue()),
            intval((string) $color->getAlpha())
        );
        $font_size = 5;
        imagestring(
            $this->modified,
            $font_size,
            $this->calculateStartPosition($this->getWidth(), strlen($text) * ($font_size * 2), $x),
            $this->calculateStartPosition($this->getHeight(), $font_size * 3, $y),
            $text,
            $new_color
        );
    }
    public function addLabel(Text $text, ?int $x = null, ?int $y = null)
    {
        $new_color = imagecolorallocatealpha(
            $this->modified,
            intval((string) $text->getColor()->getRed()),
            intval((string) $text->getColor()->getGreen()),
            intval((string) $text->getColor()->getBlue()),
            intval((string) $text->getColor()->getAlpha())
        );
        $font_size = $text->getSize();
        if (is_null($text->getFont())) {
            $font_size = min(5, $text->getSize());
            //$this->addText($text->getText(), $text->getColor(), $x, $y);
            imagestring(
                $this->modified,
                $font_size,
                $this->calculateStartPosition($this->getWidth(), strlen($text->getText()) * ($font_size * 2), $x),
                $this->calculateStartPosition($this->getHeight(), $font_size * 3, $y),
                $text->getText(),
                $new_color
            );
        } else {
            //$this->addTextWithFont($text->getText(), $text->getColor(), $text->getFont(), $x, $y);
            $caja_texto = imagettfbbox($font_size, 0, $text->getFont(), $text->getText());
            //echo "<pre>" . print_r($caja_texto, true);exit;
            imagettftext(
                $this->modified,
                $font_size,
                0,
                $this->calculateStartPosition($this->getWidth(), $caja_texto[0] + $caja_texto[2], $x),// + (is_int($x) && $x < 0 ? $caja_texto[2] : $caja_texto[0]),
                $this->calculateStartPosition($this->getHeight(), $caja_texto[3] + $caja_texto[7], $y),// + (is_int($y) && $y < 0 ? $caja_texto[7] : $caja_texto[7]),
                $new_color,
                $text->getFont(),
                $text->getText()
            );
        }
    }

    public function addImageWithOpaticy(AbstractImage $estampa, int $opacity = 50, ?int $x = 0, ?int $y = 0)
    {
        $opacity = min($opacity, 100);
        imagecopymerge(
            $this->modified,
            $estampa(),
            $this->calculateStartPosition($this->getWidth(), $estampa->getWidth(), $x),
            $this->calculateStartPosition($this->getHeight(), $estampa->getHeight(), $y),
            0,
            0,
            $estampa->getWidth(),
            $estampa->getHeight(),
            $opacity
        );
    }
*/

    public function addImage(AbstractImage $estampa, ?int $x = 0, ?int $y = 0)
    {
        imagecopy(
            $this->modified,
            $estampa(),
            $this->calculateStartPosition($this->getWidth(), $estampa->getWidth(), $x),
            $this->calculateStartPosition($this->getHeight(), $estampa->getHeight(), $y),
            0,
            0,
            $estampa->getWidth(),
            $estampa->getHeight(),
        );
    }
    public function crop(Size $size, ?int $x = null, ?int $y = null)
    {
        $this->modified = imagecrop($this->modified, [
            'x' => $this->calculateStartPosition($this->getWidth(), $size->getWidth(), $x),
            'y' => $this->calculateStartPosition($this->getHeight(), $size->getHeight(), $y),
            'width' => $size->getWidth(),
            'height' => $size->getHeight()
        ]);
        //$this->modified = imagecropauto($this->modified, IMG_CROP_TRANSPARENT);
    }
    public function cropauto()
    {
        $this->modified = imagecropauto($this->modified, IMG_CROP_TRANSPARENT);
    }

    public function resize(?int $width = null, ?int $height = null)
    {
        if ($width > $this->getWidth()) {
            $height ??= -1;
            $modified = imagescale($this->modified, $width, $height);
        } else {
            if (!empty($width) && $width < $this->getWidth()) {
                //return $this->modified = imagescale($this->modified, $width);//mala calidada
                $height = $this->getWidth() / $width;
                $height = ceil($this->getHeight() / $height);
                //return imageresolution($this->modified, intval($width), intval($height));//no reescala
            }
            $width = intval($width);
            $height = intval($height);
            $modified = imagecreatetruecolor($width, $height);
            //imagecopyresized($modified, $this->modified, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
            imagecopyresampled($modified, $this->modified, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());//mejor calidad
        }
        $this->modified = $modified;
    }

    public function grey()
    {
        imagecopymergegray($this->modified, $this->modified, 0, 0, 0, 0, $this->getWidth(), $this->getHeight(), 0);
    }

    public function noise($cantidad = 5, $rango = 'y')
    {
        $x = $this->getWidth();
        $y = $this->getHeight();
        for ($i = 0; $i < $cantidad; $i++) {
            //$color = imagecolorallocate($this->modified, rand(64, 192), rand(64, 192), rand(64, 192));
            if ($rango == 'y') {
                $linea = rand(0, $x);
                $start = (new Coordinates)->setX($linea)->setY(0);
                $end = (new Coordinates)->setX($linea + rand(-10, 10))->setY($y);
                //imageline($this->modified, $linea, 0, $linea + rand(-10, 10), $y, $color);
            } else {
                $linea = rand(0, $y);
                $start = (new Coordinates)->setX(0)->setY($linea);
                $end = (new Coordinates)->setX($x)->setY($linea + rand(-10, 10));
                //imageline($this->modified, 0, $linea, $x, $linea + rand(-10, 10), $color);
            }
            $add = (new Line)
                ->setColor(
                    (new Color)
                        ->setRed(new ColorLevel(rand(64, 192)))
                        ->setGreen(new ColorLevel(rand(64, 192)))
                        ->setBlue(new ColorLevel(rand(64, 192)))
                )
                ->setStartCoordinates($start)
                ->setEndCoordinates($end)
            ;
            $this->add($add);
        }
    }

    public function invert()
    {
        imageflip($this->modified, IMG_FLIP_VERTICAL);
    }
    public function mirror()
    {
        imageflip($this->modified, IMG_FLIP_HORIZONTAL);
    }

    public function rotate(float $angle, Color $background_color)
    {
        $background_color = imagecolorallocatealpha(
            $this->modified,
            intval((string) $background_color->getRed()),
            intval((string) $background_color->getGreen()),
            intval((string) $background_color->getBlue()),
            intval((string) $background_color->getAlpha())
        );
        $this->modified = imagerotate($this->modified, $angle, $background_color);
    }

    public function __destruct()
    {
        imagedestroy($this->modified);
        imagedestroy($this->resource);
    }

    public function __tostring(): string
    {
        $filepath = tempnam(sys_get_temp_dir(), 'img');
        $this->save($filepath);
        $data = file_get_contents($filepath);
        unlink($filepath);
        return $data;
    }

    public function __invoke(): GdImage
    {
        return $this->modified;
    }

}
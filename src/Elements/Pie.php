<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Elements;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ApplicableInterface;
use JuanchoSL\ImageTools\Contracts\EditableInterface;
use JuanchoSL\ImageTools\Contracts\Invokable;
use JuanchoSL\ImageTools\Contracts\InvokableInterface;
use JuanchoSL\ImageTools\Contracts\ReadableInterface;
use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Dtos\Size;
use JuanchoSL\ImageTools\Traits\PositionerTrait;
use JuanchoSL\ImageTools\ValueObjects\TransparencyLevel;

class Pie implements ApplicableInterface
{

    use PositionerTrait;

    protected Color $text_color;
    protected Coordinates $start;
    protected Size $size;
    protected int $degrees;

    public function setColor(Color $color): static
    {
        $this->text_color = $color;
        return $this;
    }

    public function getColor(): Color
    {
        return $this->text_color;
    }

    public function setStartCoordinates(Coordinates $start): static
    {
        $this->start = $start;
        return $this;
    }
    public function setSize(Size $size): static
    {
        $this->size = $size;
        return $this;
    }

    public function setDegrees(int $degrees): static
    {
        $this->degrees = $degrees;
        return $this;
    }
    public function getDegrees(): int
    {
        return $this->degrees;
    }
    public function apply(InvokableInterface $image): GdImage
    {
        $imager = $image();
        $color = $this->getColor();
/*  
        if (is_null($this->getColor()->getAlpha())) {
            $type = IMG_ARC_NOFILL; //without body
            //$type=IMG_ARC_PIE;
        } elseif (intval((string) $this->getColor()->getAlpha()) == 0) {
            $type = IMG_ARC_EDGED;
        } elseif (intval((string) $this->getColor()->getAlpha()) == 127) {
            //$type = IMG_ARC_EDGED;
            $color->setAlpha(new TransparencyLevel(0));
            $type = IMG_ARC_CHORD;
        } else {
            $type = IMG_ARC_PIE;
            
        }
        $type = IMG_ARC_ROUNDED;
*/
        $color = $color($image);
        imagefilledarc($imager, $this->start->getX(), $this->start->getY(), $this->size->getWidth(), $this->size->getHeight(), 0, $this->degrees, $color, IMG_ARC_PIE);
        //imagearc($imager, $this->start->getX(), $this->start->getY(), $this->size->getWidth(), $this->size->getHeight(),0,$this->degrees, $color);
        return $imager;
    }
}
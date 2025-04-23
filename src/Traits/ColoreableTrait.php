<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Traits;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ColorInterface;

trait ColoreableTrait
{

    protected ColorInterface $text_color;

    public function setColor(ColorInterface $color): static
    {
        $this->text_color = $color;
        return $this;
    }

    public function getColor(): ColorInterface
    {
        return $this->text_color;
    }

    protected function applyColor(GdImage $imager)
    {
        //$imager = $image();
        if (is_null($this->getColor()->getAlpha())) {
            return imagecolorallocate(
                $imager,
                intval((string) $this->getColor()->getRed()),
                intval((string) $this->getColor()->getGreen()),
                intval((string) $this->getColor()->getBlue())
            );
        }
        return imagecolorallocatealpha(
            $imager,
            intval((string) $this->getColor()->getRed()),
            intval((string) $this->getColor()->getGreen()),
            intval((string) $this->getColor()->getBlue()),
            intval((string) $this->getColor()->getAlpha())
        );
    }
}
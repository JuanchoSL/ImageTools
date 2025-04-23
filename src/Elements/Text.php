<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Elements;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ApplicableInterface;
use JuanchoSL\ImageTools\Contracts\ColoreableInterface;
use JuanchoSL\ImageTools\Contracts\InvokableInterface;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Traits\ColoreableTrait;
use JuanchoSL\ImageTools\Traits\PositionerTrait;

class Text implements ApplicableInterface, ColoreableInterface
{
    use ColoreableTrait, PositionerTrait;

    protected ?string $font = null;
    protected string $text = '';
    protected int $size = 5;
    protected ?Coordinates $start = null;

    public function setText(string $text): static
    {
        $this->text = $text;
        return $this;
    }
    public function setFont(string $font): static
    {
        $this->font = $font;
        return $this;
    }
    public function setSize(int $size): static
    {
        $this->size = $size;
        return $this;
    }
    public function setStartCoordinates(Coordinates $start): static
    {
        $this->start = $start;
        return $this;
    }
    public function getText(): string
    {
        return $this->text;
    }
    public function getSize(): int
    {
        return $this->size;
    }
    public function getFont(): ?string
    {
        return $this->font;
    }

    public function apply(InvokableInterface $image): GdImage
    {
        $imager = $image();

        $color = $this->getColor();
        //$new_color = $color($image);
        $new_color = $this->applyColor($image());
        $font_size = $this->getSize();
        if (is_null($this->getFont())) {

            $font_size = min(5, $this->getSize());
            imagestring(
                $imager,
                $font_size,
                $this->calculateStartPosition($image->getWidth(), strlen($this->getText()) * ($font_size * 2), $this->start?->getX()),
                $this->calculateStartPosition($image->getHeight(), $font_size * 3, $this->start?->getY()),
                $this->getText(),
                $new_color
            );
        } else {

            $caja_texto = imagettfbbox($font_size, 0, $this->getFont(), $this->getText());
            imagettftext(
                $imager,
                $font_size,
                0,
                $this->calculateStartPosition($image->getWidth(), $caja_texto[0] + $caja_texto[2], $this->start?->getX()),
                $this->calculateStartPosition($image->getHeight(), $caja_texto[3] + $caja_texto[7], $this->start?->getY()),
                $new_color,
                $this->getFont(),
                $this->getText()
            );
        }
        return $imager;
    }
}
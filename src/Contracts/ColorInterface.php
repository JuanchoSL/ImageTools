<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Contracts;

use JuanchoSL\ImageTools\ValueObjects\ColorLevel;
use JuanchoSL\ImageTools\ValueObjects\TransparencyLevel;

interface ColorInterface
{

    public function setRed(ColorLevel $level): static;
    public function setGreen(ColorLevel $level): static;
    public function setBlue(ColorLevel $level): static;
    public function setAlpha(TransparencyLevel $alpha): static;
    public function getRed(): ColorLevel;
    public function getGreen(): ColorLevel;
    public function getBlue(): ColorLevel;
    public function getAlpha(): ?TransparencyLevel;
}
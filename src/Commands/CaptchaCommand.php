<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Commands;

use JuanchoSL\HttpData\Factories\StreamFactory;
use JuanchoSL\ImageTools\Elements\Arc;
use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Dtos\EmptyImage;
use JuanchoSL\ImageTools\Dtos\Size;
use JuanchoSL\ImageTools\Dtos\SolidImage;
use JuanchoSL\ImageTools\Elements\Polygon;
use JuanchoSL\ImageTools\Elements\Rectangle;
use JuanchoSL\ImageTools\Elements\Square;
use JuanchoSL\ImageTools\Elements\Text;
use JuanchoSL\ImageTools\Dtos\TextLabel;
use JuanchoSL\ImageTools\Formats\AbstractImage;
use JuanchoSL\ImageTools\Formats\PngImage;
use JuanchoSL\ImageTools\Formats\StringImage;
use JuanchoSL\ImageTools\Formats\WebpImage;
use JuanchoSL\ImageTools\ImageToolsFactory;
use JuanchoSL\ImageTools\ValueObjects\ColorLevel;
use JuanchoSL\ImageTools\ValueObjects\TransparencyLevel;
use JuanchoSL\RequestListener\Enums\InputArgument;
use JuanchoSL\RequestListener\Enums\InputOption;
use JuanchoSL\RequestListener\UseCases;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CaptchaCommand extends UseCases
{
    public function configure(): void
    {
        //        $this->addArgument('width', InputArgument::REQUIRED, InputOption::SINGLE);
//        $this->addArgument('height', InputArgument::REQUIRED, InputOption::SINGLE);
//        $this->addArgument('mark', InputArgument::REQUIRED, InputOption::SINGLE);

    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $bg = (new Color)
            ->setRed(new ColorLevel(rand(224, 255)))
            ->setGreen(new ColorLevel(rand(224, 255)))
            ->setBlue(new ColorLevel(rand(224, 255)));

        $size = (new Size)->setWidth(150)->setHeight(90);
        $image = new SolidImage;
        $image->setSize($size)->setBgColor($bg);

        $captcha = new PngImage($image());
        $color = (new Color)
            ->setRed(new ColorLevel(rand(80, 127)))
            ->setGreen(new ColorLevel(rand(80, 127)))
            ->setBlue(new ColorLevel(rand(80, 127)))
            ->setAlpha(new TransparencyLevel(64))
        ;
        $label = (new Text)
            ->setColor($color)
            ->setText($request->getAttribute('mark', $this->autoKey(7, 8)))
            ->setSize(18)
            ->setFont(implode(DIRECTORY_SEPARATOR, [dirname(__FILE__, 3), 'assets', 'fonts', 'ididthis.ttf']))
            //->setStartCoordinates(new Coordinates)
        ;
        $captcha->add($label);
        $captcha->noise(intval(140 / 15), 'x');
        $captcha->noise(intval(90 / 15), 'y');
        $captcha->rotate(rand(-30, 30), $bg);
        $captcha->crop($size);

        $imagen = (new StreamFactory)->createStream((string) $captcha);
        return $response->withHeader('content-type', $captcha->getMimetype())->withHeader('content-length', (string) $imagen->getSize())->withBody($imagen);
    }

    private function autoKey($minimo, $maximo)
    {
        $clave = "";
        $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ1234567890";
        for ($i = 0; $i < mt_rand($minimo, $maximo); $i++) {
            $clave .= $caracteres[mt_rand(0, strlen($caracteres) - 1)];
        }
        return $clave;
    }
}
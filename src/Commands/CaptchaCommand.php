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
use JuanchoSL\ImageTools\Engines\AbstractImage;
use JuanchoSL\ImageTools\Engines\PngImage;
use JuanchoSL\ImageTools\Engines\StringImage;
use JuanchoSL\ImageTools\Engines\WebpImage;
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
        /*
        $image = new TextLabel(200, 150);
        $image->setBgColor((new Color)->setRed(new ColorLevel(rand(0, 80)))->setGreen(new ColorLevel(rand(0, 80)))->setBlue(new ColorLevel(rand(0, 80))));
        $image->setColor((new Color)->setRed(new ColorLevel(rand(0, 80)))->setGreen(new ColorLevel(rand(0, 80)))->setBlue(new ColorLevel(rand(0, 80))));
        $image->setText('juancho');
        //$image->setAngle(rand(-25, 25));
*/
        $bg = (new Color)
            ->setRed(new ColorLevel(rand(224, 255)))
            ->setGreen(new ColorLevel(rand(224, 255)))
            ->setBlue(new ColorLevel(rand(224, 255)));

        $size = (new Size)->setWidth(150)->setHeight(90);
        $image = new SolidImage($size);
        $image->setBgColor($bg);

        $captcha = new PngImage($image());
        $color = (new Color)
            ->setRed(new ColorLevel(rand(80, 127)))
            ->setGreen(new ColorLevel(rand(80, 127)))
            ->setBlue(new ColorLevel(rand(80, 127)))
            ->setAlpha(new TransparencyLevel(64))
        ;
        if (true) {
            $label = (new Text)
                ->setColor($color)
                ->setText($request->getAttribute('mark', $this->autoKey(7, 8)))
                ->setSize(18)
                ->setFont(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'ididthis.ttf')
                //->setStartCoordinates(new Coordinates)
            ;
            $captcha->add($label);
            $captcha->noise(intval(140 / 15), 'x');
            $captcha->noise(intval(90 / 15), 'y');
            $captcha->rotate(rand(-30, 30), $bg);
            $captcha->crop($size);
        } else {

            $pcolor = (new Color)
                ->setRed(new ColorLevel(rand(80, 127)))
                ->setGreen(new ColorLevel(rand(80, 127)))
                ->setBlue(new ColorLevel(rand(80, 127)))
                ->setAlpha(new TransparencyLevel(64))
            ;
            /*$polygon = (new Polygon)->setColor($pcolor)->setCoordinates(
                (new Coordinates)->setX(75)->setY(10),
                (new Coordinates)->setX(91)->setY(23),
                (new Coordinates)->setX(84)->setY(40),
                (new Coordinates)->setX(66)->setY(40),
                (new Coordinates)->setX(59)->setY(23),
            );*/
            //$polygon = (new Square)->setColor($pcolor)->setStartCoordinates((new Coordinates)->setX(20)->setY(10))->setSize(50);
            $polygon = (new Arc)->setColor($pcolor)->setDegrees(240)->setSize((new Size)->setWidth(80)->setHeight(40))->setStartCoordinates((new Coordinates)->setX(80)->setY(40));
            $captcha->add($polygon);

        }

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
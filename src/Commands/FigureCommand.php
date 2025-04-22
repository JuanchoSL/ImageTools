<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Commands;

use JuanchoSL\HttpData\Factories\StreamFactory;
use JuanchoSL\ImageTools\Elements\Arc;
use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Dtos\EmptyImage;
use JuanchoSL\ImageTools\Dtos\Size;
use JuanchoSL\ImageTools\Dtos\SolidImage;
use JuanchoSL\ImageTools\Elements\Cercle;
use JuanchoSL\ImageTools\Elements\Ellipse;
use JuanchoSL\ImageTools\Elements\Line;
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

class FigureCommand extends UseCases
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
            ->setRed(new ColorLevel(255))
            ->setGreen(new ColorLevel(255))
            ->setBlue(new ColorLevel(255));

        $size = (new Size)->setWidth(150)->setHeight(90);
        $image = new SolidImage;
        $image->setSize($size)->setBgColor($bg);

        $captcha = new PngImage($image());
        $color = (new Color)
            ->setRed(new ColorLevel(0))
            ->setGreen(new ColorLevel(0))
            ->setBlue(new ColorLevel(0))
            ->setAlpha(new TransparencyLevel(0))
        ;

        switch (strtolower($request->getAttribute('figure'))) {
            default:
            case 'line':
                $polygon = (new Line)->setColor($color)
                    ->setStartCoordinates((new Coordinates)->setX(15)->setY(25))
                    ->setEndCoordinates((new Coordinates)->setX(105)->setY(65));
                break;
            case 'cercle':
                $polygon = (new Cercle)->setColor($color)->setStartCoordinates((new Coordinates)->setX(75)->setY(45))->setSize(50);
                break;
            case 'ellipse':
                $polygon = (new Ellipse)->setColor($color)->setStartCoordinates((new Coordinates)->setX(75)->setY(45))->setSize((new Size)->setWidth(100)->setHeight(50));
                break;
            case 'square':
                $polygon = (new Square)->setColor($color)->setStartCoordinates((new Coordinates)->setX(20)->setY(10))->setSize(50);
                break;
            case 'rectangle':
                $polygon = (new Rectangle)->setColor($color)->setStartCoordinates((new Coordinates)->setX(20)->setY(10))->setSize((new Size)->setWidth(100)->setHeight(50));
                break;
            case 'polygon':
                $polygon = (new Polygon)->setColor($color)->setCoordinates(
                    (new Coordinates)->setX(75)->setY(10),
                    (new Coordinates)->setX(91)->setY(23),
                    (new Coordinates)->setX(84)->setY(40),
                    (new Coordinates)->setX(66)->setY(40),
                    (new Coordinates)->setX(59)->setY(23),
                );
                break;
        }

        $captcha->add($polygon);
        $path = implode(DIRECTORY_SEPARATOR, [dirname(__FILE__, 3), 'assets', 'images', strtolower($request->getAttribute('figure'))]);
        if (!file_exists($path)) {
            $captcha->save($path);
        }
        $imagen = (new StreamFactory)->createStream((string) $captcha);
        return $response->withHeader('content-type', $captcha->getMimetype())->withHeader('content-length', (string) $imagen->getSize())->withBody($imagen);
    }

}
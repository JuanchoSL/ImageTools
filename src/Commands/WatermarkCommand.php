<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Commands;

use JuanchoSL\HttpData\Factories\StreamFactory;
use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\Dtos\Text;
use JuanchoSL\ImageTools\Dtos\TextLabel;
use JuanchoSL\ImageTools\Engines\PngImage;
use JuanchoSL\ImageTools\Engines\StringImage;
use JuanchoSL\ImageTools\ImageToolsFactory;
use JuanchoSL\ImageTools\ValueObjects\ColorLevel;
use JuanchoSL\ImageTools\ValueObjects\TransparencyLevel;
use JuanchoSL\RequestListener\Enums\InputArgument;
use JuanchoSL\RequestListener\Enums\InputOption;
use JuanchoSL\RequestListener\UseCases;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WatermarkCommand extends UseCases
{
    public function configure(): void
    {
        //$this->addArgument('origin');
        $this->addArgument('format', InputArgument::REQUIRED, InputOption::SINGLE);
        $this->addArgument('size', InputArgument::REQUIRED, InputOption::SINGLE);
        $this->addArgument('mark', InputArgument::OPTIONAL, InputOption::SINGLE);
        $this->addArgument('grey', InputArgument::OPTIONAL, InputOption::VOID);

    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $file = (PHP_SAPI == 'CLI') ? $request->getBody() : $request->getUploadedFiles()['myfile'];
        $factory = new ImageToolsFactory;
        $destiny = $factory->createByExtension($request->getAttribute('format'));
        $image = new $destiny(StringImage::read((string) $file->getStream()));
        if ($request->getAttribute('size', 0) > 0) {
            $image->resize(intval($request->getAttribute('size')));
        }
        if (!empty($request->getAttribute('mark'))) {
            $color = (new Color)
                ->setRed(new ColorLevel())
                ->setGreen(new ColorLevel())
                ->setBlue(new ColorLevel())
                ->setAlpha(
                    new TransparencyLevel(64)
                );
            $label = (new Text)
                ->setColor($color)
                ->setText($request->getAttribute('mark'))
                //->setFont(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'ididthis.ttf')
                ->setSize(5);
            $image->add($label);
        }
        if (!empty($request->getAttribute('grey'))) {
            $image->grey();
        }

        if (!empty($request->getAttribute('noise'))) {
            $image->noise(20, 'x');
            $image->noise(15, 'y');
        }
        $filename = pathinfo($file->getClientFilename(), PATHINFO_FILENAME) . '-' . $request->getAttribute('size') . '.' . $image->getExtension();
        $imagen = (new StreamFactory)->createStream((string) $image);
        return $response->withHeader('content-type', $image->getMimetype())->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')->withHeader('content-length', (string) $imagen->getSize())->withBody($imagen);
    }
}
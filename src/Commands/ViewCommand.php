<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Commands;

use JuanchoSL\HttpData\Factories\StreamFactory;
use JuanchoSL\RequestListener\UseCases;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ViewCommand extends UseCases
{
    public function configure(): void
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {


        $image = <<<'EOH'
<!DOCTYPE html>
<html>
<body>

<h1>File upload</h1>

<p>Show a file-select field which allows a file to be chosen for upload:</p>
<form action="/convert" method="post" enctype="multipart/form-data">
  <label for="format">Select a final format:</label>
  <select id="format" name="format">
  <option value="PNG">PNG</option>
  <option value="JPG">JPG</option>
  <option value="WEBP">WEBP</option>
  <option value="AVIF">AVIF</option>
  </select>
  <br/>
  <label for="mark">Select a mark label:</label>
  <input type="text" id="mark" name="mark" value=""><br><br>
  <label for="size">Select a new width:</label>
  <input type="number" id="size" name="size" value="500"><br><br>
  <label for="grey">Remove colors:</label>
  <input type="checkbox" id="grey" name="grey" value="1"><br><br>
  <label for="noise">Apply noise lines:</label>
  <input type="checkbox" id="noise" name="noise" value="1"><br><br>
  <label for="myfile">Select a original file:</label>
  <input type="file" id="myfile" name="myfile"><br><br>
  <input type="submit" value="Submit">
</form>

</body>
</html>
EOH;
        return $response->withBody((new StreamFactory)->createStream($image));
    }
}
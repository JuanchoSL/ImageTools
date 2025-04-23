# ImageTools

## Description

Little methods collection for create, modify convert and manipulate images, graphics, texts, watermarks and logos

## Install

```bash
composer require juanchosl/imagetools
```

## How to use

### Create a Solid image

IF we needs to create a new image, can be created without format, and use an invokable system for generate the GDImage object previously to be modified or saved

```php
//Create a black color
$bg = (new Color)
    ->setRed(new ColorLevel(0))
    ->setGreen(new ColorLevel(0))
    ->setBlue(new ColorLevel(0))
;

//Define an Image size
$size = (new Size)->setWidth(150)->setHeight(90);

//Create Image and apply the created values
$image = new SolidImage;
$image->setSize($size)->setColor($color);
```

### Open an image for edit

#### Readed or sended image

```php
$new_image = StringImage::read((string) $file->getStream())
```

#### Existing image

```php
$new_image = ImageToolFactory::open($file_path_of_the_image);
```

#### Created image

```php
$new_image = new PngImage($image());
```

### Add elements to oppened image

#### Create and add a text over an oppened image with a custom color (0-255)

```php
$color = (new Color)->setRed(new ColorLevel(125))->setGreen(new ColorLevel(30))->setBlue(new ColorLevel(10));
$label = (new Text)->setColor($color)->setText("This is a text")->setSize(5);
$new_image->add($label);
```

![Text](https://github.com/JuanchoSL/ImageTools/blob/master/assets/images/text.png?raw=true "Text")

#### Text with true type fonts

```php
$color = (new Color)->setRed(new ColorLevel(125))->setGreen(new ColorLevel(30))->setBlue(new ColorLevel(10));
$label = (new Text)->setColor($color)->setText("Here a text")->setSize(18)->setFont($path_to_the_font);
$new_image->add($label);
```

![TTF text](https://github.com/JuanchoSL/ImageTools/blob/master/assets/images/ttf.png?raw=true "TTF text")

#### Line

```php
$color = (new Color)->setRed(new ColorLevel(125))->setGreen(new ColorLevel(30))->setBlue(new ColorLevel(10));
$polygon = (new Line)
    ->setColor($color)
    ->setStartCoordinates((new Coordinates)->setX(15)->setY(25))
    ->setEndCoordinates((new Coordinates)->setX(105)->setY(65))
;
$new_image->add($polygon);
```

![Line](https://github.com/JuanchoSL/ImageTools/blob/master/assets/images/line.png?raw=true "Line")

#### Arc

```php
$color = (new Color)
    ->setRed(new ColorLevel(125))
    ->setGreen(new ColorLevel(30))
    ->setBlue(new ColorLevel(10))
;
$polygon = (new Arc)
    ->setColor($color)
    ->setDegrees((new Degrees)->setStart(0)->setEnd(240))
    ->setSize((new Size)->setWidth(80)->setHeight(40))
    ->setCenter((new Coordinates)->setX(80)->setY(40));
$new_image->add($polygon);
```

![Arc](https://github.com/JuanchoSL/ImageTools/blob/master/assets/images/arc.png?raw=true "Arc")

#### Pie

```php

$center = (new Coordinates)->setX(75)->setY(45);
$size = (new Size)->setWidth(50)->setHeight(50);

$color = (new Color)->setRed(new ColorLevel(255))->setGreen(new ColorLevel(0))->setBlue(new ColorLevel(0));
$polygon = (new Pie)
    ->setColor($color)
    ->setSize($size)
    ->setCenter($center)
    ->setDegrees((new Degrees)->setStart(0)->setEnd(45));
$new_image->add($polygon);

$color = (new Color)->setRed(new ColorLevel(0))->setGreen(new ColorLevel(255))->setBlue(new ColorLevel(0));
$polygon = (new Pie)
    ->setColor($color)
    ->setSize($size)
    ->setCenter($center)
    ->setDegrees((new Degrees)->setStart(45)->setEnd(95));
$new_image->add($polygon);

$color = (new Color)->setRed(new ColorLevel(0))->setGreen(new ColorLevel(0))->setBlue(new ColorLevel(255));
$polygon = (new Pie)
    ->setColor($color)
    ->setSize($size)
    ->setCenter($center)
    ->setDegrees((new Degrees)->setStart(95)->setEnd(195));
$new_image->add($polygon);
```

![Pie](https://github.com/JuanchoSL/ImageTools/blob/master/assets/images/pie.png?raw=true "Pie")

#### Cercle

```php
$color = (new Color)
    ->setRed(new ColorLevel(125))
    ->setGreen(new ColorLevel(30))
    ->setBlue(new ColorLevel(10))
;
$polygon = (new Cercle)
    ->setColor($color)
    ->setCenter((new Coordinates)->setX(75)->setY(45))
    ->setSize(50)
;
$new_image->add($polygon);
```

![Cercle](https://github.com/JuanchoSL/ImageTools/blob/master/assets/images/cercle.png?raw=true "Cercle")

#### Ellipse

```php
$color = (new Color)
    ->setRed(new ColorLevel(125))
    ->setGreen(new ColorLevel(30))
    ->setBlue(new ColorLevel(10))
;
$polygon = (new Ellipse)
    ->setColor($color)
    ->setCenter((new Coordinates)->setX(75)->setY(45))
    ->setSize((new Size)->setWidth(100)->setHeight(50))
;
$new_image->add($polygon);
```

![Ellipse](https://github.com/JuanchoSL/ImageTools/blob/master/assets/images/ellipse.png?raw=true "Ellipse")

#### Square

```php
$color = (new Color)
    ->setRed(new ColorLevel(125))
    ->setGreen(new ColorLevel(30))
    ->setBlue(new ColorLevel(10))
;
$polygon = (new Square)
    ->setColor($color)
    ->setStartCoordinates((new Coordinates)->setX(20)->setY(10))
    ->setSize(50)
;
$new_image->add($polygon);
```

![Square](https://github.com/JuanchoSL/ImageTools/blob/master/assets/images/square.png?raw=true "Square")

#### Rectangle

```php
$color = (new Color)
    ->setRed(new ColorLevel(125))
    ->setGreen(new ColorLevel(30))
    ->setBlue(new ColorLevel(10))
;
$size = (new Size)->setWidth(100)->setHeight(50);
$start = (new Coordinates)->setX(20)->setY(10);
$polygon = (new Rectangle)
    ->setColor($color)
    ->setStartCoordinates($start)
    ->setSize($size)
;
$new_image->add($polygon);
```

![Rectangle](https://github.com/JuanchoSL/ImageTools/blob/master/assets/images/rectangle.png?raw=true "Rectangle")

#### Polygon

```php
$color = (new Color)
    ->setRed(new ColorLevel(125))
    ->setGreen(new ColorLevel(30))
    ->setBlue(new ColorLevel(10))
;
$polygon = (new Polygon)
    ->setColor($color)
    ->setCoordinates(
        (new Coordinates)->setX(75)->setY(10),
        (new Coordinates)->setX(91)->setY(23),
        (new Coordinates)->setX(84)->setY(40),
        (new Coordinates)->setX(66)->setY(40),
        (new Coordinates)->setX(59)->setY(23),
    )
;
$new_image->add($polygon);
```

![Polygon](https://github.com/JuanchoSL/ImageTools/blob/master/assets/images/polygon.png?raw=true "Polygon")

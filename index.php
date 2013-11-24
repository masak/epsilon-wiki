<?php
# Install PSR-0-compatible class autoloader
spl_autoload_register(function($class){
    require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

use \Michelf\Markdown;

$text = file_get_contents('articles-md/0.md');
$html = Markdown::defaultTransform($text);

?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>Carl Mäsak</title>
</head>
<body>
    <?php
        echo $html;
    ?>
</body>

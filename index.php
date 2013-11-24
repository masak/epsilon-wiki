<?php
# Install PSR-0-compatible class autoloader
spl_autoload_register(function($class){
    require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

use \Michelf\Markdown;

$article = 'main';

switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':
    case 'PUT':
        save_article($article);
        break;
    case 'GET':
        if (isset($_GET["edit"])) {
            edit_article($article);
        }
        else {
            show_article($article);
        }
        break;
}

function save_article($article) {
    $markdown = $_POST["article-markdown"];
    $result = file_put_contents('articles-md/0.md', $markdown);

    if ($result === FALSE) {
        die_with_error("Tried to save the article but couldn't write to the file :(");
    }
    else {
        header('Location: /carl/wiki/');
        exit;
    }
}

function die_with_error($error) {

?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>There was an error</title>
</head>
<body>
    <?php echo $error ?>
</body>
<?php
    exit;
}

function show_article($article) {
    $markdown = file_get_contents('articles-md/0.md');
    $html = Markdown::defaultTransform($markdown);

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
<?php
    exit;
}

function edit_article($article) {
    $markdown = file_get_contents('articles-md/0.md');

?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>Editing "Carl Mäsak"</title>
</head>
<body>
    <form action="?article=main" method="post">
        <p><textarea name="article-markdown" rows="20" cols="80"><?php echo $markdown; ?></textarea></p>
        <p><input type="submit" value="Save"></p>
    </form>
</body>
<?php
    exit;
}

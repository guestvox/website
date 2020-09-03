<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <form action="" method="post">
            <input type="text" name="texto">
            <button type="submit">Traducir</button>
        </form>
        <?php
            require_once ('vendor/autoload.php');
            use \Statickidz\GoogleTranslate;
                        
            if (isset($_POST['texto']))
            {
                $source = 'es';
                $target = 'en';
                $text = $_POST['texto'];

                $trans = new GoogleTranslate();
                $result = $trans->translate($source, $target, $text);

                echo '<h2>'.$result.'</h2>';
            }
        ?>
</body>
</html>
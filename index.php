<?php
header('Content-Type: text/html; charset=utf-8');

function __autoload($classname) {
    $file = 'Integer2TextConvertor/' . $classname . '.php';
    if (is_readable($file)) {
        include_once($file);
    }
}

$number = !empty($_POST['number'])
    ? (int) $_POST['number']
    : rand(Integer2TextConverter::MIN_VALUE, Integer2TextConverter::MAX_VALUE);

$eng = ConverterFactory::getConverter('eng')->convert($number);
$rus = ConverterFactory::getConverter('rus')->convert($number);

?>

<form method="post">
    <label>
        Enter number (empty to get a random value): <input type="text" name="number">
    </label>
    <input type="submit" value="GO">
</form>
<p><b><?= number_format($number, 0, '', ' '); ?></b></p>
<p><b>English:</b> <?= $eng ?></p>
<p><b>Russian:</b> <?= $rus ?></p>

<?php

require_once './SingleLayerPerceptron.php';
require_once './MultipleLayerPerceptron.php';

$brainFilePath = __DIR__ . '/weights.json';

// &
$slp = new SingleLayerPerceptron($brainFilePath);

//if (!file_exists($brainFilePath)) {
    $slp->study([
        [0, 0, 0],
        [1, 1, 1],
        [0, 1, 0],
        [1, 0, 0],
    ]);
//}

echo $slp->test(0, 1) . PHP_EOL;

//$mlp = new MultipleLayerPerceptron();
//$mlp->study();
//echo $slp->test(0, 1) . PHP_EOL;

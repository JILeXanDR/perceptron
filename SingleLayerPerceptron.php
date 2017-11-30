<?php

class SingleLayerPerceptron
{
    private $inputs = [];
    private $weights = [];

    private $weightsFilePath;

    public function __construct($brainFilePath)
    {
        $this->weightsFilePath = $brainFilePath;
        $this->inputs = array_fill(0, 2, null);

        if (file_exists($this->weightsFilePath)) {
            $weights = json_decode(file_get_contents($this->weightsFilePath), true);
        } else {
            $weights = $this->randomWeights();
        }

        $this->weights = $weights;
    }

    private function randomWeights()
    {
        $weights = [];

        foreach ($this->inputs as $index => $input) {
            $weights[$index] = rand(0, 50) / 100;
        }

        return $weights;
    }

    private function summator()
    {
        $summ = 0;

        foreach ($this->inputs as $index => $input) {
            $summ += $input * $this->weights[$index];
        }

        return $summ;
    }

    private function activation($summatorValue)
    {
        return $summatorValue > 0.5 ? 1 : 0;
    }

    private function calculateOutput()
    {
        return $this->activation($this->summator());
    }

    public function study(array $dataSets)
    {
        echo "Start studying\n";

        $gError = null;

        do {

            echo "study...\n";

            $gError = 0;

            foreach ($dataSets as $dataSet) {

                $expectedOutput = $dataSet[2];

                // remove expected output
                array_pop($dataSet);

                $this->inputs = $dataSet;

                $output = $this->calculateOutput();
                $error = $expectedOutput - $output;
                $gError += abs($error);

                echo sprintf('Input data => %s, expected => %s, output => %s, error => %s', json_encode($this->inputs), $expectedOutput, $output, $error) . PHP_EOL;

                // change weights (back propagation)
                foreach ($this->weights as $index => $weight) {
                    $this->weights[$index] += 0.1 * $error * $this->inputs[$index];
                }
            }

        } while ($gError !== 0);

        echo "Studying was finished\n";

        file_put_contents($this->weightsFilePath, json_encode($this->weights));
    }

    public function test(...$inputs)
    {
        $this->inputs = $inputs;

        return $this->calculateOutput();
    }
}

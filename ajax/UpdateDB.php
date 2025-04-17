<?php
function load($file)
{
    if (file_exists($file)) {
        $data = explode("\n\n", file_get_contents($file));
        for ($i = 0; $i < count($data); $i++) {
            file_put_contents('newFile.txt', $i . $data[$i] . "\n\n");
        }
    }
}

load("../TalentFR.txt");

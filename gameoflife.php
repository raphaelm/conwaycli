<?php
// Copyright 2009 Raphael Michel <http://www.raphaelmichel.de>
// It's public domain. But please do not remove this note
// Usage:
// php gameoflife.php [timeout [width [height]]]
// Examples:
//      php gameoflife.php
//      php gameoflife.php 2
//      php gameoflife.php 5 60
//      php gameoflife.php 1 70 26
// Test Run:
//      php gameoflife.php glider

class gameoflife {
    // Attention: field[y][x]
    var $field = array();
    
    function initfield($width, $height, $rand = true){
        for($y = 0; $y < $height; $y++){
            for($x = 0; $x < $width; $x++){
                if($rand)
                    $this->field[$y][$x] = (bool) rand(0,1);
                else
                    $this->field[$y][$x] = false;
            }
        }
    }

    function print_field($field){
        for($y = 0; $y < count($field); $y++){
            for($x = 0; $x < count($field[$y]); $x++){
                if($field[$y][$x])
                    echo "X";
                else echo " ";
            }
            echo "\n";
        }   
    }

    function next_generation($field){
        $newfield = array();
        $this->any = false;
        for($y = 0; $y < count($field); $y++){
            for($x = 0; $x < count($field[$y]); $x++){
                $cell = $field[$y][$x];
                $neighbours = 0;
                if($field[($y-1)][($x-1)]) $neighbours++;
                if($field[($y-1)][($x)]) $neighbours++;
                if($field[($y)][($x-1)]) $neighbours++;
                if($field[($y+1)][($x+1)]) $neighbours++;
                if($field[($y+1)][($x)]) $neighbours++;
                if($field[($y)][($x+1)]) $neighbours++;
                if($field[($y-1)][($x+1)]) $neighbours++;
                if($field[($y+1)][($x-1)]) $neighbours++;
                
                if($cell && ($neighbours <= 1 || $neighbours >= 4)) $cell = false;
                elseif(!$cell && $neighbours == 3) $cell = true;
                else $cell = $cell;
                if(!$this->any && $cell) $this->any = true;
                $newfield[$y][$x] = $cell; 
            }
        } 
        return $newfield;
    }

    function startgame($width = 50, $height = 20, $timeout = 2, $init = true){
        if($init) $this->initfield($width, $height);
        $i = 1;
        while(1) {
            $i++;
            system(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? "cls" : "clear");
            $this->field = $this->next_generation($this->field);
            $this->print_field($this->field);
            echo "Generation $i | Conway's Game of Life | PHP-Random-Implementation";
            if(!$this->any) die("\nNothing left.");
            sleep($timeout);
        }
    }
}
$gol = new gameoflife;
if($argv[1] == 'glider'){ // to test whether it's a real game of life
    $gol->initfield(50, 20, false);
    $gol->field[5][8] = true;
    $gol->field[5][9] = true;
    $gol->field[5][10] = true;
    $gol->field[4][10] = true;
    $gol->field[3][9] = true;
    $gol->startgame((($argv[3]) ? $argv[3] : 50), (($argv[4]) ? $argv[4] : 20), (($argv[2]) ? $argv[2] : 2), false);
}else{
    $gol->startgame((($argv[2]) ? $argv[2] : 50), (($argv[3]) ? $argv[3] : 20), (($argv[1]) ? $argv[1] : 2));
}

<?php
    function rupiah($nominal){
        return "Rp".number_format($nominal, 0, ',', '.');
    }

    function rupiahArray($nominal){
        array_map(function($num){
            return "Rp".number_format($num, 0, ',', '.');
        }, $nominal);
    }

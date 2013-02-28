<?php
/**
 * Author: xworm
 * Date: 13-2-28
 * Time: 下午4:00
 */

function out_put($array) {
    switch (SYS_MODE) {
        case 'development' : var_dump($array);
            break;
        case 'testing' : echo json_encode($array);
            break;
        case 'production' : echo json_encode($array);
            break;
        default : echo json_encode($array);
    }
}
<?php
//htmlspecialcharsがを短縮する
// function h($str) {
//     return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
// }

function h( $str ) {
    if ( is_array( $str ) ) {
        return array_map("h", $str);
    } else {
        return htmlspecialchars( $str, ENT_QUOTES, 'UTF-8' );
    }
}


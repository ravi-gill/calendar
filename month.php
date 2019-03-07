<?php

echo PHP_EOL;

define( 'RESET', "\e[0m" );

define( 'BOLD', "\e[1m" );

define( 'CYAN', "\e[36m" );

define( 'BLUE', "\e[34m" );

$options = getopt('m:y:');

if ( ! empty( $options['y'] ) && @preg_match( '/^[12][0-9]{3}$/', $options['y'] ) === 1 ) {

    $year = intval( $options['y'] );

} else {

    $year = intval( date( 'Y' ) );

}

if ( ! empty( $options['m'] ) ) {

    $month = intval( $options['m'] );

    if ( $month <= 0 || $month > 12 ) {

        $month = intval( date( 'm' ) );

    }

} else {

    $month = intval( date( 'm' ) );

}

$days_in_week = 7;

$day_one = 1;

$days_in_month = cal_days_in_month( CAL_GREGORIAN, $month, $year );

$days_before = intval( date( 'N', mktime( 0, 0, 0, $month, $day_one, $year ) ) ) % $days_in_week;

$days_after = ( $days_in_week -1 ) - ( intval( date( 'N', mktime( 0, 0, 0, $month, $days_in_month, $year ) ) ) % $days_in_week );

$total_days = $days_in_month + $days_before + $days_after;

$rows = intdiv( $total_days, $days_in_week );

$cols = $days_in_week;

$grid = array();

for ( $i = 0; $i < $rows; $i++ ) {

    $grid[$i] = array();

    for ( $j = 0; $j < $cols; $j++ ) {

        $grid[$i][$j] = '';

    }
}

$sunday_start = FALSE;

for ( $i = 1; $i <= $days_in_month; $i++ ) {

    $row = ( intval( date( 'W', mktime( 0, 0, 0, $month, $i, $year ) ) ) - intval( date( 'W', mktime( 0, 0, 0, $month, $day_one, $year ) ) ) );

    if( $sunday_start ) {

        $row -= 1;

    }

    $col = date( 'N', mktime( 0, 0, 0, $month, $i, $year ) ) %  $days_in_week;

    if ( $col === 0 ) {

        if ( $i === 1 ) {

            $sunday_start = TRUE;

        } else {

            $row += 1;

        }

    }

    $grid[$row][$col] = $i;

}

echo BOLD . BLUE;

echo "\t" . strtoupper( date( 'F', mktime( 0, 0, 0, $month, $day_one, $year ) ) ) . ' ' . $year . PHP_EOL . PHP_EOL;

echo "\tSun\tMon\tTue\tWed\tThu\tFri\tSat\n";

echo RESET;

echo CYAN;

for ( $i = 0; $i < $rows; $i++ ) {

    echo "\t";

    for ( $j = 0; $j < $cols; $j++ ) {

        echo $grid[$i][$j];

        echo "\t";
    }

    echo "\n";

}

echo RESET;

echo PHP_EOL;

?>

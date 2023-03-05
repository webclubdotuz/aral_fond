<?php

use Carbon\Carbon;

function my_date_format($date)
{
    //  1 ян. 2021
    setlocale(LC_ALL, 'ru_RU.UTF-8');

    $mm = [
        '1' => 'янв',
        '2' => 'фев',
        '3' => 'мар',
        '4' => 'апр',
        '5' => 'май',
        '6' => 'июн',
        '7' => 'июл',
        '8' => 'авг',
        '9' => 'сен',
        '10' => 'окт',
        '11' => 'ноя',
        '12' => 'дек',
    ];

    $date = Carbon::parse($date);
    $month = $mm[$date->format('n')];
    $day = $date->format('j');
    $year = $date->format('Y');

    return $day . ' ' . $month . ' ' . $year;


}

function hasRole($role)
{

    $user = auth()->user()->roles->contains('slug', $role);
    // dd($user, $role);
    if (is_string($role)) {
        return auth()->user()->roles->contains('slug', $role);
    }
    return false;
}


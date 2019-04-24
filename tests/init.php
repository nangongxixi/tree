<?php

namespace j\tree\tests;

# init.php
/**
 * User: Administrator
 * Date: 2017/4/11
 * Time: 10:47
 */

use j\db\ServiceProvider;

require __DIR__ . "/../vendor/autoload.php";

/**
 * @param $express
 * @param $title
 */
function assert_expr($express, $title){
    echo $title . ":" ;
    if($express){
        echo " ok\n";
    } else {
        echo " fail\n";
        exit;
    }
}

function assert_eq($a, $b, $title){
    echo $title . ":" ;
    if($a == $b){
        echo " ok\n";
    } else {
        echo " fail({$a} != {$b})\n";
        exit;
    }
}

config()->set('db', [
    'conn' => [
        'host' => '192.168.0.234',
        'port' => 3306,
        'database' => 'newjc001',
        'user' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'persitent' => false
    ],
    'prefix' => '',
    'log' => [
        'enable' => true,
        'trace' => false,
        'logger' => __DIR__ . '/sql.log'
    ]
]);

service()->set('config', config());
service()->registerProviders([
   ServiceProvider::class
]);

function getGdNumsMap(){
    return
        array (
            0 => 39989,
            1 => 16658,
            104 => 12731,
            184 => 12223,
            628 => 11179,
            749 => 11038,
            76 => 10463,
            407 => 9021,
            1128 => 7117,
            1606 => 6748,
            265 => 6393,
            441 => 5619,
            1369 => 4887,
            977 => 4663,
            589 => 3876,
            1312 => 3804,
            437 => 3730,
            1309 => 3608,
            1350 => 3594,
            1360 => 3322,
            1044 => 3217,
            745 => 2964,
            1329 => 2898,
            1305 => 2796,
            1461 => 2210,
            516 => 1937,
            1473 => 1844,
            1342 => 1819,
            520 => 1795,
            442 => 1684,
            1592 => 1644,
            1375 => 1433,
            1483 => 1362,
            4288 => 1282,
            3751 => 1220,
            3099 => 1019,
            522 => 1016,
            229 => 1001,
            2844 => 949,
            1961 => 941,
            488 => 928,
            1008 => 833,
            450 => 779,
            1365 => 777,
            1058 => 697,
            1455 => 642,
            4428 => 622,
            1055 => 553,
            1435 => 480,
            2036 => 277,
            77 => 264,
            1361 => 261,
            4695 => 249,
            1771 => 241,
            980 => 226,
            4743 => 224,
            1693 => 206,
            783 => 191,
            4294 => 144,
            4242 => 120,
            1306 => 108,
            1988 => 105,
            3316 => 97,
            3086 => 94,
            31 => 93,
            978 => 77,
            2 => 73,
            1963 => 73,
            1607 => 72,
            1476 => 72,
            90 => 71,
            4297 => 70,
            21 => 70,
            5005 => 69,
            4727 => 64,
            523 => 62,
            3656 => 61,
            91 => 60,
            4326 => 57,
            94 => 53,
            4296 => 53,
            5132 => 53,
            995 => 52,
            1039 => 52,
            4429 => 51,
            3318 => 51,
            3321 => 50,
            4 => 50,
            4173 => 50,
            1923 => 48,
            1613 => 47,
            4787 => 47,
            100 => 45,
            1011 => 43,
            4327 => 42,
            3323 => 40,
            4983 => 36,
            1964 => 36,
            4301 => 35,
            4325 => 35,
            3333 => 34,
            4764 => 34,
            1353 => 33,
            1623 => 32,
            4082 => 32,
            4083 => 32,
            443 => 32,
            1805 => 32,
            4324 => 31,
            1960 => 30,
            4312 => 29,
            71 => 29,
            4313 => 27,
            692 => 27,
            3752 => 26,
            3087 => 26,
            4311 => 26,
            3256 => 26,
            4299 => 26,
            4295 => 25,
            266 => 23,
            445 => 23,
            1003 => 23,
            3339 => 22,
            997 => 21,
            1371 => 20,
            68 => 20,
            3356 => 20,
            4328 => 20,
            1358 => 20,
            4969 => 19,
            3358 => 19,
            1037 => 19,
            3349 => 18,
            3213 => 17,
            3427 => 17,
            4298 => 17,
            3334 => 17,
            4306 => 16,
            4962 => 16,
            3088 => 16,
            3423 => 16,
            3336 => 16,
            1330 => 16,
            4331 => 16,
            1357 => 16,
            1331 => 15,
            3319 => 15,
            3426 => 15,
            4330 => 15,
            197 => 15,
            2012 => 15,
            1351 => 15,
            3753 => 14,
            4305 => 14,
            3332 => 14,
            292 => 14,
            4997 => 14,
            1617 => 13,
            2845 => 13,
            1475 => 13,
            6 => 13,
            2073 => 13,
            4130 => 12,
            1374 => 12,
            1328 => 12,
            3422 => 11,
            1333 => 11,
            828 => 11,
            3354 => 11,
            4314 => 11,
            3418 => 11,
            3340 => 11,
            96 => 11,
            267 => 11,
            4433 => 10,
            832 => 10,
            4982 => 10,
            4310 => 10,
            4302 => 10,
            982 => 10,
            3314 => 10,
            1481 => 10,
            1460 => 9,
            3063 => 9,
            3091 => 9,
            841 => 9,
            2086 => 9,
            1035 => 9,
            4967 => 9,
            1354 => 9,
            4316 => 9,
            4342 => 8,
            564 => 8,
            4432 => 8,
            766 => 8,
            3758 => 8,
            4987 => 8,
            3 => 8,
            4963 => 8,
            3649 => 8,
            4300 => 8,
            4307 => 8,
            3411 => 8,
            4180 => 8,
            3382 => 8,
            687 => 8,
            4262 => 8,
            4181 => 8,
            1479 => 8,
            1335 => 8,
            4409 => 7,
            4431 => 7,
            97 => 7,
            3335 => 7,
            3361 => 7,
            4096 => 7,
            694 => 7,
            1946 => 7,
            699 => 7,
            693 => 7,
            208 => 6,
            4443 => 6,
            4683 => 6,
            1050 => 6,
            571 => 6,
            1017 => 6,
            1704 => 6,
            4981 => 6,
            3326 => 6,
            3324 => 6,
            3357 => 6,
            4337 => 6,
            186 => 6,
            3337 => 6,
            3343 => 6,
            110 => 6,
            1337 => 6,
            361 => 6,
            1477 => 6,
            3841 => 5,
            3170 => 5,
            3094 => 5,
            268 => 5,
            4966 => 5,
            4972 => 5,
            830 => 5,
            3762 => 5,
            439 => 5,
            673 => 5,
            3327 => 5,
            4309 => 5,
            4304 => 5,
            3364 => 5,
            1971 => 5,
            999 => 5,
            1789 => 5,
            1307 => 5,
            4098 => 4,
            555 => 4,
            3754 => 4,
            3781 => 4,
            598 => 4,
            3223 => 4,
            4100 => 4,
            1247 => 4,
            536 => 4,
            4322 => 4,
            1332 => 4,
            187 => 4,
            1027 => 4,
            985 => 4,
            996 => 4,
            2015 => 4,
            1038 => 4,
            1006 => 4,
            4971 => 4,
            1950 => 4,
            3412 => 4,
            209 => 4,
            4790 => 4,
            3387 => 4,
            3414 => 4,
            4097 => 4,
            3647 => 4,
            3685 => 4,
            1804 => 4,
            1040 => 4,
            3425 => 4,
            83 => 4,
            4289 => 4,
            758 => 3,
            799 => 3,
            3415 => 3,
            385 => 3,
            4910 => 3,
            4437 => 3,
            2867 => 3,
            4668 => 3,
            4435 => 3,
            625 => 3,
            3097 => 3,
            4875 => 3,
            3159 => 3,
            92 => 3,
            4127 => 3,
            1151 => 3,
            3360 => 3,
            833 => 3,
            3761 => 3,
            3140 => 3,
            3355 => 3,
            1041 => 3,
            4308 => 3,
            4986 => 3,
            4806 => 3,
            1249 => 3,
            1948 => 3,
            4977 => 3,
            3771 => 3,
            1129 => 3,
            4250 => 3,
            1308 => 3,
            4332 => 3,
            3089 => 3,
            3352 => 3,
            51 => 3,
            103 => 3,
            4318 => 3,
            4315 => 3,
            4095 => 3,
            98 => 3,
            3359 => 3,
            1046 => 3,
            3421 => 3,
            3684 => 3,
            4335 => 3,
            127 => 3,
            1784 => 3,
            3331 => 3,
            1801 => 3,
            1965 => 3,
            1465 => 2,
            626 => 2,
            254 => 2,
            1056 => 2,
            3272 => 2,
            122 => 2,
            2098 => 2,
            521 => 2,
            282 => 2,
            387 => 2,
            291 => 2,
            3376 => 2,
            586 => 2,
            4434 => 2,
            3138 => 2,
            842 => 2,
            3755 => 2,
            4442 => 2,
            2846 => 2,
            3770 => 2,
            2852 => 2,
            873 => 2,
            1807 => 2,
            3816 => 2,
            5103 => 2,
            4440 => 2,
            3153 => 2,
            1373 => 2,
            3986 => 2,
            1990 => 2,
            3085 => 2,
            4085 => 2,
            1985 => 2,
            561 => 2,
            3375 => 2,
            583 => 2,
            4303 => 2,
            3372 => 2,
            3759 => 2,
            4336 => 2,
            3424 => 2,
            998 => 2,
            1022 => 2,
            4989 => 2,
            1793 => 2,
            3257 => 2,
            702 => 2,
            4791 => 2,
            4898 => 2,
            986 => 2,
            1013 => 2,
            3325 => 2,
            1927 => 2,
            840 => 2,
            4339 => 2,
            3420 => 2,
            3416 => 2,
            1854 => 2,
            1482 => 2,
            979 => 2,
            4788 => 2,
            5115 => 2,
            4104 => 2,
            4319 => 2,
            3362 => 2,
            1969 => 2,
            1952 => 2,
            5201 => 2,
            4251 => 2,
            674 => 2,
            4320 => 2,
            994 => 2,
            1794 => 2,
            124 => 2,
            1785 => 2,
            365 => 2,
            2106 => 2,
            4291 => 2,
            130 => 1,
            394 => 1,
            627 => 1,
            198 => 1,
            272 => 1,
            608 => 1,
            3560 => 1,
            160 => 1,
            1609 => 1,
            1314 => 1,
            244 => 1,
            1362 => 1,
            1364 => 1,
            511 => 1,
            1697 => 1,
            47 => 1,
            4090 => 1,
            4408 => 1,
            1457 => 1,
            230 => 1,
            169 => 1,
            5072 => 1,
            170 => 1,
            607 => 1,
            4093 => 1,
            1051 => 1,
            190 => 1,
            315 => 1,
            846 => 1,
            3092 => 1,
            334 => 1,
            3855 => 1,
            86 => 1,
            286 => 1,
            274 => 1,
            4407 => 1,
            444 => 1,
            5084 => 1,
            4145 => 1,
            4964 => 1,
            333 => 1,
            4375 => 1,
            338 => 1,
            269 => 1,
            3095 => 1,
            3408 => 1,
            3363 => 1,
            563 => 1,
            568 => 1,
            4446 => 1,
            4828 => 1,
            4824 => 1,
            3550 => 1,
            4430 => 1,
            3090 => 1,
            4867 => 1,
            4675 => 1,
            3846 => 1,
            4439 => 1,
            4659 => 1,
            3774 => 1,
            3782 => 1,
            4486 => 1,
            326 => 1,
            559 => 1,
            4519 => 1,
            2863 => 1,
            547 => 1,
            2848 => 1,
            545 => 1,
            4601 => 1,
            4673 => 1,
            3139 => 1,
            125 => 1,
            2884 => 1,
            2851 => 1,
            4658 => 1,
            4674 => 1,
            3772 => 1,
            3756 => 1,
            3236 => 1,
            3559 => 1,
            3182 => 1,
            3539 => 1,
            3529 => 1,
            3054 => 1,
            4984 => 1,
            4146 => 1,
            2006 => 1,
            1621 => 1,
            3158 => 1,
            3887 => 1,
            3032 => 1,
            3070 => 1,
            3057 => 1,
            548 => 1,
            4670 => 1,
            3744 => 1,
            4482 => 1,
            35 => 1,
            605 => 1,
            4970 => 1,
            4979 => 1,
            1200 => 1,
            4565 => 1,
            2069 => 1,
            3746 => 1,
            3876 => 1,
            3512 => 1,
            3294 => 1,
            1049 => 1,
            210 => 1,
            1338 => 1,
            3151 => 1,
            3282 => 1,
            78 => 1,
            4105 => 1,
            1781 => 1,
            1967 => 1,
            11 => 1,
            4109 => 1,
            3161 => 1,
            3681 => 1,
            283 => 1,
            1327 => 1,
            2847 => 1,
            4047 => 1,
            4973 => 1,
            4341 => 1,
            3417 => 1,
            233 => 1,
            3330 => 1,
            1036 => 1,
            1709 => 1,
            4414 => 1,
            4084 => 1,
            3329 => 1,
            1339 => 1,
            102 => 1,
            1019 => 1,
            1015 => 1,
            1001 => 1,
            4321 => 1,
            3384 => 1,
            3776 => 1,
            1930 => 1,
            4978 => 1,
            82 => 1,
            1009 => 1,
            1018 => 1,
            4980 => 1,
            5088 => 1,
            3241 => 1,
            646 => 1,
            4886 => 1,
            4855 => 1,
            1926 => 1,
            4838 => 1,
            5096 => 1,
            1929 => 1,
            4990 => 1,
            4681 => 1,
            2864 => 1,
            1970 => 1,
            1201 => 1,
            85 => 1,
            4334 => 1,
            3617 => 1,
            855 => 1,
            3652 => 1,
            2064 => 1,
            3441 => 1,
            3572 => 1,
            3393 => 1,
            3622 => 1,
            1951 => 1,
            3378 => 1,
            4293 => 1,
            3379 => 1,
            698 => 1,
            4092 => 1,
            1023 => 1,
            4271 => 1,
            1363 => 1,
            204 => 1,
            5078 => 1,
            3373 => 1,
            5196 => 1,
            5193 => 1,
            5202 => 1,
            5203 => 1,
            4329 => 1,
            4317 => 1,
            3648 => 1,
            1787 => 1,
            4231 => 1,
            1811 => 1,
            1788 => 1,
            4340 => 1,
            336 => 1,
            327 => 1,
            392 => 1,
            4290 => 1,
            1474 => 1,
        );
}
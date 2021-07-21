<?php

if_post('/calendar_pick', function ()
{
    $content = input('content');

    if (! $content) {
        return [];
    }

    $res = [
        'title' => '',
        'start_time' => '',
        'end_time' => '',
        'place' => '',
        'reminder_time' => '',
        'description' => '',
    ];

    $picker = function ($line, $matches) {

        foreach ($matches as $match) {
            if (starts_with($line, $match)) {
                return [true, str_replace([$match.':', $match.'：', $match], '', $line)];
            }
        }

        return [false, null];
    };

    function time_formater($advisory, $line, $if_afternoon = false) {

        $date_regs = [
            '/(?:([0-9]+)年)?(?:( ?[0-9]+ ?)月)?(?:( ?[0-9]+ ?)日)/', // 2020年11月18日
            '/(?:([0-9]+ ?)年)?(?:( ?[0-9]+ ?)月)?(?:( ?[0-9]+ ?)号)/', // 2020年11月18号
            '/(?:([0-9]+)-)?(?:([0-9]+)-)(?:([0-9]+))/', // 2020-11-18
            '/(?:([0-9]+)\/)?(?:([0-9]+)\/)(?:([0-9]+))/', // 2020/11/18
            '/(?:([0-9]+ ?)年)?(?:( ?[0-9]+ ?)月)?(?:( ?[0-9]+ ?)!:)/', // 2020年11月18
        ];

        $default_year = datetime($advisory, 'Y');
        $default_month = datetime($advisory, 'm');
        $default_day = datetime($advisory, 'd');
        $default_hour = datetime($advisory, 'H');
        $default_minute = datetime($advisory, 'i');
        $default_second = datetime($advisory, 's');

        $year = '';
        $month = '';
        $day = '';

        foreach ($date_regs as $reg) {
            $matches = [];
            preg_match_all($reg, $line, $matches);
            if (not_empty($matches[0])) {
                $year = trim(array_shift($matches[1]));
                $month = trim(array_shift($matches[2]));
                $day = trim(array_shift($matches[3]));
                break;
            }
        }

        $year = $year ?: $default_year;
        $month = $month ?: $default_month;
        $day = $day ?: $default_day;

        $time_regs = [
            '/(?:([0-9]{1,2} ?)点( ?[0-9]{1,2} ?))分(?:( ?[0-9]{1,2} ?)秒)?/', // 9点30分24秒
            '/(?:([0-9]{1,2} ?)时( ?[0-9]{1,2} ?))分(?:( ?[0-9]{1,2} ?)秒)?/', // 9时30分24秒
            '/(?:(\d{1,2}):(\d{2}))(?::(\d{2}))?/', // 9:30
        ];

        $hour = '';
        $minute = '';
        $second = '';

        foreach ($time_regs as $time_reg) {
            $matches = [];
            preg_match_all($time_reg, $line, $matches);
            if (not_empty($matches[0])) {
                $hour = trim(array_shift($matches[1]));
                $minute = trim(array_shift($matches[2]));
                $second = trim(array_shift($matches[3]));
                break;
            }
        }

        $hour = $hour ?: $default_hour;
        $minute = $minute ?: $default_minute;
        $second = $second ?: $default_second;

        return datetime($year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second.($if_afternoon ? ' PM': ''));
    };

    $time_picker = function ($line) {

        $res = [];

        $carve_signs = ['-', '~', '至', '到'];

        $useful_carve_sign = null;
        $carved_times = [];

        $if_afternoon = false;
        if (stristr($line, '下午')) {
            $if_afternoon = true;
        }

        foreach ($carve_signs as $carve_sign) {
            $exploded = explode($carve_sign, $line);
            if (count($exploded) == 2) {
                $useful_carve_sign = $carve_sign;
                $carved_times = $exploded;
            }
        }

        $target_lines = is_null($useful_carve_sign)? (array) $line: $carved_times;

        $advisory = datetime('now', 'Y-m-d H:i:00');

        foreach ($target_lines as $target_line) {
            $advisory = time_formater($advisory, $target_line, $if_afternoon);
            $res[] = $advisory;
        }

        return $res;
    };

    foreach (explode("\n", $content) as $line)
    {
        $line = trim($line);

        list($bool, $matched) = $picker($line, [
            '会议主题'
        ]);

        if ($bool) { 
            $res['title'] = $matched;
        }

        list($bool, $matched) = $picker($line, [
            '会议时间'
        ]);

        if ($bool) { 
            $times = $time_picker($matched);
            $res['start_time'] = $times[0] ?: '';
            $res['end_time'] = $times[1] ?: '';
        }

        list($bool, $matched) = $picker($line, [
            '会议地点'
        ]);

        if ($bool) { 
            $res['place'] = $matched;
        }

        $res['description'] = $content;
    }

    if (empty($res['title']) && not_empty($res['place'])) {
        $res['title'] = $res['place'];
    }

    return $res;
});

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | 这个 following language lines contain 这个 default error messages used by
    | 这个 validator class. Some of 这个se rules have multiple versions such
    | as 这个 size rules. Feel free to tweak each of 这个se messages here.
    |
    */

    'accepted' => '这个 :attribute 必须接受',
    'active_url' => '这个 :attribute 不是有效的网址.',
    'after' => '这个 :attribute 必须是晚于 :date.',
    'after_or_equal' => '这个 :attribute 日期必须晚于或等于 :date.',
    'alpha' => '这个 :attribute 可能只包含字母.',
    'alpha_dash' => '这个 :attribute 只能包含字母、数字、破折号和下划线.',
    'alpha_num' => '这个 :attribute 只能包含字母和数字.',
    'array' => '这个 :attribute 必须是数字.',
    'before' => '这个 :attribute 日期必须早于 :date.',
    'before_or_equal' => '这个 :attribute 日期必须早于或等于 :date.',
    'between' => [
        'numeric' => '这个 :attribute 必须介于 :min 和 :max.',
        'file' => '这个 :attribute 必须介于 :min 和 :max 千字节.',
        'string' => '这个 :attribute 必须介于 :min 和 :max 字符.',
        'array' => '这个 :attribute 必须介于 :min 和 :max 项目.',
    ],
    'boolean' => '这个 :attribute 字段必须为 对 或 错.',
    'confirmed' => '这个 :attribute 确认不匹配.',
    'date' => '这个 :attribute 不是有效日期.',
    'date_equals' => '这个 :attribute 日期必须等于 :date.',
    'date_format' => '这个 :attribute 格式不符 :format.',
    'different' => '这个 :attribute 和 :o这个r 必须不同.',
    'digits' => '这个 :attribute 必须 :digits digits.',
    'digits_between' => '这个 :attribute 必须介于 :min 和 :max 数字.',
    'dimensions' => '这个 :attribute 图像尺寸无效.',
    'distinct' => '这个 :attribute 字段有重复值.',
    'email' => '这个 :attribute 必须是一个有效的E-mail地址.',
    'exists' => '这个 selected :attribute 是无效的.',
    'file' => '这个 :attribute 必须是一个文件.',
    'filled' => '这个 :attribute 字段必须有一个值.',
    'gt' => [
        'numeric' => '这个 :attribute 必须大于 :value.',
        'file' => '这个 :attribute 必须大于 :value 千字节.',
        'string' => '这个 :attribute 必须大于 :value 字符.',
        'array' => '这个 :attribute 必须超过 :value 项目.',
    ],
    'gte' => [
        'numeric' => '这个 :attribute 必须大于或等于 :value.',
        'file' => '这个 :attribute 必须大于或等于 :value 千字节.',
        'string' => '这个 :attribute 必须大于或等于 :value 字符.',
        'array' => '这个 :attribute 必须有 :value 项目或更多.',
    ],
    'image' => '这个 :attribute 必须是图像.',
    'in' => '这个 selected :attribute 是无效的.',
    'in_array' => '这个 :attribute 字段不存在于 :o这个r.',
    'integer' => '这个 :attribute 必须是整数.',
    'ip' => '这个 :attribute 必须是有效的 IP address.',
    'ipv4' => '这个 :attribute 必须是有效的 IPv4 地址.',
    'ipv6' => '这个 :attribute 必须是有效的 IPv6 地址.',
    'json' => '这个 :attribute 必须是有效的 JSON 串.',
    'lt' => [
        'numeric' => '这个 :attribute 必须小于 :value.',
        'file' => '这个 :attribute 必须小于 :value 千字节.',
        'string' => '这个 :attribute 必须小于 :value 字符.',
        'array' => '这个 :attribute 必须少于 :value 项目.',
    ],
    'lte' => [
        'numeric' => '这个 :attribute 必须小于或等于 :value.',
        'file' => '这个 :attribute 必须小于或等于 :value 千字节.',
        'string' => '这个 :attribute 必须小于或等于 :value 字符.',
        'array' => '这个 :attribute 不得超过 :value 项目.',
    ],
    'max' => [
        'numeric' => '这个 :attribute 不得大于 :max.',
        'file' => '这个 :attribute 不得大于 :max 千字节.',
        'string' => '这个 :attribute 不得大于 :max 字符.',
        'array' => '这个 :attribute 不得超过 :max 项目.',
    ],
    'mimes' => '这个 :attribute 必须是一个文件类型: :values.',
    'mimetypes' => '这个 :attribute 必须是一个文件类型: :values.',
    'min' => [
        'numeric' => '这个 :attribute 必须至少 :min.',
        'file' => '这个 :attribute 必须至少 :min 千字节.',
        'string' => '这个 :attribute 必须至少 :min 字符.',
        'array' => '这个 :attribute 必须至少有 :min 项目.',
    ],
    'not_in' => '这个 selected :attribute 是无效的.',
    'not_regex' => '这个 :attribute 格式无效.',
    'numeric' => '这个 :attribute 必须是数字.',
    'present' => '这个 :attribute 字段必须存在.',
    'regex' => '这个 :attribute 格式无效.',
    'required' => '这个 :attribute 字段是必需的.',
    'required_if' => '这个 :attribute 需要字段时 :o这个r 是 :value.',
    'required_unless' => '这个 :attribute 字段是必需的，除非 :o这个r 在 :values.',
    'required_with' => '这个 :attribute 需要字段时 :values 存在.',
    'required_with_all' => '这个 :attribute 需要字段时 :values 存在.',
    'required_without' => '这个 :attribute 需要字段时 :values 不存在.',
    'required_without_all' => '这个 :attribute 字段是必需的,当没有 :values 存在.',
    'same' => '这个 :attribute 和 :o这个r 必须匹配.',
    'size' => [
        'numeric' => '这个 :attribute 必须 :size.',
        'file' => '这个 :attribute 必须 :size 千字节.',
        'string' => '这个 :attribute 必须 :size 字符.',
        'array' => '这个 :attribute 必须包含 :size 项目.',
    ],
    'starts_with' => '这个 :attribute 必须以下列之一开始: :values',
    'string' => '这个 :attribute 必须是字符串.',
    'timezone' => '这个 :attribute 必须是有效区间.',
    'unique' => '这个 :attribute 已有人使用.',
    'uploaded' => '这个 :attribute 上传失败.',
    'url' => '这个 :attribute 格式无效.',
    'uuid' => '这个 :attribute 必须是有效的 UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using 这个
    | convention "attribute.rule" to name 这个 lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation attributes
    |--------------------------------------------------------------------------
    |
    | 这个 following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines - Vietnamese
	| 
	| Translator: HopThu.Top
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
	|
    */

    'accepted' => ':attribute phải được chấp nhận.',
    'active_url' => ':attribute không phải là một URL hợp lệ.',
    'after' => ':attribute phải là một ngày sau :date.',
    'after_or_equal' => ':attribute phải là một ngày sau hoặc bằng :date.',
    'alpha' => ':attribute chỉ có thể chứa các chữ cái.',
    'alpha_dash' => ':attribute chỉ có thể chứa chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num' => ':attribute chỉ có thể chứa chữ cái và số.',
    'array' => ':attribute phải là một mảng.',
    'before' => ':attribute phải là một ngày trước :date.',
    'before_or_equal' => ':attribute phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => ':attribute phải ở giữa :min và :max.',
        'file' => ':attribute phải ở giữa :min và :max kilobyte.',
        'string' => ':attribute phải ở giữa :min và :max ký tự.',
        'array' => ':attribute phải ở giữa :min và :max item.',
    ],
    'boolean' => ':attribute trường phải đúng hoặc sai.',
    'confirmed' => ':attribute xác nhận không khớp.',
    'date' => ':attribute không phải là ngày hợp lệ.',
    'date_equals' => ':attribute phải là một ngày bằng :date.',
    'date_format' => ':attribute không phù hợp với định dạng :format.',
    'different' => ':attribute và :other phải khác.',
    'digits' => ':attribute phải có :digits chữ số.',
    'digits_between' => ':attribute phải nằm giữa :min và :max chữ số.',
    'dimensions' => ':attribute có kích thước hình ảnh không hợp lệ.',
    'distinct' => ':attribute trường có giá trị trùng lặp.',
    'email' => ':attribute phải là một địa chỉ email hợp lệ.',
    'exists' => 'Thuộc tính được chọn :attribute không hợp lệ.',
    'file' => ':attribute phải là một tập tin.',
    'filled' => ':attribute trường phải có giá trị.',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobyte.',
        'string' => ':attribute phải lớn hơn :value ký tự.',
        'array' => ':attribute phải lớn hơn :value item.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobyte.',
        'string' => ':attribute phải lớn hơn hoặc bằng :value ký tự.',
        'array' => ':attribute phải bằng :value item hoặc nhiều hơn.',
    ],
    'image' => ':attribute phải là một hình ảnh.',
    'in' => 'Lựa chọn :attribute không hợp lệ.',
    'in_array' => ':attribute lĩnh vực không tồn tại trong :other.',
    'integer' => ':attribute phải là số nguyên.',
    'ip' => ':attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4' => ':attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6' => ':attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json' => ':attribute phải là một chuỗi JSON hợp lệ.',
    'lt' => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file' => ':attribute phải nhỏ hơn :value kilobyte.',
        'string' => ':attribute phải nhỏ hơn :value ký tự.',
        'array' => ':attribute phải nhỏ hơn :value item.',
    ],
    'lte' => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => ':attribute phải nhỏ hơn hoặc bằng :value kilobyte.',
        'string' => ':attribute phải nhỏ hơn hoặc bằng :value ký tự.',
        'array' => ':attribute không được có nhiều hơn :value item.',
    ],
    'max' => [
        'numeric' => ':attribute có thể không lớn hơn :max.',
        'file' => ':attribute có thể không lớn hơn :max kilobyte.',
        'string' => ':attribute có thể không lớn hơn :max ký tự.',
        'array' => ':attribute có thể không lớn hơn :max item.',
    ],
    'mimes' => ':attribute phải là một tập tin loại: :values.',
    'mimetypes' => ':attribute phải là một tập tin loại: :values.',
    'min' => [
        'numeric' => ':attribute ít nhất phải có :min.',
        'file' => ':attribute ít nhất phải có :min kilobyte.',
        'string' => ':attribute ít nhất phải có :min ký tự.',
        'array' => ':attribute ít nhất phải có :min item.',
    ],
    'not_in' => 'Lựa chọn :attribute không hợp lệ.',
    'not_regex' => ':attribute định dạng không hợp lệ.',
    'numeric' => ':attribute phải là một số.',
    'present' => ':attribute trường phải có mặt.',
    'regex' => ':attribute định dạng không hợp lệ.',
    'required' => ':attribute trường được yêu cầu.',
    'required_if' => ':attribute trường được yêu cầu khi :other là :value.',
    'required_unless' => ':attribute trường là bắt buộc trừ khi :other trong :values.',
    'required_with' => ':attribute trường được yêu cầu khi :values có mặt.',
    'required_with_all' => ':attribute trường được yêu cầu khi :values có mặt.',
    'required_without' => ':attribute trường được yêu cầu khi :values không có mặt.',
    'required_without_all' => ':attribute trường là bắt buộc khi :values không có mặt.',
    'same' => ':attribute và :other không khớp.',
    'size' => [
        'numeric' => ':attribute cần phải có :size.',
        'file' => ':attribute cần phải có :size kilobyte.',
        'string' => ':attribute cần phải có :size ký tự.',
        'array' => ':attribute phải chứa :size item.',
    ],
    'starts_with' => ':attribute phải bắt đầu với một trong những điều sau đây: :values',
    'string' => ':attribute phải là một chuỗi.',
    'timezone' => ':attribute phải là một vùng hợp lệ.',
    'unique' => ':attribute đã được thực hiện.',
    'uploaded' => ':attribute không tải lên được.',
    'url' => ':attribute định dạng không hợp lệ.',
    'uuid' => ':attribute phải là một UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
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
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];

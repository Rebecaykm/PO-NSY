<?php

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行には、バリデータクラスによって使用されるデフォルトの
    | エラーメッセージが含まれています。これらのルールのいくつかには、
    | サイズルールのように複数のバージョンがあります。これらのメッセージを
    | ここで自由に調整してください。
    |
    */

    'accepted' => ':attribute を承認する必要があります。',
    'active_url' => ':attribute は有効なURLではありません。',
    'after' => ':attribute は :date より後の日付でなければなりません。',
    'after_or_equal' => ':attribute は :date と同じか、それ以降の日付でなければなりません。',
    'alpha' => ':attribute には文字のみを含めることができます。',
    'alpha_dash' => ':attribute には文字、数字、ダッシュ、およびアンダースコアのみを含めることができます。',
    'alpha_num' => ':attribute には文字と数字のみを含めることができます。',
    'array' => ':attribute は配列でなければなりません。',
    'before' => ':attribute は :date より前の日付でなければなりません。',
    'before_or_equal' => ':attribute は :date と同じか、それ以前の日付でなければなりません。',
    'between' => [
        'numeric' => ':attribute は :min から :max の間でなければなりません。',
        'file' => ':attribute は :min から :max キロバイトの間でなければなりません。',
        'string' => ':attribute は :min から :max 文字の間でなければなりません。',
        'array' => ':attribute は :min から :max 個のアイテムが必要です。',
    ],
    'boolean' => ':attribute フィールドは真または偽でなければなりません。',
    'confirmed' => ':attribute 確認が一致しません。',
    'date' => ':attribute は有効な日付ではありません。',
    'date_equals' => ':attribute は :date と等しい日付でなければなりません。',
    'date_format' => ':attribute は :format 形式と一致しません。',
    'different' => ':attribute と :other は異なっている必要があります。',
    'digits' => ':attribute は :digits 桁でなければなりません。',
    'digits_between' => ':attribute は :min から :max 桁の間でなければなりません。',
    'dimensions' => ':attribute には無効な画像寸法があります。',
    'distinct' => ':attribute フィールドには重複する値があります。',
    'email' => ':attribute は有効なメールアドレスでなければなりません。',
    'ends_with' => ':attribute は次のいずれかで終わる必要があります: :values。',
    'exists' => '選択された :attribute は無効です。',
    'file' => ':attribute はファイルでなければなりません。',
    'filled' => ':attribute フィールドには値が必要です。',
    'gt' => [
        'numeric' => ':attribute は :value より大きくなければなりません。',
        'file' => ':attribute は :value キロバイトより大きくなければなりません。',
        'string' => ':attribute は :value 文字より大きくなければなりません。',
        'array' => ':attribute には :value 個以上のアイテムが必要です。',
    ],
    'gte' => [
        'numeric' => ':attribute は :value 以上でなければなりません。',
        'file' => ':attribute は :value キロバイト以上でなければなりません。',
        'string' => ':attribute は :value 文字以上でなければなりません。',
        'array' => ':attribute には :value 個以上のアイテムが必要です。',
    ],
    'image' => ':attribute は画像でなければなりません。',
    'in' => '選択された :attribute は無効です。',
    'in_array' => ':attribute フィールドは :other に存在しません。',
    'integer' => ':attribute は整数でなければなりません。',
    'ip' => ':attribute は有効なIPアドレスでなければなりません。',
    'ipv4' => ':attribute は有効なIPv4アドレスでなければなりません。',
    'ipv6' => ':attribute は有効なIPv6アドレスでなければなりません。',
    'json' => ':attribute は有効なJSON文字列でなければなりません。',
    'lt' => [
        'numeric' => ':attribute は :value より小さくなければなりません。',
        'file' => ':attribute は :value キロバイトより小さくなければなりません。',
        'string' => ':attribute は :value 文字より小さくなければなりません。',
        'array' => ':attribute には :value 個未満のアイテムが必要です。',
    ],
    'lte' => [
        'numeric' => ':attribute は :value 以下でなければなりません。',
        'file' => ':attribute は :value キロバイト以下でなければなりません。',
        'string' => ':attribute は :value 文字以下でなければなりません。',
        'array' => ':attribute には :value 個以下のアイテムが必要です。',
    ],
    'max' => [
        'numeric' => ':attribute は :max より大きくてはなりません。',
        'file' => ':attribute は :max キロバイトより大きくてはなりません。',
        'string' => ':attribute は :max 文字より多くてはなりません。',
        'array' => ':attribute には :max 個より多くのアイテムを含めることはできません。',
    ],
    'mimes' => ':attribute はタイプ: :values のファイルでなければなりません。',
    'mimetypes' => ':attribute はタイプ: :values のファイルでなければなりません。',
    'min' => [
        'numeric' => ':attribute は少なくとも :min でなければなりません。',
        'file' => ':attribute は少なくとも :min キロバイトでなければなりません。',
        'string' => ':attribute は少なくとも :min 文字でなければなりません。',
        'array' => ':attribute には少なくとも :min 個のアイテムが必要です。',
    ],
    'not_in' => '選択された :attribute は無効です。',
    'not_regex' => ':attribute の形式は無効です。',
    'numeric' => ':attribute は数値でなければなりません。',
    'password' => 'パスワードが正しくありません。',
    'present' => ':attribute フィールドが存在している必要があります。',
    'regex' => ':attribute の形式は無効です。',
    'required' => ':attribute フィールドは必須です。',
    'required_if' => ':attribute フィールドは、:other が :value のときに必須です。',
    'required_unless' => ':attribute フィールドは、:other が :values にない限り必須です。',
    'required_with' => ':attribute フィールドは、:values が存在する場合に必須です。',
    'required_with_all' => ':attribute フィールドは、:values が存在する場合に必須です。',
    'required_without' => ':attribute フィールドは、:values が存在しない場合に必須です。',
    'required_without_all' => ':attribute フィールドは、:values が存在しない場合に必須です。',
    'same' => ':attribute と :other は一致する必要があります。',
    'size' => [
        'numeric' => ':attribute は :size でなければなりません。',
        'file' => ':attribute は :size キロバイトでなければなりません。',
        'string' => ':attribute は :size 文字でなければなりません。',
        'array' => ':attribute は :size 個のアイテムを含める必要があります。',
    ],
    'starts_with' => ':attribute は次のいずれかで始まる必要があります: :values。',
    'string' => ':attribute は文字列でなければなりません。',
    'timezone' => ':attribute は有効なゾーンでなければなりません。',
    'unique' => ':attribute は既に使用されています。',
    'uploaded' => ':attribute のアップロードに失敗しました。',
    'url' => ':attribute の形式は無効です。',
    'uuid' => ':attribute は有効なUUIDでなければなりません。',

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション言語行
    |--------------------------------------------------------------------------
    |
    | ここでは、"attribute.rule" の命名規則を使用して属性ルールに特定の
    | カスタムバリデーションメッセージを指定できます。これにより、
    | 特定の属性ルールに対して特定のカスタム言語行を簡単に指定できます。
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'カスタムメッセージ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性
    |--------------------------------------------------------------------------
    |
    | 次の言語行は、例えば、"E-Mail Address" ではなく "email" といった
    | 読み手に親しみやすい方法で属性プレースホルダーを置き換えるために
    | 使用されます。これは単にメッセージをより表現力豊かにするためです。
    |
    */

    'attributes' => [],

];

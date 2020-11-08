<?php
// 攻撃属性
define('BT_ATTR_01', 1); //火
define('BT_ATTR_02', 2); //木
define('BT_ATTR_03', 3); //風
define('BT_ATTR_04', 4); //水
// 防御属性
define('BT_DF_ATTR_KAI', 1); //回避
define('BT_DF_ATTR_BOU', 2); //防御
define('BT_DF_ATTR_SOUSAI', 3); //相殺
// 覚醒スキル
define('BT_LIMIT_01', 1); //リミットブレイク
define('BT_LIMIT_02', 2); //コンセントレイト
define('BT_LIMIT_03', 3); //デュアルドライブ
// 100-999:攻撃ターン時スキル
define('BT_AT_NASHI', 100); //無し
define('BT_AT_SEI_01', 201); //精密攻撃
define('BT_AT_SEI_02', 202); //精密攻撃
define('BT_AT_SEI_03', 203); //精密攻撃
define('BT_AT_SEI_04', 204); //精密攻撃
define('BT_AT_SEI_04', 304); //精密攻撃
define('BT_AT_BUI_01', 301); //部位破壊
define('BT_AT_BUI_02', 302); //部位破壊
define('BT_AT_BUI_03', 303); //部位破壊
define('BT_AT_BUI_04', 304); //部位破壊
define('BT_AT_GADO', 401); //ガードブレイク
define('BT_AT_HOMI', 402); //ホーミング
define('BT_AT_KONBI', 501); //コンビネーション
define('BT_AT_MEIKYO', 601); //明鏡止水
define('BT_AT_SENI', 701); //戦意高揚
define('BT_AT_SEISIN', 702); //精神統一
// 1000-9999：防御ターン時スキル
define('BT_DF_NASHI', 1000); //無し
define('BT_DF_BOU', 2001); //防御専念
define('BT_DF_KAI', 2002); //回避専念
define('BT_DF_RAN', 2003); //乱数回避
define('BT_DF_KOUBOU', 3001); //攻防一体
define('BT_DF_KAUNTA', 3002); //カウンター
define('BT_DF_KAKUGO', 4001); //覚悟完了
// パッシブスキル
define('BT_PAV_KOU', 1); // 攻撃強化
define('BT_PAV_MEI', 2); // 命中強化
define('BT_PAV_SP', 4); // SP強化
define('BT_PAV_KONBO', 5); // コンボ充填
// 戦闘状態
define('BT_ST_FUKOKU', 1); // 宣戦布告
define('BT_ST_SINKOU', 2); // 進行中
define('BT_ST_TYUDAN', 3); // 中断
define('BT_ST_KETYAKU', 9); // 決着
// 属性の相性
define('BT_COM_FURI', 1); // 不利
define('BT_COM_KIKKOU', 5); // 拮抗
define('BT_COM_YUURI', 9); // 有利
return [
    'Site' => [
        'title' => 'サイト名', // サイト名
        'admin' => 1, // 管理者の登録可能人数
        'logmax' => 10000, // ログを残す行数（全部屋合計）
    ],
    'Room' => [
        'entering' => '{0}に{1}が入室しました。',
        'exiting' => '{0}から{1}が退室しました。',
        'dice' => '{0}：[Dice]{1}...{2} = {3}',
    ],
    'Battle' => [
        'narration' => [
            'NARR_BATTLE_DECLARATION' => '{0}は{1}に宣戦布告！',
            'NARR_BATTLE_START' => '戦闘開始！　先攻は{0}、後攻は{1}！',
            'NARR_BATTLE_RESTART' => '{0}、{1}の戦闘再開！',
            'NARR_BATTLE_STATUS' => '[HP={0} / SP={1} / ×{2} / +{3}dmg / {4}% / {5}]',
            'NARR_BATTLE_DMG' => 'ダメージ計算 / ((5+{0})+({1})+({2}+{3}))*({4})*({5})*({6})={7}dmg',
            'NARR_BATTLE_RENZOKU' => '連撃判定 / (20+{0}*10)={1}% / {2} / {3}',
            'NARR_BATTLE_SOKOJIKARA' => '底力判定 / ({0})+({1}*2)={2}% / {3} / {4}',
            'NARR_BATTLE_MEITYU' => '命中判定 / (20+{0}*10)+({1})+({2}+{3})-({4}+{5}+{6})={7}% / {8} / {9}',
            'NARR_BATTLE_KASURI' => 'かすり傷判定 / (20+{0}*10)={1}% / {2} / {3}',
            'NARR_BATTLE_SKILL' => '{0}【{1}】[{2}] vs [{5}]【{4}】{3}',
            'NARR_MEITYU' => '{0}の『{1}』が{2}に命中！ {3} の{4}ダメージ！',
            'NARR_HAZURE' => '{0}は{1}の『{2}』を{3}した！', // 回避、防御、相殺
            'NARR_KASURI' => 'しかし、{0}しきれず {1} の半減ダメージ！', // 回避、防御、相殺
            'NARR_HATUDOU' => '{0}の{1}が発動！', // 攻防一体、カウンター
            'NARR_KONBI' => ' {0} コンボバースト！',
            'NARR_RENXOKU_HATSUDOU' => '連続攻撃！',
            'NARR_KONBI_FUHATSU' => 'コンビネーション不発！',
            'NARR_SENI_UP' => '{0}は『{1}』を使用！　戦意高揚、HP {2} の回復！',
            'NARR_SENI_FUHATSU' => '{0}は『{1}』を使用！　戦意高揚不発！',
            'NARR_SEISHIN_UP' => '{0}は『{1}』を使用。精神統一、SP {2} の回復！',
            'NARR_SEISHIN_FUHATSU' => '{0}は『{1}』を使用！　精神統一不発！',
            'NARR_SOKOJIKARA' => '{0}の底力が発動！　戦闘続行！',
            'NARR_KAKUSEI' => '{0}の『{1}』が覚醒！', // 覚醒スキル
            'NARR_KO' => '{0}は戦闘不能！',
        ],
        'attributes' => [
            BT_ATTR_01 => '火',
            BT_ATTR_02 => '木',
            BT_ATTR_03 => '風',
            BT_ATTR_04 => '水',
        ],
        'momentums' => [
            BT_DF_ATTR_KAI => '回避',
            BT_DF_ATTR_BOU => '防御',
            BT_DF_ATTR_SOUSAI => '相殺',
        ],
        'compatibilitys' => [
            BT_COM_FURI => '不利',
            BT_COM_KIKKOU => '拮抗',
            BT_COM_YUURI => '有利',
        ],
        'tokills' => [
            0 => '',
            2 => '小',
            3 => '中',
            4 => '大',
        ],
        'limitSkills' => [
            BT_LIMIT_01 => 'リミットブレイク',
            BT_LIMIT_02 => 'コンセントレイト',
            BT_LIMIT_03 => 'デュアルドライブ',
        ],
        'passiveSkills' => [
            BT_PAV_KOU => '攻撃力強化',
            BT_PAV_MEI => '命中率強化',
            BT_PAV_SP => 'SP強化',
            BT_PAV_KONBO => 'コンボ充填',
        ],
        'battleSkills' => [
            '攻撃スキル' => [ // ここの名称を使っていることがあるので、変更時は注意
                BT_AT_SEI_01 => '精密射撃（火）',
                BT_AT_SEI_02 => '精密射撃（木）',
                BT_AT_SEI_03 => '精密射撃（風）',
                BT_AT_SEI_04 => '精密射撃（水）',
                BT_AT_BUI_01 => '部位破壊（火）',
                BT_AT_BUI_02 => '部位破壊（木）',
                BT_AT_BUI_03 => '部位破壊（風）',
                BT_AT_BUI_04 => '部位破壊（水）',
                BT_AT_GADO => 'ガードブレイク',
                BT_AT_HOMI => 'ホーミング',
                BT_AT_KONBI => 'コンビネーション',
                BT_AT_MEIKYO => '明鏡止水',
            ],
            '特殊スキル' => [ // ここの名称を使っていることがあるので、変更時は注意
                BT_AT_SENI => '戦意高揚',
                BT_AT_SEISIN => '精神統一',
            ],
            '防御スキル' => [ // ここの名称を使っていることがあるので、変更時は注意
                BT_DF_BOU => '防御専念',
                BT_DF_KAI => '回避専念',
                BT_DF_RAN => '乱数回避',
                BT_DF_KOUBOU => '攻防一体',
                BT_DF_KAUNTA => 'カウンター',
                BT_DF_KAKUGO => '覚悟完了',
            ]
        ],
    ],
    'ColorCodes' => [ // name は CSS でも出力するため、英名にすること
        ['code' => '#000000', 'name' => 'black', ],
        ['code' => '#000080', 'name' => 'navy', ],
        ['code' => '#00008b', 'name' => 'darkblue', ],
        ['code' => '#0000cd', 'name' => 'mediumblue', ],
        ['code' => '#0000ff', 'name' => 'blue', ],
        ['code' => '#006400', 'name' => 'darkgreen', ],
        ['code' => '#008000', 'name' => 'green', ],
        ['code' => '#008080', 'name' => 'teal', ],
        ['code' => '#008b8b', 'name' => 'darkcyan', ],
        ['code' => '#00bfff', 'name' => 'deepskyblue', ],
        ['code' => '#00ced1', 'name' => 'darkturquoise', ],
        ['code' => '#00fa9a', 'name' => 'mediumspringgreen', ],
        ['code' => '#00ff00', 'name' => 'lime', ],
        ['code' => '#00ff7f', 'name' => 'springgreen', ],
        ['code' => '#00ffff', 'name' => 'aqua', ],
        ['code' => '#00ffff', 'name' => 'cyan', ],
        ['code' => '#191970', 'name' => 'midnightblue', ],
        ['code' => '#1e90ff', 'name' => 'dodgerblue', ],
        ['code' => '#20b2aa', 'name' => 'lightseagreen', ],
        ['code' => '#228b22', 'name' => 'forestgreen', ],
        ['code' => '#2e8b57', 'name' => 'seagreen', ],
        ['code' => '#2f4f4f', 'name' => 'darkslategray', ],
        ['code' => '#32cd32', 'name' => 'limegreen', ],
        ['code' => '#3cb371', 'name' => 'mediumseagreen', ],
        ['code' => '#40e0d0', 'name' => 'turquoise', ],
        ['code' => '#4169e1', 'name' => 'royalblue', ],
        ['code' => '#4682b4', 'name' => 'steelblue', ],
        ['code' => '#483d8b', 'name' => 'darkslateblue', ],
        ['code' => '#48d1cc', 'name' => 'mediumturquoise', ],
        ['code' => '#4b0082', 'name' => 'indigo', ],
        ['code' => '#556b2f', 'name' => 'darkolivegreen', ],
        ['code' => '#5f9ea0', 'name' => 'cadetblue', ],
        ['code' => '#6495ed', 'name' => 'cornflowerblue', ],
        ['code' => '#66cdaa', 'name' => 'mediumaquamarine', ],
        ['code' => '#696969', 'name' => 'dimgray', ],
        ['code' => '#6a5acd', 'name' => 'slateblue', ],
        ['code' => '#6b8e23', 'name' => 'olivedrab', ],
        ['code' => '#708090', 'name' => 'slategray', ],
        ['code' => '#778899', 'name' => 'lightslategray', ],
        ['code' => '#7b68ee', 'name' => 'mediumslateblue', ],
        ['code' => '#7cfc00', 'name' => 'lawngreen', ],
        ['code' => '#7fff00', 'name' => 'chartreuse', ],
        ['code' => '#7fffd4', 'name' => 'aquamarine', ],
        ['code' => '#800000', 'name' => 'maroon', ],
        ['code' => '#800080', 'name' => 'purple', ],
        ['code' => '#808000', 'name' => 'olive', ],
        ['code' => '#808080', 'name' => 'gray', ],
        ['code' => '#87ceeb', 'name' => 'skyblue', ],
        ['code' => '#87cefa', 'name' => 'lightskyblue', ],
        ['code' => '#8a2be2', 'name' => 'blueviolet', ],
        ['code' => '#8b0000', 'name' => 'darkred', ],
        ['code' => '#8b008b', 'name' => 'darkmagenta', ],
        ['code' => '#8b4513', 'name' => 'saddlebrown', ],
        ['code' => '#8fbc8f', 'name' => 'darkseagreen', ],
        ['code' => '#90ee90', 'name' => 'lightgreen', ],
        ['code' => '#9370db', 'name' => 'mediumpurple', ],
        ['code' => '#9400d3', 'name' => 'darkviolet', ],
        ['code' => '#98fb98', 'name' => 'palegreen', ],
        ['code' => '#9932cc', 'name' => 'darkorchid', ],
        ['code' => '#9acd32', 'name' => 'yellowgreen', ],
        ['code' => '#a0522d', 'name' => 'sienna', ],
        ['code' => '#a52a2a', 'name' => 'brown', ],
        ['code' => '#a9a9a9', 'name' => 'darkgray', ],
        ['code' => '#add8e6', 'name' => 'lightblue', ],
        ['code' => '#adff2f', 'name' => 'greenyellow', ],
        ['code' => '#afeeee', 'name' => 'paleturquoise', ],
        ['code' => '#b0c4de', 'name' => 'lightsteelblue', ],
        ['code' => '#b0e0e6', 'name' => 'powderblue', ],
        ['code' => '#b22222', 'name' => 'firebrick', ],
        ['code' => '#b8860b', 'name' => 'darkgoldenrod', ],
        ['code' => '#ba55d3', 'name' => 'mediumorchid', ],
        ['code' => '#bc8f8f', 'name' => 'rosybrown', ],
        ['code' => '#bdb76b', 'name' => 'darkkhaki', ],
        ['code' => '#c0c0c0', 'name' => 'silver', ],
        ['code' => '#c71585', 'name' => 'mediumvioletred', ],
        ['code' => '#cd5c5c', 'name' => 'indianred', ],
        ['code' => '#cd853f', 'name' => 'peru', ],
        ['code' => '#d2691e', 'name' => 'chocolate', ],
        ['code' => '#d2b48c', 'name' => 'tan', ],
        ['code' => '#d3d3d3', 'name' => 'lightgray', ],
        ['code' => '#d8bfd8', 'name' => 'thistle', ],
        ['code' => '#da70d6', 'name' => 'orchid', ],
        ['code' => '#daa520', 'name' => 'goldenrod', ],
        ['code' => '#db7093', 'name' => 'palevioletred', ],
        ['code' => '#dc143c', 'name' => 'crimson', ],
        ['code' => '#dcdcdc', 'name' => 'gainsboro', ],
        ['code' => '#dda0dd', 'name' => 'plum', ],
        ['code' => '#deb887', 'name' => 'burlywood', ],
        ['code' => '#e0ffff', 'name' => 'lightcyan', ],
        ['code' => '#e6e6fa', 'name' => 'lavender', ],
        ['code' => '#e9967a', 'name' => 'darksalmon', ],
        ['code' => '#ee82ee', 'name' => 'violet', ],
        ['code' => '#eee8aa', 'name' => 'palegoldenrod', ],
        ['code' => '#f08080', 'name' => 'lightcoral', ],
        ['code' => '#f0e68c', 'name' => 'khaki', ],
        ['code' => '#f0f8ff', 'name' => 'aliceblue', ],
        ['code' => '#f0fff0', 'name' => 'honeydew', ],
        ['code' => '#f0ffff', 'name' => 'azure', ],
        ['code' => '#f4a460', 'name' => 'sandybrown', ],
        ['code' => '#f5deb3', 'name' => 'wheat', ],
        ['code' => '#f5f5dc', 'name' => 'beige', ],
        ['code' => '#f5f5f5', 'name' => 'whitesmoke', ],
        ['code' => '#f5fffa', 'name' => 'mintcream', ],
        ['code' => '#f8f8ff', 'name' => 'ghostwhite', ],
        ['code' => '#fa8072', 'name' => 'salmon', ],
        ['code' => '#faebd7', 'name' => 'antiquewhite', ],
        ['code' => '#faf0e6', 'name' => 'linen', ],
        ['code' => '#fafad2', 'name' => 'lightgoldenrodyellow', ],
        ['code' => '#fdf5e6', 'name' => 'oldlace', ],
        ['code' => '#ff0000', 'name' => 'red', ],
        ['code' => '#ff00ff', 'name' => 'fuchsia', ],
        ['code' => '#ff00ff', 'name' => 'magenta', ],
        ['code' => '#ff1493', 'name' => 'deeppink', ],
        ['code' => '#ff4500', 'name' => 'orangered', ],
        ['code' => '#ff6347', 'name' => 'tomato', ],
        ['code' => '#ff69b4', 'name' => 'hotpink', ],
        ['code' => '#ff7f50', 'name' => 'coral', ],
        ['code' => '#ff8c00', 'name' => 'darkorange', ],
        ['code' => '#ffa07a', 'name' => 'lightsalmon', ],
        ['code' => '#ffa500', 'name' => 'orange', ],
        ['code' => '#ffb6c1', 'name' => 'lightpink', ],
        ['code' => '#ffc0cb', 'name' => 'pink', ],
        ['code' => '#ffd700', 'name' => 'gold', ],
        ['code' => '#ffdab9', 'name' => 'peachpuff', ],
        ['code' => '#ffdead', 'name' => 'navajowhite', ],
        ['code' => '#ffe4b5', 'name' => 'moccasin', ],
        ['code' => '#ffe4c4', 'name' => 'bisque', ],
        ['code' => '#ffe4e1', 'name' => 'mistyrose', ],
        ['code' => '#ffebcd', 'name' => 'blanchedalmond', ],
        ['code' => '#ffefd5', 'name' => 'papayawhip', ],
        ['code' => '#fff0f5', 'name' => 'lavenderblush', ],
        ['code' => '#fff5ee', 'name' => 'seashell', ],
        ['code' => '#fff8dc', 'name' => 'cornsilk', ],
        ['code' => '#fffacd', 'name' => 'lemonchiffon', ],
        ['code' => '#fffaf0', 'name' => 'floralwhite', ],
        ['code' => '#fffafa', 'name' => 'snow', ],
        ['code' => '#ffff00', 'name' => 'yellow', ],
        ['code' => '#ffffe0', 'name' => 'lightyellow', ],
        ['code' => '#fffff0', 'name' => 'ivory', ],
        ['code' => '#ffffff', 'name' => 'white', ],
    ],
];

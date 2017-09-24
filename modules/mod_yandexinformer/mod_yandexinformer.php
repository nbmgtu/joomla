<?php
defined('_JEXEC') or die('Restricted access');

$YANDEX_ID = $params->get('yandexid', 0);
$YANDEX_TEXTCOLOR = $params->get('yandextextcolor', 0);
$YANDEX_COLORBEGIN = $params->get('yandexcolorbegin', 'FFFFFFFF');
$YANDEX_COLOREND = $params->get('yandexcolorend', 'EFEFEFFF');
$YANDEX_ARROWCOLOR = $params->get('yandexarrowcolor', 1);
$YANDEX_SIZE = $params->get('yandexsize', 3);
$YANDEX_VIEW = $params->get('yandexview', 'pageviews');

switch ( $YANDEX_VIEW )
{
 case 'pageviews': $YANDEX_VIEW_TITLE = 'просмотры'; break;
 case 'visits': $YANDEX_VIEW_TITLE = 'визиты'; break;
 case 'uniques': $YANDEX_VIEW_TITLE = 'уникальные посетители'; break;
}

switch ( $YANDEX_SIZE )
{
 case 3: $YANDEX_STYLE = 'width:88px; height:31px; border:0;'; $YANDEX_VIEW_TITLE = 'просмотры, визиты и уникальные посетители'; break;
 case 2: $YANDEX_STYLE = 'width:80px; height:31px; border:0;'; break;
 case 1: $YANDEX_STYLE = 'width:80px; height:15px; border:0;'; break;
}

echo str_replace(
 array( '{YANDEX_ID}', '{YANDEX_TEXTCOLOR}', '{YANDEX_COLORBEGIN}', '{YANDEX_COLOREND}', '{YANDEX_ARROWCOLOR}', '{YANDEX_SIZE}', '{YANDEX_VIEW}', '{YANDEX_VIEW_TITLE}', '{YANDEX_STYLE}'),
 array($YANDEX_ID, $YANDEX_TEXTCOLOR, $YANDEX_COLORBEGIN, $YANDEX_COLOREND, $YANDEX_ARROWCOLOR, $YANDEX_SIZE, $YANDEX_VIEW, $YANDEX_VIEW_TITLE, $YANDEX_STYLE),
 file_get_contents(__DIR__ . '/yandexinformer.template')
);

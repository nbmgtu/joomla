<?php
defined('_JEXEC') or die('Restricted access');

echo str_replace('{YANDEX_ID}', $params->get('yandexid', 0), file_get_contents(__DIR__ . '/yandexcounter.template'));

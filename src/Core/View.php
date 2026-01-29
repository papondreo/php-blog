<?php

namespace App\Core;

use Smarty;

class View
{
    private static ?Smarty $smarty = null;

    public static function getInstance(): Smarty
    {
        if (self::$smarty === null) {
            $config = require dirname(__DIR__) . '/Config/config.php';
            $paths = $config['paths'];

            self::$smarty = new Smarty();
            self::$smarty->setTemplateDir($paths['templates']);
            self::$smarty->setCompileDir($paths['templates_c']);
            self::$smarty->setCacheDir($paths['cache']);

            self::$smarty->assign('base_url', $config['app']['base_url']);
        }

        return self::$smarty;
    }

    public static function render(string $template, array $data = []): void
    {
        $smarty = self::getInstance();

        foreach ($data as $key => $value) {
            $smarty->assign($key, $value);
        }

        $smarty->display($template);
    }
}


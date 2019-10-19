<?php

namespace app\helpers;

use app\Application;

/**
 * Class SortLink
 *
 * @package app\helpers
 */
class SortLink
{

    /**
     * @var null|array
     */
    protected static $_parsedData = null;

    /**
     * @var null|UrlMixer
     */
    protected static $_currentUrl = null;

    /**
     * @param string $sortParam
     *
     * @return array
     */
    public static function parse($sortParam = 'sort')
    {
        if (is_null(self::$_parsedData)) {
            $descending = false;
            $sortColumn = Application::getInstance()->request->get($sortParam);
            if (!empty($sortColumn)) {
                if (strncmp($sortColumn, '-', 1) === 0) {
                    $descending = true;
                    $sortColumn = substr($sortColumn, 1);
                }
            }
            self::$_parsedData = [$sortColumn, $descending];
        }

        return self::$_parsedData;
    }

    /**
     * @return UrlMixer|null
     */
    protected static function getCurrentUrl()
    {
        if (is_null(self::$_currentUrl)) {
            self::$_currentUrl = new UrlMixer(Application::getInstance()->request->getRequestUri());
        }

        return self::$_currentUrl;
    }

    /**
     * @param $column
     * @param $title
     * @param string $sortParam
     *
     * @return string
     */
    public static function make($column, $title, $sortParam = 'sort')
    {
        list($currentColumn, $descending) = self::parse($sortParam);
        $icon = '';
        if ($currentColumn === $column) {
            if ($descending) {
                $icon = '<i class="fa fa-fw fa-sort-up"></i>';
            } else {
                $icon = '<i class="fa fa-fw fa-sort-down"></i>';
                $column = '-' . $column;
            }
        }

        $href = self::getCurrentUrl()->mix([$sortParam => $column]);

        return '<a href="' . $href . '">' . $title . ' ' . $icon . '</a>';
    }
}
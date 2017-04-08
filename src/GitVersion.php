<?php
/**
 *    ______            __             __
 *   / ____/___  ____  / /__________  / /
 *  / /   / __ \/ __ \/ __/ ___/ __ \/ /
 * / /___/ /_/ / / / / /_/ /  / /_/ / /
 * \______________/_/\__/_/   \____/_/
 *    /   |  / / /_
 *   / /| | / / __/
 *  / ___ |/ / /_
 * /_/ _|||_/\__/ __     __
 *    / __ \___  / /__  / /____
 *   / / / / _ \/ / _ \/ __/ _ \
 *  / /_/ /  __/ /  __/ /_/  __/
 * /_____/\___/_/\___/\__/\___/
 *
 */
namespace ControlAltDelete;

class GitVersion
{
    /**
     * @var string
     */
    static private $version;

    /**
     * Retrieve the git version number.
     *
     * @param null $directory
     * @return string
     */
    public static function find($directory = null)
    {
        $iterator = self::getDirectory($directory);
        if (!$iterator) {
            static::$version = 'v0.0.1';
            return static::$version;
        }

        $files = self::getFileList($iterator);

        natsort($files);
        static::$version = end($files);

        return static::$version;
    }

    /**
     * @param $files
     * @return array
     */
    private static function getFileList(\DirectoryIterator $files)
    {
        $files = static::directoryIteratorToArray($files);
        $files = array_filter($files, function (\DirectoryIterator $file) {
            return !$file->isDot() && $file->isFile();
        });

        return array_map(function (\DirectoryIterator $file) {
            return $file->getFilename();
        }, $files);
    }

    /**
     * @return \DirectoryIterator|false
     */
    private static function getDirectory($directory)
    {
        $path = $directory . '/.git/refs/tags';

        if (!file_exists($path)) {
            return false;
        }

        return new \DirectoryIterator($path);
    }

    private static function directoryIteratorToArray(\DirectoryIterator $files)
    {
        $output = [];
        foreach ($files as $file) {
            $output[] = $file;
        }

        return $output;
    }
}

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
     * @var array
     */
    static private $fileList = [];

    /**
     * Retrieve the git version number.
     *
     * @param null $directory
     * @return string
     * @throws DirectoryNotFoundException
     */
    public static function find($directory = null)
    {
        $iterator = self::getDirectory($directory);
        if (!$iterator) {
            throw new DirectoryNotFoundException;
        }

        static::loadFileList($iterator);

        natsort(static::$fileList);
        static::$version = end(static::$fileList);

        return static::$version;
    }

    /**
     * @param $files
     * @return array
     */
    private static function loadFileList(\DirectoryIterator $files)
    {
        foreach ($files as $file) {
            static::processFile($file);
        }
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

    /**
     * @param \DirectoryIterator $file
     */
    private static function processFile(\DirectoryIterator $file)
    {
        if ($file->isDot() || !$file->isFile()) {
            return;
        }

        static::$fileList[] = $file->getFilename();
    }
}

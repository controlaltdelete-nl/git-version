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

namespace ControlAltDelete\Tests;

use ControlAltDelete\GitVersion;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class GitVersionTest extends TestCase
{
    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    private $root;

    public function setUp()
    {
        $structure = [
            '.git' => [
                'refs' => [
                    'tags' => [
                        'v1.0' => 'v1.0',
                        'v10.0' => 'v10.0',
                        'v2.0' => 'v2.0',
                    ]
                ]
            ]
        ];

        $this->root = vfsStream::setup('root', null, $structure);
    }

    /**
     * @expectedException \ControlAltDelete\DirectoryNotFoundException
     */
    public function testShouldThrowAnExceptionWhenDirectoryNotFound()
    {
        GitVersion::find('random/directory/that/does/not/exists');
    }

    public function testUsesNatsorting()
    {
        $result = GitVersion::find($this->root->url());

        $this->assertEquals('v10.0', $result);
    }
}

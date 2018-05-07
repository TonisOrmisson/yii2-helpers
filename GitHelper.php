<?php
/**
 * Created by PhpStorm.
 * User: tonis_o
 * Date: 11.04.18
 * Time: 15:45
 */

namespace andmemasin\helpers;


class QuickGit
{
    /** @var int */
    private $major = 1;
    /** @var int */
    private $minor = 0;
    /** @var string */
    private $patch = '';
    /** @var int */
    private $commits = 0;
    /** @var string */
    private $commit = '';

    /**
     * @method __construct
     */
    public function __construct()
    {
        // Collect git data.
        exec('git describe --always', $gitHashShort);
        $this->patch = $gitHashShort;
        exec('git rev-list HEAD | wc -l', $gitCommits);
        $this->commits = $gitCommits;
        exec('git log -1', $gitHashLong);
        $this->commit = $gitHashLong;
    }
    /**
     * @return string
     */
    public function toString($format = 'short')
    {
        switch ($format) {
            case 'long':
                return sprintf(
                    '%d.%d.%s (#%d, %s)',
                    $this->major,
                    $this->minor,
                    $this->patch,
                    $this->commits,
                    $this->commit
                );
            default:
                return sprintf(
                    '%d.%d.%s',
                    $this->major,
                    $this->minor,
                    $this->patch
                );
        }
    }

    /**
     * @method __toString
     */
    public function __toString()
    {
        return $this->toString();
    }
}
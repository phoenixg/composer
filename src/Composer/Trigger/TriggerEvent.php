<?php

/*
 * This file is part of Composer.
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Composer\Trigger;

use Composer\Composer;
use Composer\IO\IOInterface;

/**
 * The Trigger Event.
 *
 * @author François Pluchino <francois.pluchino@opendisplay.com>
 */
class TriggerEvent
{
    /**
     * @var string This event's name
     */
    private $name;

    /**
     * @var Composer The composer instance
     */
    private $composer;

    /**
     * @var IOInterface The IO instance
     */
    private $io;

    /**
     * Constructor.
     *
     * @param string      $name     The event name
     * @param Composer    $composer The composer objet
     * @param IOInterface $io       The IOInterface object
     */
    public function __construct($name, Composer $composer, IOInterface $io)
    {
        $this->name = $name;
        $this->composer = $composer;
        $this->io = $io;
    }

    /**
     * Returns the event's name.
     *
     * @return string The event name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the composer instance.
     *
     * @return Composer
     */
    public function getComposer()
    {
        return $this->composer;
    }

    /**
     * Returns the IO instance.
     *
     * @return IOInterface
     */
    public function getIO()
    {
        return $this->io;
    }
}
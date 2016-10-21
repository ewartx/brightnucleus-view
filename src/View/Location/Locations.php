<?php
/**
 * Bright Nucleus View Component.
 *
 * @package   BrightNucleus\View
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      http://www.brightnucleus.com/
 * @copyright 2016 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\View\Location;

use BrightNucleus\View\Exception\InvalidLocation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Locations.
 *
 * @since   0.1.1
 *
 * @package BrightNucleus\View\Location
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class Locations extends ArrayCollection
{

    /**
     * Adds a location at the end of the collection if it does not already exist.
     *
     * @param mixed $location The location to add.
     *
     * @return boolean Whether the location was added or not.
     */
    public function add($location)
    {
        if ($this->hasLocation($location)) {
            return false;
        }

        return parent::add($location);
    }

    /**
     * Check whether a given location is already registered.
     *
     * For two locations to be equal, both their path and their extensions must be the same.
     *
     * @since 0.1.1
     *
     * @param Location $location Location to check the existence of.
     *
     * @return bool Whether the location is already registered or not.
     *
     * @throws InvalidLocation If the location is not valid.
     */
    public function hasLocation($location)
    {
        if ( ! $location instanceof Location) {
            throw new InvalidLocation(
                sprintf(
                    _('Invalid location to check existence for: "%s".'),
                    serialize($location)
                )
            );
        }

        return $this->exists(function ($key, $element) use ($location) {
            return $location == $element;
        });
    }
}
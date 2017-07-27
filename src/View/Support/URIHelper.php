<?php declare(strict_types=1);
/**
 * Bright Nucleus View Component.
 *
 * @package   BrightNucleus\View
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      http://www.brightnucleus.com/
 * @copyright 2016-2017 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\View\Support;

/**
 * Class URIHelper.
 *
 * @since   0.1.1
 *
 * @package BrightNucleus\View\Support
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class URIHelper
{

    /**
     * Check whether a given URI has a specific extension.
     *
     * @since 0.1.3
     *
     * @param string $uri       URI to check the extension of.
     * @param string $extension Extension to check for.
     *
     * @return bool
     */
    public static function hasExtension(string $uri, string $extension): bool
    {
        $uriLength       = mb_strlen($uri);
        $extensionLength = mb_strlen($extension);
        if ($extensionLength > $uriLength) {
            return false;
        }

        return substr_compare($uri, $extension, $uriLength - $extensionLength, $extensionLength) === 0;
    }

    /**
     * Get the filename for an URI.
     *
     * @since 0.1.3
     *
     * @param string $uri URI to get the filename from.
     *
     * @return string Filename without path.
     */
    public static function getFilename(string $uri): String
    {
        return basename($uri);
    }
}

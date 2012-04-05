<?php
/**
 * File containing the eZTidyFilter class
 *
 * @version //autogentag//
 * @package EZTidy
 * @copyright Copyright (C) 2008-2012 Guillaume Kulakowski and contributors
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

/**
 * The eZTidyFilter class provide eZTidy output filter for eZ Publish
 *
 * @package EZTidy
 * @version //autogentag//
 */
class eZTidyFilter
{

    /**
     * Tidyfication of output
     *
     * @param string $output
     */
    static function filter( $output )
    {
        $tidy = eZTidy::instance( 'OutputFilter' );
        return $tidy->tidyCleaner( $output );
    }

}

?>
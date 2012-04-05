<?php
/**
 * File containing the eZTidy class
 *
 * @version //autogentag//
 * @package EZTidy
 * @copyright Copyright (C) 2008-2012 Guillaume Kulakowski and contributors
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

/**
 * The eZTidy class provide Tidy functions in eZ Publish
 *
 * @package EZTidy
 * @version //autogentag//
 */
class eZTidy
{
    protected $tidy;
    protected $config = array();
    protected $options = array();
    public $isTidyfied = false;


    /**
     * Constructor
     *
     * @param string $conf_section
     */
    function __construct( $conf_section )
    {
        $ini = eZINI::instance( "eztidy.ini" );

        $this->config = $ini->variable( $conf_section, 'Configuration' );
        $this->options = $ini->variableMulti( 'Global', array(
            'charset'            => 'Charset',
            'showTidyElement'    => 'ShowTidyElement'
        ) );
    }



    /**
     * Get a new instance of eZTidy
     *
     * @param string $conf_section
     * @return object eZTidy
     */
    static function instance( $conf_section = "Tidy" )
    {
        $globalsKey = "eZTidyGlobalInstance-$conf_section";
        $globalsIsLoadedKey = "eZTidyGlobalIsLoaded-$conf_section";

        if ( !isset( $GLOBALS[$globalsKey] ) ||
            !( $GLOBALS[$globalsKey] instanceof eZTidy ) )
        {
            $GLOBALS[$globalsIsLoadedKey] = false;
            $GLOBALS[$globalsKey] = new eZTidy( $conf_section );
            $GLOBALS[$globalsIsLoadedKey] = true;
        }

        return $GLOBALS[$globalsKey];
    }



    /**
     * Show tidy warning
     */
    private function reportWarning()
    {
        $warning = tidy_get_error_buffer( $this->tidy );
        if ( !empty($warning) )
        {
            eZDebugSetting::writeWarning( "extension-eztidy", "$warning", 'eZTidy::tidyCleaner()' );
        }
    }



    /**
     * Tidyfication of the strings
     *
     * @param string $str
     * @return string
     */
    public function tidyCleaner ( $str )
    {
        eZDebug::accumulatorStart( 'eztidytemplateoperator', 'Tidy', 'Tidy template operator' );

        if ( !class_exists( 'tidy' ) )
        {
            eZDebug::writeError( "phpTidy isn't installed", 'eZTidy::tidyCleaner()' );
            return $str;
        }

        $str = trim( $str );
        if ( $str == "" )
        {
            return "";
        }

        $this->tidy = new tidy;
        $this->tidy->parseString( $str, $this->config, $this->options['charset'] );
        $this->tidy->cleanRepair();
        $this->isTidyfied = true;
        $this->reportWarning();
        $output = tidy_get_output( $this->tidy );

        if ( strtolower( $this->options['showTidyElement'] ) == 'enabled' )
        {
            return "<!-- Tidy - Begin -->\n" . $output . "\n<!-- Tidy - End -->";
        }

        eZDebug::accumulatorStop( 'eztidytemplateoperator' );

        return $output;
    }

}

?>
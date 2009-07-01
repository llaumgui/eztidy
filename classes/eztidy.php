<?php
//
// Definition of eZTidy class
//
// Created on: <28-nov-2008 12:14:34 bf>
//
// SOFTWARE NAME: eZTidy
// SOFTWARE RELEASE: 0.2
// BUILD VERSION:
// COPYRIGHT NOTICE: Copyright (c) 2008 Guillaume Kulakowski and contributors
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//


/*! \file eztidy.php
*/

/*!
  \class eZTidy eztidy.php
  \brief
*/
class eZTidy
{
    protected $tidy;
    protected $config = array();
    protected $options = array();
    public $isTidyfied = false;


    /*!
     Constructor

     \param $conf_section string
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


    /*!
     Get a new instance of eZTidy

     \param $conf_section string
     \return object eZTidy
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



    /*!
     Show tidy warning
     */
    private function reportWarning()
    {
        $warning = tidy_get_error_buffer($this->tidy);
        if ( !empty($warning) )
            eZDebugSetting::writeWarning( "extension-eztidy", "$warning", 'eZTidy::tidyCleaner()' );
    }



    /*!
     Tidyfication des strings

     \param $str string
     \return string
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
            return "";

        $this->tidy = new tidy;
        $this->tidy->parseString( $str, $this->config, $this->options['charset'] );
        $this->tidy->cleanRepair();
        $this->isTidyfied = true;
        $this->reportWarning();
        $output = tidy_get_output( $this->tidy );

        if ( strtolower($this->options['showTidyElement']) == 'enabled' )
            return "<!-- Tidy - Begin -->\n" . $output . "\n<!-- Tidy - End -->";

        eZDebug::accumulatorStop( 'eztidytemplateoperator' );

        return $output;
    }

} // EOC

?>
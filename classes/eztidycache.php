<?php
//
// Definition of eZTidyCache class
//
// Created on: <28-nov-2008 12:14:34 bf>
//
// SOFTWARE NAME: eZTidy
// SOFTWARE RELEASE: 1.0
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


/*! \file eztidycache.php
*/

/*!
  \class eZTidyCache eztidycache.php
  \brief
*/
class eZTidyCache extends eZTidy
{

    /*!
     Constructeur
     */
    function __construct()
    {
        $ini = eZINI::instance( "eztidy.ini" );

        $this->config = $ini->variable( 'TidyCache', 'Configuration' );
        $this->options = array_merge(
            $ini->variableMulti( 'Global', array(
                'charset'            => 'Charset',
                'showTidyElement'    => 'ShowTidyElement'
            ) ),
            $ini->variableMulti( 'TidyCache', array(
                'viewCache'            => 'ViewCache',
                'templateBlock'        => 'TemplateBlock'
            ) )
        );

    }



    /*!
     Permet d'instancier l'objet eZTidyCache.

     \return object eZTidyCache
     */
    static function instance()
    {
        if ( !isset( $GLOBALS['eZTidyCacheInstance'] ) ||
             !( $GLOBALS['eZTidyCacheInstance'] instanceof eZTidyCache ) )
        {
            $GLOBALS['eZTidyCacheInstance'] = new eZTidyCache();
        }

        return $GLOBALS['eZTidyCacheInstance'];
    }



    /*!
     Permet de nettoyer le contenu avant sa mise en cache.

     \param &$contents mixed
     \param $scope string
     \param $filePath string
     \@return string
     */
    public function clean( &$contents, $scope, $filePath )
    {
        switch ($scope)
        {
        	case 'viewcache':
            	if ( strtolower($this->options['viewCache']) == 'enabled' )
            	{
            	    $this->cleanSerial( $contents, 'content' );
                    eZDebugSetting::writeDebug( "\"$filePath\" with scope \"$scope\" is tidyfied", "eZTidyCache::clean()" );
            	}
            	break;

        	case 'template-block':
        	   if ( strtolower($this->options['templateBlock']) == 'enabled' )
        	    {
    	            $contents = $this->tidyCleaner( $contents );
    	            eZDebug::writeDebug( "\"$filePath\" with scope \"$scope\" is tidyfied", "eZTidyCache::clean()" );
        	    }
            	break;

        	default:
            	break;
        }
    }



    /*!
     Tidyfication des serial

     \param &$contents string
     \param $part string
     */
    private function cleanSerial( &$contents, $part )
    {
        $data = @unserialize( $contents );
        if ( is_array( $data ) && array_key_exists( $part, $data ) )
        {
            $data[$part] = $this->tidyCleaner( $data[$part] );
            $contents = serialize( $data );
        }
    }

} // EOC

?>
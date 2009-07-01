<?php
//
// Definition of eZTidyTemplatesOperators class
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


/*! \file eztidycache.php
*/

/*!
  \class eZTidyTemplatesOperators eztidytemplatesoperators.php
  \brief
*/
class eZTidyTemplatesOperators
{

    private $Operators;


    /*!
     Constructor
     */
    function __construct()
    {
        /* Opérateurs */
        $this->Operators = array(
            'tidy',
        );
    }



    function &operatorList()
    {
        return $this->Operators;
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
         return array(
            'tidy' => array( ),
        );
    }



    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace,
                      &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'tidy':
                eZDebugSetting::writeNotice( "extension-eztidy", "Use 'tidy' template operator", "eZTidy::tidyCleaner()" );
                $tidy = eZTidy::instance();
                $operatorValue = $tidy->tidyCleaner( $operatorValue );
                break;
        }
    }

} // EOC

?>
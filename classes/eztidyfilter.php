<?php
//
// Definition of eZTidyFilter class
//
// Created on: <28-nov-2008 12:14:34 bf>
//
// SOFTWARE NAME: eZTidy
// SOFTWARE RELEASE: 0.9
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


/*! \file eztidyfilter
*/

/*!
  \class eZTidyFilter eztidyfilter
  \brief
*/
class eZTidyFilter
{

    static function filter( $output )
    {
        $tidy = eZTidy::instance( 'OutputFilter' );
        return $tidy->tidyCleaner( $output );
    }

}

?>
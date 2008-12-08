<?php
//
// Definition of eZDBTidyFileHandler class
//
// Created on: <28-Nov-2008 16:40:46 vs>
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

/*! \file ezdbtidyfilehandler.php
*/
class eZDBTidyFileHandler extends eZDBFileHandler
{

    /**
     * Store file contents.
     *
     * \public
     * \static
     */
    function fileStoreContents( $filePath, $contents, $scope = false, $datatype = false )
    {
        eZDebug::accumulatorStart( 'eztidycache', 'Tidy', 'Tidy cache' );
        $ezTidyCache = eZTidyCache::instance();
        $ezTidyCache->clean( $contents, $scope );
        eZDebug::accumulatorStop( 'eztidycache' );

        parent::storeContents( $contents, $scope, $datatype, $storeLocally );
    }

} // EOC

?>
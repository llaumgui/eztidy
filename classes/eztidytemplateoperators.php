<?php
/**
 * File containing the eZTidyTemplatesOperators class
 *
 * @version //autogentag//
 * @package EZTidy
 * @copyright Copyright (C) 2008-2012 Guillaume Kulakowski and contributors
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

/**
 * The eZTidyTemplatesOperators class provide Tidy's templates operators to eZ Publish.
 *
 * @package EZTidy
 * @version //autogentag//
 */
class eZTidyTemplatesOperators
{

    private $Operators;


    /**
     * Constructor
     */
    function __construct()
    {
        $this->Operators = array(
            'tidy',
        );
    }



    /**
     * Return list of operators
     *
     * @return multitype:string
     */
    function &operatorList()
    {
        return $this->Operators;
    }



    /**
     * Return named parameters by operator
     *
     * @return boolean
     */
    function namedParameterPerOperator()
    {
        return true;
    }



    /**
     * Return named parameters list
     *
     * @return multitype:multitype:
     */
    function namedParameterList()
    {
         return array(
            'tidy' => array( ),
        );
    }



    /**
     * Excecute template operator action
     *
     * @param eZTemplate_type $tpl
     * @param string $operatorName
     * @param array $operatorParameters
     * @param operatorList $rootNamespace
     * @param operatorList $currentNamespace
     * @param string $operatorValue
     * @param array $namedParameters
     */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace,
        &$currentNamespace, &$operatorValue, &$namedParameters
    ) {
        switch ( $operatorName )
        {
            case 'tidy':
                eZDebugSetting::writeNotice( "extension-eztidy", "Use 'tidy' template operator", "eZTidy::tidyCleaner()" );
                $tidy = eZTidy::instance();
                $operatorValue = $tidy->tidyCleaner( $operatorValue );
                break;
        }
    }

}

?>
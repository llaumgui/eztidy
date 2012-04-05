<?php
/**
 * File containing the $eZTemplateOperatorArray array
 *
 * @version //autogentag//
 * @package EZTidy
 * @copyright Copyright (C) 2008-2012 Guillaume Kulakowski and contributors
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

// Operator autoloading
$eZTemplateOperatorArray = array();
$eZTemplateOperatorArray[] = array(
    'script' => 'extension/eztidy/classes/eztidytemplateoperators.php',
    'class' => 'eZTidyTemplatesOperators',
    'operator_names' => array(
        'tidy'
    )
);

?>
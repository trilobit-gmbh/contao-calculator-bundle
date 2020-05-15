<?php

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-calculator-bundle
 */

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['trilobit_contao_calculator.listener.insert_tags', 'onReplace'];

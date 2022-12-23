<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 */

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['trilobit_contao_calculator.listener.insert_tags', 'onReplace'];

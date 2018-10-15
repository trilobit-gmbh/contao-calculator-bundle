<?php

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-calculator-bundle
 */

namespace Trilobit\CalculatorBundle;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

/**
 * Class Calculator.
 */
class Calculator
{
    /**
     * @var array
     */
    private $arrVariables = [];

    /**
     * @param $args
     */
    public function __construct() //$args
    {
        $arrVars = Helper::getConfigData();

        if (!empty($arrVars['vars'])) {
            foreach ($arrVars['vars'] as $strName => $mixedValue) {
                $this->addVariable($strName, $mixedValue);
            }
        }
    }

    /**
     * @param $strName
     * @param $mixedValue
     */
    public function addVariable($strName, $mixedValue)
    {
        $this->arrVariables[$strName] = $mixedValue;
    }

    /**
     * @param $strInsertTag
     *
     * @return bool|string
     */
    public function myCalculator($strInsertTag)
    {
        $arrSplit = explode('::', $strInsertTag, 2);

        // prüfen ob für Taschenrechner
        if ('calc' === $arrSplit[0]) {
            // Rechenergebnis initialisieren
            $strResultValue = 0;

            $strTask = $arrSplit[1];

            $expressionLanguage = new ExpressionLanguage();

            try {
                $strResultValue = ($expressionLanguage->evaluate(
                    $strTask,
                    $this->arrVariables
                ));
            } catch (SyntaxError $e) {
                return false;
            }

            // Ergebnis ausgaben
            return $strResultValue;
        }

        return false;
    }
}

<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-calculator-bundle
 */

namespace Trilobit\ContaoCalculator\EventListener;

use Contao\System;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;
use Trilobit\ContaoCalculator\DependencyInjection\TrilobitContaoCalculatorExtension;

class InsertTagsListener extends TrilobitContaoCalculatorExtension
{
    /**
     * On replace insert tag.
     *
     * @return string|bool
     */
    public function onReplace(string $tag)
    {
        $chunks = explode('::', $tag, 2);

        if ('calc' === $chunks[0]) {
            $task = $chunks[1];

            $taskHelper = [
                'date' => 'Date::parse',
                'post' => 'Input::post',
                'get' => 'Input::get',
            ];

            foreach ($taskHelper as $key => $value) {
                if (preg_match_all('/\[\['.$key.'::(.*?)\]\]/', $chunks[1], $matches)) {
                    foreach ($matches[0] as $k => $v) {
                        $task = str_replace($v, $value($matches[1][$k]), $task);
                    }
                }
            }

            $expressionLanguage = new ExpressionLanguage();

            try {
                $result = $expressionLanguage->evaluate(
                    $task,
                    $this->getUserVariables()
                );
            } catch (SyntaxError $e) {
                return false;
            }

            return $result;
        }

        return false;
    }

    private function getUserVariables(): array
    {
        $container = System::getContainer();

        if (!$container->hasParameter('trilobit.calculator')) {
            return [];
        }

        $parameter = $container->getParameter('trilobit.calculator');

        if (!isset($parameter['vars'])) {
            return [];
        }

        return $parameter['vars'];
    }
}

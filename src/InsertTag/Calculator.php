<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-calculator-bundle
 */

namespace Trilobit\ContaoCalculator\InsertTag;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

class Calculator implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param $insertTag
     *
     * @return bool|string
     */
    public function onEvaluateInsertTag(string $insertTag)
    {
        $parts = explode('::', $insertTag, 2);

        if ('calc' === $parts[0]) {
            $task = $parts[1];

            if (preg_match_all('/\[\[date::(.*?)\]\]/', $parts[1], $dates)) {
                foreach ($dates[0] as $k => $v) {
                    $task = str_replace($v, Date::parse($dates[1][$k]), $task);
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
        if (!$this->container->hasParameter('trilobit')) {
            return [];
        }

        $root = $this->container->getParameter('trilobit');

        if (!isset($root['calculator']['vars'])) {
            return [];
        }

        return $root['calculator']['vars'];
    }
}

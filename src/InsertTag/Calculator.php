<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
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
        if (!$this->container->hasParameter('trilobit_contao_calculator')) {
            return [];
        }

        $root = $this->container->getParameter('trilobit_contao_calculator');

        if (!isset($root['vars'])) {
            return [];
        }

        return $root['vars'];
    }
}

<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-calculator-bundle
 */

namespace Trilobit\ContaoCalculator;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Trilobit\ContaoCalculator\DependencyInjection\TrilobitContaoCalculatorExtension;

/**
 * Configures the trilobit calculator bundle.
 *
 * @author trilobit GmbH <https://github.com/trilobit-gmbh>
 */
class TrilobitContaoCalculatorBundle extends Bundle
{
    /**
     * Overridden to allow for the custom extension alias.
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new TrilobitContaoCalculatorExtension();
        }

        return $this->extension;
    }

    public function getParent()
    {
    }
}

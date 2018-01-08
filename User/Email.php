<?php
/**
 * This file is part of the Borobudur package.
 *
 * (c) 2018 Borobudur <http://borobudur.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Borobudur\Component\Value\User;

use Borobudur\Component\Value\ScalarValueObjectInterface;
use Borobudur\Component\Value\User\Exception\InvalidEmailException;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class Email implements ScalarValueObjectInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $check = filter_var($value, FILTER_VALIDATE_EMAIL);

        if (!$check) {
            throw new InvalidEmailException('Invalid email format');
        }

        $this->value = strtolower($value);
    }

    public function getScalarValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getScalarValue();
    }
}

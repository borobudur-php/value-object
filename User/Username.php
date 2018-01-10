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
use Borobudur\Component\Value\User\Exception\InvalidUsernameException;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class Username implements ScalarValueObjectInterface
{
    public const MIN_LENGTH = 5;

    public const MAX_LENGTH = 10;

    public const FORMAT = '/^[a-z0-9\_]+$/';

    /**
     * @var string
     */
    private $username;

    /**
     * Constructor.
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        $username = strtolower($username);

        $this->validate($username);

        $this->username = $username;
    }

    public function equals(Username $username): bool
    {
        return $this->username === $username->getScalarValue();
    }

    public function setUsername(string $username): Username
    {
        return new Username($username);
    }

    public function getScalarValue()
    {
        return $this->username;
    }

    public function __toString(): string
    {
        return $this->getScalarValue();
    }

    /**
     * @param string $username
     */
    private function validate(string $username): void
    {
        $this->assertNotEmpty($username);
        $this->assertNotTooShort($username);
        $this->assertNotTooLong($username);
        $this->assertValidFormat($username);
    }

    /**
     * @param string $username
     */
    private function assertNotEmpty(string $username): void
    {
        if (empty($username)) {
            throw new InvalidUsernameException('Username cannot be empty');
        }
    }

    /**
     * @param string $username
     */
    private function assertNotTooShort(string $username): void
    {
        if (strlen($username) < self::MIN_LENGTH) {
            throw new InvalidUsernameException(sprintf('Username must be %d characters or more', self::MIN_LENGTH));
        }
    }

    /**
     * @param string $username
     */
    private function assertNotTooLong(string $username): void
    {
        if (strlen($username) > self::MAX_LENGTH) {
            throw new InvalidUsernameException(sprintf('Username must be %d characters or less', self::MAX_LENGTH));
        }
    }

    /**
     * @param string $username
     */
    private function assertValidFormat(string $username): void
    {
        if (1 !== preg_match(self::FORMAT, $username)) {
            throw new InvalidUsernameException('Invalid username format');
        }
    }
}

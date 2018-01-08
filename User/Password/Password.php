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

namespace Borobudur\Component\Value\User\Password;

use Borobudur\Component\Value\User\Password\Hasher\HasherInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class Password
{
    /**
     * @var $hashed
     */
    private $hashed;

    /**
     * @var HasherInterface
     */
    private $hasher;

    /**
     * Constructor.
     *
     * @param string          $hashed
     * @param HasherInterface $hasher
     */
    public function __construct(string $hashed, HasherInterface $hasher)
    {
        $this->hashed = $hashed;
        $this->hasher = $hasher;
    }

    public static function create(string $password, HasherInterface $hasher): Password
    {
        return new static($hasher->hash($password), $hasher);
    }

    public function matches(string $password): bool
    {
        return $this->hasher->verify($password, $this->hashed);
    }

    public function isNeedToRehash(): bool
    {
        return $this->hasher->isNeedToRehash($this->hashed);
    }
}

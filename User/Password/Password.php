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

    public static function fromArray(array $data): Password
    {
        return new Password($data['hashed'], $data['hasher']['class']::{'fromArray'}($data['hasher']['data']));
    }

    public function matches(string $password): bool
    {
        return $this->hasher->verify($password, $this->hashed);
    }

    public function isNeedToRehash(): bool
    {
        return $this->hasher->isNeedToRehash($this->hashed);
    }

    public function toArray(): array
    {
        return [
            'hashed' => $this->hashed,
            'hasher' => [
                'class' => get_class($this->hasher),
                'data'  => $this->hasher->toArray(),
            ],
        ];
    }
}

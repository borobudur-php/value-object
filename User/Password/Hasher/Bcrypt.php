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

namespace Borobudur\Component\Value\User\Password\Hasher;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class Bcrypt implements HasherInterface
{
    public const DEFAULT_COST = 11;

    public const ALGORITHM = ['code' => PASSWORD_BCRYPT, 'name' => 'bcrypt'];

    /**
     * @var array
     */
    private $options;

    /**
     * Constructor.
     *
     * @param int    $cost
     * @param string $salt
     */
    public function __construct(int $cost, string $salt)
    {
        $this->options = ['cost' => $cost, 'salt' => $salt];
    }

    public static function fromArray(array $data): HasherInterface
    {
        return new Bcrypt($data['cost'], $data['salt']);
    }

    public static function create(): Bcrypt
    {
        $salt = base_convert(sha1(uniqid((string) mt_rand(), true)), 16, 36);

        return new static(self::DEFAULT_COST, $salt);
    }

    /**
     * {@inheritdoc}
     */
    public function hash(string $text): string
    {
        return password_hash($text, self::ALGORITHM['code'], $this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function verify(string $text, string $hashed): bool
    {
        return password_verify($text, $hashed);
    }

    /**
     * {@inheritdoc}
     */
    public function isHashed(string $text): bool
    {
        $expected = [
            'algo'     => self::ALGORITHM['code'],
            'algoName' => self::ALGORITHM['name'],
            'options'  => ['cost' => $this->options['cost']],
        ];

        return $expected === password_get_info($text);
    }

    /**
     * {@inheritdoc}
     */
    public function isNeedToRehash(string $hashed): bool
    {
        return password_needs_rehash($hashed, self::ALGORITHM['code'], $this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return $this->options;
    }
}

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
interface HasherInterface
{
    public static function fromArray(array $data): HasherInterface;

    public function hash(string $text): string;

    public function verify(string $text, string $hashed): bool;

    public function isHashed(string $text): bool;

    public function isNeedToRehash(string $hashed): bool;

    public function toArray(): array;
}

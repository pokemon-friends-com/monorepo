<?php

namespace pkmnfriends\Infrastructure\Contracts\Traits;

use Illuminate\Support\Facades\Crypt;

trait SecurityHashTrait
{

    /**
     * @param mixed $data Date to crypt.
     *
     * @return string
     */
    protected function createHash($data)
    {
        $serializedData = serialize($data);
        $hash = Crypt::encryptString($serializedData);

        return base64_encode($hash);
    }

    /**
     * @param string $base64Hash Base64 encoded string to decrypt.
     *
     * @return mixed
     */
    protected function readHash(string $base64Hash)
    {
        $hash = base64_decode($base64Hash);
        $serializedData = Crypt::decryptString($hash);

        return unserialize($serializedData);
    }
}

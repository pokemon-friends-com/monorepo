<?php namespace obsession\App\Traits;

use Illuminate\Support\Facades\Crypt;

trait SecurityHashTrait
{

    /**
     * @param string|array|Object $data Date to crypt.
     *
     * @return string
     */
    protected function createHash($data)
    {
        $data = serialize($data);
        $hash = Crypt::encryptString($data);

        return base64_encode($hash);
    }

    /**
     * @param string $hash Base64 encoded string to decrypt.
     *
     * @return mixed
     */
    protected function readHash($hash)
    {
        $hash = base64_decode($hash);
        $strDecrypted = Crypt::decryptString($hash);

        return unserialize($strDecrypted);
    }
}

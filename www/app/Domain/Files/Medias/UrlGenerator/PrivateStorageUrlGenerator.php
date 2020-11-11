<?php

namespace pkmnfriends\Domain\Files\Medias\UrlGenerator;

use Spatie\MediaLibrary\UrlGenerator\LocalUrlGenerator;
use pkmnfriends\Infrastructure\Contracts\Traits\SecurityHashTrait;

class PrivateStorageUrlGenerator extends LocalUrlGenerator
{
    use SecurityHashTrait;

    /**
     * Get the url for the profile of a media item.
     *
     * @return string
     */
    public function getUrl(): string
    {
        $hash = $this
            ->createHash([
                'id' => $this->media->id,
                'timestamp' => time(),
            ]);

        return route('anonymous.files.media', ['hash' => $hash]);
    }
}

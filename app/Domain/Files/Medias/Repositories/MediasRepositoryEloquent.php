<?php

namespace pkmnfriends\Domain\Files\Medias\Repositories;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use pkmnfriends\Infrastructure\Contracts\
{
    Request\RequestAbstract,
    Repositories\RepositoryEloquentAbstract,
    Traits\SecurityHashTrait
};
use pkmnfriends\Domain\Files\Medias\{Media, Repositories\MediasRepository};

class MediasRepositoryEloquent extends RepositoryEloquentAbstract implements MediasRepository
{
    use SecurityHashTrait;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Media::class;
    }

    /**
     * Attach the file to post, the media library will now able to
     * manage the file.
     *
     * @param HasMedia $entity
     * @param string $newFilePath
     * @param string $collection
     * @param string $diskName
     * @param array $collectionFilters
     *
     * @return HasMedia
     */
    public function attachNewMediaToEntityAndDeletePreviousOne(
        HasMedia $entity,
        $newFilePath,
        $collection,
        $diskName = '',
        $collectionFilters = []
    ) {
        $entity
            ->getMedia($collection, $collectionFilters)
            ->each(function ($media) use ($entity) {
                // HasMediaTrait
                $entity->deleteMedia($media->id);
            });

        $entity
            ->addMedia($newFilePath)
            ->toMediaCollection($collection, $diskName);

        return $entity;
    }

    /**
     * @param string $hash
     *
     * @seealso https://laracasts.com/discuss/channels/general-discussion/opening-files-online-using-laravel
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function streamPrivateDocument($hash = '')
    {
        $data = $this->readHash($hash);
        $media = $this->find($data['id']);

        if ($media) {
            return $media->toResponse(request());
        }

        throw new \Exception();
    }
}

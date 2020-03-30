<?php

namespace template\Domain\Files\Medias\Repositories;

use Illuminate\Support\Facades\
{
    File,
    Response
};
use Spatie\MediaLibrary\HasMedia\HasMedia;
use template\Infrastructure\Contracts\
{
    Request\RequestAbstract,
    Repositories\RepositoryEloquentAbstract,
    Traits\SecurityHashTrait
};
use template\Domain\Files\Medias\
{
    Media,
    Repositories\MediasRepository
};

class MediasRepositoryEloquent extends RepositoryEloquentAbstract implements MediasRepository
{
    use SecurityHashTrait;

    protected $mime_types = [
        'ai' => 'application/postscript',
        'aif' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'asc' => 'text/plain',
        'atom' => 'application/atom+xml',
        'atom' => 'application/atom+xml',
        'au' => 'audio/basic',
        'avi' => 'video/x-msvideo',
        'bcpio' => 'application/x-bcpio',
        'bin' => 'application/octet-stream',
        'bmp' => 'image/bmp',
        'cdf' => 'application/x-netcdf',
        'cgm' => 'image/cgm',
        'class' => 'application/octet-stream',
        'cpio' => 'application/x-cpio',
        'cpt' => 'application/mac-compactpro',
        'csh' => 'application/x-csh',
        'css' => 'text/css',
        'csv' => 'text/csv',
        'dcr' => 'application/x-director',
        'dir' => 'application/x-director',
        'djv' => 'image/vnd.djvu',
        'djvu' => 'image/vnd.djvu',
        'dll' => 'application/octet-stream',
        'dmg' => 'application/octet-stream',
        'dms' => 'application/octet-stream',
        'doc' => 'application/msword',
        'dtd' => 'application/xml-dtd',
        'dvi' => 'application/x-dvi',
        'dxr' => 'application/x-director',
        'eps' => 'application/postscript',
        'etx' => 'text/x-setext',
        'exe' => 'application/octet-stream',
        'ez' => 'application/andrew-inset',
        'gif' => 'image/gif',
        'gram' => 'application/srgs',
        'grxml' => 'application/srgs+xml',
        'gtar' => 'application/x-gtar',
        'hdf' => 'application/x-hdf',
        'hqx' => 'application/mac-binhex40',
        'htm' => 'text/html',
        'html' => 'text/html',
        'ice' => 'x-conference/x-cooltalk',
        'ico' => 'image/x-icon',
        'ics' => 'text/calendar',
        'ief' => 'image/ief',
        'ifb' => 'text/calendar',
        'iges' => 'model/iges',
        'igs' => 'model/iges',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'js' => 'application/x-javascript',
        'json' => 'application/json',
        'kar' => 'audio/midi',
        'latex' => 'application/x-latex',
        'lha' => 'application/octet-stream',
        'lzh' => 'application/octet-stream',
        'm3u' => 'audio/x-mpegurl',
        'man' => 'application/x-troff-man',
        'mathml' => 'application/mathml+xml',
        'me' => 'application/x-troff-me',
        'mesh' => 'model/mesh',
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'mif' => 'application/vnd.mif',
        'mov' => 'video/quicktime',
        'movie' => 'video/x-sgi-movie',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'mpe' => 'video/mpeg',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpga' => 'audio/mpeg',
        'ms' => 'application/x-troff-ms',
        'msh' => 'model/mesh',
        'mxu' => 'video/vnd.mpegurl',
        'nc' => 'application/x-netcdf',
        'oda' => 'application/oda',
        'ogg' => 'application/ogg',
        'pbm' => 'image/x-portable-bitmap',
        'pdb' => 'chemical/x-pdb',
        'pdf' => 'application/pdf',
        'pgm' => 'image/x-portable-graymap',
        'pgn' => 'application/x-chess-pgn',
        'png' => 'image/png',
        'pnm' => 'image/x-portable-anymap',
        'ppm' => 'image/x-portable-pixmap',
        'ppt' => 'application/vnd.ms-powerpoint',
        'ps' => 'application/postscript',
        'qt' => 'video/quicktime',
        'ra' => 'audio/x-pn-realaudio',
        'ram' => 'audio/x-pn-realaudio',
        'ras' => 'image/x-cmu-raster',
        'rdf' => 'application/rdf+xml',
        'rgb' => 'image/x-rgb',
        'rm' => 'application/vnd.rn-realmedia',
        'roff' => 'application/x-troff',
        'rss' => 'application/rss+xml',
        'rtf' => 'text/rtf',
        'rtx' => 'text/richtext',
        'sgm' => 'text/sgml',
        'sgml' => 'text/sgml',
        'sh' => 'application/x-sh',
        'shar' => 'application/x-shar',
        'silo' => 'model/mesh',
        'sit' => 'application/x-stuffit',
        'skd' => 'application/x-koan',
        'skm' => 'application/x-koan',
        'skp' => 'application/x-koan',
        'skt' => 'application/x-koan',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'snd' => 'audio/basic',
        'so' => 'application/octet-stream',
        'spl' => 'application/x-futuresplash',
        'src' => 'application/x-wais-source',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc' => 'application/x-sv4crc',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        'swf' => 'application/x-shockwave-flash',
        't' => 'application/x-troff',
        'tar' => 'application/x-tar',
        'tcl' => 'application/x-tcl',
        'tex' => 'application/x-tex',
        'texi' => 'application/x-texinfo',
        'texinfo' => 'application/x-texinfo',
        'tif' => 'image/tiff',
        'tiff' => 'image/tiff',
        'tr' => 'application/x-troff',
        'tsv' => 'text/tab-separated-values',
        'txt' => 'text/plain',
        'ustar' => 'application/x-ustar',
        'vcd' => 'application/x-cdlink',
        'vrml' => 'model/vrml',
        'vxml' => 'application/voicexml+xml',
        'wav' => 'audio/x-wav',
        'wbmp' => 'image/vnd.wap.wbmp',
        'wbxml' => 'application/vnd.wap.wbxml',
        'wml' => 'text/vnd.wap.wml',
        'wmlc' => 'application/vnd.wap.wmlc',
        'wmls' => 'text/vnd.wap.wmlscript',
        'wmlsc' => 'application/vnd.wap.wmlscriptc',
        'wrl' => 'model/vrml',
        'xbm' => 'image/x-xbitmap',
        'xht' => 'application/xhtml+xml',
        'xhtml' => 'application/xhtml+xml',
        'xls' => 'application/vnd.ms-excel',
        'xml' => 'application/xml',
        'xpm' => 'image/x-xpixmap',
        'xsl' => 'application/xml',
        'xslt' => 'application/xslt+xml',
        'xul' => 'application/vnd.mozilla.xul+xml',
        'xwd' => 'image/x-xwindowdump',
        'xyz' => 'chemical/x-xyz',
        'zip' => 'application/zip',
    ];

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

        $raw_media_file = $this->find($data['id']);

        if (File::isFile($raw_media_file->getPath())) {
            $path_parts = pathinfo($raw_media_file->getPath());
            $extension = $path_parts['extension'];
            $content_types = $this->mime_types;

            $file_path = File::get($raw_media_file->getPath());
            $response = Response::make($file_path, 200);

            // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)
            $response->header('Content-Type', $content_types[$extension]);
            $response->header(
                'Content-disposition',
                'filename="' . $raw_media_file->file_name . '"'
            );

            return $response;
        }

        throw new \Exception();
    }
}

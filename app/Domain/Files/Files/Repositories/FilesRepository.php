<?php

namespace template\Domain\Files\Files\Repositories;

use Illuminate\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use League\Glide\{Responses\LaravelResponseFactory, ServerFactory};
use Barryvdh\Elfinder\{Connector, Session\LaravelSession};
use template\Domain\Users\Users\User;

define('ELFINDER_DROPBOX_CONSUMERKEY', '');
define('ELFINDER_DROPBOX_CONSUMERSECRET', '');
define('ELFINDER_DROPBOX_META_CACHE_PATH', '');

define('ELFINDER_GOOGLEDRIVE_CLIENTID', '');
define('ELFINDER_GOOGLEDRIVE_CLIENTSECRET', '');

define('ELFINDER_BOX_CLIENTID', '');
define('ELFINDER_BOX_CLIENTSECRET', '');

//include_once base_path('vendor/studio-42/elfinder/php/elFinderVolumeMySQL.class.php');
//include_once base_path('vendor/studio-42/elfinder/php/elFinderVolumeFTP.class.php');
//include_once base_path('vendor/studio-42/elfinder/php/elFinderVolumeDropbox.class.php');
//include_once base_path('vendor/studio-42/elfinder/php/elFinderVolumeGoogleDrive.class.php');
//include_once base_path('vendor/studio-42/elfinder/php/elFinderVolumeBox.class.php');
//include_once base_path('vendor/studio-42/elfinder/php/elFinderVolumeOneDrive.class.php');

class FilesRepository
{

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $package = 'elfinder';

    /**
     * FilesRepository constructor.
     */
    public function __construct()
    {
        $this->app = app();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connector()
    {
        $roots = $this->app->config->get('elfinder.roots', []);

        if (empty($roots)) {
            $roots = array_merge($roots, $this->listElFinderDirectories());
            $roots = array_merge(
                $roots,
                $this->listElFinderDisks('elfinder.disks.' . User::ROLE_ADMINISTRATOR)
            );
        }

        return $this->generateElFinderFilesManagerConnector($roots);
    }

    /**
     * @param array $roots
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function generateElFinderFilesManagerConnector(array $roots = [])
    {
        $session = null;
        $rootOptions = $this->app->config->get('elfinder.root_options', []);
        $opts = $this->app->config->get('elfinder.options', []);

        if (app()->bound('session.store')) {
            $sessionStore = app('session.store');
            $session = new LaravelSession($sessionStore);
        }

        foreach ($roots as $key => $root) {
            $roots[$key] = array_merge($rootOptions, $root);
        }

        $opts = array_merge($opts, ['roots' => $roots, 'session' => $session]);
        // Run elFinder.
        $connector = new Connector(new \elFinder($opts));
        $connector->run();

        return $connector->getResponse();
    }

    /**
     * @return array
     */
    public function getViewVars()
    {
        $csrf = true;
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = str_replace("-", "_", $this->app->config->get('app.locale'));

        if (!file_exists(public_path("/{$dir}/js/i18n/elfinder.{$locale}.js"))) {
            $locale = false;
        }

        return compact('dir', 'locale', 'csrf');
    }

    /**
     * @param string $path
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function streamPublicDocument(string $path)
    {
        if (Storage::cloud()->exists($path)) {
            return Storage::cloud()->response(basename($path));
        }

        throw new \Exception();
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function streamPublicThumbnail(string $path)
    {
        return ServerFactory::create([
            'source' => Storage::cloud()->getDriver(),
            'cache' => Storage::disk('thumbnails')->getDriver(),
            'driver' => 'imagick',
            'response' => new LaravelResponseFactory(app('request')),
        ])
            ->getImageResponse($path, []);
    }

    /**
     * @param string $config
     *
     * @return array
     */
    protected function listElFinderDirectories(string $config = 'elfinder.dir')
    {
        $roots = [];
        $dirs = (array)$this->app['config']->get($config, []);

        foreach ($dirs as $dir) {
            $roots[] = [
                // driver for accessing file system (REQUIRED)
                'driver' => 'LocalFileSystem',
                // path to files (REQUIRED)
                'path' => public_path($dir),
                // URL to files (REQUIRED)
                'URL' => url($dir),
                // filter callback (OPTIONAL)
                'accessControl' => $this->app->config->get('elfinder.access')
            ];
        }

        return $roots;
    }

    /**
     * @param string $config
     *
     * @return array
     */
    protected function listElFinderDisks(
        $config = 'elfinder.disks.' . User::ROLE_ADMINISTRATOR
    ) {
        $roots = [];
        $disks = (array)$this->app['config']->get($config, []);

        foreach ($disks as $key => $root) {
            if (is_string($root)) {
                $key = $root;
                $root = [];
            }
            $disk = app('filesystem')->disk($key);
            if ($disk instanceof FilesystemAdapter) {
                $defaults = [
                    'driver' => 'Flysystem',
                    'filesystem' => $disk->getDriver(),
                    'alias' => $key,
                    'accessControl' => $this->app->config->get('elfinder.access'),
                ];
                $roots[] = array_merge($defaults, $root);
            }
        }

        return $roots;
    }
}

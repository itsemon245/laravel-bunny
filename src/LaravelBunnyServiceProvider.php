<?php 

namespace Itsemon245\LaravelBunny;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNAdapter;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNClient;

class LaravelBunnyServiceProvider extends \Illuminate\Support\ServiceProvider{
  public function boot(){
    $this->extendBunnyStorage();
  }

  public function extendBunnyStorage(){
    Storage::extend('bunny', function ($app, $config) {
      $root = $config['root'] ??'';
      $pullZoneUrl = $config['pull_zone'] ?? '';
      if ($pullZoneUrl && $root) {
        $pullZoneUrl = rtrim($pullZoneUrl, '/') . '/' . ltrim($root, '/');
      }

      $adapter = new BunnyCDNAdapter(
        new BunnyCDNClient(
          $config['storage_zone'],
          $config['api_key'],
          $config['region']
        ),
        $pullZoneUrl
      );

      $filesystem = new Filesystem($adapter, $config);
      return new FilesystemAdapter(
        $filesystem,
        $adapter,
        $config
      );
    });
  }
}

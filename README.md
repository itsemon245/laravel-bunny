<!--![Laravel_pausable_job_banner](https://github.com/itsemon245/laravel-pausable-job/assets/82655944/a9e055c9-9610-4d4e-94d4-ecc61acfd09b)-->

<p align="center">
 <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/itsemon245/laravel-bunny?style=for-the-badge&label=Downloads&color=61C9A8" alt="Total Downloads"></a>
 <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/itsemon245/laravel-bunny?style=for-the-badge&label=Version" alt="Latest Stable Version"></a>
 <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/itsemon245/laravel-bunny?style=for-the-badge&label=License" alt="License"></a>
</p>

# Laravel Bunny
A simple package that provides a new Storage Driver for bunny CDN using their [Filesystem Adapter](https://github.com/PlatformCommunity/flysystem-bunnycdn).

### Installation
```sh
composer require itsemon245/laravel-bunny
```

### Configuration
Add a new entry for `disks` in `config/filesystems.php` using the following example.
```php
  'bunny'=>[
      'driver' => 'bunny',
      'storage_zone' => env('BUNNYCDN_STORAGE_ZONE', 'my-storage-zone'),# Name of your storage zone
      'pull_zone' => env('BUNNYCDN_PULL_ZONE', 'https://random.b-cdn.net'),#Pull Zone URL
      'api_key' => env('BUNNYCDN_API_KEY') # Use one of the password found in the storage zone.
      'region' => env('BUNNYCDN_REGION', Itsemon245\LaravelBunny\Region::DEFAULT), #the default should be de
      'root'=> 'my-files',#Optional, all files will be stored under this directory if specified
  ]
```
> [!NOTE]
> **Don't use the api key from your account settings, it does not work. Use one of the passwords found under Storage Zone > FTP & API Access section**

### Usage
Usage is pretty simple.
```php
//Storing file
Storage::disk('bunny')->put('new-file.txt', 'hello-world');

//Retrieving url
$url = Storage::disk('bunny')->url('new-file.txt');# https://random.b-cdn.net/my-files/new-file.txt
```
You can also skip calling the disk method everytime if you  set `FILESYSTEM_DISK` to `bunny` in you `.env`. Then you can do something simple like.
```php
//Storing file
Storage::put('new-file.txt', 'hello-world');

//Retrieving url
$url = Storage::url('new-file.txt');# https://random.b-cdn.net/my-files/new-file.txt
```
### List of regions
**For a full region list, please visit the [BunnyCDN API documentation page](https://docs.bunny.net/reference/storage-api#storage-endpoints).**

The package also comes with a set of region constants to use

```php
use Itsemon245\LaravelBunny\Region;

# Europe
Region::DEFAULT = 'de';
Region::FALKENSTEIN = 'de';
Region::STOCKHOLM = 'se';

# United Kingdom
Region::UNITED_KINGDOM = 'uk';

# USA
Region::NEW_YORK = 'ny';
Region::LOS_ANGELAS = 'la';

# SEA
Region::SINGAPORE = 'sg';

# Oceania
Region::SYDNEY = 'syd';

# Africa
Region::JOHANNESBURG = 'jh';

# South America
Region::BRAZIL = 'br';
```


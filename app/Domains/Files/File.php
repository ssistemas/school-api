<?php

namespace Emtudo\Domains\Files;

use Emtudo\Domains\Files\Presenters\FilePresenter;
use Emtudo\Domains\Files\Transformers\FileTransformer;
use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Support\ViewPresenter\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class File.
 *
 * @property Tenant $tenant
 * @property string $kind
 * @property string $label
 * @property string $uuid
 * @property string $mime
 * @property string $extension
 * @property int $tenant_id
 * @property int $size
 */
class File extends TenantModel
{
    use Presentable, SoftDeletes;

    protected $table = 'files';

    protected $presenter = FilePresenter::class;

    protected $transformerClass = FileTransformer::class;

    protected $fillable = [
        'kind',
        'tenant_id',
        'label',
        'uuid',
        'mime',
        'size',
        'extension',
    ];

    /**
     * Relationship to Polymorphic Objects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function fileable()
    {
        return $this->morphTo();
    }

    public function getRelativePath()
    {
        return $this->tenant_id . '/' . $this->uuid . '.' . $this->extension;
    }

    public function getSignedURL(int $timeout = 0)
    {
        $disk = Storage::disk(env('STORAGE_DRIVER', 's3'));
        $path = $this->getRelativePath();

        $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key' => $path,
        ]);

        $minutes = ($timeout > 0) ? $timeout : env('STORAGE_GET_TIMEOUT', 20);
        $minutes = "+{$minutes} minutes";

        $request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, $minutes);

        return (string) $request->getUri();
    }

    /**
     * @return bool|string
     */
    public function getInstance()
    {
        $storage = self::getStorage();

        if ($storage->exists($this->getRelativePath())) {
            return $storage->get($this->getRelativePath());
        }

        return false;
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public static function getStorage()
    {
        return Storage::getFacadeRoot();
    }

    public function shortLabel()
    {
        if (Str::length($this->label) > 20) {
            return Str::limit($this->label, 10, '...' . Str::substr($this->label, -6, 6));
        }

        return $this->label;
    }

    public function getFile()
    {
        $disk = Storage::disk(env('STORAGE_DRIVER', 's3'));
        $path = $this->getRelativePath();

        if ($disk->exists($path)) {
            return $disk->get($path);
        }

        return $path;
    }

    public function getSafeLabelAttribute()
    {
        $label = $this->label ?? $this->uuid ?? $this->publicId();

        $label = Str::replaceLast($this->extension, '', $label);

        $label = Str::slug($label, '_');

        $label = Str::lower($label);

        $label = "{$label}.{$this->extension}";

        return $label;
    }
}

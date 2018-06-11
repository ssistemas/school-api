<?php

namespace Emtudo\Domains\Files\Providers;

use Emtudo\Domains\Files\Contracts;
use Emtudo\Domains\Files\Database\Migrations\CreateFilesTable;
use Emtudo\Domains\Files\Repositories;
use Emtudo\Support\Domain\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    protected $alias = 'files';

    protected $migrations = [
        CreateFilesTable::class,
    ];

    public $bindings = [
        Contracts\FileRepository::class => Repositories\FileRepository::class,
    ];
}

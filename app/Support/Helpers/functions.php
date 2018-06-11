<?php

use Emtudo\Support\Helpers\UUID;
use Illuminate\Support\Facades\Storage;

if (!function_exists('storage_file_save')) {
    /**
     * @param string     $disk
     * @param array      $file
     * @param null|mixed $size
     * @param null|mixed $filename
     *
     * @return bool|string
     */
    function storage_file_save(string $disk, array $file = [], $size = null, $filename = null)
    {
        if (!array_has($file, ['name', 'content'])) {
            return false;
        }

        $filename = $filename ?? uuid().'_'.$file['name'];

        $content = base64_decode($file['content'] ?? '', true);

        $saved = Storage::disk($disk)->put($filename, $content);
        if ($saved && $size && storage_file_size($disk, $filename) > $size) {
            storage_file_delete($disk, $filename);

            return false;
        }

        return ($saved) ? $filename : false;
    }
}

if (!function_exists('storage_file_path_info')) {
    /**
     * @param string $disk
     * @param string $file
     *
     * @return bool|string
     */
    function storage_file_path_info(string $disk, string $file)
    {
        return pathinfo(storage_file_url($disk, $file));
    }
}

if (!function_exists('storage_file_mime')) {
    /**
     * @param string $disk
     * @param string $file
     *
     * @return bool|string
     */
    function storage_file_mime(string $disk, string $file)
    {
        if (!storage_file_exists($disk, $file)) {
            return false;
        }

        $path = storage_file_url($disk, $file);

        return mime_content_type($path);
    }
}

if (!function_exists('storage_file_delete')) {
    /**
     * @param string $disk
     * @param string $file
     *
     * @return bool
     */
    function storage_file_delete(string $disk, string $file)
    {
        return Storage::disk($disk)->delete($file);
    }
}

if (!function_exists('storage_file_url')) {
    /**
     * @param string $disk
     * @param string $file
     *
     * @return string
     */
    function storage_file_url(string $disk, string $file)
    {
        return Storage::disk($disk)->url($file);
    }
}

if (!function_exists('storage_file_exists')) {
    /**
     * @param string $disk
     * @param string $file
     *
     * @return bool
     */
    function storage_file_exists(string $disk, string $file)
    {
        return Storage::disk($disk)->exists($file);
    }
}

if (!function_exists('storage_file_size')) {
    /**
     * @param string $disk
     * @param string $file
     *
     * @return int
     */
    function storage_file_size(string $disk, string $file)
    {
        return Storage::disk($disk)->size($file);
    }
}

if (!function_exists('storage_file_get')) {
    /**
     * @param string $disk
     * @param string $file
     *
     * @return string
     */
    function storage_file_get(string $disk, string $file)
    {
        return Storage::disk($disk)->get($file);
    }
}

if (!function_exists('translate_day')) {
    function translate_day($day)
    {
        $days = [
            'monday' => 'segunda',
            'tuesday' => 'terça',
            'wednesday' => 'quarta',
            'thursday' => 'quinta',
            'friday' => 'sexta',
            'saturday' => 'śabado',
            'sunday' => 'domingo',
        ];

        return $days[$day] ?? $day;
    }
}

if (!function_exists('uuid')) {
    function uuid()
    {
        return UUID::v4();
    }
}

if (!function_exists('route_search')) {
    function route_search($router, $name)
    {
        $singular = str_singular($name);
        $controller = ucfirst($singular).'Controller';

        $router
            ->get("$name/search", "$controller@index")
            ->name("{$name}.search");

        route_index_show($router, $name);
    }
}

if (!function_exists('route_index_show')) {
    function route_index_show($router, $name)
    {
        $singular = str_singular($name);
        $controller = ucfirst($singular).'Controller';

        $router
            ->get($name, "$controller@index")
            ->name("{$name}.index");

        $router
            ->get("$name/{{$singular}}", "$controller@show")
            ->name("{$name}.show");
    }
}

if (!function_exists('where_json')) {
    function where_json($key)
    {
        $path = explode('->', $key);
        $newKey = $path[0];
        $newPath = $path[1];

        //`address`->$.'\"street\"'
        //`address`->'$.\"street\"'

        return "`{$newKey}`->'$.\"".$newPath."\"'";
    }
}

if (!function_exists('debug')) {
    function debug()
    {
        $values = func_get_args();
        if (1 === count($values)) {
            return Log::info(json_encode($values));
        }
        foreach ($values as $value) {
            Log::info(json_encode($value));
        }
    }
}

if (!function_exists('tenant_public_id')) {
    /**
     * @return string
     */
    function tenant_public_id()
    {
        $tenant = \Emtudo\Domains\Tenants\Tenant::currentTenant();

        if (!$tenant) {
            return null;
        }

        return $tenant->publicId();
    }
}

if (!function_exists('tenant')) {
    /**
     * @return null|\Emtudo\Domains\Tenants\Tenant
     */
    function tenant()
    {
        try {
            $tenant = \Emtudo\Domains\Tenants\Tenant::currentTenant();

            return $tenant;
        } catch (\Exception $e) {
            return null;
        }
    }
}

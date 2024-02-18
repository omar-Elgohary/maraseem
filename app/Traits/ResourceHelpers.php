<?php

namespace App\Traits;

use LogicException;
use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

trait ResourceHelpers
{
    public function __construct()
    {
        $this->setModelName();
        $this->initAttributeNames();
    }


    protected function setModelName()
    {
        $reflector = new ReflectionClass($this);
        $model = $reflector->name;

        $array = explode('\\', $model);
        $model = str_replace('Controller', '', end($array));

        $this->name = $model;

        if (!isset($this->model)) {
            if (class_exists('App\\Models\\' . $model)) {
                $this->model = 'App\\Models\\' . $model;
            } elseif (class_exists('App\\' . $model)) {
                $this->model = 'App\\' . $model;
            } elseif (class_exists('App\\Model\\' . $model)) {
                $this->model = 'App\\Model\\' . $model;
            }
        }
    }

    protected function initAttributeNames()
    {
        if (!isset($this->model)) {
            throw new LogicException('JodaResources can\'t find a suitable model for ' . get_class($this) . ' please set it manually through $model');
        }

        $array = explode('\\', $this->model);
        $name = lcfirst($this->name ?? end($array));
        $this->kebabName = Str::kebab($this->name ?? end($array));

        if (!isset($this->singularCamelName)) {
            $this->singularCamelName = $name;
            $this->pluralCamelName = Str::plural($this->singularCamelName);
            $this->pluralKebabName = Str::kebab(Str::plural($this->singularCamelName));
            $this->pluralSnakeName = Str::snake(Str::plural($this->singularCamelName));
        }

        $reflector = new ReflectionClass($this);
        $namespace = '';
        if ($reflector->getNamespaceName() != 'App\Http\Controllers')
            $namespace = Str::lower(str_replace('App\Http\Controllers\\', '', $reflector->getNamespaceName()));

        if (!isset($this->view)) {
            $this->view = $namespace ? "$namespace.$this->kebabName" : "$this->kebabName";
        }

        if (!isset($this->route)) {
            $this->route = $namespace ? "$namespace.$this->pluralKebabName" : "$this->pluralKebabName";
        }
    }


    public function getQuery()
    {
        if (method_exists($this, 'query')) {
            return $this->query($this->model::where(function ($query) {
                return $this->filterQueryString($query);
            }));
        } else {
            return $this->model::where(function ($query) {
                return $this->filterQueryString($query);
            })->get();
        }
    }

    protected function filterQueryString($query)
    {
        if ($this->filterQueryString ?? true) {
            $collection = $query;
            foreach (request()->all() as $key => $value) {
                $isColumnExist = Schema::hasColumn((new $this->model)->getTable(), $key);
                $isValueEmpty = $value == '' || $value == null;
                if (!$isValueEmpty && $isColumnExist) {
                    $collection = $collection->where($key, $value);
                }
            }
            return $collection;
        } else {
            return $query;
        }
    }

    protected function beforeStore()
    {
    }
    protected function afterStore($model = null)
    {
    }

    protected function beforeUpdate($model = null)
    {
    }
    protected function afterUpdate($model = null)
    {
    }

    protected function beforeDestroy($model = null)
    {
    }
    protected function afterDestroy()
    {
    }


    protected function storeRules()
    {
        return isset($this->storeRules)
            ? $this->storeRules
            : (isset($this->rules)
                ? $this->rules
                : (isset($this->model::$storeRules)
                    ? $this->model::$storeRules
                    : (
                        (isset($this->model::$rules)
                            ? $this->model::$rules
                            : null))));
    }

    protected function updateRules()
    {
        return isset($this->updateRules)
            ? $this->updateRules
            : (isset($this->rules)
                ? $this->rules
                : (isset($this->model::$updateRules)
                    ? $this->model::$updateRules
                    : (
                        (isset($this->model::$rules)
                            ? $this->model::$rules
                            : null))));
    }

    protected function uploadFilesIfExist($data)
    {
        if (isset($this->files)) {
            foreach ($this->files as $file) {
                if (request()->hasFile($file) and request()->$file) {
                    $fileName =
                        (auth()->user() ? auth()->user()->id : '') . '-' .
                        time() . '.' .
                        request()->file($file)->getClientOriginalExtension();
                    $filePath = "$this->pluralCamelName/$fileName";
                    $data[$file] = $filePath;
                    Storage::disk(config('joda-resources.disk', 'local'))->put($filePath, file_get_contents(request()->$file));
                }
            }
        }
        return $data;
    }

    protected function updateJsonIfExist($data)
    {
        if (isset($this->json)) {
            foreach ($this->json as $json) {
                $data[$json] = json_encode(isset($data[$json]) ? $data[$json] : [], JSON_UNESCAPED_UNICODE);
            }
        }
        return $data;
    }

    protected function deleteFilesIfExist($model)
    {
        if (isset($this->files)) {
            foreach ($this->files as $file) {
                if (Storage::disk(config('joda-resources.disk', 'local'))->exists($model->$file)) {
                    Storage::disk(config('joda-resources.disk', 'local'))->delete($model->$file);
                }
            }
        }
    }
}

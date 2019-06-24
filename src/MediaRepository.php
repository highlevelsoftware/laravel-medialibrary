<?php

namespace Spatie\MediaLibrary;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\Collection as DbCollection;

class MediaRepository
{
    /** @var \Spatie\MediaLibrary\Models\Media */
    protected $model;

    /** @param \Spatie\MediaLibrary\Models\Media $model */
    public function __construct(Media $model)
    {
        $this->model = $model;
    }

    /**
     * Get all media in the collection.
     *
     * @param \Spatie\MediaLibrary\HasMedia\HasMedia $model
     * @param string $collectionName
     * @param array|callable $filter
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCollection(HasMedia $model, $collectionName, $filter = [])
    {
        return $this->applyFilterToMediaCollection($model->loadMedia($collectionName), $filter);
    }

    /**
     * Apply given filters on media.
     *
     * @param \Illuminate\Support\Collection $media
     * @param array|callable $filter
     *
     * @return \Illuminate\Support\Collection
     */
    protected function applyFilterToMediaCollection(Collection $media, $filter)
    {
        if (is_array($filter)) {
            $filter = $this->getDefaultFilterFunction($filter);
        }

        return $media->filter($filter);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getByModelType($modelType)
    {
        return $this->model->where('model_type', $modelType)->get();
    }

    public function getByIds(array $ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function getByModelTypeAndCollectionName($modelType, $collectionName)
    {
        return $this->model
            ->where('model_type', $modelType)
            ->where('collection_name', $collectionName)
            ->get();
    }

    public function getByCollectionName($collectionName)
    {
        return $this->model
            ->where('collection_name', $collectionName)
            ->get();
    }

    /**
     * Convert the given array to a filter function.
     *
     * @param $filters
     *
     * @return \Closure
     */
    protected function getDefaultFilterFunction(array $filters)
    {
        return function (Media $media) use ($filters) {
            foreach ($filters as $property => $value) {
                if (! Arr::has($media->custom_properties, $property)) {
                    return false;
                }

                if (Arr::get($media->custom_properties, $property) !== $value) {
                    return false;
                }
            }

            return true;
        };
    }
}

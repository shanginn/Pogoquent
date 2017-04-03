<?php

namespace Shanginn\Postgresql\Eloquent;

use Illuminate\Database\Eloquent\Model;

class _EnumBuilder extends \Illuminate\Database\Eloquent\Builder
{
    /**
     * Set a model instance for the model being queried.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }
}
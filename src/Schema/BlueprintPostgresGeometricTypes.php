<?php

namespace Shanginn\Postgresql\Schema;

/**
 * @mixin Blueprint
 */
trait BlueprintPostgresGeometricTypes
{
    /**
     * Create a new line column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function line($column)
    {
        return $this->addColumn('line', $column);
    }

    /**
     * Create a new line segment (lseg) column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function lineSegment($column)
    {
        return $this->addColumn('lineSegment', $column);
    }

    /**
     * Create a new box column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function box($column)
    {
        return $this->addColumn('box', $column);
    }

    /**
     * Create a new path column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function path($column)
    {
        return $this->addColumn('path', $column);
    }

    /**
     * Create a new polygon column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function polygon($column)
    {
        return $this->addColumn('polygon', $column);
    }

    /**
     * Create a new circle column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function circle($column)
    {
        return $this->addColumn('circle', $column);
    }
}
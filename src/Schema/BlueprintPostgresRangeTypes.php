<?php

namespace Shanginn\Postgresql\Schema;

/**
 * @mixin Blueprint
 */
trait BlueprintPostgresRangeTypes
{
    /**
     * Create a new big (64-bit) integer range (int8) column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function bigIntegerRange($column)
    {
        return $this->addColumn('bigIntegerRange', $column);
    }

    /**
     * Create a new date range column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function dateRange($column)
    {
        return $this->addColumn('dateRange', $column);
    }

    /**
     * Create a new (32-bit) integer range (int4) column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function integerRange($column)
    {
        return $this->addColumn('integerRange', $column);
    }

    /**
     * Create a new numeric range (numrange) column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function numericRange($column)
    {
        return $this->addColumn('numericRange', $column);
    }

    /**
     * Create a new timestamp range (tsrange) column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function timestampRange($column)
    {
        return $this->addColumn('timestampRange', $column);
    }

    /**
     * Create a new timestamp w/ timezone range (tstzrange) column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function timestampTimezoneRange($column)
    {
        return $this->addColumn('timestampTimezoneRange', $column);
    }
}
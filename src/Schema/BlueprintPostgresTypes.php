<?php

namespace Shanginn\Postgresql\Schema;

trait BlueprintPostgresTypes
{
    use BlueprintPostgresGeometricTypes;
    use BlueprintPostgresRangeTypes;
    //use BlueprintPostgresInherits;
    //use BlueprintPostgresEnums;

    /**
     * Create a new netmask (CIDR-notation) (cidr) column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function netmask($column)
    {
        return $this->addColumn('netmask', $column);
    }

    /**
     * Create a new money column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function money($column)
    {
        return $this->addColumn('money', $column);
    }

    /**
     * Create a new array column on the table.
     * Note: cannot use 'array' as function name in PHP7
     *
     * @param  string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function arr($column)
    {
        return $this->addColumn('array', $column);
    }
}
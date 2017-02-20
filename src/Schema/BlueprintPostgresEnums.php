<?php

namespace Shanginn\Postgresql\Schema;

trait BlueprintPostgresEnums
{
    /**
     * Create a new enum column on the table.
     *
     * @param  string $column
     * @param  string $type
     * @param  array $allowed
     * @return \Illuminate\Support\Fluent
     */
    public function enum($column, $type, array $allowed)
    {
        PostgresBuilder::$indexesConcurrently;
        return $this->addColumn('enum', $column, compact('type', 'allowed'));
    }
}
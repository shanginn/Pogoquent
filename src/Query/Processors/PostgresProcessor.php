<?php

namespace Shanginn\Postgresql\Query\Processors;

use Illuminate\Database\Query\Builder;

class PostgresProcessor extends \Illuminate\Database\Query\Processors\PostgresProcessor
{
    /**
     * Process the results of a "select" query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  array  $results
     * @return array
     */
    public function processSelect(Builder $query, $results)
    {
        return $results;
    }
}

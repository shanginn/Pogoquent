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

    public function processColumnWithTypesListing($results)
    {
        return array_reduce(
            array_keys($results),
            function ($result, $key) use ($results) {
                $result[$results[$key]->column_name] = $results[$key]->data_type;

                return $result;
            },
            []
        );
    }
}

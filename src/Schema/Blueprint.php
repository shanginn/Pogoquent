<?php

namespace Shanginn\Postgresql\Schema;

class Blueprint extends \Illuminate\Database\Schema\Blueprint
{
    use BlueprintPostgresColumns;

    /**
     * @param array|string $columns
     * @param string $name
     * @param string $algorithm
     * @return \Illuminate\Support\Fluent
     */
    public function index($columns, $name = null, $algorithm = null)
    {
        return $this->indexCommand('index', $columns, $name, $algorithm ?? 'btree');
    }

    /**
     * Add a new index command to the blueprint.
     *
     * @param  string        $type
     * @param  string|array  $columns
     * @param  string        $index
     * @param  string|null   $algorithm
     * @return \Illuminate\Support\Fluent
     */
    protected function indexCommand($type, $columns, $index, $algorithm = null)
    {
        $columns = (array) $columns;

        // If no name was specified for this index, we will create one using a basic
        // convention of the table name, followed by the columns, followed by an
        // index type, such as primary or index, which makes the index unique.
        $index = $index ?: $this->createIndexName($type, $columns);

        $concurrently = PostgresBuilder::$indexesConcurrently ? 'concurrently' : '';

        return $this->addCommand(
            $type, compact('index', 'columns', 'algorithm', 'concurrently')
        );
    }
}

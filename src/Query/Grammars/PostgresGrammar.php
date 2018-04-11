<?php

namespace Shanginn\Postgresql\Query\Grammars;

use Illuminate\Database\Query\Builder;

class PostgresGrammar extends \Illuminate\Database\Query\Grammars\PostgresGrammar
{
    /**
     * All of the available clause operators.
     *
     * @var array
     */
    protected $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=',
        'like', 'not like', 'between', 'ilike',
        '&', '|', '#', '<<', '>>',
        '@>', '<@', '?', '?|', '?&', '||', '-', '-', '#-',
        '&&'
    ];

    /**
     * Jsonb operators that require function wrapping
     *
     * TODO: operator '?|' also fits for points and lines
     *
     * @var array
     */
    protected $jsonbOperators = [
        '?' => 'jsonb_exists',
        '?|' => 'jsonb_exists_any',
        '?&' => 'jsonb_exists_all'
    ];

    /**
     * Compile an upsert statement into SQL.
     *
     * @param Builder $query
     * @param array $values
     * @param string $unique
     * @return string
     */
    public function compileUpsert(Builder $query, array $values, $unique)
    {
        $insert = $this->compileInsert($query, $values);

        if (! is_array(reset($values))) {
            $values = [$values];
        }

        $keys = array_keys(reset($values));

        // excluded fields are all fields except $unique one that will be updated
        // also created_at should be excluded since record already exists
        $excluded = array_filter($keys, function ($e) use ($unique) {
            return $e != $unique && $e != 'created_at';
        });

        $update = join(', ', array_map(function ($e) { return "\"$e\" = \"excluded\".\"$e\""; }, $excluded));

        return "$insert on conflict ($unique) do update set $update";
    }

    /**
     * {@inheritdoc}
     */
    protected function whereBasic(Builder $query, $where)
    {
        if (in_array($where['operator'], array_keys($this->jsonbOperators))) {
            return $this->whereJsonbOperators($where);
        }

        return parent::whereBasic($query, $where);
    }

    /**
     * Compile where clause wrapping jsonb operators with appropriate functions
     *
     * @param $where
     * @return string
     */
    protected function whereJsonbOperators($where)
    {
        $value = $this->parameter($where['value']);
        //dd($value);
        $func = $this->jsonbOperators[$where['operator']];

        return "$func(" . $this->wrap($where['column']) . ', ' . $value . ')';
    }

    /**
     * Compile "grouping sets" expression
     *
     * @param array $groups
     * @return string
     */
    public function compileGroupingSets(array $groups)
    {
        $args = array_map(function ($group) {
            return '(' . join(', ', $this->wrapArray($group)) . ')';
        }, $groups);

        return 'grouping sets ( ' . join(', ', $args) . ' )';
    }

    /**
     * Compile "rollup" expression
     *
     * @param array $groups
     * @return string
     */
    public function compileRollup(array $groups)
    {
        $args = $this->wrapArray($groups);

        return 'rollup ( ' . join(', ', $args) . ' )';
    }

    /**
     * Compile "cube" expression
     *
     * @param array $groups
     * @return string
     */
    public function compileCube(array $groups)
    {
        $args = $this->wrapArray($groups);

        return 'cube ( ' . join(', ', $args) . ' )';
    }

    /**
     * Compile the "select *" portion of the query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  array  $columns
     * @return string|null
     */
    protected function compileColumns(Builder $query, $columns)
    {
        // If the query is actually performing an aggregating select, we will let that
        // compiler handle the building of the select clauses, as it will need some
        // more syntax that is best handled by that function to keep things neat.
        if (! is_null($query->aggregate)) {
            return;
        }

        $select = 'select ' .
            ($query->distinct ? 'distinct ' : '') .
            (is_string($query->distinct) ? 'on (' . $this->w($query->distinct) . ') ' : '');

        return $select . $this->columnize($columns);
    }

    /**
     * Wraps array of columns
     *
     * @param array|string $columns
     * @return array|string
     */
    protected function w($columns)
    {
        return is_array($columns) ?
            $this->wrapArray($columns) :
            $this->wrap($columns);
    }
}

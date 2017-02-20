<?php
//TODO
namespace Shanginn\Postgresql\Schema\Grammars;

use Illuminate\Database\Schema\Blueprint;
use \Illuminate\Support\Fluent;

trait PostgresGrammarEnums
{
    public function compileGetEnumsList()
    {
        'select distinct t.typname as enum
        from pg_type t 
           join pg_enum e on t.oid = e.enumtypid  
           join pg_catalog.pg_namespace n ON n.oid = t.typnamespace;
           ';
    }

    /**
     * Compile the query to determine the list of columns.
     *
     * @param  string  $type
     * @param  array   $options
     *
     * @return string
     * @internal param string $table
     */
    public function compileCreateEnum($type, $options)
    {
        $allowed = collect($options)->map(function ($a) {
            return "'{$a}'";
        })->implode(', ');

        return sprintf('CREATE TYPE "%s" AS ENUM (%s));', $type, $allowed);
    }

    /**
     * Compile the query to determine the list of columns.
     *
     * @param  string $type
     * @param $alias
     * @return string
     */
    public function compileGetEnum($type, $alias = 'json')
    {
        return sprintf('
            DO $$
            BEGIN
                IF EXISTS (SELECT array_to_json(enum_range(NULL::test))) THEN
                    SELECT array_to_json(enum_range(NULL::test)) as json;
                END IF;
            END
            $$;', $type, $alias
        );
    }

    /**
     * Create the column definition for an enum type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     *
     * @deprecated Please use PostgresBuilder::createEnum() instead.
     *
     * @return void
     */
    protected function typeEnum(Fluent $column)
    {

    }
}
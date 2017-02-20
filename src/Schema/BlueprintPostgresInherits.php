<?php

namespace Shanginn\Postgresql\Schema;

use Illuminate\Support\Fluent;

trait BlueprintPostgresInherits
{
    //TODO:
    //
    // WORK IN PROGRESS. NOT TESTED
    //
    //:TODO

    /**
     * The inherited tables that should be added to the table.
     *
     * @var array
     */
    protected $inheritance = [];

    /**
     * Indicate that the table need to be inherits from $table
     *
     * @param $table
     * @return Fluent
     */
    public function inherits($table)
    {
        if ($this->creating()) {
            return $this->createInheritance($table);
        } else {
            return $this->alterInheritance('inherits', $table);
        }
    }

    /**
     * Remove inheritance from $table
     *
     * @param $table
     * @return \Illuminate\Support\Fluent|mixed
     */
    public function noInherits($table)
    {
        if ($this->creating()) {
            return $this->removeInheritance($table);
        } else {
            return $this->alterInheritance('noInherits', $table);
        }
    }

    /**
     * @param $type
     * @param $table
     *
     * @return \Illuminate\Support\Fluent
     */
    protected function alterInheritance($type, $table)
    {
        return $this->addCommand($type, compact('table'));
    }

    /**
     * Add a new inheritance to the blueprint.
     *
     * @param  string  $table
     * @param  array   $parameters
     * @return \Illuminate\Support\Fluent
     */
    protected function createInheritance($table, array $parameters = [])
    {
        $this->inheritance[] = $table = new Fluent(
            array_merge(compact('table'), $parameters)
        );

        return $table;
    }

    /**
     * Remove an inheritance from the schema blueprint.
     *
     * @param  string  $table
     * @return $this
     */
    protected function removeInheritance($table)
    {
        $this->inheritance = array_values(array_filter($this->inheritance, function ($c) use ($table) {
            return $c['attributes']['table'] != $table;
        }));

        return $this;
    }

    /**
     * Get the commands on the blueprint.
     *
     * @return array
     */
    public function getInheritance()
    {
        return $this->inheritance;
    }
}
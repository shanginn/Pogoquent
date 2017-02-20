<?php

namespace Shanginn\Postgresql\Schema\Grammars;

use \Illuminate\Support\Fluent;
use Illuminate\Database\Schema\Blueprint;

trait PostgresGrammarInherits
{
    //TODO:
    //
    // WORK IN PROGRESS. NOT TESTED
    //
    //:TODO

    /**
     * Compile the blueprint's inherits definitions.
     *
     * @param  Blueprint $blueprint
     * @return array
     */
    protected function getInheritance(Blueprint $blueprint)
    {
        return collect($blueprint->getInheritance())->map(function ($table) {
            return $this->wrapTable($table);
        })->implode(', ');
    }

    /**
     * Compile a inheritance command.
     *
     * @param  \Illuminate\Database\Schema\Blueprint  $blueprint
     * @param  \Illuminate\Support\Fluent  $command
     * @return string
     */
    public function compileInherits(Blueprint $blueprint, Fluent $command)
    {
        return sprintf('alter table %s inherits (%s);',
            $this->wrapTable($blueprint),
            $this->wrapTable($command->table)
        );
    }

    /**
     * Compile a inheritance command.
     *
     * @param  \Illuminate\Database\Schema\Blueprint  $blueprint
     * @param  \Illuminate\Support\Fluent  $command
     * @return string
     */
    public function compileUnInherits(Blueprint $blueprint, Fluent $command)
    {
        return sprintf('alter table %s no inherits (%s);',
            $this->wrapTable($blueprint),
            $this->wrapTable($command->table)
        );
    }

    /**
     * Compile a create table command.
     *
     * @param  \Illuminate\Database\Schema\Blueprint  $blueprint
     * @param  \Illuminate\Support\Fluent  $command
     * @return string
     */
    public function compileCreate(Blueprint $blueprint, Fluent $command)
    {
        $sql = parent::compileCreate($blueprint, $command);

        if (count($tables = $this->getInheritance($blueprint))) {
            return sprintf('%s inherits (%s);', $sql, $tables);
        }

        return $sql;
    }
}
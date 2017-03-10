<?php

namespace Shanginn\Postgresql\Eloquent;
use DB;
use Schema;

class Enum extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = null;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        if (! isset($this->table)) {
            return str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
        }

        return $this->table;
    }

    public static function getEnum($name)
    {
        return DB::select("SELECT unnest(enum_range(NULL::$name))");
    }

    public static function createEnum(string $name, array $options)
    {
        dd('@createEnum', Schema::compileCreateEnum($name, $options));
        return DB::statement("CREATE TYPE {$name} AS ENUM");
    }
}
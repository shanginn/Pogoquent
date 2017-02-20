<?php
namespace Shanginn\Postgresql\Eloquent;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    use Concerns\Postgresed;
}
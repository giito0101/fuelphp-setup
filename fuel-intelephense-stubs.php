<?php

/**
 * Intelephense-only stubs for FuelPHP runtime aliases.
 *
 * FuelPHP aliases many Fuel\Core classes into the global namespace at runtime.
 * Intelephense does not execute FuelPHP's autoloader, so these declarations make
 * those global aliases visible to static analysis.
 */

class Database_Query extends \Fuel\Core\Database_Query
{
}

abstract class Database_Query_Builder extends \Fuel\Core\Database_Query_Builder
{
}

class Database_Query_Builder_Insert extends \Fuel\Core\Database_Query_Builder_Insert
{
}


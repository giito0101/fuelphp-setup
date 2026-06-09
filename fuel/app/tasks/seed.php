<?php

namespace Fuel\Tasks;

use Fuel\Core\DB;

class Seed
{
    public static function run()
    {
        $query = DB::insert('skills');

        $query->columns(array('name', 'level'))
            ->values(array('PHP', 'beginner'))
            ->execute();

        echo "Seed completed.\n";
    }
}

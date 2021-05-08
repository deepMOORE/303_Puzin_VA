<?php declare(strict_types=1);

shell_exec('sqlite3 data/clinic.db < db_init.sql');

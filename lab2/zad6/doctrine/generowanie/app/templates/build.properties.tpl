propel.project = {$conf.database}
propel.database = mysql
propel.database.url = mysql:host={$conf.host} dbname={$conf.database} username={$conf.username} password={$conf.password}
propel.targetPackage = {$conf.database}

propel.addGenericAccessors = true
propel.addGenericMutators = true

propel.mysql.tableType     = InnoDB

propel.home                    = .
propel.phpconf.dir             = {$conf.folder}/../lib
propel.php.dir                 = {$conf.folder}/../lib
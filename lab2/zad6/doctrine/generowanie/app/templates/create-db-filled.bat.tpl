copy output\sql\sql-create-base.sql output\sql\sql-filled.sql


{if $conf.orm == propel}
    type output\propel\build\sql\schema.sql >> output\sql\sql-filled.sql
{else}
    type output\sql\doctrine-tables.sql >> output\sql\sql-filled.sql
{/if}

type output\sql\triggers.sql >> output\sql\sql-filled.sql
type input\{$conf.database}.sql >> output\sql\sql-filled.sql
mysql -u{$conf.root} -p{$conf.rootpassword} < output\sql\sql-filled.sql
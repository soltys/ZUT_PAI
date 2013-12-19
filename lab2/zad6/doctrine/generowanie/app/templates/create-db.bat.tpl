copy output\sql\sql-create-base.sql output\sql\sql-complete.sql

{if $conf.orm == propel}
    type output\propel\build\sql\schema.sql >> output\sql\sql-complete.sql
{else}
    type output\sql\doctrine-tables.sql >> output\sql\sql-complete.sql
{/if}

type output\sql\triggers.sql >> output\sql\sql-complete.sql
mysql -u{$conf.root} -p{$conf.rootpassword} < output\sql\sql-complete.sql
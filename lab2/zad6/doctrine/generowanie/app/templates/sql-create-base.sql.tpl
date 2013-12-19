set names utf8;
drop database if exists {$conf.database};
create database {$conf.database} default character set utf8 collate utf8_polish_ci;
grant all on {$conf.database}.* to {$conf.username}@{$conf.host} identified by '{$conf.password}';
flush privileges;
use {$conf.database};



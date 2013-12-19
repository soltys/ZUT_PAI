<?xml version="1.0" encoding="ISO-8859-1"?>
<config>
  <propel>
    <datasources default="{$conf.database}">
      <datasource id="{$conf.database}">
        <adapter>mysql</adapter>
        <connection>
          <classname>DebugPDO</classname>
          <dsn>mysql:host={$conf.host};dbname={$conf.database}</dsn>
          <user>{$conf.username}</user>
          <password>{$conf.password}</password>
          <attributes>
            <option id="ATTR_EMULATE_PREPARES">true</option>
          </attributes>
          <settings>
            <setting id="charset">{$conf.encoding}</setting>
          </settings>
        </connection>
      </datasource>
    </datasources>
  </propel>
</config>
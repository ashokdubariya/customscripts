## Magento 2 Useful Commands

## Enable / Disable Maintenance Mode
`php bin/magento maintenance:enable`

`php bin/magento maintenance:disable`

## Static Content Deployment Commands
`php -d memory_limit=1G bin/magento setup:static-content:deploy en_GB -t Magento/<YOUR THEME NAME>`

`php bin/magento setup:static-content:deploy en_US en_GB -t Magento/backend`

`php bin/magento setup:static-content:deploy en_GB -t Magento/blank`

`php bin/magento setup:static-content:deploy en_GB -t Magento/luma`

`php bin/magento setup:static-content:deploy en_GB -t Magento/<YOUR THEME NAME>`

## Magento 2 Commands
`php bin/magento setup:upgrade`

`php bin/magento setup:di:compile`

`php bin/magento indexer:reindex`

`php bin/magento cache:flush`

`php bin/magento cache:clean`

`php bin/magento cache:disable`

`php bin/magento cache:enable`

`php bin/magento cache:status`

## Mode Commands (default, developer, production)
`php bin/magento deploy:mode:show`

`php bin/magento deploy:mode:set production --skip-compilation`

`php bin/magento deploy:mode:set developer --skip-compilation`

## Reset Permission Commands
`find . -type f -exec chmod 644 {} \;`

`find . -type d -exec chmod 755 {} \;`

`find . -type f -exec chmod 777 {} \;`

`find . -type d -exec chmod 777 {} \;`

## Create tar.gz File
`tar -zcvf app.tar.gz app/*`

## Extract tar.gz File
`tar -zxvf app.tar.gz`

## Export Database Command
`mysqldump -u DB_USERNAME -p DATABASE_NAME > BACKUP_FILE_NAME.sql`

## Create tar.gz for Database file
`tar -zcvf DATABSE_TAR_FILE_NAME.tar.gz DATABASE_NAME.sql`

## Magento Installation
`php bin/magento setup:install --base-url=http://localhost/magento-versions/magento243/ --db-host=localhost --db-name=magento_243 --db-user=root --db-password=mysql123 --admin-firstname=admin --admin-lastname=admin --admin-email=admin@example.com --admin-user=admin --admin-password=admin123 --language=en_US --currency=USD --timezone=America/Chicago --use-rewrites=1 `

## Execute Below Command for Apache
`sudo php bin/magento config:set web/secure/base_static_url http://localhost/magento-versions/magento243/pub/static/`

`sudo php bin/magento config:set web/unsecure/base_static_url http://localhost/magento-versions/magento243/pub/static/`

`sudo php bin/magento config:set web/secure/base_media_url http://localhost/magento-versions/magento243/pub/media/`

`sudo php bin/magento config:set web/unsecure/base_media_url http://localhost/magento-versions/magento243/pub/media/`

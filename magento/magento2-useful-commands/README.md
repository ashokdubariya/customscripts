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

## Command Commands
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

## SSH Useful Commands

#### Export Database
* mysqldump -u DB_USERNAME -p DB_NAME > DB_BKP_NAME.sql

#### Import Database
* mysql -u DB_USERNAME -p DB_NAME < SQL_FILENAME.sql

#### Create TAR GZ file
* tar -zcvf FILE_NAME.tar.gz FOLDERNAME/*
* tar -zcvf FILE_NAME.tar.gz filename.txt

#### Create ZIP file
* zip -r FILE_NAME.zip FOLDERNAME/*

#### Extract ZIP file
* unzip FILE_NAME.zip
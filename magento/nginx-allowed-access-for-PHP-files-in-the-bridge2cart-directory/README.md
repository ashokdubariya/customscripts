## Nginx - Allowed access for PHP files in the bridge2cart directory
This code will be use to allowed access for PHP files in the bridge2cart directory.

## You can use below code in the Nginx configuration file
`location /bridge2cart/ {
	index index.php index.html index.htm;
	try_files $uri =404;
	expires 30d;
	location ~* \.php$ {
		try_files $uri $uri/ =404;
		fastcgi_pass NAME_OF_THE_FASTCGI_PASS;
		include fastcgi_params;
		fastcgi_index index.php;
		fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
		include fastcgi_params;
	}
}`
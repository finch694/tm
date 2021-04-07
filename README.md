<h1 align="center">Task App</h1>

Small application for task managment. The application was created for the purpose of acquiring practical skills. 
******
#DESCRIPTION
The application implements three roles<sup id="a1">[1](#f1)</sup> for users: 
1. User (executor)(can change the statuses of assigned tasks and close them by setting one of the final statuses)
2. Manager (can create a task, assign it to a user, delete/update a managed task)
3. Administrator (can create a priority/status for tasks, menage users, menage all tasks, view log)

When creating a task, you can add links to the task's text. You can also attach files to tasks.
***
#REQUIREMENTS
The application built with Yii2 PHP Framework

* PHP >= 7.4
   * php-fpm
   * php-cli
   * php-curl
   * php-gzip
   * php-mbstring
   * php-pgsql / php-mysql
* composer
* nginx / apache
***
#INSTALLATION

1. Clone this repository
```
git clone https://github.com/finh694/tm [/path/to/application]
cd [/path/to/application]/tm/
php init
composer install
```
2. Set configuration `/path/to/tm/common/config/main-local.php`
   1. Create a new database and adjust the `components['db']` configuration in `/path/to/tm/common/config/main-local.php` accordingly.
   2. Set mailer configuration 

for example:
```
<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=localhost;port=5432;bname=dbName',
            'username' => 'dbUser',
            'password' => 'dbPassword',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.service.com',  
                'username' => 'username@mail.com',
                'password' => 'password',
                'port' => '578', 
                'encryption' => 'ssl',
            ],
        ],
    ],
]; 
```
3. Open a console terminal, apply migrations:
   1. Main migration
   ```/path/to/php-bin/php /path/to/yii-application/yii migrate```
   1. Rbac migration
   ```/path/to/php-bin/php /path/to/yii-application/yii migrate --migrationPath=@yii/rbac/migrations/```
   1. Log migration 
   ```/path/to/php-bin/php /path/to/yii-application/yii migrate --migrationPath=@yii/log/migrations/```

4. Run rbac init
```
/path/to/php-bin/php /path/to/yii-application/yii rbac-start/init
```

5. Create symlinks 
```cd [/path/to/application]/tm/frontend/web
ln -s ../../backend/web/uploads/ 
ln -s ../../backend/web/img/
```

6. Set configuration of your web server<sup id="a2">[2](#f2)</sup>:

Example for nginx:
```
server {
    listen 80;
    server_name advanced.local;

    set $base_root /path/to/advanced;
    root $base_root;

    #error_log /var/log/nginx/advanced.local.error.log warn;
    #access_log /var/log/nginx/advanced.local.access.log main;
    charset UTF-8;
    index index.php index.html;

    location / {
        root $base_root/frontend/web;
        try_files $uri $uri/ /frontend/web/index.php$is_args$args;

        # omit static files logging, and if they don't exist, avoid processing by Yii (uncomment if necessary)
        #location ~ ^/.+\.(css|js|ico|png|jpe?g|gif|svg|ttf|mp4|mov|swf|pdf|zip|rar)$ {
        #    log_not_found off;
        #    access_log off;
        #    try_files $uri =404;
        #}

        location ~ ^/assets/.+\.php(/|$) {
            deny all;
        }
    }

    location /admin {
        alias $base_root/backend/web/;

        # redirect to the URL without a trailing slash (uncomment if necessary)
        #location = /admin/ {
        #    return 301 /admin;
        #}

        # prevent the directory redirect to the URL with a trailing slash
        location = /admin {
            # if your location is "/backend", try use "/backend/backend/web/index.php$is_args$args"
            # bug ticket: https://trac.nginx.org/nginx/ticket/97
            try_files $uri /backend/web/index.php$is_args$args;
        }

        # if your location is "/backend", try use "/backend/backend/web/index.php$is_args$args"
        # bug ticket: https://trac.nginx.org/nginx/ticket/97
        try_files $uri $uri/ /backend/web/index.php$is_args$args;

        # omit static files logging, and if they don't exist, avoid processing by Yii (uncomment if necessary)
        #location ~ ^/admin/.+\.(css|js|ico|png|jpe?g|gif|svg|ttf|mp4|mov|swf|pdf|zip|rar)$ {
        #    log_not_found off;
        #    access_log off;
        #    try_files $uri =404;
        #}

        location ~ ^/admin/assets/.+\.php(/|$) {
            deny all;
        }
    }

    location ~ ^/.+\.php(/|$) {
        rewrite (?!^/((frontend|backend)/web|admin))^ /frontend/web$uri break;
        rewrite (?!^/backend/web)^/admin(/.+)$ /backend/web$1 break;

        #fastcgi_pass 127.0.0.1:9000; # proxy requests to a TCP socket
        fastcgi_pass unix:/var/run/php-fpm.sock; # proxy requests to a UNIX domain socket (check your www.conf file)
        fastcgi_split_path_info ^(.+\.php)(.*)$;
        include /etc/nginx/fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        try_files $fastcgi_script_name =404;
    }

    location ~ /\. {
        deny all;
    }
}
```
Example for apache:
```
<VirtualHost *:80>
    ServerName advanced.local

    #ErrorLog /var/log/apache2/advanced.local.error.log
    #CustomLog /var/log/apache2/advanced.local.access.log combined
    AddDefaultCharset UTF-8

    Options FollowSymLinks
    DirectoryIndex index.php index.html
    RewriteEngine on

    RewriteRule /\. - [L,F]

    DocumentRoot /path/to/advanced/frontend/web
    <Directory /path/to/advanced/frontend/web>
        AllowOverride none
        <IfVersion < 2.4>
          Order Allow,Deny
          Allow from all
        </IfVersion>
        <IfVersion >= 2.4>
          Require all granted
        </IfVersion>

        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule ^ index.php [L]
    </Directory>

    # redirect to the URL without a trailing slash (uncomment if necessary)
    #RewriteRule ^/admin/$ /admin [L,R=301]

    Alias /admin /path/to/advanced/backend/web
    # prevent the directory redirect to the URL with a trailing slash
    RewriteRule ^/admin$ /admin/ [L,PT]
    <Directory /path/to/advanced/backend/web>
        AllowOverride none
        <IfVersion < 2.4>
            Order Allow,Deny
            Allow from all
        </IfVersion>
        <IfVersion >= 2.4>
            Require all granted
        </IfVersion>

        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule ^ index.php [L]
    </Directory>
</VirtualHost>
```
7. To assign the first role 'Adminisrator' to registered user
```
/path/to/php-bin/php /path/to/yii-application/yii rbac-admin-assign/init [id user]
```
***
<b id="f1">1</b> Each subsequent role includes the functionality of the previous one. [↩](#a1)

<b id="f2">2</b> https://github.com/mickgeek/yii2-advanced-one-domain-config [↩](#a2)

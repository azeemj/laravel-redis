
Target :I want to make the slow web based system to work very fast.

I have used Laravel framework and Redis server in order to implement the solution for the given scenario.
Laravel gives fast MVC design with secure .Redis-cache server ,i have used my personel local redis server .
redis configurations are available in database.php under config folder.



Installation setup
1. please update DB name ,user name and password to .env file that is available under blog folder and execute db_setup.txt file in order to create database and its table.

2. please enter following command from blog folder , "php artisan key:generate "

3. chmod -R 777 blog/storage/

4. if the site is not loading then please enter the following command from blog folder ,"composer update"
ex:make sure site is loading by the following URL , http://localhost/azeem-test/code/web/az/blog/index?msisdn=60123456789&operatorid=3&shortcodeid=8&text=ON+GAMES






1. I have used laravel frame work ,mysql ,Redis cache server to implement the solution
2. Please check blog/app/Http/Controller -->for contorller functions
3. Model ->app/Mo.php
4. Class ->app/lib/myfunctions.php
5. curl http://localhost/object/code/web/az/blog/unprocessed-cache
6. curl http://localhost/object/code/web/az/blog/delete-cache
All URLs:
http://localhost/azeem-test/code/web/az/blog/index?msisdn=60123456789&operatorid=3&shortcodeid=8&text=ON+GAMES

http://localhost/azeem-test/code/web/az/blog/unprocessed-cache

http://localhost/azeem-test/code/web/az/blog/storedb

http://localhost/azeem-test/code/web/az/blog/delete-cache

http://localhost/azeem-tes/code/web/az/blog/stats

Thanks

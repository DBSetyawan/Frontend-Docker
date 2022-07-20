To create a new user, execute an interactive bash shell on the db container with docker-compose exec:

# Front End Settings

This front end for Backend API.

## Description

An in-depth paragraph about your project and overview of use.

## Getting Started

### Dependencies

* Describe any prerequisites, libraries, OS version, etc., needed before installing program.
* Docker
* Laravel

### Installing

* How/where to download your program
* Any modifications needed to be made to files/folders

### Executing program

* How to run the program
* Step-by-step bullets
```
step(1) docker-compose up -d --build
step(2)docker-compose exec app composer require yajra/laravel-datatables-oracle:"~9.0"
```

## Help

Step(3) Inside the container, log into the MySQL root administrative account:
```
mysql -u root -p
```

You will be prompted for the password you set for the MySQL root account during installation in your docker-compose file.

Start by checking for the database called laravel, which you defined in your docker-compose file. Run the show databases command to check for existing databases:
```
show databases;
```

You will see the laravel database listed in the output:
```
Output command: show databases;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| api_backend        |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
5 rows in set (0.00 sec)
```

Next, create the user account that will be allowed to access this database. Our username will be laraveluser, though you can replace this with another name if you’d prefer. Just be sure that your username and password here match the details you set in your .env file in the previous step:
```
mysql> GRANT ALL ON api_backend.* TO 'api_backend'@'%' IDENTIFIED BY 'daniel';
```

Flush the privileges to notify the MySQL server of the changes:
```
mysql> FLUSH PRIVILEGES;
```

Exit Mysql:
```
mysql> EXIT;
```

Finally, exit the container:
```
root@c83ksdb832e0:/# exit
```

With your application running, you can migrate your data and experiment with the tinker command, which will initiate a PsySH console with Laravel preloaded. PsySH is a runtime developer console and interactive debugger for PHP, and Tinker is a REPL specifically for Laravel. Using the tinker command will allow you to interact with your Laravel application from the command line in an interactive shell.

First, test the connection to MySQL by running the Laravel artisan migrate command, which creates a migrations table in the database from inside the container:

```
docker-compose exec app php artisan migrate
```

This command will migrate the default Laravel tables. The output confirming the migration will look like this:
```
Output

Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table
```

Once the migration is complete, you can run a query to check if you are properly connected to the database using the tinker command:

```
docker-compose exec app php artisan tinker
```

Test the MySQL connection by getting the data you just migrated:
```
>>> \DB::table('migrations')->get();
```

You will see output that looks like this:
```
Output
=> Illuminate\Support\Collection {#2856
     all: [
       {#2862
         +"id": 1,
         +"migration": "2014_10_12_000000_create_users_table",
         +"batch": 1,
       },
       {#2865
         +"id": 2,
         +"migration": "2014_10_12_100000_create_password_resets_table",
         +"batch": 1,
       },
     ],
   }
```

## Conclusion
You now have a LEMP stack application running on your server, which you’ve tested by accessing the Laravel welcome page and creating MySQL database migrations.

Key to the simplicity of this installation is Docker Compose, which allows you to create a group of Docker containers, defined in a single file, with a single command. If you would like to learn more about how to do CI with Docker Compose, take a look at How To Configure a Continuous Integration Testing Environment with Docker and Docker Compose on Ubuntu 16.04. If you want to streamline your Laravel application deployment process then How to Automatically Deploy Laravel Applications with Deployer on Ubuntu 16.04 will be a relevant resource.

## Authors

Contributors names and contact info

Daniel Budi Setyawan 
[@DBSetyawan](https://github.com/DBSetyawan)

## Version History

* 0.2
    * Various bug fixes and optimizations
    * See [commit change]() or See [release history]()
* 0.1
    * Initial Release

## License

This project is licensed under the Front End developer License - see the LICENSE.md file for details
[hosted]: awkward-alfreda.gopagoda.com "This is just a demo"

#Welcome to stackfeed

[Demo][hosted]

###Components

* Laravel 4.0.x
* Grunt
* Bower

###Install
1. `$ git clone git@github.com:timwax/stackfeed.git`

2. Create database

3. Change configuration depending on the running environment
	* production /app/config/database.php
	* dev /app/config/local/database.php
	* Laravel has a cool config system and making the app take local config change
	bootstrap/start.php

			$env = $app->detectEnvironment(array(

				'local' => array('machine-host-name'),

			));

	to your running servers hostname

4. on your command line

* `$ cd /to/your/repo/`
* `$ php artisan migrate`

Then you are all set

---------------------------------------------

If you are developing run

* `$ grunt watch`

and it will compile the scss, compile javascript on file changes. Live reload can auto refresh browser for you
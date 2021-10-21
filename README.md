# Planner

# Description
1. Prepare database:
   1.1. Structure
   1.2. PHP import script (can be launched from shell or browser), that will import 2-3 pages of projects from our gallery: https://planner5d.com/gallery/floorplans
2. List of projects. Pressing on list item should open project preview page.
3. Project preview page should contain:
   3.1. Project title
   3.2. Project preview (Canvas 2D) on which you should draw project room polygons from first floor
   3.3. Hits - how many times project preview page was visited

# How to use
- Written and tested with PHPStorm (I installed PHP 8.0 with php-npm and php-mysql libs)
- After install Mariadb 10.6 - https://www.unixmen.com/install-mariadb-arch-linuxmanjaro/ - create DB and User with PRIVILEGES according to the .env - https://mariadb.com/kb/en/create-user/ (Configured in Storm - https://www.jetbrains.com/help/phpstorm/mariadb.html)
- Inside the settings of the Storm configured interpreter - https://www.jetbrains.com/help/phpstorm/configuring-local-interpreter.html ;
- And configured composer client - https://www.jetbrains.com/help/phpstorm/using-the-composer-dependency-manager.html; if you do not have previously installed, you can download it - https://getcomposer.org/download/
- Then run "composer install" to get CURL, PDO, DOM extensions and Autoload
- After -  copy env.example .env (after it copied you can set your DB preferences)
- To run web server, just go to "cd /src/View" - and execute "php -S localhost:8000" - finally it is ready to test;
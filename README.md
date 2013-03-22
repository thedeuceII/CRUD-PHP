# [CRUD-PHP] 

CRUD-PHP is a very easy way to start your small application without setup a lot of configurations as you have in a framework.

To get started, checkout https://github.com/wildiney/CRUD-PHP!



## Quick start

* [Download the latest release](https://github.com/wildiney/CRUD-PHP)

* Clone the repo: `git clone https://github.com/wildiney/CRUD-PHP.git`.


It's very easy to setup up a new application.

* First of all, download or clone to your root application.

* Iinsert the informations about your host on config/config.inc.php and include this file at the begining of your application.

  <?php include_once('../config/config.inc.php'); ?>

* After that, for each table that you need just create a php file inside the folder classes with the name of your class extending MainConnection.
  
  //file "/classes/Production.class.php"
  
  
  class Production extends MainConnection
  
  
  {
  
  
  	   protected $table = "your table";
	
	     protected $primaryKey = "your table primary key";
  
  }

* Call your new class in your file without includes. There is a feature to autoload your classes.


  $production = new Production;

  $allProduction = $production->listAll();



## Versioning

For transparency and insight into our release cycle, and for striving to maintain backward compatibility, this project will be maintained under the Semantic Versioning guidelines as much as possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)

* New additions without breaking backward compatibility bumps the minor (and resets the patch)

* Bug fixes and misc changes bumps the patch



## Bug tracker

Have a bug or a feature request? [Please open a new issue](https://github.com/wildiney/CRUD-PHP/issues). 

Before opening any issue, please search for existing issues.



## Author

**Wildiney Di Masi**

+ http://www.wildiney.com/

+ http://twitter.com/wildiney

+ http://github.com/wildiney

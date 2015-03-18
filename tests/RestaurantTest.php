<?php
        /**
        * @backupGlobals disabled
        * @backupStaticAttributes disabled
        */        

        require_once "src/Restaurant.php"

        $DB = new PDO('pgsql:host=localhost;dbname=yelp_test');

        class RestaurantTest extends PHPUNIT_Framework_TestCase
        {
            protected function tearDown()
            {
                Restaurant:deleteAll();
                //Cuisine:deleteAll();
            }
        }
?>

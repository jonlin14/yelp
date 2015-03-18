<?php
        /**
        * @backupGlobals disabled
        * @backupStaticAttributes disabled
        */

        require_once "src/Restaurant.php";

        $DB = new PDO('pgsql:host=localhost;dbname=yelp_test');

        class RestaurantTest extends PHPUnit_Framework_TestCase
        {
            protected function tearDown()
            {
                Restaurant::deleteAll();
                //Cuisine:deleteAll();
            }

            function test_save()
            {
                //Arrange
                $name= "Burger King";
                $new_name_test = new Restaurant($name);

                //Act
                $new_name_test->save();
                $result = $new_name_test->getName();

                //Assert
                $this->assertEquals("Burger King", $result);
            }

            function test_deleteAll()
            {
                //Arrange
                $name= "Burger King";
                $new_name_test = new Restaurant($name);

                //Act
                $result= $new_name_test->deleteAll();

                //Assert
                $this->assertEquals(null, $result);
            }
        }
?>

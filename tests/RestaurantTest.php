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
                //Restaurant::deleteAll();

                //Assert
                //$result = Restaurant::getAll();

                //$this->assertEquals([], $result);
                $this->assertEquals(null, $result);
            }

            function test_getAll()
            {
                $id = null;
                $name = "Burger King";
                $new_name_test = new Restaurant($name, $id);
                $new_name_test->save();
                $name1 = "McDonalds";
                $new_name_test1 = new Restaurant($name1, $id);
                $new_name_test1->save();
                $result = Restaurant::getAll();

                $this->assertEquals([$new_name_test, $new_name_test1], $result);
            }


            function test_find()
            {
                $id = null;
                $name = "Burger King";
                $new_name_test = new Restaurant($name, $id);
                $new_name_test->save();

                $name1 = "McDonalds";
                $new_name_test1 = new Restaurant($name1, $id);
                $new_name_test1->save();

                $result = Restaurant::find($new_name_test1->getId());

                $this->assertEquals($name1, $result);

            }
        }
?>

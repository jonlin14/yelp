<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";

    $DB = new PDO('pgsql:host=localhost;dbname=yelp_test');

    class CuisineTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Cuisine::deleteAll();
        }

        function test_getAll() {
            $id = null;
            $type1 = 'mexican';
            $cuisine1 = new Cuisine($type1, $id);
            $cuisine1->save();
            $type2 = 'italian';
            $cuisine2 = new Cuisine($type2, $id);
            $cuisine2->save();

            $results = Cuisine::getAll();

            $this->assertEquals([$cuisine1, $cuisine2], $results);
        }

        function test_saveTest() {

            //arrange
            $id = null;
            $type = 'mexican';
            $cuisine1 = new Cuisine($type, $id);

            //act
            $cuisine1->save();
            $results = Cuisine::getAll();

            //assert
            $this->assertEquals($cuisine1, $results[0]);

        }

        function test_search()
        {
            $id = 1;

            $type1 = 'mexican';
            $cuisine1 = new Cuisine($type1, $id);
            $cuisine1->save();

            $type2 = 'italian';
            $cuisine2 = new Cuisine($type2, $id = 2);
            $cuisine2->save();

            $result = Cuisine::search($cuisine1->getId());

            $this->assertEquals($cuisine1, $result);

        }

        function testUpdate()
        {
            //Arrange
            $type= "mexican";
            $id = 1;
            $test_type = new Cuisine ($type, $id);
            $test_type->save();

            $new_type= "thai";

            //Act
            $test_type->update($new_type);

            //Assert
            $this->assertEquals("thai", $test_type->getType());
        }
    }




 ?>

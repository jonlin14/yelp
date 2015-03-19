<?php

    class Restaurant {

        private $name;
        private $id;
        private $cuisine_id;


        function __construct($name, $id = null, $cuisine_id)
        {
            $this->name= $name;
            $this->id = $id;
            $this->cuisine_id=$cuisine_id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name=$new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = $new_id;
        }

        function getCuisine_Id()
        {
            return $this->cuisine_id;
        }

        function setCuisine_Id($new_cuisine_id)
        {
            $this->cuisine_id = $new_cuisine_id;
        }


        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO restaurants (name, cuisine_id) VALUES ('{$this->getName()}', {$this->getCuisine_Id()}) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants *;");
        }

        static function getAll()
        {
             $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
             $new_array = array();
             foreach ($returned_restaurants as $element)
             {
                 $name = $element['name'];
                 $id = $element['id'];
                 $cuisine_id = $element['cuisine_id'];
                 $new_restaurant = new Restaurant($name, $id, $cuisine_id);
                 array_push($new_array, $new_restaurant);
             }
                return $new_array;
        }

        static function search($search_id)
        {
            $found_restaurant = null;
            $returned_array = Restaurant::getAll();
            foreach ($returned_array as $element)
            {
                $id = $element->getId();
                if ($id == $search_id)
                {
                    $found_restaurant = $element;
                }
            }
            return $found_restaurant;
        }
        static function searchCuisine($search_cuisine_id)
        {
            $found_cuisine = array();
            $returned_array = Restaurant::getAll();
            foreach ($returned_array as $element)
            {
                $cuisine_id = $element->getCuisine_Id();
                if ($cuisine_id == $search_cuisine_id)
                {
                    array_push($found_cuisine, $element);
                }
            }
            return $found_cuisine;
        }
    }
?>

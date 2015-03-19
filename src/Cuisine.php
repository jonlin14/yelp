<?php

    class Cuisine {

        private $type;
        private $id;

        function __construct($type, $id = null)
        {
            $this->type= $type;
            $this->id = $id;
        }

        function setType($new_type)
        {
            $this->type= $new_type;
        }

        function getType()
        {
            return $this->type;
        }

        function setId($new_id)
        {
            $this->id = $new_id;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO cuisine (type) VALUES ('{$this->getType()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);

        }

        function update($new_type)
        {
            $GLOBALS['DB']->exec("UPDATE cuisine SET type = '{$new_type}' WHERE id = {$this->getId()};");
            $this->setType($new_type);
        }

        static function getAll()
        {
            $returned_Cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine");
            $new_array = array();

            foreach($returned_Cuisines as $element)
            {
                $description = $element['type'];
                $id = $element['id'];
                $new_cuisine = new Cuisine($description, $id);
                array_push($new_array, $new_cuisine);
            }
            return $new_array;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine *;");
        }

        static function search($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach ($cuisines as $cuisine) {
                $cuisine_id = $cuisine->getId();
                if ($cuisine_id == $search_id) {
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine WHERE id = {$this->getId()};");
        }

    }

?>

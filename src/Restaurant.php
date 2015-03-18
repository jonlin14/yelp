<?php

    class Restaurant {

        private $name;

        function __construct($name)
        {
            $this->name= $name;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name=$new_name;
        }

        
    }
?>

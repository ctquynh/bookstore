<?php
    class Entity {
        private $data = array();
        function __get($name)
        {
            return $this->data[$name];
        }

        function __set($name, $value)
        {
            $this->data[$name] = $value;
        }
    }
?>
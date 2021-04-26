<?php
    class Address {
        public function __construct(string $street,string $city, string $state, int $zip) {
            $this->street = $street;
            $this->city = $city;
            $this->state = $state;
            $this->zip = $zip;
        }

        public $street;
        public $city;
        public $state;
        public $zip;
    }
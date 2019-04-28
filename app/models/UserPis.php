<?php
    class UserPis extends Eloquent {
        protected $connection = 'pis';
        protected $table = 'users';
        protected $primaryKey = 'id';
    }
?>
<?php
class UserDts extends Eloquent {
    protected $connection = 'dts';
    protected $table = 'users';
    protected $primaryKey = 'id';
}
?>
<?php
class Tardiness extends Eloquent {
    protected $connection = 'pis';
    protected $table = 'tardiness';
    protected $primaryKey = 'id';
}
?>
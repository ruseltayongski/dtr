<?php
/**
 * Created by PhpStorm.
 * User: doh7_it
 * Date: 7/19/2023
 * Time: 11:14 AM
 */

class CardView extends Eloquent
{
    protected $table = 'card_view';
    protected $fillable=['bal_credits', 'new_bal'];
}

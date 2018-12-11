<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Follow Class responsible for followers operations.
 * @package App
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class Follow extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['followee_id'];
    
}

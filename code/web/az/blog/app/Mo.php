<?php
namespace App;


use Illuminate\Database\Eloquent\Model;


class Mo extends Model 
{
  

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mo_azeem';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['msisdn', 'operatorid', 'shortcodeid','text','auth_token','created_at'];

  
}

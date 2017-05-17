<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
    	'street', 'zip', 'city'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
	}

	public function getCanonicalForm()
	{
		return $this->street . ", " . $this->zip . " " . $this->city;
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}

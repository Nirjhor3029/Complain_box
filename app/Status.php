<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	//
	public function idea(){
		return $this->hasMany(Idea::class);
	}
}

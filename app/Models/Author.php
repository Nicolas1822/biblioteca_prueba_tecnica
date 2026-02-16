<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	use HasFactory;

	protected $table = "authors";

	protected $fillable = [
		'id',
		'name',
		'biography',
		'birth_date'
	];

	public function book() {
		return $this->hasMany(Book::class, 'author_id');
	}
}

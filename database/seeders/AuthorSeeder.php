<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Database\Factories\BookFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Author::factory()
		->count(10)
		->has(Book::factory()->count(3))
		->create();
	}
}

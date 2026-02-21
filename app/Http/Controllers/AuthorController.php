<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorsRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$authors = Author::select('name', 'biography', 'birth_date')->get();
		return response()->json($authors);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(AuthorsRequest $request)
	{
		$createAuthor = Author::create([
			'name' => $request->name,
			'biography' => $request->biography,
			'birth_date' => $request->birth_date,
		]);

		return response()->json(['state' => 'author created successfuly'])->setStatusCode(201);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(int $id)
	{
		$author = Author::with([
			'book' => function ($query) {
				$query->select('title', 'isbn', 'published_year', 'author_id');
			}
		])->find($id);

		if (!$author) {
			return response()->json([
				'error' => 'Author not found'
			], 404);
		}

		// Estructurar la respuesta
		return response()->json([
			'data' => [
				'author' => [
					'name' => $author->name,
					'biography' => $author->biography,
					'birth_date' => $author->birth_date,
				],
				'book' => $author->book->map(function ($book) {
					return [
						'title' => $book->title,
						'isbn' => $book->isbn,
						'published_year' => $book->published_year,
					];
				}),
			]
		], 200);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
}

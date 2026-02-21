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
	 * Update the specified resource in storage.
	 */
	public function update(AuthorsRequest $request, string $id)
	{
		$getIdAuthor = Author::findOrFail($id);

		$getIdAuthor->name = $request->name ?? $getIdAuthor->name;
		$getIdAuthor->biography = $request->biography ?? $getIdAuthor->biography;
		$getIdAuthor->birth_date = $request->birth_date ?? $getIdAuthor->birth_date;

		$getIdAuthor->save();

		return response()->json([
			'message' => 'Author update successfully',
			'author' => $getIdAuthor
		])->setStatusCode(200);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		if (Book::where('author_id', '=', $id)->exists()) {
			return response()->json([
				'error' => 'You cannot delete an author with associated books'
			])->setStatusCode(409);
		}

		$getIdAuthor = Author::findOrFail($id);

		$getIdAuthor->delete();

		return response()->json(['message' => 'Author Deleted'])->setStatusCode(200);
	}
}

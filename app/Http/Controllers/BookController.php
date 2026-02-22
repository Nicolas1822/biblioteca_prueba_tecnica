<?php

namespace App\Http\Controllers;

use App\Http\Requests\BooksRequest;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$getAllBooks = Book::all();
		return response()->json([$getAllBooks])->setStatusCode(200);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(BooksRequest $request)
	{
		$getAuthor = Author::where('id', '=', $request->author_id)->exists();
		if (!$getAuthor) {
			return response()->json([
				'error' => 'author not found in the system'
			])->setStatusCode(404);
		}

		Book::create([
			'author_id' => $request->author_id,
			'title' => $request->title,
			'isbn' => $request->isbn,
			'published_year' => $request->published_year,
		]);

		return response()->json(['state' => 'book created successfuly'])->setStatusCode(201);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		$getIdBook = Book::findOrFail($id);
		return response()->json([$getIdBook])->setStatusCode(200);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		$getAuthor = Author::where('id', '=', $request->author_id)->exists();
		if (!$getAuthor) {
			return response()->json([
				'error' => 'author not found in the system'
			])->setStatusCode(404);
		}

		$getIdBook = Book::findOrFail($id);
		$getIdBook->author_id = $request->author_id ?? $getIdBook->author_id;
		$getIdBook->title = $request->title ?? $getIdBook->titlle;
		$getIdBook->isbn = $request->isbn ?? $getIdBook->isbn;
		$getIdBook->published_year = $request->published_year ?? $getIdBook->published_year;
		$getIdBook->save();

		return response()->json([
			'mesage' => 'Book updated succesfully',
			$getIdBook
		])->setStatusCode(200);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		$getIdBook = Book::findOrFail($id);
		$getIdBook->delete();
				return response()->json([
			'mesage' => 'Book deleted succesfully',
		])->setStatusCode(200);
	}
}

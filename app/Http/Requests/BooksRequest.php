<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BooksRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'author_id' => 'required|numeric',
			'title' => 'required|string|max:80',
			'isbn' => 'required|unique:books,isbn|string',
			'published_year' => 'required|numeric|min:1000|max:2026'
		];
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array<string, string>
	 */
	public function messages(): array
	{
		return [
			'author_id.required' => 'The author_id is required',
			'author_id.numeric' => 'The author_id has been numeric',
			'title.required' => 'The title is required',
			'title.max' => 'The title has been contain max 80 characters',
			'isbn.required' => 'The isbn is required',
			'isbn.unique' => 'isbn has been unique',
			'published_year.required' => 'The published year is required',
			'published_year.numeric' => 'The published year has been contain numbers',
			'published_year.max' => 'The published year has been contain max 4 characters',
			'published_year.min' => 'The published year has been contain min 4 characters',
		];
	}
}

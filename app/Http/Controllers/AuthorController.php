<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Author;

class AuthorController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return the list of authors
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::all();
        
        return $this->successResponse($authors);
    }
    
    /**
     * Create one new author
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Obtain and show one author
     * @return Illuminate\Http\Response
     */
    public function show($authorId)
    {
        $author = Author::findOrFail($authorId);

        return $this->successResponse($author);
    }

    /**
     * Update an existing author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $authorId)
    {
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
        ];

        $this->validate($request, $rules);
        $author = Author::findOrFail($authorId);
        $author->fill($request->all());

        if ($author->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();

        return $this->successResponse($author);
    }

    /**
     * Remove an existing author
     * @return Illuminate\Http\Response
     */
    public function destroy($authorId)
    {
        $author = Author::findOrFail($authorId);
        $author->delete();

        return $this->successResponse($author);

    }

    //
}

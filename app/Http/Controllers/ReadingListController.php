<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReadingListResource;
use App\ReadingList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Exception;

/**
 * Class ReadingListController
 * @package App\Http\Controllers
 */
class ReadingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        //@todo implement api auth
        if ($user = Auth::user()) {
            return ReadingListResource::collection($user->readingLists);
        }
        return ReadingListResource::collection(ReadingList::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ReadingListResource
     */
    public function store(Request $request)
    {
        $list = ReadingList::create([
            'name' => $request->json('name'),
            'user_id' => Auth::user()->id ?? 1 //@todo implement user/auth system
        ]);

        $list->books()->attach($request->json('bookIds'));

        return new ReadingListResource($list);
    }

    /**
     * Display the specified resource.
     *
     * @param ReadingList $list
     * @return ReadingListResource
     */
    public function show(ReadingList $list)
    {
        return new ReadingListResource($list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ReadingList $list
     * @return ReadingListResource
     */
    public function update(Request $request, ReadingList $list)
    {
        //@todo need to do book request validation here
        if ($request->json('detach')) {
            $list->books()->detach($request->json('books'));
        } else {
            $list->books()->sync($request->json('books'), $request->json('detach_existing') ?? false);
        }

        return new ReadingListResource($list);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReadingList $list
     * @throws Exception
     */
    public function destroy(ReadingList $list)
    {
        $list->delete();
    }
}

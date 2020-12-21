<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PeopleResource;
use App\Models\People;

class PeopleController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @OA\Get(
     *      path="/peoples",
     *      operationId="getPeoplesList",
     *      tags={"Peoples"},
     *      summary="Get list Peoples",
     *      description="Returns list peoples",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */
    public function index()
    {
        $oPeople = People::all();

        return response(
            [ 'data' => PeopleResource::collection($oPeople),
                'message' => 'successfully'],
            200);
    }

    /**
     * @OA\Get(
     *      path="/peoples/{id}",
     *      operationId="getPeopleById",
     *      tags={"Peoples"},
     *      summary="Get Import information",
     *      description="Returns People data",
     *      @OA\Parameter(
     *          name="id",
     *          description="People id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      )
     * )
     */
    public function show($iPeople)
    {
        try {
            $oPeople = People::findOrFail($iPeople);

            return response(
                ['data' => new PeopleResource($oPeople),
                    'message' => 'successfully']
                ,200);

        } catch (\Exception $oError) {
            return response()->json(['data' => '', 'message' => 'Not Found!'], 404);
        }
    }
}

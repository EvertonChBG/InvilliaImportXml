<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ImportResource;
use App\Models\Import;

class ImportController extends ApiController
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
     *      path="/imports",
     *      operationId="getImportList",
     *      tags={"Imports"},
     *      summary="Get list of Files Importeds",
     *      description="Returns list of files importeds",
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
        $oImport = Import::all();

        return response(
            ['data' => ImportResource::collection($oImport),
                'message' => 'successfully'],
            200);
    }

    /**
     * @OA\Get(
     *      path="/imports/{id}",
     *      operationId="getImportById",
     *      tags={"Imports"},
     *      summary="Get Import information",
     *      description="Returns Import data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Import id",
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
    public function show($iImport)
    {
        try {
            $oImport = Import::findOrFail($iImport);

            return response(
                ['data' => new ImportResource($oImport),
                    'message' => 'successfully']
                ,200);

        } catch (\Exception $oError) {
            return response()->json(['data' => '','message' => 'Not Found!'],404);
        }
    }
}

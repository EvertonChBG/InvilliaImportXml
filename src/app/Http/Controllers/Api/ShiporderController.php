<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ShiporderResource;
use App\Models\Shiporder;

class ShiporderController extends ApiController
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
     *      path="/shiporders",
     *      operationId="getShipordersList",
     *      tags={"Shiporders"},
     *      summary="Get list Shiporders",
     *      description="Returns list Shiporders",
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
        $oShiporder = Shiporder::with('items')->get()->all();

        return response(
            [ 'data' => ShiporderResource::collection($oShiporder),
            'message' => 'successfully'],
            200);
    }

    /**
     * @OA\Get(
     *      path="/shiporders/{id}",
     *      operationId="getShipordersById",
     *      tags={"Shiporders"},
     *      summary="Get Shiporder information",
     *      description="Returns Shiporder data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Shiporder id",
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
    public function show($iShiporder)
    {
        try {
            $oShiporder = Shiporder::with('items')
                ->findOrFail($iShiporder);

            return response(
                ['data' => new ShiporderResource($oShiporder),
                    'message' => 'successfully']
                ,200);

        } catch (\Exception $oError) {
            return response()->json(['data' => '', 'message' => 'Not Found!'], 404);
        }
    }
}

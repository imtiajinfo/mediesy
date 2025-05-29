<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\PurchaseOrders;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // return [
        //     'data' => PurchaseOrderResource::collection($this->collection),
        //     'message' => 'Data processing completed',
        // ];

        // return [
        //     'data' => $this->chunk(500, function ($PurchaseOrders) use (&$purchase) {
        //         $purchaseChunk = $PurchaseOrders->map(function ($brand) {
        return [
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'total_purchase_qty' => $this->total_purchase_qty,
            'total_received_qty' => $this->total_received_qty,
        ];
        // });
        //         $purchase[] = $purchaseChunk->toArray();
        //     }),
        //     'message' => 'Data processing completed',
        // ];
    }



    /**
     * Add additional data to the resource response.
     *
     * @param  Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'meta' => [
                'key' => ['nested' => 'value'],
                'key' => true,
            ],
        ];
    }



    /**
     * Customize the outgoing response for the resource.
     *
     * @param  Request  $request
     * @param  \Illuminate\Http\JsonResponse  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}

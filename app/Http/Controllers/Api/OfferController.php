<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\offer;

class OfferController extends Controller {

    /**
     * @api {get} /api/offer-listing  Offer listing & details
     * @apiHeader {String} Accept application/json. 
     * @apiName GetOfferListDetail
     * @apiGroup Offer
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message offers found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "offers found",
     *    "data": [
     *        {
     *            "id": 2,
     *            "name": "3 days, 3 nights",
     *           "description": "<h1><strong>3 days, 3 nights</strong></h1>\n\n<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>\n\n<ul>\n\t<li>\n\t<h1>but also the leap into electronic typesetting, remaining essentially unchanged.</h1>\n\t</li>\n\t<li>\n\t<h1>It was popularised in the 1960s with the release of Letraset sheets containing</h1>\n\t</li>\n\t<li>\n\t<h1>Lorem Ipsum passages, and more recently with desktop publishing software</h1>\n\t</li>\n\t<li>\n\t<h1>like Aldus PageMaker including versions of Lorem Ipsum</h1>\n\t</li>\n</ul>\n",
     *            "valid_to": "Nov-21-2018",
     *            "price": 500,
     *            "discount": "10% OFF",
     *            "discounted_price": 450,
     *            "offer_images": [
     *                {
     *                    "id": 2,
     *                    "banner_image_url": "http://127.0.0.1:8000/storage/offer_images/QKSTxwKTkrHBY1vp3OmMNSONGjse5lUT27xo8PXf.jpeg",
     *                    "offer_id": 2
     *                },
     *                {
     *                    "id": 3,
     *                    "banner_image_url": "http://127.0.0.1:8000/storage/offer_images/KBv5Q07WSicZDST5Wf42U2iFhSivLMh6TsK5frcE.jpeg",
     *                    "offer_id": 2
     *                }
     *            ]
     *        }
     *    ]
     * }
     * 
     * @apiError ResortIdMissing The resort id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Resort id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function offerListing(Request $request) {
        try {
            if($request->resort_id == -1){
                $offers = offer::where(["is_active" => 1])->with([
                        'offerImages' => function($query) {
                            $query->select('id', 'image_name as banner_image_url', 'offer_id');
                        }
                    ])->latest()->get();
            }else{
                if (!$request->resort_id) {
                    return $this->sendErrorResponse("Resort id missing", (object) []);
                }
                $offers = offer::where(["is_active" => 1, "resort_id" => $request->resort_id])->with([
                            'offerImages' => function($query) {
                                $query->select('id', 'image_name as banner_image_url', 'offer_id');
                            }
                        ])->get();
            }
            $dataArray = [];
            if (count($offers) > 0) {
                foreach ($offers as $key => $offer) {
                    $validity = Carbon::parse($offer->valid_to);
                    $dataArray[$key]['id'] = $offer->id;
                    $dataArray[$key]['name'] = $offer->name;
                    $dataArray[$key]['description'] = $offer->description;
                    $dataArray[$key]['valid_to'] = $validity->format('M-d-Y');
                    $dataArray[$key]['price'] = $offer->price;
                    $dataArray[$key]['discount'] = $offer->discount_percentage . "% OFF";
                    $dataArray[$key]['discounted_price'] = (int) $offer->price - (int) $offer->calculated_discount;
                    $dataArray[$key]['offer_images'] = $offer->offerImages;
                }

                return $this->sendSuccessResponse("offers found", $dataArray);
            } else {
                return $this->sendErrorResponse("offers not found", (object) []);
            }
        } catch (\Exception $e) {
            return $this->administratorResponse();
        }
    }

}

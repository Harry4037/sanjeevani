<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\offer;
use App\Models\Resort;

class OfferController extends Controller {

    /**
     * @api {get} /api/offer-listing  Offer listing & details
     * @apiHeader {String} Accept application/json. 
     * @apiName GetOfferListDetail
     * @apiGroup Offer
     * 
     * @apiParam {String} resort_id Resort Id* (For guest user use resort id value -1).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message offers found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "offers found",
      "data": [
      {
      "id": 5,
      "name": "Valentines Day Offer",
      "description": "<p>Chocolate and flowers and officially done. This year, give your S.O. a gift they&rsquo;ll never forget&mdash;a stay at a luxurious hotel with added perks guaranteed to put you in the mood. Sweet dreams ;)</p>\r\n\r\n<p>_____________________________________________________________________</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Room Amenities:&nbsp;</strong><em>Guests can choose from a total of 108 rooms that are categorised into Standard, Fortune Club rooms and Suites. The hotel also has an accessible room. Most of the rooms have an impeccable view of the Chamundi Hills and come equipped with all modern amenities. Amenities include a flat-screen TV, high-speed internet connectivity, mini-bar, electronic safe, tea/coffee maker and iron/ironing board.</em></p>\r\n\r\n<p>_____________________________________________________________________</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Hotel Facilities:&nbsp;</strong><em>With laundry service and 24-hour room service, guests never have to worry about any of their daily chores during their stay. The Tulip Spa is renowned for the rejuvenating experience it offers with an array of holistic and Ayurvedic programmes to choose from. Other facilities include a swimming pool, steam room, and fitness centre.</em></p>\r\n\r\n<p>_____________________________________________________________________</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Dining:&nbsp;</strong><em>Orchid is the 24-hour restaurant that offers an array of culinary delight and sumptuous buffets, ideal for a luncheon meeting or a relaxed dinner. The Oriental Pavilion is open only for dinner and serves authentic Oriental cuisine in a modern, contemporary setting. Neptune Bar &amp; Lounge is the perfect place to relax and unwind after a tiring day, with an excellent selection of spirits and wines. The Terrace Grill &amp; Tandoor offers a mesmerizing view of the Chamundi Hills, combined with diffused lighting and lounge music.</em></p>\r\n\r\n<p>_____________________________________________________________________</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ul>\r\n\t<li><em>FREE Breakfast</em></li>\r\n\t<li><em>Two bottles of mineral water on a daily basis in the room</em></li>\r\n\t<li><em>Fruit Basket &amp; Cookies</em></li>\r\n\t<li><em>10% Discount on F&amp;b &amp; Laundry</em></li>\r\n\t<li><em>Accommodation</em></li>\r\n</ul>",
      "valid_to": "Feb-17-2019",
      "price": 13000,
      "discount": "25% OFF",
      "discounted_price": 9750,
      "offer_images": [
      {
      "id": 17,
      "banner_image_url": "http://127.0.0.1:1234/storage/offer_images/Cq5X48lXqVJOEcbi0yYNkKeitYboDLAyxmqmSSDV.jpeg",
      "offer_id": 5
      }
      ]
      },
      {
      "id": 7,
      "name": "Amazing Offer of 3N-4D @Sanjeevani Resort",
      "description": "<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\r\n\r\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\r\n\r\n<h1><strong>Terms &amp; Conditions</strong></h1>\r\n\r\n<ul>\r\n\t<li>The free cancellation is applicable on select hotels. Please check the cancellation policy while booking. The policy will be mentioned while making the hotel booking and in the booking confirmation voucher sent to the customer.</li>\r\n\t<li>The hotel cancellation policy will apply on any cancellation done by the customer.</li>\r\n\t<li>There is no restriction on travel dates.</li>\r\n\t<li>This is only applicable to&nbsp;online hotel bookings made via&nbsp;www.makemytrip.com&nbsp;and MakeMyTrip mobile app (Android and iOS only).</li>\r\n\t<li>User Agreement and Privacy Policy at MakeMyTrip website shall apply. MakeMyTrip will be entitled to reject any claim in case there is any abuse/misuse of the offer by the customer or the cancellation/claim is not eligible under the offer.</li>\r\n\t<li>Travel agents, by occupation, are barred from making bookings for their customers and MakeMyTrip reserves the right to deny the offer against such bookings or to cancel such bookings.</li>\r\n\t<li>MakeMyTrip reserves the right, without notice or liability and without assigning any reasons whatsoever, to add, alter, modify, change or vary all or any of these terms and conditions or to replace, wholly or in part, this Offer by another Offer, whether similar to this Offer or not, or to withdraw it altogether at any point in time by providing appropriate notice.</li>\r\n\t<li>All decisions with respect to the offer shall be at the discretion of MakeMyTrip and the same shall be final, binding and non-contestable.</li>\r\n\t<li>The terms and conditions shall be governed by the laws of India. Any dispute arising out of or in relation to this offer shall be subject to the exclusive jurisdiction of competent courts in New Delhi.</li>\r\n\t<li>The maximum liability of MakeMyTrip in the event of any claim arising out of this offer shall not exceed the amount under the underlying transaction paid by the customer.</li>\r\n\t<li>MakeMyTrip shall not be liable to pay for any indirect, punitive, special, incidental or consequential damages arising out of or in connection with the offer.</li>\r\n\t<li>Breakfast</li>\r\n\t<li>Complimentary stay for children under 5 without extra bed</li>\r\n\t<li>Complimentary Mineral Water Daily: 1 bottle</li>\r\n\t<li>Complimentary Tea/Coffee Maker with Daily Replenishments</li>\r\n\t<li>Buffet breakfast at a multicuisine restaurant</li>\r\n</ul>",
      "valid_to": "Jan-31-2019",
      "price": 17999,
      "discount": "15% OFF",
      "discounted_price": 15300,
      "offer_images": [
      {
      "id": 19,
      "banner_image_url": "http://127.0.0.1:1234/storage/offer_images/ZjOeKoMM51fz1iV9rIz1zM3RKy1mU3bNTaBreAy8.jpeg",
      "offer_id": 7
      },
      {
      "id": 20,
      "banner_image_url": "http://127.0.0.1:1234/storage/offer_images/cpgxq1oAGgcMhpkFvwBBwwAUDYzilxdU6KxHNYmT.jpeg",
      "offer_id": 7
      }
      ]
      },
      {
      "id": 8,
      "name": "Reverse Diabetes Package for 21 Days @ Sanjeevani",
      "description": "<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\r\n\r\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\r\n\r\n<h1><strong>Day Routine Plan</strong></h1>\r\n\r\n<p>05:00 AM: Wake Up</p>\r\n\r\n<p>05:30 AM: Fasting Sugar</p>\r\n\r\n<p>05:45 AM: Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM: Walk/Yoga</p>\r\n\r\n<p>07:00 AM: Coconut Water</p>\r\n\r\n<p>08:00 AM: Salad Breakfast</p>\r\n\r\n<p>09:00 AM: Meditation/Massage</p>\r\n\r\n<p>12:00 AM: Lunch</p>\r\n\r\n<p>12:30 PM: Walk</p>\r\n\r\n<p>03:00 PM: Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM: Consultancy</p>\r\n\r\n<p>04:00 PM: Routine Check-up</p>\r\n\r\n<p>06:00 PM: Dinner</p>\r\n\r\n<p>07:00 PM: Spiritual Classes</p>\r\n\r\n<p>08:00 PM: Bed Time</p>",
      "valid_to": "Jan-31-2019",
      "price": 49999,
      "discount": "10% OFF",
      "discounted_price": 45000,
      "offer_images": [
      {
      "id": 21,
      "banner_image_url": "http://127.0.0.1:1234/storage/offer_images/8373Pl3Ku7pO4AWXg0aPgumXuXyTbTEHY54wgb5t.jpeg",
      "offer_id": 8
      },
      {
      "id": 22,
      "banner_image_url": "http://127.0.0.1:1234/storage/offer_images/x8BdhjL6Vs1FES7jLTA2M860F4vR44uAPWPJyhjD.jpeg",
      "offer_id": 8
      }
      ]
      },
      {
      "id": 9,
      "name": "New Year Eve Party @Le Maridien, New Delhi",
      "description": "<p>Located close to tourist attractions in Mysore, Fortune JP Palace offers comfortable rooms, delicious food and luxuries like swimming pool.</p>\r\n\r\n<p><strong>Location:&nbsp;</strong><em>Situated in the heart of the grand old city of Mysore, the Fortune JP Palace is well-connected to many major tourist attractions. Mysore Palace is 2 km away and St. Philomena&#39;s Church a 5 minute walk from the hotel. The hotel is 15 km away from Mysore International Airport and 3 km away from Mysore Railway Station.</em></p>\r\n\r\n<p><strong>Room Amenities:&nbsp;</strong><em>Guests can choose from a total of 108 rooms that are categorised into Standard, Fortune Club rooms and Suites. The hotel also has an accessible room. Most of the rooms have an impeccable view of the Chamundi Hills and come equipped with all modern amenities. Amenities include a flat-screen TV, high-speed internet connectivity, mini-bar, electronic safe, tea/coffee maker and iron/ironing board.</em></p>\r\n\r\n<p><strong>Hotel Facilities:&nbsp;</strong><em>With laundry service and 24-hour room service, guests never have to worry about any of their daily chores during their stay. The Tulip Spa is renowned for the rejuvenating experience it offers with an array of holistic and Ayurvedic programmes to choose from. Other facilities include a swimming pool, steam room and fitness centre.</em></p>\r\n\r\n<p><strong>Dining:&nbsp;</strong><em>Orchid is the 24-hour restaurant that offers an array of culinary delight and sumptuous buffets, ideal for a luncheon meeting or a relaxed dinner. The Oriental Pavilion is open only for dinner and serves authentic Oriental cuisine in a modern, contemporary setting. Neptune Bar &amp; Lounge is the perfect place to relax and unwind after a tiring day, with an excellent selection of spirits and wines. The Terrace Grill &amp; Tandoor offers a mesmerizing view of the Chamundi Hills, combined with diffused lighting and lounge music.</em></p>\r\n\r\n<ul>\r\n\t<li><em>FREE Breakfast</em></li>\r\n\t<li><em>Two bottles of mineral water on daily basis in the room</em></li>\r\n\t<li><em>Fruit Basket &amp; Cookies</em></li>\r\n\t<li><em>10% Discount on F&amp;b &amp; Laundry</em></li>\r\n\t<li><em>Accommodation</em></li>\r\n</ul>",
      "valid_to": "Mar-20-2019",
      "price": 4999,
      "discount": "10% OFF",
      "discounted_price": 4500,
      "offer_images": [
      {
      "id": 23,
      "banner_image_url": "http://127.0.0.1:1234/storage/offer_images/teiCziEAsMEw5504WytwxptrVnZx62mBAsCxf8sg.jpeg",
      "offer_id": 9
      },
      {
      "id": 24,
      "banner_image_url": "http://127.0.0.1:1234/storage/offer_images/6wBQmgwEgwmEqQfkCEjZ02eag9wmrr8G4aICPERP.jpeg",
      "offer_id": 9
      }
      ]
      }
      ]
      }
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
            if ($request->resort_id == -1) {
                $resortId = 0;
                $defaultResort = Resort::where("is_default", 1)->first();
                if ($defaultResort) {
                    $resortId = $defaultResort->id;
                } else {
                    $defaultResort = Resort::query()->first();
                    $resortId = $defaultResort->id;
                }

                $offers = offer::where(["is_active" => 1, "resort_id" => $resortId])->with([
                            'offerImages' => function($query) {
                                $query->select('id', 'image_name as banner_image_url', 'offer_id');
                            }
                        ])->latest()->get();
            } else {
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
                    if (count($offer->offerImages) > 0) {
                        $dataArray[$key]['offer_images'] = $offer->offerImages;
                    } else {
                        $dataArray[$key]['offer_images'][0] = [
                            'id' => 0,
                            'banner_image_url' => asset('img/image_loader.png')
                        ];
                    }
                }

                return $this->sendSuccessResponse("offers found", $dataArray);
            } else {
                return $this->sendErrorResponse("offers not found", []);
            }
        } catch (\Exception $e) {
            return $this->administratorResponse();
        }
    }

}

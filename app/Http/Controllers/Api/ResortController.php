<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\ResortImage;
use App\Models\ResortRoom;
use App\Models\RoomType;
use App\Models\RoomtypeImage;

class ResortController extends Controller {

    /**
     * @api {get} /api/resort-detail Resort detail
     * @apiHeader {String} Accept application/json. 
     * @apiName GetResortDetail
     * @apiGroup Resort
     * 
     * @apiParam {String} resort_id Resort id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Resort found.
     * @apiSuccess {JSON}   data Json data.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "Resort found.",
      "data": {
      "resort": {
      "id": 2,
      "amenities": "1#2#3#4#5#6#7#8#10",
      "other_amenities": "Other Amenity",
      "name": "Dintex",
      "description": "<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>",
      "address": "U-701",
      "latitude": 28.5355,
      "longitude": 77.391,
      "room_types": [
      {
      "id": 1,
      "name": "Tent",
      "icon": "http://127.0.0.1:1234/storage/room_icon/jIkGVEx07jhjpJeVw6x1Un5cwrYBiuNC8pkpzD6i.png",
      "description": "<p>A modern two person, lightweight hiking dome tent; it is tied to rocks as there is nowhere to drive stakes on this rock shelf</p>\r\n\r\n<p>A&nbsp;<strong>tent</strong>&nbsp;(/tɛnt/) is a&nbsp;shelter&nbsp;consisting of sheets of&nbsp;fabric&nbsp;or other material draped over, attached to a frame of poles or attached to a supporting rope. While smaller tents may be free-standing or attached to the ground, large tents are usually anchored using&nbsp;guy ropes&nbsp;tied to stakes or&nbsp;tent pegs. First used as portable homes by&nbsp;nomads, tents are now more often used for recreational&nbsp;camping&nbsp;and as temporary shelters.</p>\r\n\r\n<p>They were also used by&nbsp;Native American&nbsp;and&nbsp;Canadian aboriginal&nbsp;tribes of the&nbsp;Plains Indians, called a teepee or&nbsp;tipi, noted for its cone shape and peak&nbsp;smoke-hole, since ancient times, variously estimated from 10,000 years BCE<sup>[1]</sup>&nbsp;to 4,000 BCE.<sup>[2]</sup></p>\r\n\r\n<p>Tents range in size from &quot;bivouac&quot; structures, just big enough for one person to sleep in, up to huge&nbsp;circus tents&nbsp;capable of seating thousands of people. The bulk of this article is concerned with tents used for recreational camping which have sleeping space for one to ten people. Larger tents are discussed in a separate section below.</p>\r\n\r\n<p>Tents for recreational camping fall into two categories. Tents intended to be carried by backpackers are the smallest and lightest type. Small tents may be sufficiently light that they can be carried for long distances on a&nbsp;touring bicycle, a&nbsp;boat, or when&nbsp;backpacking.</p>\r\n\r\n<p>The second type are larger, heavier tents which are usually carried in a car or other vehicle. Depending on tent size and the experience of the person or people involved, such tents can usually be assembled (pitched) in between 5 and 25 minutes; disassembly (striking) takes a similar length of time. Some very specialised tents have spring-loaded poles and can be &#39;pitched&#39; in seconds, but take somewhat longer to &#39;strike&#39; (take down and pack).</p>",
      "room_images": [
      {
      "id": 15,
      "banner_image_url": "http://127.0.0.1:1234/storage/room_images/n1nqaIsGBJ6Gy1vA25y5uR3WisGNd1mPpmf7zqFE.jpeg"
      },
      {
      "id": 16,
      "banner_image_url": "http://127.0.0.1:1234/storage/room_images/5vX4d5MPS7DPWv2dqfffDeCVqhJqQOLYS2rNf3PV.jpeg"
      },
      {
      "id": 17,
      "banner_image_url": "http://127.0.0.1:1234/storage/room_images/QeW6Q1awh2HiHI88QbnGHV4oXA2Mq5IVk6E681xE.jpeg"
      }
      ]
      },
      {
      "id": 4,
      "name": "Villa",
      "icon": "http://127.0.0.1:1234/storage/room_icon/NhK1cwngieiju9smBG58SqQgJGE7gQfaymDMGTMu.png",
      "description": "<p><strong>Villa </strong>is a house of 240 square meters (2583 sq.ft) that sits on a property of 10,000 square meters (108,000 sq.ft).</p>\r\n\r\n<p>It has several balconies and terraces; and is suitable for a&nbsp;<strong>maximum of ten people (8+2).</strong></p>\r\n\r\n<p>The Villa<strong>&nbsp;has two floors</strong>, with<strong>&nbsp;four bedrooms</strong>&nbsp;(2 master suites and 2 guest rooms) and four bathrooms, as well as a 4000 square meter (43,000 sq. ft) garden. Exotic Ip&eacute; hardwood flooring is laid throughout the house.</p>\r\n\r\n<p>The Villa is set behind an automatic wide gate with plenty of covered parking spaces.&nbsp; From the parking area, the house can be easily accessed (just one step) for all types of guests.</p>\r\n\r\n<p>Villa Miragalli is fully furnished with&nbsp;<strong>personalized A/C</strong>&nbsp;and heating throughout the entire house and bedrooms, as well as a&nbsp;<strong>hot tub</strong>&nbsp;(which can be enjoyed all year), an&nbsp;<strong>infinity and heated swimming pool,</strong>&nbsp;outdoor kitchen, gazebo, barbecue, hammock,&nbsp;<strong>Sky TV</strong>, Playstation 3, home theater system, iPod station, Bose sound system, alarm,<strong>&nbsp;free fast Wi-Fi</strong>&nbsp;(bring your laptop or smartphone), and all the comforts you need to make this your home away from home.</p>\r\n\r\n<p><strong><em>Top Floor</em></strong></p>\r\n\r\n<p><strong>Living Area</strong></p>\r\n\r\n<p>The main entrance places you on the top floor, where you enter into the spacious living area (60 square meters; 645 sq. ft).&nbsp; In this living room, you and your loved ones can sink into the three comfortable sofas, where you will enjoy the warmth of the beautiful fireplace.&nbsp; One of these sofas converts into a double bed.&nbsp; You can also choose from hundreds of international channels on Sky TV or&nbsp;<strong>play PlayStation 3 on the 47&rdquo; Smart TV.</strong></p>\r\n\r\n<p><strong>Kitchen</strong></p>\r\n\r\n<p>The large and beautiful kitchen (30 square meters; 323 sq. ft) can also be accessed from the patio.&nbsp;<strong>&nbsp;It is fully equipped</strong>&nbsp;with refrigerator/freezer, six-ring gas stove, dishwasher, wine refrigerator, pots and pans, plates and silverware, American coffee maker,ice maker, Espresso coffee maker,Moka coffee maker, toaster, blender, ice machine and microwave.&nbsp; The kitchen is also linked to the dining area, which is&nbsp; furnished with a spectacularly large round table, made of lava stone and a bench built into a stone wall. Throughout the house, you can enjoy the beautiful seascape view.</p>",
      "room_images": [
      {
      "id": 13,
      "banner_image_url": "http://127.0.0.1:1234/storage/room_images/UQktkirCPW3wqypGTOwxs4fHNd1bN5RCq2T2axKV.jpeg"
      }
      ]
      },
      {
      "id": 2,
      "name": "Cottage",
      "icon": "http://127.0.0.1:1234/storage/room_icon/nwTzl8N78rgaO01KkJGwUjYesgMeyp2uSKaBCGJC.png",
      "description": "<p>A&nbsp;<strong>cottage</strong>&nbsp;is, typically, a small house. It may carry the connotation of being an old or old-fashioned building. In modern usage, a cottage is usually a modest, often cosy dwelling, typically in a&nbsp;rural&nbsp;or semi-rural location.</p>\r\n\r\n<p>The word comes from the&nbsp;architecture of England, where it originally referred to a house with ground floor living space and an upper floor of one or more bedrooms fitting under the eaves. In&nbsp;British English&nbsp;the term now denotes a small dwelling of traditional build, although it can also be applied to modern construction designed to resemble traditional houses (&quot;mockcottages&quot;). Cottages may be detached houses, or&nbsp;terraced, such as those built to house workers in mining villages. The&nbsp;tied accommodation&nbsp;provided to farm workers was usually a cottage, see&nbsp;cottage garden. Peasant farmers were once known as&nbsp;cotters.</p>\r\n\r\n<p>The&nbsp;holiday cottage&nbsp;exists in many cultures under different names. In&nbsp;American English, &quot;cottage&quot; is one term for such holiday homes, although they may also be called a &quot;cabin&quot;, &quot;chalet&quot;, or even &quot;camp&quot;. In certain countries (e.g.&nbsp;Scandinavia,&nbsp;Baltics, and&nbsp;Russia) the term &quot;cottage&quot; has local synonyms: In Finnish&nbsp;<em>m&ouml;kki</em>, in Estonian&nbsp;<em>suvila</em>, in Swedish&nbsp;<em>stuga</em>, in Norwegian&nbsp;<em>hytte</em>&nbsp;(from the German word&nbsp;<em>H&uuml;tte</em>), in Slovak&nbsp;<em>chalupa</em>, in Russian&nbsp;<em>дача</em>&nbsp;(<em>dacha</em>, which can refer to a vacation/summer home, often located near a body of water).</p>\r\n\r\n<p>There are cottage-style dwellings in American cities that were built primarily for the purpose of housing slaves.</p>\r\n\r\n<p>In places such as Canada, &quot;cottage&quot; carries no connotations of size (compare with&nbsp;vicarage&nbsp;or&nbsp;hermitage).</p>",
      "room_images": [
      {
      "id": 14,
      "banner_image_url": "http://127.0.0.1:1234/storage/room_images/NILsFkRMjeOC8Tgh1TWklF1MQmkMHx8PqTtaT5X0.jpeg"
      }
      ]
      }
      ],
      "resort_images": [
      {
      "id": 137,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/DynGNPt3xDthCm4XQVBrS87yLxTDfQGmkH7ajXYa.jpeg",
      "resort_id": 2
      },
      {
      "id": 136,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/u4jxf7wGLFDUbvCMMhxmIG8eGO3EVyco04bzJgvL.jpeg",
      "resort_id": 2
      },
      {
      "id": 84,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/qp51L9T46MSA3sAjFSULwtH4dhgBuaUal2G2fm4z.jpeg",
      "resort_id": 2
      },
      {
      "id": 117,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/uQ5JQpmF8yfyKZngz9DjGjIauHPlzH5qGmREUCTc.jpeg",
      "resort_id": 2
      }
      ],
      "resort_amenities": [
      {
      "id": 1,
      "resort_id": 2,
      "name": "Gym",
      "icon": null
      },
      {
      "id": 2,
      "resort_id": 2,
      "name": "SPA",
      "icon": null
      },
      {
      "id": 14,
      "resort_id": 2,
      "name": "Cricket",
      "icon": null
      },
      {
      "id": 15,
      "resort_id": 2,
      "name": "Movie Library",
      "icon": null
      }
      ],
      "resort_near_by_places": [
      {
      "id": 7,
      "name": "Tibetan Buddhist Temple",
      "distance_from_resort": 28,
      "resort_id": 2
      },
      {
      "id": 8,
      "name": "Forest Research Institute",
      "distance_from_resort": 15,
      "resort_id": 2
      }
      ]
      },
      "resort_amenities": [
      {
      "amenity_id": "1"
      },
      {
      "amenity_id": "2"
      },
      {
      "amenity_id": "3"
      },
      {
      "amenity_id": "4"
      },
      {
      "amenity_id": "5"
      },
      {
      "amenity_id": "6"
      },
      {
      "amenity_id": "7"
      },
      {
      "amenity_id": "8"
      },
      {
      "amenity_id": "10"
      }
      ],
      "resort_other_amenities": [
      {
      "name": "Other Amenity"
      }
      ]
      }
      }
     * 
     * 
     * @apiError ResortIdMissing The resort id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Resort id missing.",
     *  "data": {}
     * }
     * 
     * 
     */
    public function resortDetail(Request $request) {
        try {
            if (!$request->resort_id) {
                return $this->sendErrorResponse("Resort id missing.", (object) []);
            }

            $resort = Resort::selectRaw('id, amenities, other_amenities, name, description, address_1 as address, ROUND(latitude,2) as latitude, ROUND(longitude,2) as longitude')->where(["id" => $request->resort_id, "is_active" => 1])->with([
                        'resortImages' => function($query) {
                            $query->select('id', 'image_name as banner_image_url', 'resort_id');
                        }
                    ])->with([
                        'resortAmenities' => function($query) {
                            $query->select('id', 'resort_id', 'name');
                        }
                    ])->with([
                        'resortNearByPlaces' => function($query) {
                            $query->select('id', 'name', 'distance_from_resort', 'resort_id');
                        }
                    ])->first();

            if ($resort) {

                $resortRoomTypes = ResortRoom::select('room_type_id')->where("resort_id", $resort->id)->distinct()->get();
                $resortRoomArray = [];
                if ($resortRoomTypes) {
                    $d = 0;
                    foreach ($resortRoomTypes as $key => $resortRoomType) {
                        $roomType = RoomType::find($resortRoomType->room_type_id);
                        if ($roomType) {
                            $resortRoomArray[$d]['id'] = $roomType ? $roomType->id : 0;
                            $resortRoomArray[$d]['name'] = $roomType ? $roomType->name : '';
                            $resortRoomArray[$d]['icon'] = $roomType ? $roomType->icon : '';
                            $resortRoomArray[$d]['description'] = $roomType ? $roomType->description : '';
                            $roomImages = RoomtypeImage::select('id', 'image_name as banner_image_url')->where("roomtype_id", $resortRoomType->room_type_id)->get();
                            if ($roomImages) {
                                $resortRoomArray[$d]['room_images'] = $roomImages;
                            } else {
                                $resortRoomArray[$d]['room_images'] [0] = [
                                    'id' => 0,
                                    'banner_image_url' => asset('img/image_loader.png')
                                ];
                            }
                            $d++;
                        }
                    }
                }

                $resortAmenitiesArray = [];
                if ($resort->amenities) {
                    foreach (explode("#", $resort->amenities) as $k => $amenity_id) {
                        $resortAmenitiesArray[$k]['amenity_id'] = $amenity_id;
                    }
                }

                $resortOtherAmenitiesArray = [];
                if ($resort->other_amenities) {
                    foreach (explode("#", $resort->other_amenities) as $j => $amenity_name) {
                        $resortOtherAmenitiesArray[$j]['name'] = $amenity_name;
                    }
                }


                $data['resort'] = $resort->toArray();
                if (count($resort->resortImages) == 0) {
                    $data['resort']['resort_images'][0] = [
                        'id' => 0,
                        'banner_image_url' => asset('img/image_loader.png')
                    ];
                }
                $data['resort_amenities'] = $resortAmenitiesArray;
                $data['resort_other_amenities'] = $resortOtherAmenitiesArray;
                $data['resort']['room_types'] = $resortRoomArray;

                return $this->sendSuccessResponse("Resort found.", $data);
            } else {

                return $this->sendErrorResponse("Resort not found.", (object) []);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->administratorResponse();
        }
    }

    /**
     * @api {get} /api/resort-listing Resort listing
     * @apiHeader {String} Accept application/json. 
     * @apiName GetResortListing
     * @apiGroup Resort
     * 
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Resorts found.
     * @apiSuccess {JSON}   data Json data.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "resorts found",
      "data": [
      {
      "id": 1,
      "name": "Sanjeevani Resorts & Tents",
      "description": "<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\r\n\r\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\r\n\r\n<p>Sanjeevani&rsquo;s 12 months Free from Life Style Disease Package</p>\r\n\r\n<p><br />\r\nBecome a member and be free from Life style Disease such as Diabetes<br />\r\nMembers are required to attend Seven days residential retreat at Sanjeevani, Dehradun to kick start your reverse diabetes therapy. During your stay you will be provided Diabetes Tests, Yoga, Meditation, Vegan Diet, Massage Therapy, Trekking and Training.<br />\r\nIn addition, you will be provided with a free Glucometer with 25 strips for self check on fortnight basis and to update our Relationship Manager allotted to you by us.&nbsp;<br />\r\nDaily Routine Call/SMS/App alerts from Sanjeevani<br />\r\n&bull; Wake-Up<br />\r\n&bull; Yoga/Walk<br />\r\n&bull; Breakfast<br />\r\n&bull; Lunch<br />\r\n&bull; Snacks<br />\r\n&bull; Dinner<br />\r\nWeekly Call from Dietician/Doctor/Therapist<br />\r\nConsultation call (time for each individual will be given separately)</p>\r\n\r\n<p><br />\r\n<strong>Free Tests:</strong><br />\r\nHba1c, Vitamin-B12 and Vitamin-D test every quarter and C-peptide test after 12 months program&nbsp;</p>\r\n\r\n<p><br />\r\n<strong>Progress Report</strong><br />\r\nYou will be updated for your progress report timely &amp; Your Medical history will be maintained by us that you can access online anytime.</p>\r\n\r\n<p><br />\r\n<strong>Note:</strong><br />\r\nConsultation with our experts is available anytime between between 10 AM and 6 PM. This is a 1 year membership program for limited people, specially who are suffering from Life style diseases such as Diabetes, Thyroid, Heart, Kidney, Arthritis, ED-PE, etc</p>",
      "address": "Horawala, Dehradun UttraKhand India",
      "resort_images": [
      {
      "id": 25,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/ymENq0tEvnDgPRdAV3Y7mQaKvhX06Uj8jpJbuvdv.jpeg",
      "resort_id": 1
      },
      {
      "id": 24,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/pzRNJJ2T2EPe39rN9ax7VZf4GxM8UqBurIzKnl37.jpeg",
      "resort_id": 1
      },
      {
      "id": 23,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/YmCu1wPzsAD8lfyBwagZOJH8i5klDdZ8vrM20kg3.jpeg",
      "resort_id": 1
      }
      ]
      },
      {
      "id": 2,
      "name": "Dintex",
      "description": "<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>",
      "address": "U-701",
      "resort_images": [
      {
      "id": 137,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/DynGNPt3xDthCm4XQVBrS87yLxTDfQGmkH7ajXYa.jpeg",
      "resort_id": 2
      },
      {
      "id": 136,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/u4jxf7wGLFDUbvCMMhxmIG8eGO3EVyco04bzJgvL.jpeg",
      "resort_id": 2
      },
      {
      "id": 84,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/qp51L9T46MSA3sAjFSULwtH4dhgBuaUal2G2fm4z.jpeg",
      "resort_id": 2
      },
      {
      "id": 117,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/uQ5JQpmF8yfyKZngz9DjGjIauHPlzH5qGmREUCTc.jpeg",
      "resort_id": 2
      }
      ]
      },
      {
      "id": 3,
      "name": "Shaheen Bagh (a boutique resort & spa)",
      "description": "<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>",
      "address": "Shigally School Road Jamniwala, Guniyal Gaon",
      "resort_images": [
      {
      "id": 53,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/73OZaSDAUmTeWKVG5XvSIw38d7wkkAkyITdvvNFd.jpeg",
      "resort_id": 3
      },
      {
      "id": 52,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/51YWRpbZnDThLJfEiMZriEwz4m3ycxao2JL5X5vN.png",
      "resort_id": 3
      }
      ]
      },
      {
      "id": 4,
      "name": "Shinura Nature Retreat",
      "description": "<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>",
      "address": "Abhimanyu Cricket Academy, Jamniwala Hills Near Guniya Near, Dehradun,",
      "resort_images": [
      {
      "id": 130,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/9C2PRgGBq2gHNTFZctD6J9jiyrXX4sJMwXskKC9U.jpeg",
      "resort_id": 4
      },
      {
      "id": 128,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/k6hAqSMZKULtsGfk5VFssrljKVKMGIHGzZzFkODE.jpeg",
      "resort_id": 4
      },
      {
      "id": 125,
      "banner_image_url": "http://127.0.0.1:1234/storage/resort_images/wvIzJp6lXAGAeQAEV7Tx2AcH7ChwdHgF1fTcLe3R.jpeg",
      "resort_id": 4
      }
      ]
      }
      ]
      }
     * 
     * 
     * 
     */
    public function resortListing(Request $request) {
        try {

            $resorts = Resort::select('id', 'name', 'description', 'address_1 as address')->where(["is_active" => 1])->with([
                        'resortImages' => function($query) {
                            $query->select('id', 'image_name as banner_image_url', 'resort_id');
                        }
                    ])->get();
            if ($resorts) {
                $resortArray = [];
                $resorts = $resorts->toArray();
                foreach ($resorts as $k => $resort) {
                    $resortArray[$k] = $resort;
                    if (count($resort['resort_images']) <= 0) {
                        $resortArray[$k]['resort_images'][0] = [
                            'id' => 0,
                            'banner_image_url' => asset('img/image_loader.png')
                        ];
                    }
                }
                return $this->sendSuccessResponse("resorts found", $resortArray);
            } else {
                return $this->sendSuccessResponse("resorts not found", $resorts);
            }
        } catch (Exception $ex) {
            return $this->administratorResponse();
        }
    }

}

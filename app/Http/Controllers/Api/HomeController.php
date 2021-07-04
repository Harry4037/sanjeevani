<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Banner;
use App\Models\UserBookingDetail;
use App\Models\Resort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ResortNearbyPlace;
use App\Models\offer;
use Carbon\Carbon;
use App\Models\HealthcateProgram;
use App\Models\NearbyPlaceImage;
use App\Models\HealthcateProgramDay;
use App\Models\Notification;
use App\Models\Cart;

class HomeController extends Controller {

    /**
     * @api {get} /api/home Home
     * @apiHeader {String} Accept application/json. 
     * @apiName PostHome
     * @apiGroup Home
     * 
     * @apiParam {String} user_id User id.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message service successfully access.
     * @apiSuccess {JSON}   data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "service successfully access.",
      "data": {
      "user": {
      "id": 149,
      "user_name": "Om",
      "mobile_number": "8077575835",
      "email_id": "om@mail.com",
      "voter_id": "http://127.0.0.1:1234/img/no-image.jpg",
      "aadhar_id": null,
      "address1": "",
      "city_id": 0,
      "user_type_id": 3,
      "no_of_rooms": "1",
      "notification_count": 0,
      "cart_count": 0,
      "user_health_detail": null,
      "user_booking_detail": {
      "id": 43,
      "room_type_id": 1,
      "check_in_pin": 7015,
      "check_out_pin": 3336,
      "resort_room_id": 338,
      "user_id": 149,
      "booking_id": "GOIBO123456",
      "source_name": "GOIBO",
      "resort_id": 2,
      "package_id": 6,
      "check_in": "04-Mar-2019",
      "check_in_time": "12:00:00 AM",
      "check_out": "30-Mar-2019",
      "check_out_time": "10:00:00 AM",
      "resort": {
      "id": 2,
      "name": "Dintex",
      "description": "<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>",
      "contact_number": "8588936238",
      "address_1": "U-701"
      },
      "bookingpeople_accompany": [
      {
      "id": 23,
      "person_name": "Ankit",
      "person_age": "10",
      "person_type": "Child"
      },
      {
      "id": 24,
      "person_name": "Anshu",
      "person_age": "25",
      "person_type": "Adult"
      }
      ],
      "room_type_detail": {
      "id": 1,
      "name": "Tent",
      "description": "<p>A modern two person, lightweight hiking dome tent; it is tied to rocks as there is nowhere to drive stakes on this rock shelf</p>\r\n\r\n<p>A&nbsp;<strong>tent</strong>&nbsp;(/tɛnt/) is a&nbsp;shelter&nbsp;consisting of sheets of&nbsp;fabric&nbsp;or other material draped over, attached to a frame of poles or attached to a supporting rope. While smaller tents may be free-standing or attached to the ground, large tents are usually anchored using&nbsp;guy ropes&nbsp;tied to stakes or&nbsp;tent pegs. First used as portable homes by&nbsp;nomads, tents are now more often used for recreational&nbsp;camping&nbsp;and as temporary shelters.</p>\r\n\r\n<p>They were also used by&nbsp;Native American&nbsp;and&nbsp;Canadian aboriginal&nbsp;tribes of the&nbsp;Plains Indians, called a teepee or&nbsp;tipi, noted for its cone shape and peak&nbsp;smoke-hole, since ancient times, variously estimated from 10,000 years BCE<sup>[1]</sup>&nbsp;to 4,000 BCE.<sup>[2]</sup></p>\r\n\r\n<p>Tents range in size from &quot;bivouac&quot; structures, just big enough for one person to sleep in, up to huge&nbsp;circus tents&nbsp;capable of seating thousands of people. The bulk of this article is concerned with tents used for recreational camping which have sleeping space for one to ten people. Larger tents are discussed in a separate section below.</p>\r\n\r\n<p>Tents for recreational camping fall into two categories. Tents intended to be carried by backpackers are the smallest and lightest type. Small tents may be sufficiently light that they can be carried for long distances on a&nbsp;touring bicycle, a&nbsp;boat, or when&nbsp;backpacking.</p>\r\n\r\n<p>The second type are larger, heavier tents which are usually carried in a car or other vehicle. Depending on tent size and the experience of the person or people involved, such tents can usually be assembled (pitched) in between 5 and 25 minutes; disassembly (striking) takes a similar length of time. Some very specialised tents have spring-loaded poles and can be &#39;pitched&#39; in seconds, but take somewhat longer to &#39;strike&#39; (take down and pack).</p>",
      "icon": "http://127.0.0.1:1234/storage/room_icon/jIkGVEx07jhjpJeVw6x1Un5cwrYBiuNC8pkpzD6i.png"
      },
      "room_detail": {
      "id": 338,
      "resort_id": 2,
      "room_type_id": 1,
      "room_no": "T-2"
      }
      }
      },
      "banners": [
      {
      "id": 7,
      "banner_image_url": "http://127.0.0.1:1234/storage/banner_images/NtMHzZqOd4usHJ6cf7VY6meo5HbZ8iW8xHPCDoY5.jpeg"
      },
      {
      "id": 10,
      "banner_image_url": "http://127.0.0.1:1234/storage/banner_images/3VMDIqLhAeZ49ZFPtsx88cS0roApDtILPaTYH9h3.jpeg"
      },
      {
      "id": 11,
      "banner_image_url": "http://127.0.0.1:1234/storage/banner_images/DKUj5zAQMLw37kOCbB9cdd46zYZcL0qwtO3S8K8d.jpeg"
      },
      {
      "id": 12,
      "banner_image_url": "http://127.0.0.1:1234/storage/banner_images/zZmNNMb1940r8ydLxRX6VESxebUI2LbFvDqAlOhP.jpeg"
      },
      {
      "id": 14,
      "banner_image_url": "http://127.0.0.1:1234/storage/banner_images/u8VvcCIk1tdx3F917f1DxrAoUR47cGecol1J8Bjs.jpeg"
      },
      {
      "id": 15,
      "banner_image_url": "http://127.0.0.1:1234/storage/banner_images/sRYRByOcSH2B57cqf7HBcjnK3dgK5GRaPxdcVGxq.jpeg"
      },
      {
      "id": 16,
      "banner_image_url": "http://127.0.0.1:1234/storage/banner_images/qPnHOwfPO2Se58VpDXPubbV8ZPGsdu1St9aRzBH1.jpeg"
      },
      {
      "id": 17,
      "banner_image_url": "http://127.0.0.1:1234/storage/banner_images/Ue9UTJXpjJqzWuMSNkAyqopUxiBCCwzWy20XMknk.jpeg"
      },
      {
      "id": 18,
      "banner_image_url": "http://127.0.0.1:1234/storage/banner_images/Zul3MqJIS4VetnRo986mSjrAfNA6GNxXzNrAPjXo.jpeg"
      },
      {
      "id": 21,
      "banner_image_url": "http://127.0.0.1:1234/storage/banner_images/LOWd8xqvSYryFAhiRHCXoXEHU9dU0zeCCAVxb8Je.jpeg"
      }
      ],
      "nearby_attaractions": [
      {
      "id": 8,
      "name": "Forest Research Institute",
      "description": "<p>For a bargain entrance fee you get to enjoy the architecture and grounds, several brilliantly old-fashioned museums, and the botanical gardens (though the latter need quite a bit of attention). We wandered into the paper-making office and got a free guided tour of a disused mill by a Dr Gupta and his staff which was fantastic. One of the best afternoons we had in Dehradun and a complete accident! This place is definitely worth a visit.</p>",
      "distance": 15,
      "precautions": "<p>One of the Iconic places in India and especially in Dehradun. Student of the Year has been shot here, and after that, this place has become one of the most visited places in the town.</p>",
      "address": "Mason Rd | Indian Military Academy, Dehradun - 248001",
      "latitude": 25.22222,
      "longitude": 36.55555,
      "images": [
      {
      "id": 16,
      "banner_image_url": "http://127.0.0.1:1234/storage/nearby_images/KZMoKARmBBYICyyQjwkzbApwdS4KtA8cSMWE9XAL.jpeg"
      },
      {
      "id": 20,
      "banner_image_url": "http://127.0.0.1:1234/storage/nearby_images/qiSrpffmBDT8DO3ZqE8xeoswKqFJ7kwsesqoyzoJ.jpeg"
      }
      ]
      },
      {
      "id": 7,
      "name": "Tibetan Buddhist Temple",
      "description": "<p>Buddha Temple is a Tibetan monestary, also called as Mindrolling Monastery and was build in 1965 by his eminence the Kochen Rinpoche and few other monks for the promotion and protection of religious &amp;amp; cultural understanding of Buddhism. Built in Japanese architecture style, Buddha Temple complex atmosphere provides a mental peace equal to Buddhist monk. Buddha temple complex was created as one of the four schools of Tibetan religion. This temple complex is known as &#39;Nyigma&#39; while other schools known as Sakya, Kagyu and Geluk respectively.</p>",
      "distance": 28,
      "precautions": "<p>Temple garden and shops are open for all seven days for but temple remains open for Sunday only for public.Visitors are requested to remove shoes before entering the main hall of Buddha temple.</p>",
      "address": "New Basti, Clement Town Uttrakhand Dehradun-248197",
      "latitude": 30.3231,
      "longitude": 78.0473,
      "images": [
      {
      "id": 14,
      "banner_image_url": "http://127.0.0.1:1234/storage/nearby_images/PeIZtPLOGu0nCi4WCW7nRPUT6o5sMxfjfwnz4V13.jpeg"
      }
      ]
      }
      ],
      "best_offers": [
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
      }
      ],
      "health_care": [
      {
      "id": 14,
      "name": "Holiday Package",
      "description": "<p>2Night and 3 Day</p>",
      "start_from": "15-02-2019",
      "end_to": "31-05-2019",
      "total_days": 3,
      "healthcare_images": [
      {
      "id": 49,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/FJ6ZhivkTUozs9FANVwNYQZHlLkXlWd8n5L8v35J.jpeg",
      "health_program_id": 14
      },
      {
      "id": 50,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/FeYWXm2Hho1m5l3fWtNWTfVE02KM4k8r3hfO3QYS.jpeg",
      "health_program_id": 14
      }
      ],
      "healthcare_days": [
      {
      "id": 440,
      "day": "1",
      "description": "<p>1</p>",
      "health_program_id": 14
      },
      {
      "id": 441,
      "day": "2",
      "description": "<p><br />\r\n2</p>",
      "health_program_id": 14
      },
      {
      "id": 442,
      "day": "3",
      "description": "<p>3</p>",
      "health_program_id": 14
      }
      ]
      },
      {
      "id": 11,
      "name": "Healthcare Package Reverse Diabetes in 3 Days",
      "description": "<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>",
      "start_from": "14-02-2019",
      "end_to": "09-03-2019",
      "total_days": 3,
      "healthcare_images": [
      {
      "id": 31,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/HUjdVCzjj1A51ak7ipjUg9oKWcKQs4dyAtOaOJpT.jpeg",
      "health_program_id": 11
      },
      {
      "id": 32,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/VcE35u8GzY1FSprjK8aQBP3DSIG5fZoLOa8XYRSy.jpeg",
      "health_program_id": 11
      }
      ],
      "healthcare_days": [
      {
      "id": 418,
      "day": "3",
      "description": "<p><strong>05:00 AM : </strong>Wake Up</p>\r\n\r\n<hr />\r\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\r\n\r\n<hr />\r\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\r\n\r\n<hr />\r\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\r\n\r\n<hr />\r\n<p><strong>07:00 AM :</strong> Coconut Water</p>\r\n\r\n<hr />\r\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\r\n\r\n<hr />\r\n<p><strong>09:00 AM :</strong> Meditation/Massage</p>\r\n\r\n<hr />\r\n<p><strong>12:00 AM :</strong> Lunch</p>\r\n\r\n<hr />\r\n<p><strong>12:30 PM : </strong>Walk</p>\r\n\r\n<hr />\r\n<p><strong>03:00 PM :</strong> Banana/Cashew/Almond Shake</p>\r\n\r\n<hr />\r\n<p><strong>03:30 PM :</strong> Consultancy</p>\r\n\r\n<hr />\r\n<p><strong>04:00 PM :</strong> Routine Check-up</p>\r\n\r\n<hr />\r\n<p><strong>06:00 PM :</strong> Dinner</p>\r\n\r\n<hr />\r\n<p><strong>07:00 PM :</strong> Spritual Classes</p>\r\n\r\n<hr />\r\n<p><strong>08:00 PM :</strong> Bed Time</p>",
      "health_program_id": 11
      },
      {
      "id": 416,
      "day": "1",
      "description": "<p><strong>05:00 AM : </strong>Wake Up</p>\r\n\r\n<hr />\r\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\r\n\r\n<hr />\r\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\r\n\r\n<hr />\r\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\r\n\r\n<hr />\r\n<p><strong>07:00 AM :</strong> Coconut Water</p>\r\n\r\n<hr />\r\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\r\n\r\n<hr />",
      "health_program_id": 11
      },
      {
      "id": 417,
      "day": "2",
      "description": "<p><strong>05:00 AM : </strong>Wake Up</p>\r\n\r\n<hr />\r\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\r\n\r\n<hr />\r\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\r\n\r\n<hr />\r\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\r\n\r\n<hr />\r\n<p><strong>07:00 AM :</strong> Coconut Water</p>\r\n\r\n<hr />\r\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\r\n\r\n<hr />\r\n<p><strong>09:00 AM :</strong> Meditation/Massage</p>\r\n\r\n<hr />\r\n<p><strong>12:00 AM :</strong> Lunch</p>\r\n\r\n<hr />\r\n<p><strong>12:30 PM : </strong>Walk</p>\r\n\r\n<hr />\r\n<p><strong>03:00 PM :</strong> Banana/Cashew/Almond Shake</p>\r\n\r\n<hr />\r\n<p><strong>03:30 PM :</strong> Consultancy</p>\r\n\r\n<hr />\r\n<p><strong>04:00 PM :</strong> Routine Check-up</p>\r\n\r\n<hr />\r\n<p><strong>06:00 PM :</strong> Dinner</p>\r\n\r\n<hr />\r\n<p><strong>07:00 PM :</strong> Spritual Classes</p>\r\n\r\n<hr />\r\n<p><strong>08:00 PM :</strong> Bed Time</p>",
      "health_program_id": 11
      }
      ]
      },
      {
      "id": 9,
      "name": "Healthcare Package Reverse Diabetes in 7 Days",
      "description": "<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>",
      "start_from": "24-01-2019",
      "end_to": "28-02-2019",
      "total_days": 7,
      "healthcare_images": [
      {
      "id": 25,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/1Gtjax1vMjsVrOguQE1APXC0Jl32ZyKxJ6Lku0j6.jpeg",
      "health_program_id": 9
      },
      {
      "id": 26,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/gNHZv5TbtoCja85UCT2DRUMWTQTIFmISfjfQUky3.jpeg",
      "health_program_id": 9
      },
      {
      "id": 27,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/CcfvNS5TnJmvp278HJPrX3RyN5Sc7Upr4cVKWP48.png",
      "health_program_id": 9
      }
      ],
      "healthcare_days": [
      {
      "id": 346,
      "day": "1",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 9
      },
      {
      "id": 347,
      "day": "2",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 9
      },
      {
      "id": 348,
      "day": "3",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 9
      },
      {
      "id": 349,
      "day": "4",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 9
      },
      {
      "id": 350,
      "day": "5",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 9
      },
      {
      "id": 351,
      "day": "6",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 9
      },
      {
      "id": 352,
      "day": "7",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 9
      }
      ]
      },
      {
      "id": 8,
      "name": "Reverse Diabetes in 14 Days",
      "description": "<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>",
      "start_from": "02-03-2019",
      "end_to": "25-03-2019",
      "total_days": 14,
      "healthcare_images": [
      {
      "id": 21,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/vPypbA0VfuqyqyId4lqXdieGZECKTfThR7tJoAFu.jpeg",
      "health_program_id": 8
      },
      {
      "id": 20,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/Nacs301RGy2W19tRktcbzJPeADaTNEtFne99GgnT.jpeg",
      "health_program_id": 8
      }
      ],
      "healthcare_days": [
      {
      "id": 381,
      "day": "14",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 380,
      "day": "13",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 379,
      "day": "12",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 378,
      "day": "11",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 377,
      "day": "10",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 376,
      "day": "9",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 375,
      "day": "8",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 374,
      "day": "7",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 373,
      "day": "6",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 372,
      "day": "5",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 371,
      "day": "4",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 370,
      "day": "3",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 369,
      "day": "2",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      },
      {
      "id": 368,
      "day": "1",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 8
      }
      ]
      },
      {
      "id": 6,
      "name": "Reverse Diabetes in 21 Days",
      "description": "<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>",
      "start_from": "24-01-2019",
      "end_to": "22-01-2019",
      "total_days": 21,
      "healthcare_images": [
      {
      "id": 17,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/Xj6B4ayTdL3F7AkLwGxH6VrfSVzHbkBf3yUregTa.jpeg",
      "health_program_id": 6
      },
      {
      "id": 22,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/dHRAYPVxQkmw9yfLVScYCN5QUvO4OJ8NqQRBI0Ag.jpeg",
      "health_program_id": 6
      },
      {
      "id": 23,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/2IjaxxOCWYNtHvFs564nkSrkyyKU0TQxddp0qyt0.jpeg",
      "health_program_id": 6
      },
      {
      "id": 24,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/rTGNijkeoYlZB5xJqQk9JLYU7881mj6O0PqJfns2.jpeg",
      "health_program_id": 6
      }
      ],
      "healthcare_days": [
      {
      "id": 326,
      "day": "2",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 325,
      "day": "1",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 327,
      "day": "3",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 328,
      "day": "4",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 329,
      "day": "5",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 330,
      "day": "6",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 331,
      "day": "7",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 332,
      "day": "8",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 333,
      "day": "9",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 334,
      "day": "10",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 335,
      "day": "11",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 336,
      "day": "12",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 337,
      "day": "13",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 338,
      "day": "14",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 339,
      "day": "15",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 340,
      "day": "16",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 341,
      "day": "17",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 342,
      "day": "18",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 343,
      "day": "19",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 344,
      "day": "20",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 345,
      "day": "21",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      }
      ]
      }
      ]
      }
      }
     * 
     * 
     * 
     */
    public function home(Request $request) {
        try {

            $user = User::select('id', 'user_name', 'mobile_number', 'email_id', 'voter_id', 'aadhar_id', 'address1', 'city_id', 'user_type_id')
                    ->where(["id" => $request->user_id])
                    ->with([
                        'userHealthDetail' => function($query) {
                            $query->select(DB::raw("id, user_id, medical_documents, fasting, bp, insullin_dependency, (CASE WHEN (is_diabeties = '1') THEN 'yes' ELSE 'no' END) as diabeties, (CASE WHEN (is_ppa = '1') THEN 'yes' ELSE 'no' END) as ppa, (CASE WHEN (hba_1c = '1') THEN 'yes' ELSE 'no' END) as hba_1c"));
                        }
                    ])
                    ->with([
                        'userBookingDetail' => function($query) {
                            $query->selectRaw(DB::raw('id, room_type_id, check_in_pin, check_out_pin, resort_room_id, user_id, source_id as booking_id, source_name, resort_id, package_id, DATE_FORMAT(check_in, "%d-%b-%Y") as check_in, DATE_FORMAT(check_in, "%r") as check_in_time, DATE_FORMAT(check_out, "%d-%b-%Y") as check_out_date, check_out, DATE_FORMAT(check_out, "%r") as check_out_time, is_checked_in'));
                        }
                    ])
                    ->first();
            if ($user) {
                $user['no_of_rooms'] = "1";
            }
            $user['is_checked_in'] = $user->user_type_id == 4 ? false : isset($user->userBookingDetail->is_checked_in) && ($user->userBookingDetail->is_checked_in == 1) ? true : false;

            $notification = Notification::where(["user_id" => $request->user_id, "is_view" => 0])->count();
            $cartCount = Cart::where(["user_id" => $request->user_id])->count();
            $user['cart_count'] = $cartCount;
            $user['notification_count'] = $notification;

            $resortId = isset($user->userBookingDetail->resort_id) ? $user->userBookingDetail->resort_id : 0;
            if ($resortId == 0) {
                $defaultResort = Resort::where("is_default", 1)->first();
                if ($defaultResort) {
                    $resortId = $defaultResort->id;
                } else {
                    $defaultResort = Resort::query()->first();
                    $resortId = $defaultResort->id;
                }
            }
//            if ($resortId > 0) {
                $banners = Banner::where(["is_active" => 1, "resort_id" => $resortId])->get();
//            } else {
//                $banners = Banner::where("is_active", 1)->take(5)->get();
//            }
            $bannerArray = [];
            $i = 0;
            foreach ($banners as $banner) {
                $bannerArray[$i]['id'] = $banner->id;
                $bannerArray[$i]['banner_image_url'] = $banner->name;
                $i++;
            }

//            if (isset($user->userBookingDetail->resort_id)) {
                $nearby = ResortNearbyPlace::where(["is_active" => 1, "resort_id" => $resortId])->take(5)->latest()->get();
//            } else {
//                $nearby = ResortNearbyPlace::where(["is_active" => 1])->take(5)->latest()->get();
//            }

            $nearbyArray = [];
            foreach ($nearby as $k => $near) {
                $nearbyImages = NearbyPlaceImage::where("nearby_place_id", $near->id)->get();
                $nearbyArray[$k]['id'] = $near->id;
                $nearbyArray[$k]['name'] = $near->name;
                $nearbyArray[$k]['description'] = $near->description;
                $nearbyArray[$k]['distance'] = $near->distance_from_resort;
                $nearbyArray[$k]['precautions'] = $near->precautions;
                $nearbyArray[$k]['address'] = $near->address_1;
                $nearbyArray[$k]['latitude'] = $near->latitude;
                $nearbyArray[$k]['longitude'] = $near->longitude;
                if (count($nearbyImages) > 0) {
                    $j = 0;
                    foreach ($nearbyImages as $nearbyImage) {
                        $nearbyArray[$k]['images'][$j]['id'] = $nearbyImage->id;
                        $nearbyArray[$k]['images'][$j]['banner_image_url'] = $nearbyImage->name;
                        $j++;
                    }
                } else {
                    $nearbyArray[$k]['images'][0] = [
                        'id' => 0,
                        'banner_image_url' => asset('img/image_loader.png')
                    ];
                }
            }

//            if (isset($user->userBookingDetail->resort_id)) {
                $offers = offer::where(["is_active" => 1, "resort_id" => $resortId])->with([
                            'offerImages' => function($query) {
                                $query->select('id', 'image_name as banner_image_url', 'offer_id');
                            }
                        ])->take(5)->latest()->get();
//            } else {
//                $offers = offer::where(["is_active" => 1])->with([
//                            'offerImages' => function($query) {
//                                $query->select('id', 'image_name as banner_image_url', 'offer_id');
//                            }
//                        ])->take(5)->latest()->get();
//            }

            $offerArray = [];
            if ($offers) {
                foreach ($offers as $key => $offer) {
                    $validity = Carbon::parse($offer->valid_to);
                    $offerArray[$key]['id'] = $offer->id;
                    $offerArray[$key]['name'] = $offer->name;
                    $offerArray[$key]['description'] = $offer->description;
                    $offerArray[$key]['valid_to'] = $validity->format('M-d-Y');
                    $offerArray[$key]['price'] = $offer->price;
                    $offerArray[$key]['discount'] = $offer->discount_percentage . "% OFF";
                    $offerArray[$key]['discounted_price'] = (int) $offer->price - (int) $offer->calculated_discount;
                    if (count($offer->offerImages) > 0) {
                        $offerArray[$key]['offer_images'] = $offer->offerImages;
                    } else {
                        $offerArray[$key]['offer_images'][0] = [
                            'id' => 0,
                            'banner_image_url' => asset('img/image_loader.png')
                        ];
                    }
                }
            }

//            if (isset($user->userBookingDetail->resort_id)) {

                $healthcare = HealthcateProgram::select(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'))
                                ->with([
                                    'healthcareImages' => function($query) {
                                        $query->select('id', 'image_name as banner_image_url', 'health_program_id');
                                    }
                                ])
                                ->with([
                                    'healthcareDays' => function($query) {
                                        $query->select('id', 'day', 'description', 'health_program_id');
                                    }
                                ])->where(["is_active" => 1, "resort_id" => $resortId])->take(5)->latest()->get();
//            } else {
//                $healthcare = HealthcateProgram::select(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'))->where(["is_active" => 1])
//                                ->with([
//                                    'healthcareImages' => function($query) {
//                                        $query->select('id', 'image_name as banner_image_url', 'health_program_id');
//                                    }
//                                ])
//                                ->with([
//                                    'healthcareDays' => function($query) {
//                                        $query->select('id', 'day', 'description', 'health_program_id');
//                                    }
//                                ])->take(5)->latest()->get();
//            }

            $dataHealthArray = [];
            if (count($healthcare) > 0) {
                $healthcare = $healthcare->toArray();
                foreach ($healthcare as $key => $health) {
                    $healthcareDays = HealthcateProgramDay::where('health_program_id', $health['id'])->count();
                    $dataHealthArray[$key] = $health;
                    if (count($health['healthcare_images']) <= 0) {
                        $dataHealthArray[$key]['healthcare_images'][0] = [
                            'id' => 0,
                            'banner_image_url' => asset('img/image_loader.png')
                        ];
                    }
                    $dataHealthArray[$key]['total_days'] = $healthcareDays;
                }
            }

            $response['success'] = true;
            $response['status_code'] = 200;
            $response['message'] = "service successfully access.";
            if (isset($user->id) && ($user->id > 0)) {
                $user = $user->toArray();
                if ($user['user_health_detail'] == null) {
                    $user['user_health_detail'] = (object) [];
                }
            } else {
                $user = (object) [];
            }
            $response['data'] = [
                "user" => $user,
                "banners" => $bannerArray,
                "nearby_attaractions" => $nearbyArray,
                "best_offers" => $offerArray,
                "health_care" => $dataHealthArray
            ];
            return $this->jsonData($response);
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\MealType;
use App\Models\MealItem;
use App\Models\MealPackage;
use App\Models\MealPackageItem;
use App\Models\Cart;
use App\Models\Resort;

class MealController extends Controller {

    /**
     * @api {get} /api/meal-listing  Category wise meal listing
     * @apiHeader {String} Accept application/json. 
     * @apiName GetMealList
     * @apiGroup Meal
     * 
     * @apiParam {String} resort_id Resort id* (For guest user use resort id value -1).
     * @apiParam {String} user_id User id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Meal list found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "Meal list found",
      "data": {
      "meal_packages": [
      {
      "id": 12,
      "name": "Breakfast plate",
      "image_url": "http://127.0.0.1:1234/storage/meal_package_images/d1OJlyJx3ndLeYjcUREJ4R3WqWMsU0lHOFHaTEyc.jpeg",
      "price": 110,
      "quantity_count": 0,
      "meal_items": [
      {
      "id": 320,
      "description": "dummy,
      "category": "N",
      "name": "Boiled Egg",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/nRJmJEkN9VsB4zIfMljsdrZMoEg8FZIhLAAbtIT0.jpeg",
      "price": 50
      },
      {
      "id": 319,
      "description": "dummy,
      "category": "V",
      "name": "sandwich",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/sIfdcO4ALhCtuXnjuKUQFUkLgng60aqI19xGb54W.jpeg",
      "price": 60
      }
      ]
      },
      {
      "id": 17,
      "name": "Lunch  Thali",
      "image_url": "http://127.0.0.1:1234/storage/meal_package_images/WMsWtVgGih3ygCElWvTB3Bne8aky9mOlEi1gBXB6.jpeg",
      "price": 300,
      "quantity_count": 0,
      "meal_items": [
      {
      "id": 349,
      "description": "dummy",
      "category": "V",
      "name": "PLAIN RICE",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/9nVLxxSxxoIJrzYptXjDh6g9HqwvKEv6kWVwZfOZ.jpeg",
      "price": 80
      },
      {
      "id": 350,
      "description": "dummy",
      "category": "V",
      "name": "kadhai paneer",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/ASBKXtmGAdOx3t6U6CApm5xFol4jD4Z9Ic1KTrYr.png",
      "price": 250
      },
      {
      "id": 351,
      "description": "dummy",     *
      "category": "V",
      "name": "Mix Veg",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/smHJD5kcICVSGdXwqcUCN1kmRP0NBfGbIETSwI5i.jpeg",
      "price": 180
      },
      {
      "id": 352,
      "description": "dummy",
      "category": "V",
      "name": "plain roti",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/84ijg5Hmk6PzAl9PJjtWn4LDMysDcqbIQjNWKfGT.jpeg",
      "price": 40
      },
      {
      "id": 353,
      "description": "dummy",
      "category": "V",
      "name": "Dal Tadka",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/6usfxv12m2LGrsjEZZDzJwFIAJUptpffhLlC6dp2.png",
      "price": 150
      },
      {
      "id": 354,
      "category": "V",
      "name": "Gulab Jamun",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/jAZzRh54dEuvIHb1WkqwJ6i326KsXB4t1xD9ZrIb.png",
      "price": 180
      },
      {
      "id": 355,
      "category": "V",
      "name": "salad",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/TEns8pKMUyNyMA4jytMSHBhUZ8aFv8JrEQQuKrLq.png",
      "price": 60
      }
      ]
      },
      {
      "id": 18,
      "name": "chineese combo",
      "image_url": "http://127.0.0.1:1234/storage/meal_package_images/NUGLOiA2tQzWa0wraaKNoMvNi060mlkUg140Daoa.png",
      "price": 499,
      "quantity_count": 0,
      "meal_items": [
      {
      "id": 356,
      "category": "V",
      "name": "paneer chilli",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/KCYhJdLYoqMGfY1dbrdjj5jhYh81MDw2VN37xzRu.jpeg",
      "price": 120
      },
      {
      "id": 357,
      "category": "V",
      "name": "fried rice",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/zhbbuV8PWazi6knF34xsz4cl5X3udziYzRqG7not.jpeg",
      "price": 150
      },
      {
      "id": 358,
      "category": "V",
      "name": "manchurian",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/JfwGmY8ZuHVN7DbkWOrOsAXptr8eauRsJyCl01tW.jpeg",
      "price": 180
      },
      {
      "id": 359,
      "category": "V",
      "name": "Noddles",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/nNDZyYixSFEAEVJUS7JqzaPMc9OQv9SyoJ8iYbJS.jpeg",
      "price": 110
      },
      {
      "id": 360,
      "category": "V",
      "name": "momos",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/OqT8aMlBYvDbyCvEt9qp7uwYJMY2MbZHFzEc58ON.png",
      "price": 160
      },
      {
      "id": 361,
      "category": "V",
      "name": "Honey Chilly Potato",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/W3ad3Cw3L70II97UTxp6mds8haigE3ym5qyZuODp.jpeg",
      "price": 160
      }
      ]
      },
      {
      "id": 19,
      "name": "non veg combo",
      "image_url": "http://127.0.0.1:1234/storage/meal_package_images/OjG5Op6DiVXmoNz1m4C3SdjdqZ53rxqhCWoEfnSM.jpeg",
      "price": 699,
      "quantity_count": 0,
      "meal_items": [
      {
      "id": 476,
      "category": "V",
      "name": "Lemonade",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/CZ38GDAHzP1GZci06uqgtujD1XUbEiP2QfToQnW3.png",
      "price": 100
      },
      {
      "id": 475,
      "category": "N",
      "name": "chicken curry",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/aGtC5OCtA61SCVP7gJWqJoP4X9YR9V5dKs1e5pyb.jpeg",
      "price": 250
      },
      {
      "id": 474,
      "category": "N",
      "name": "chicken korma",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/csYH8B1Y3qkiBbaY6UkXG1tPnBwI0uv1ZoQU0sDk.png",
      "price": 250
      },
      {
      "id": 473,
      "category": "N",
      "name": "chicken lollypop",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/QNQb0Kxqz4PnFOFagMQGh6IRKlrxt2JOBuSr7oxx.jpeg",
      "price": 280
      }
      ]
      },
      {
      "id": 20,
      "name": "north indian meal",
      "image_url": "http://127.0.0.1:1234/storage/meal_package_images/FrQVok1muRTbH81WBsRwd9GvSSN40KE5CTU49Ni7.jpeg",
      "price": 599,
      "quantity_count": 0,
      "meal_items": [
      {
      "id": 484,
      "category": "V",
      "name": "salad",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/TEns8pKMUyNyMA4jytMSHBhUZ8aFv8JrEQQuKrLq.png",
      "price": 60
      },
      {
      "id": 483,
      "category": "V",
      "name": "Gulab Jamun",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/jAZzRh54dEuvIHb1WkqwJ6i326KsXB4t1xD9ZrIb.png",
      "price": 180
      },
      {
      "id": 482,
      "category": "V",
      "name": "Gobhi Aloo",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/vwxpkeC2NumVWn8aFbH8sn1RGsTxLSyybDu4my8T.jpeg",
      "price": 160
      },
      {
      "id": 481,
      "category": "V",
      "name": "Dal Tadka",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/6usfxv12m2LGrsjEZZDzJwFIAJUptpffhLlC6dp2.png",
      "price": 150
      },
      {
      "id": 480,
      "category": "V",
      "name": "fried rice",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/zhbbuV8PWazi6knF34xsz4cl5X3udziYzRqG7not.jpeg",
      "price": 150
      },
      {
      "id": 479,
      "category": "V",
      "name": "Mix Veg",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/smHJD5kcICVSGdXwqcUCN1kmRP0NBfGbIETSwI5i.jpeg",
      "price": 180
      },
      {
      "id": 478,
      "category": "V",
      "name": "kadhai paneer",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/ASBKXtmGAdOx3t6U6CApm5xFol4jD4Z9Ic1KTrYr.png",
      "price": 250
      },
      {
      "id": 477,
      "category": "V",
      "name": "sahi paneer",
      "image_url": "http://127.0.0.1:1234/storage/meal_images/dH7a9n2oAjLDXLpojsTCJryvfWHDU9TfVTZcnvi1.png",
      "price": 280
      }
      ]
      }
      ],
      "category_meal": [
      {
      "id": 1,
      "name": "Starter",
      "menu_items": [
      {
      "id": 71,
      "name": "paneer tikka",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/kLWKjpmGYiX26nNIQmhB2apz5ksljU3qHxmHVMx0.jpeg",
      "price": 160,
      "quantity_count": 0
      },
      {
      "id": 73,
      "name": "paneer chilli",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/KCYhJdLYoqMGfY1dbrdjj5jhYh81MDw2VN37xzRu.jpeg",
      "price": 120,
      "quantity_count": 0
      },
      {
      "id": 94,
      "name": "tandoori chaap",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/oaywSvhvfc0zgKhnQ56bxWU8xrJeKs2nPKpz2JSO.jpeg",
      "price": 140,
      "quantity_count": 0
      },
      {
      "id": 97,
      "name": "chicken lollypop",
      "category": "N",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/QNQb0Kxqz4PnFOFagMQGh6IRKlrxt2JOBuSr7oxx.jpeg",
      "price": 280,
      "quantity_count": 0
      }
      ]
      },
      {
      "id": 2,
      "name": "Main Course",
      "menu_items": [
      {
      "id": 64,
      "name": "RAJMA",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/pXsMGTYbpM1wY49aI1owtNR49qiNQPDYOKuXW26V.jpeg",
      "price": 110,
      "quantity_count": 0
      },
      {
      "id": 65,
      "name": "PLAIN RICE",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/9nVLxxSxxoIJrzYptXjDh6g9HqwvKEv6kWVwZfOZ.jpeg",
      "price": 80,
      "quantity_count": 0
      },
      {
      "id": 67,
      "name": "CHOLE BHATURE",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/k7QYBVtKUdMcDQtzqZq0ab9aJDloUhMf7zDQ4lnF.jpeg",
      "price": 80,
      "quantity_count": 0
      },
      {
      "id": 72,
      "name": "chicken biryani",
      "category": "N",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/ZFOEhkPJNVBn4j7QUYT4JMkGG1imB8Ydt2vDH4d0.jpeg",
      "price": 250,
      "quantity_count": 0
      },
      {
      "id": 78,
      "name": "paneer do-pyaza",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/UwvJiWEDgg8ouxhKsrc63HO2LsyzE1fjmjNlQciE.jpeg",
      "price": 250,
      "quantity_count": 0
      },
      {
      "id": 79,
      "name": "sahi paneer",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/dH7a9n2oAjLDXLpojsTCJryvfWHDU9TfVTZcnvi1.png",
      "price": 280,
      "quantity_count": 0
      },
      {
      "id": 80,
      "name": "kadhai paneer",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/ASBKXtmGAdOx3t6U6CApm5xFol4jD4Z9Ic1KTrYr.png",
      "price": 250,
      "quantity_count": 0
      },
      {
      "id": 81,
      "name": "Mix Veg",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/smHJD5kcICVSGdXwqcUCN1kmRP0NBfGbIETSwI5i.jpeg",
      "price": 180,
      "quantity_count": 0
      },
      {
      "id": 82,
      "name": "fried rice",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/zhbbuV8PWazi6knF34xsz4cl5X3udziYzRqG7not.jpeg",
      "price": 150,
      "quantity_count": 0
      },
      {
      "id": 83,
      "name": "plain roti",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/84ijg5Hmk6PzAl9PJjtWn4LDMysDcqbIQjNWKfGT.jpeg",
      "price": 40,
      "quantity_count": 0
      },
      {
      "id": 90,
      "name": "manchurian",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/JfwGmY8ZuHVN7DbkWOrOsAXptr8eauRsJyCl01tW.jpeg",
      "price": 180,
      "quantity_count": 0
      },
      {
      "id": 91,
      "name": "Dal Tadka",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/6usfxv12m2LGrsjEZZDzJwFIAJUptpffhLlC6dp2.png",
      "price": 150,
      "quantity_count": 0
      },
      {
      "id": 95,
      "name": "Chaap",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/kIhETAhnq4xpy1H9NvVXDP74YNQ8MEAnTVUQh9zh.jpeg",
      "price": 210,
      "quantity_count": 0
      },
      {
      "id": 99,
      "name": "chicken korma",
      "category": "N",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/csYH8B1Y3qkiBbaY6UkXG1tPnBwI0uv1ZoQU0sDk.png",
      "price": 250,
      "quantity_count": 0
      },
      {
      "id": 100,
      "name": "chicken curry",
      "category": "N",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/aGtC5OCtA61SCVP7gJWqJoP4X9YR9V5dKs1e5pyb.jpeg",
      "price": 250,
      "quantity_count": 0
      }
      ]
      },
      {
      "id": 4,
      "name": "Vegetables",
      "menu_items": [
      {
      "id": 89,
      "name": "Gobhi Aloo",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/vwxpkeC2NumVWn8aFbH8sn1RGsTxLSyybDu4my8T.jpeg",
      "price": 160,
      "quantity_count": 0
      },
      {
      "id": 102,
      "name": "Aloo Shimla mirch",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/eAd3IXUZaskpB6YRXt6cyURl0boOcVEka1cglME7.jpeg",
      "price": 110,
      "quantity_count": 0
      }
      ]
      },
      {
      "id": 5,
      "name": "Desserts",
      "menu_items": [
      {
      "id": 85,
      "name": "Moong Dal halwa",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/MlNwkXbTniqYIiqP4hu2IqQ6Aax75gPLbyXMCiLI.png",
      "price": 210,
      "quantity_count": 0
      },
      {
      "id": 87,
      "name": "Rabdi",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/lztOqLHyrFKUHVosijAA9oMbHo0nfxe2UfdddIRq.png",
      "price": 210,
      "quantity_count": 0
      },
      {
      "id": 88,
      "name": "Gulab Jamun",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/jAZzRh54dEuvIHb1WkqwJ6i326KsXB4t1xD9ZrIb.png",
      "price": 180,
      "quantity_count": 0
      }
      ]
      },
      {
      "id": 6,
      "name": "Miscellaneous",
      "menu_items": [
      {
      "id": 68,
      "name": "sandwich",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/sIfdcO4ALhCtuXnjuKUQFUkLgng60aqI19xGb54W.jpeg",
      "price": 60,
      "quantity_count": 0
      }
      ]
      },
      {
      "id": 9,
      "name": "Beverages",
      "menu_items": [
      {
      "id": 103,
      "name": "Lemonade",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/CZ38GDAHzP1GZci06uqgtujD1XUbEiP2QfToQnW3.png",
      "price": 100,
      "quantity_count": 0
      },
      {
      "id": 104,
      "name": "Vanilla Shake",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/k1qXLXvanNIBBfTzJMIEh8EoKDFMSiT1BfOcdS48.png",
      "price": 120,
      "quantity_count": 0
      }
      ]
      },
      {
      "id": 12,
      "name": "Appetizers",
      "menu_items": [
      {
      "id": 69,
      "name": "Boiled Egg",
      "category": "N",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/nRJmJEkN9VsB4zIfMljsdrZMoEg8FZIhLAAbtIT0.jpeg",
      "price": 50,
      "quantity_count": 0
      },
      {
      "id": 70,
      "name": "samosa",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/MHpic0E7NvA9tQ8OTaIjOo66BXaR90vqYeNoUe59.jpeg",
      "price": 60,
      "quantity_count": 0
      },
      {
      "id": 84,
      "name": "Noddles",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/nNDZyYixSFEAEVJUS7JqzaPMc9OQv9SyoJ8iYbJS.jpeg",
      "price": 110,
      "quantity_count": 0
      },
      {
      "id": 86,
      "name": "momos",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/OqT8aMlBYvDbyCvEt9qp7uwYJMY2MbZHFzEc58ON.png",
      "price": 160,
      "quantity_count": 0
      },
      {
      "id": 92,
      "name": "Honey Chilly Potato",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/W3ad3Cw3L70II97UTxp6mds8haigE3ym5qyZuODp.jpeg",
      "price": 160,
      "quantity_count": 0
      },
      {
      "id": 93,
      "name": "pav bhaji",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/amzN3YLVsnRCXPXaeTqY4EYf1W9rDKXpHLo0DhdU.png",
      "price": 110,
      "quantity_count": 0
      },
      {
      "id": 96,
      "name": "salad",
      "category": "V",
      "banner_image_url": "http://127.0.0.1:1234/storage/meal_images/TEns8pKMUyNyMA4jytMSHBhUZ8aFv8JrEQQuKrLq.png",
      "price": 60,
      "quantity_count": 0
      }
      ]
      }
      ]
      }
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
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function mealListing(Request $request) {
        try {
            if (!$request->resort_id) {
                return $this->sendErrorResponse("Resort id missing", (object) []);
            }
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing", (object) []);
            }


            //For meal packages
            if ($request->resort_id == -1) {
                $resortId = 0;
                $defaultResort = Resort::where("is_default", 1)->first();
                if ($defaultResort) {
                    $resortId = $defaultResort->id;
                } else {
                    $defaultResort = Resort::query()->first();
                    $resortId = $defaultResort->id;
                }

                $mealPackages = MealPackage::where(["is_active" => 1, "resort_id" => $resortId])->get();
            } else {
                $mealPackages = MealPackage::where(["is_active" => 1, "resort_id" => $request->resort_id])->get();
            }
            $packageData = [];
            if ($mealPackages) {
                foreach ($mealPackages as $key => $mealPackage) {
                    $userCartPackage = Cart::where(["user_id" => $request->user_id, "meal_package_id" => $mealPackage->id])->first();
                    $mealPackageItems = MealPackageItem::where(["meal_package_id" => $mealPackage->id])
                            ->with(["mealItem"
//                                => function($query) {
//                                    $query->withTrashed();
//                                }
                            ])
                            ->get();
                    $packageData[$key]['id'] = $mealPackage->id;
                    $packageData[$key]['name'] = $mealPackage->name;
                    $packageData[$key]['image_url'] = $mealPackage->image_name;
                    $packageData[$key]['price'] = $mealPackage->price;
                    $packageData[$key]['quantity_count'] = isset($userCartPackage->quantity) && $userCartPackage->quantity ? $userCartPackage->quantity : 0;
                    if (count($mealPackageItems) > 0) {
                        $g = 0;
                        foreach ($mealPackageItems as $k => $mealPackageItem) {
                            if ($mealPackageItem->mealItem) {
                                $packageData[$key]['meal_items'][$g]['id'] = $mealPackageItem->id;
                                $packageData[$key]['meal_items'][$g]['description'] = $mealPackageItem->description;
                                $packageData[$key]['meal_items'][$g]['category'] = $mealPackageItem->mealItem->category;
                                $packageData[$key]['meal_items'][$g]['name'] = isset($mealPackageItem->mealItem->name) ? $mealPackageItem->mealItem->name : "";
                                $packageData[$key]['meal_items'][$g]['image_url'] = isset($mealPackageItem->mealItem->image_name) ? $mealPackageItem->mealItem->image_name : "";
                                $packageData[$key]['meal_items'][$g]['price'] = isset($mealPackageItem->mealItem->price) ? $mealPackageItem->mealItem->price : "";
                                $g++;
                            }
                        }
                    } else {
                        $packageData[$key]['meal_items'] = [];
                    }
                }
            }

            if ($request->resort_id == -1) {
                $resortId = 0;
                $defaultResort = Resort::where("is_default", 1)->first();
                if ($defaultResort) {
                    $resortId = $defaultResort->id;
                } else {
                    $defaultResort = Resort::query()->first();
                    $resortId = $defaultResort->id;
                }

                $mealCategories = Mealtype::select('id', 'name')->where(["is_active" => 1, "resort_id" => $resortId])->whereHas('menuItems', function($query) use($request, $resortId) {
                            $query->where(["is_active" => 1, 'resort_id' => $resortId]);
                        })->with([
                            'menuItems' => function ($query) use($request, $resortId) {
                                $query->select('id', 'description', 'name', 'category', 'image_name as banner_image_url', 'meal_type_id', 'price')->where(["is_active" => 1, 'resort_id' => $resortId]);
                            }
                        ])->get();
            } else {
                $mealCategories = Mealtype::select('id', 'name')->where(["is_active" => 1, "resort_id" => $request->resort_id])->whereHas('menuItems', function($query) use($request) {
                            $query->where(["is_active" => 1, 'resort_id' => $request->resort_id]);
                        })->with([
                            'menuItems' => function ($query) use($request) {
                                $query->select('id', 'description', 'name', 'category', 'image_name as banner_image_url', 'meal_type_id', 'price')->where(["is_active" => 1, 'resort_id' => $request->resort_id]);
                            }
                        ])->get();
            }
            $mealCatData = [];
            if ($mealCategories) {
                foreach ($mealCategories as $m => $mealCategory) {
                    $mealCatData[$m]['id'] = $mealCategory->id;
                    $mealCatData[$m]['name'] = $mealCategory->name;
                    if ($mealCategory->menuItems) {
                        foreach ($mealCategory->menuItems as $j => $mitems) {
                            $userCart = Cart::where(["user_id" => $request->user_id, "meal_item_id" => $mitems->id])->first();
                            $mealCatData[$m]['menu_items'][$j]['id'] = $mitems->id;
                            $mealCatData[$m]['menu_items'][$j]['description'] = $mitems->description;
                            $mealCatData[$m]['menu_items'][$j]['name'] = $mitems->name;
                            $mealCatData[$m]['menu_items'][$j]['category'] = $mitems->category;
                            $mealCatData[$m]['menu_items'][$j]['banner_image_url'] = $mitems->banner_image_url;
                            $mealCatData[$m]['menu_items'][$j]['price'] = $mitems->price;
                            $mealCatData[$m]['menu_items'][$j]['quantity_count'] = isset($userCart->quantity) && $userCart->quantity ? $userCart->quantity : 0;
                        }
                    } else {
                        $mealCatData[$m]['menu_items'] = [];
                    }
                }
            }

            $data['meal_packages'] = $packageData;
            $data['category_meal'] = $mealCatData;
            return $this->sendSuccessResponse("Meal list found", $data);
        } catch (Exception $ex) {
            return $this->sendSuccessResponse("Meal list found", $data);
        }
    }

}

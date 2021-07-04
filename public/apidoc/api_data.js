define({ "api": [
  {
    "type": "get",
    "url": "/api/activities-list",
    "title": "Activity listing & details",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetActivitiesList",
    "group": "Activity",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort Id* (For guest user use resort id value -1).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Activities found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Activities found.\",\n      \"data\": [\n          {\n              \"id\": 8,\n              \"name\": \"Running\",\n              \"description\": \"<p>If you like to run, then we&#39;re throwing down a challenge to see who the best runners are. Simply pick up a biometric wristband at the new Porto Sani gym and off you go. When you return from your run we&#39;ll upload the stats onto our computer and make a leader board to show the ranking of all our runners. The challenge is open to all our guests over 16 years old.We will reward the three best runners with personal training sessions and valuable spa credits.</p>\",\n              \"address\": \"Dehradun | Uttarakhand | India\",\n              \"latitude\": 19.53,\n              \"longitude\": 57.524848,\n              \"is_booking_avaliable\": true,\n              \"activity_images\": [\n                  {\n                      \"id\": 23,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/activity_images/3HNmS1PqIBpOWHM7z02hmzLNQvf3F8aoyw7SdGhd.jpeg\",\n                      \"amenity_id\": 8\n                  },\n                  {\n                      \"id\": 24,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/activity_images/fUyFGNmOrnHlBYvTTeIfrbmbOzSVJh3dZ9kxBzuy.jpeg\",\n                      \"amenity_id\": 8\n                  }\n              ]\n          },\n          {\n              \"id\": 9,\n              \"name\": \"Yoga\",\n              \"description\": \"<p>Start a day with morning yoga to balance body and soul at roof top Yoga pavilion while enjoy the cool morning breeze, a warm sunrise entering every space of the jungle leaves. Yoga is ancient art based on a harmonizing system of development for the body, mind, and spirit. The continued practice of yoga will lead to a sense of peace and well-being, and also a feeling of being at one with their environment that help to harmonize human consciousness with the divine consciousness.</p>\",\n              \"address\": \"Dehradun | Uttarakhand | India\",\n              \"latitude\": 19.53,\n              \"longitude\": 57.524848,\n              \"is_booking_avaliable\": true,\n              \"activity_images\": [\n                  {\n                      \"id\": 25,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/activity_images/bsAmNB1gLB2Z3QDD3KHK9si6sow6guVrwerOv10R.jpeg\",\n                      \"amenity_id\": 9\n                  },\n                  {\n                      \"id\": 26,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/activity_images/bMdjvCYdRpexlenEW2WKSiRqYVkXTTj8e8TZVSDT.jpeg\",\n                      \"amenity_id\": 9\n                  }\n              ]\n          },\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Resort id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ActivityController.php",
    "groupTitle": "Activity"
  },
  {
    "type": "get",
    "url": "/api/activity-time-slots",
    "title": "Activity Time slots",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetActivityTimeSlots",
    "group": "Activity",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "activity_id",
            "description": "<p>Activity id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_date",
            "description": "<p>Booking date* (YYYY/MM/DD).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Activity time slots</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"time slots\",\n   \"data\": [\n       {\n           \"id\": 3,\n           \"from\": \"00:00:00\",\n           \"to\": \"01:00:00\",\n           \"is_booking_available\": true\n       },\n       {\n           \"id\": 4,\n           \"from\": \"02:00:00\",\n           \"to\": \"03:00:00\",\n           \"is_booking_available\": true\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ActivityIdMissing",
            "description": "<p>The activity is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BooingDateMissing",
            "description": "<p>The booking date is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"activity id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"booking date id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ActivityController.php",
    "groupTitle": "Activity"
  },
  {
    "type": "post",
    "url": "/api/book-activities",
    "title": "Activity Booking",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostActivityBooking",
    "group": "Activity",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "activity_id",
            "description": "<p>Amenity id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_date",
            "description": "<p>Booking date* (DD/MM/YYYY).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "from_time",
            "description": "<p>From Time* (24 hours format).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "to_time",
            "description": "<p>To Time* (24 hours format).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Activity booking created</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Activity booking created\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ActivityIdMissing",
            "description": "<p>The amenity is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BooingDateMissing",
            "description": "<p>The booking date is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "FromTimeMissing",
            "description": "<p>The From time is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ToTimeMissing",
            "description": "<p>The To time is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"user id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"resort id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"activity id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"booking date id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"From time missing.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"To time missing.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ActivityController.php",
    "groupTitle": "Activity"
  },
  {
    "type": "get",
    "url": "/api/amenities-list",
    "title": "Amenities listing & details",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetAmenitiesList",
    "group": "Amenities",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort Id* (For guest user use resort id value -1).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Anemities found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Anemities found.\",\n      \"data\": [\n          {\n              \"id\": 1,\n              \"name\": \"Gym\",\n              \"description\": \"<hr />\\r\\n<p>The Sanjeevani Health Club encompasses 117 square metres (1,259 square feet) of dedicated workout space with a wide range of state-of-the-art equipment. Facilities include an exercise room, sauna, steam rooms for men and women, sunlit pool, cardiovascular machines and free weights. Certified trainers are available upon request to help guests get the most out of their workouts.</p>\\r\\n\\r\\n<p>Keep up with your fitness routine whilst you&rsquo;re away with our free hotel gym. Packed with cardio and resistance equipment and free weights, you can unwind after a busy day in the capital at the Sanjeevani Resort</p>\\r\\n\\r\\n<p><strong>Highlights</strong></p>\\r\\n\\r\\n<p>&bull; Cross-trainer and treadmills<br />\\r\\n&bull; Stationary bikes and rowing machine<br />\\r\\n&bull; Free weights area<br />\\r\\n&bull; Floor-to-ceiling mirrors<br />\\r\\n&bull; Healthy snacks and juices available at&nbsp;Sacred Caf&eacute;</p>\\r\\n\\r\\n<p><strong>Gym facilities</strong></p>\\r\\n\\r\\n<p>All guests over the age of 16 who visit the Sanjeevani Resort are invited to use our in-house hotel gym to exercise and unwind.</p>\\r\\n\\r\\n<p>With a mix of equipment and weights, our hotel gym will cater to you whether you want to do a cardio workout, or if you want to give your muscles some strength training or toning exercises.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Timings Morning&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</strong><strong>Timings Evening</strong></p>\\r\\n\\r\\n<p><strong>4:00AM - 5:30AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;4:30PM - 6:00PM</strong></p>\\r\\n\\r\\n<p><strong>5:30AM - 7:00AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;6:00PM - 7:30PM</strong></p>\\r\\n\\r\\n<p><strong>7:00AM - 8:30AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;7:30PM - 9:00PM</strong></p>\\r\\n\\r\\n<p><strong>8:30AM - 10:00AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;9:00PM - 10:30PM</strong></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<hr />\\r\\n<p>The Sanjeevani Health Club encompasses 117 square metres (1,259 square feet) of dedicated workout space with a wide range of state-of-the-art equipment. Facilities include an exercise room, sauna, steam rooms for men and women, sunlit pool, cardiovascular machines and free weights. Certified trainers are available upon request to help guests get the most out of their workouts.</p>\\r\\n\\r\\n<p>Keep up with your fitness routine whilst you&rsquo;re away with our free hotel gym. Packed with cardio and resistance equipment and free weights, you can unwind after a busy day in the capital at the Sanjeevani Resort</p>\\r\\n\\r\\n<p>&nbsp;</p>\",\n              \"address\": \"Horawala | Dehradoon | Uttarakhand-248197\",\n              \"is_booking_avaliable\": true,\n              \"amenity_images\": [\n                  {\n                      \"id\": 19,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/amenity_images/a17xfSfM9pwtUzHxGksYEJvEWtvjDluB4HXH9B3Y.jpeg\",\n                      \"amenity_id\": 1\n                  },\n                  {\n                      \"id\": 20,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/amenity_images/0xnhuoEd3bH6fjeY0BaD9Sfn1orxtcjndWx1PFoq.jpeg\",\n                      \"amenity_id\": 1\n                  }\n              ]\n          },\n          {\n              \"id\": 2,\n              \"name\": \"SPA\",\n              \"description\": \"<p>If it&rsquo;s been a hard day&rsquo;s night, relax and rejuvenate at our decadent Spa. Our on-site spa offers signature Hard Rock swagger in a sophisticated and modern spa environment, catering to your every need. You can also take advantage of our full-service spa menu offered right in your suite. Whether you need a post-party facial or a poolside massage, you&rsquo;re already on our VIP list.</p>\\r\\n\\r\\n<p>Sanjeevani is the best of Dehradoon City spa hotels, with a huge menu of signature massages, baths, body treatments, facials, and other beauty services. There&rsquo;s something for every member of the family with treatments designed specifically for men, women, kids, and teens.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Timings Mornings&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Timings Evenings</strong></p>\\r\\n\\r\\n<p><strong>4:00AM - 5:30AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;4:30PM - 6:00PM</strong></p>\\r\\n\\r\\n<p><strong>5:30AM - 7:00AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 6:00PM - 7:30PM</strong></p>\\r\\n\\r\\n<p><strong>7:00AM - 8:30AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;7:30PM - 9:00PM</strong></p>\\r\\n\\r\\n<p><strong>8:30AM - 10:00AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;9:00PM - 10:30PM</strong></p>\",\n              \"address\": \"Horawala | Dehradoon| Uttrakhand-248197\",\n              \"is_booking_avaliable\": true,\n              \"amenity_images\": [\n                  {\n                      \"id\": 17,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/amenity_images/QKYvWDznmpjcuowP9UsHMPKm6ruJ8h9pgCtN94Ub.jpeg\",\n                      \"amenity_id\": 2\n                  },\n                  {\n                      \"id\": 18,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/amenity_images/3KIITP6paeE66HhJjNMQlrXERLTPw747z8alN5sb.png\",\n                      \"amenity_id\": 2\n                  }\n              ]\n          },\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Resort id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AmenityController.php",
    "groupTitle": "Amenities"
  },
  {
    "type": "get",
    "url": "/api/amenities-time-slots",
    "title": "Amenities Time slots",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetAmenityTimeSlots",
    "group": "Amenities",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "amenity_id",
            "description": "<p>Amenity id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_date",
            "description": "<p>Booking date (yyyy/mm/dd).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Anemity time slots</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"time slots\",\n   \"data\": [\n       {\n           \"id\": 1,\n           \"from\": \"09:00:00\",\n           \"to\": \"10:00:00\",\n           \"is_booking_available\": false\n       },\n       {\n           \"id\": 2,\n           \"from\": \"10:00:00\",\n           \"to\": \"11:00:00\",\n           \"is_booking_available\": true\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "AmenityIdMissing",
            "description": "<p>The amenity is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BooingDateMissing",
            "description": "<p>The booking date is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"amenity id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"booking date id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AmenityController.php",
    "groupTitle": "Amenities"
  },
  {
    "type": "post",
    "url": "/api/book-amenities",
    "title": "Amenities Booking",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostAmenitiesBooking",
    "group": "Amenities",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "amenity_id",
            "description": "<p>Amenity id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_date",
            "description": "<p>Booking date* (DD/MM/YYYY).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "from_time",
            "description": "<p>From Time* (24 hours format).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "to_time",
            "description": "<p>To Time* (24 hours format).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Anemity booking created</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Anemity booking created\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "AmenityIdMissing",
            "description": "<p>The amenity is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BooingDateMissing",
            "description": "<p>The booking date is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "FromTimeMissing",
            "description": "<p>The From time is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ToTimeMissing",
            "description": "<p>The To time is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"user id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"resort id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"amenity id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"booking date id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"From time missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"To time missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AmenityController.php",
    "groupTitle": "Amenities"
  },
  {
    "type": "get",
    "url": "/api/logout",
    "title": "Logout",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetLogout",
    "group": "Auth",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>logout successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>{}.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"logout successfully\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/api/referesh-token",
    "title": "Referesh token",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostRefereshToken",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "secret_key",
            "description": "<p>Secret key(fgwjdksA5Cyh2UuOIzGb6z+USJtc)*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Token refreshed successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>User unique token.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"status_code\": 200,\n\"message\": \"Token refreshed successfully.\",\n\"data\": {\n\"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQyZjQwOGQyNzE4N2RlZDVlMDEyZWZjODZhZDQ5NTQyZjJhNzQ5MzQ4NzVlODg0OTQ1ZDE0MjM2YzQzNDQyOTQ5YmVjYTE5Y2FhNDg0YzRiIn0.eyJhdWQiOiIxIiwianRpIjoiZDJmNDA4ZDI3MTg3ZGVkNWUwMTJlZmM4NmFkNDk1NDJmMmE3NDkzNDg3NWU4ODQ5NDVkMTQyMzZjNDM0NDI5NDliZWNhMTljYWE0ODRjNGIiLCJpYXQiOjE1NDA4MzgzNDAsIm5iZiI6MTU0MDgzODM0MCwiZXhwIjoxNTcyMzc0MzQwLCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.yV9o9kgadV-Spbl9MyFUEbiXNnrPRDQeanAAc1jJPZIGEaPlGh5VzlkTqY0NYXsvGUjaXRhXddUkAp4vY5EwDVzEAo-_cN0hW7sdQ43MNQJujCuwF2UZRTiNtOR0UV28Bu1ijZh7EBD1jn8OJ4qH4W7yXXCM3xMu7YlMYETJe5iELMMo7lwXmKpsOAXkQGcodPVgFZ0khBTmMO6ZP5SYSTJX5uv0kb586LzLpYbzWzse9BzQ3lk1JsZh6V9FFJ2SmHqoVadUGzcQQxxQBWI9J-iyncMZI4_J7Kp8WdsR4D0N5HfyBD6rMCnrW1Vunl7tE8SnXx7VLtPMv9CmqscTxrd3J2Eng-h0w3dOBUYdg4MqVGZFwuni7t0nGA_zhLCdXGEuurM-67UbWRPG5EwrJdzu9VcUYbmDqOCPDZkygjqBzhNpeuXmReOod2FxbiAvnhB0iRwDxOT1DnpPMuZpzUjKK6XL3vw82O-49OWoANbS4G4r1VI27vZwPZcYZUV8MZvPY3IGmqEPTHTfY0ccwjtfdOtLlzVtX4d8czOW5uynfpWmUdglY1RH9B7kda4KOsTXf4_kuLLyQU6cZs_F7SRIJ0gQCkP_87YrAK0cS_5jNZyUq7x7YriHYeMsyCtZ8vuh_vld8iPsd75w8eN2p4txRGVKd1Th54qLrKxMlBw\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "SecretKeyMissing",
            "description": "<p>The Mobile number should be 10 digit.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidSecretKey",
            "description": "<p>The Secret key is invalid.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"status_code\": 404,\n\"message\": \"User id missing.\",\n\"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"status_code\": 404,\n\"message\": \"Secret key missing.\",\n\"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"status_code\": 404,\n\"message\": \"Invalid Seceret key.\",\n\"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/api/send-otp",
    "title": "Send OTP",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostSendOtp",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile_number",
            "description": "<p>User unique mobile number*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email_id",
            "description": "<p>Email User email id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>User type*. (Staff member =&gt; 2 or Customer =&gt; 3).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>OTP sent successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n    \"status\": true,\n    \"status_code\": 200,\n    \"message\": \"OTP sent successfully.\",\n    \"data\": {}\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MobileNumberMissing",
            "description": "<p>The mobile number is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserTypeMissing",
            "description": "<p>The User type is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MobileNumber10Digit",
            "description": "<p>The Mobile number should be 10 digit.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidUserType",
            "description": "<p>The User invalid user type.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Mobile number missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"User type missing.\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"Mobile number should be 10 digit.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n    \"message\": \"User type invalid.\",\n    \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/api/verify-otp",
    "title": "Verify OTP",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostVerifyOtp",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile_number",
            "description": "<p>Users mobile number*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "otp",
            "description": "<p>OTP*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>User type*. (Staff member =&gt; 2 or Customer =&gt; 3).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_id",
            "description": "<p>User device Id (IMEI number)*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>OTP verified successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>User detail with unique token.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"status\": true,\n     \"status_code\": 200,\n     \"message\": \"OTP verified successfully.\",\n     \"data\": {\n         \"id\": 149,\n         \"cart_count\": 0,\n         \"user_name\": \"Om\",\n         \"first_name\": \"Om\",\n         \"mid_name\": \"\",\n         \"last_name\": \"\",\n         \"email_id\": \"om@mail.com\",\n         \"user_type_id\": 3,\n         \"is_checked_in\": false,\n         \"address\": \"\",\n         \"state\": \"\",\n         \"city\": \"\",\n         \"pincode\": \"\",\n         \"screen_name\": \"\",\n         \"profile_pic_path\": \"http://127.0.0.1:1234/img/no-image.jpg\",\n         \"mobile_number\": \"8077575835\",\n         \"token_type\": \"Bearer\",\n         \"access_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImMxMjM0MWFmY2JlMzYwMzEwMDEwYTllM2QzZTg0YjM2ZGQ4MDFmNjNmZDA4NzJkNGY2OTk4ODNiZjI0MTBmYmQ5YzVlOWFjYzY2YTMwZDNmIn0.eyJhdWQiOiI1IiwianRpIjoiYzEyMzQxYWZjYmUzNjAzMTAwMTBhOWUzZDNlODRiMzZkZDgwMWY2M2ZkMDg3MmQ0ZjY5OTg4M2JmMjQxMGZiZDljNWU5YWNjNjZhMzBkM2YiLCJpYXQiOjE1NTE2NzUzODcsIm5iZiI6MTU1MTY3NTM4NywiZXhwIjoxNTgzMjk3Nzg3LCJzdWIiOiIxNDkiLCJzY29wZXMiOltdfQ.KS-8efmZcedmsFzqD-AyCZ3jeL07HIvXbrrSnjlciTHl9oHlq5lwtT5UgC6bKaC9nHZx1MHDEKvEcft4SYiguszvhBeJmCSoigaGIKhVJEk-JLBtjA_KU6vqpJKsnC96X00f8lvqoHlNsttj0_4t0JoSCrp2ARbJ18WyRBGHCj1XYFXRzklukJPOX3T5KYQnLKj_op_n50_JUJnhaLX-KoLFFilvNMMuPGMYF-eVhsgQut4kqXgTnK8-6CRC01lk3X-8BCMKh1gtN2pG0KD3NqOapczuuv2raiafphe3OpZSRRsiRbh4KsG_2JX4_6CQ50qCerPy1hWm45sVT11mWb3DiuUgsXLgE4SqdCjmryFZy7AWb65R_DyCWLb0cWDkaMv8ulQfBcI8EHPg7ugUG5LzgSkoBOSitnU8qbD3YBGqhXIviI0yzgfwySPsErE1q1EsiEe_OranNibocSTMJLZn0T3DcPYkFPy5TbHG7N9twzuyAkx9LZ_AFNsDeNCl9U_p0YxFyCiBN6n4DLL3dCRzYPWOwD9NgTCtI-EyTSjvUuIoP9ELw2E7s7WsyPL09vxzo-S-qgrS8fe8aa573H5vgysF0UTmdbu17LFlhu-znYtUDUayPTsz9ThMa0F9X4O8rvYYgYDjluV9mBorv_9Ln2FcFiIFXFOtKAf9cgQ\",\n         \"source_name\": \"GOIBO\",\n         \"source_id\": \"GOIBO123456\",\n         \"resort_room_no\": \"T-2\",\n         \"room_type\": \"Tent\",\n         \"check_in_pin\": 7015,\n         \"check_out_pin\": 3336,\n         \"check_in_date\": \"04-Mar-2019\",\n         \"check_in_time\": \"12:00 AM\",\n         \"check_out_date\": \"30-Mar-2019\",\n         \"check_out_time\": \"10:00 AM\",\n         \"booking_id\": \"GOIBO123456\",\n         \"no_of_guest\": \"1 Adult and 1 Child\",\n         \"guest_detail\": [\n             {\n                 \"id\": 23,\n                 \"person_name\": \"Ankit\",\n                 \"person_age\": \"10\",\n                 \"person_type\": \"Child\"\n             },\n             {\n                 \"id\": 24,\n                 \"person_name\": \"Anshu\",\n                 \"person_age\": \"25\",\n                 \"person_type\": \"Adult\"\n            }\n        ],\n         \"membership\": {\n             \"membership_id\": \"ABCDE\",\n             \"valid_from\": \"04-Mar-2019 12:00 AM\",\n             \"valid_till\": \"07-Mar-2019 12:00 AM\"\n         },\n         \"resort\": {\n             \"id\": 2,\n             \"name\": \"Dintex\",\n             \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\",\n             \"amenities\": \"1#2#3#4#5#6#7#8#10\",\n             \"other_amenities\": \"Other Amenity\",\n             \"contact_number\": \"8588936238\",\n             \"other_contact_number\": null,\n             \"address_1\": \"U-701\",\n             \"address_2\": null,\n             \"address_3\": null,\n             \"pincode\": 201301,\n             \"city_id\": 181,\n             \"latitude\": 28.5355,\n             \"longitude\": 77.391,\n             \"is_active\": 1,\n             \"domain_id\": 0,\n             \"created_by\": \"1\",\n            \"updated_by\": \"1\",\n             \"created_at\": \"2018-12-20 21:19:14\",\n             \"updated_at\": \"2019-02-21 08:12:15\",\n             \"deleted_at\": null\n        }\n     }\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MobileNumberMissing",
            "description": "<p>The mobile number is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MobileNumber10Digit",
            "description": "<p>The Mobile number should be 10 digit.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "OTPMissing",
            "description": "<p>The OTP is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserTypeMissing",
            "description": "<p>The User Type is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidUserType",
            "description": "<p>The user type invalid</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "IncorrectOTP",
            "description": "<p>The OTP or mobile number incorrect.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Mobile number missing.\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Mobile number should be 10 digit.\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"OTP missing.\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"User type missing.\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"User type invalid.\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"OTP or mobile number incorrect.\",\n    \"data\": {}\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "get",
    "url": "/api/about-us",
    "title": "About us",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetAboutUs",
    "group": "CMS",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>about us found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"about us found.\",\n   \"data\": \"<p><span >About Us</span></p>\\n\\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\\n\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CmsController.php",
    "groupTitle": "CMS"
  },
  {
    "type": "get",
    "url": "/api/contact-us",
    "title": "Contact us",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetContactUs",
    "group": "CMS",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>contact us found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"status_code\": 200,\n    \"message\": \"contact us found.\",\n    \"data\": \"<h3>55 SE. Mechanic St.</h3><br><p>Coventry,</p><br><p> RI 02816</p>\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CmsController.php",
    "groupTitle": "CMS"
  },
  {
    "type": "get",
    "url": "/api/terms-conditions",
    "title": "Terms & Conditions",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetTermCondition",
    "group": "CMS",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>term &amp; condition found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"status\": true,\n     \"status_code\": 200,\n     \"message\": \"term & condition found.\",\n     \"data\": \"<h1>Terms &amp; Conditions</h1>\\n\\n<ul>\\n\\t<li>\\n\\t<p>Please read the following terms and conditions carefully as it sets out the terms of a legally binding agreement between you (the reader) and Business Standard Private Limited.</p>\\n\\t</li>\\n</ul>\\n\\n<h2>1) Introduction</h2>\\n\\n<ul>\\n\\t<li>\\n\\t<p>This following sets out the terms and conditions on which you may use the content on&nbsp;<br />\\n\\t</li>\\n</ul>\\n\\n<h2>2) Registration Access and Use</h2>\\n\\n<ul>\\n\\t<li>\\n\\t<p>We welcome users to register on our digital platforms. We offer the below mentioned registration services which may be subject to change in the future. All changes will be appended in the terms and conditions page and communicated to existing users by email.</p>\\n\\n\\t<p>Registration services are offered for individual subscribers only. If multiple individuals propose to access the same account or for corporate accounts kindly contact or write in to us. Subscription rates will vary for multiple same time access.</p>\\n\\t</li>\\n</ul>\\n\"\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CmsController.php",
    "groupTitle": "CMS"
  },
  {
    "type": "post",
    "url": "/api/sos",
    "title": "SOS",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostSOS",
    "group": "CMS",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<p>Latitude*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<p>Longitude*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Your emergency request submmited successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Your emergency request submmited successfully.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "LatitudeMissing",
            "description": "<p>The latitude is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "LongitudeMissing",
            "description": "<p>The Longitude is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Latitude missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Longitude missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CmsController.php",
    "groupTitle": "CMS"
  },
  {
    "type": "post",
    "url": "/api/submit-contact-us",
    "title": "Submit Contact us",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostSubmitContactUs",
    "group": "CMS",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "subject",
            "description": "<p>subject*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>message*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Your message submmited successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Your message submmited successfully.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "SubjectMissing",
            "description": "<p>The subject is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MessageMissing",
            "description": "<p>The Message is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Subject missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Message missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CmsController.php",
    "groupTitle": "CMS"
  },
  {
    "type": "get",
    "url": "/api/message-list",
    "title": "Chat message list",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetChatMessageList",
    "group": "Chat",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sender_id",
            "description": "<p>Sender id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "receiver_id",
            "description": "<p>Receiver id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Messages list.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>[].</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n        {\n            \"status\": false,\n            \"status_code\": 404,\n            \"message\": \"Messages list.\",\n            \"data\": [\n                {\n                    \"id\": 1,\n                    \"sender_id\": 93,\n                    \"receiver_id\": 94,\n                    \"message\": \"Hi\",\n                    \"is_view\": 0,\n                    \"created_at\": \"2019-04-18 18:10:11\",\n                    \"updated_at\": \"2019-04-18 18:10:11\",\n                    \"sender_detail\": {\n                        \"id\": 93,\n                        \"user_name\": \"SHYAM SINGH\",\n                        \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                    },\n                    \"receiver_detail\": {\n                        \"id\": 94,\n                        \"user_name\": \"HONEY KHERA\",\n                        \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                    }\n                },\n                {\n                    \"id\": 2,\n                    \"sender_id\": 94,\n                    \"receiver_id\": 93,\n                    \"message\": \"hello\",\n                    \"is_view\": 0,\n                    \"created_at\": \"2019-04-18 18:10:18\",\n                    \"updated_at\": \"2019-04-18 18:10:18\",\n                    \"sender_detail\": {\n                        \"id\": 94,\n                        \"user_name\": \"HONEY KHERA\",\n                        \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                    },\n                    \"receiver_detail\": {\n                        \"id\": 93,\n                        \"user_name\": \"SHYAM SINGH\",\n                        \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                    }\n                },\n                {\n                    \"id\": 3,\n                    \"sender_id\": 93,\n                    \"receiver_id\": 94,\n                    \"message\": \"How are you?\",\n                    \"is_view\": 0,\n                    \"created_at\": \"2019-04-18 18:10:42\",\n                    \"updated_at\": \"2019-04-18 18:10:42\",\n                    \"sender_detail\": {\n                        \"id\": 93,\n                        \"user_name\": \"SHYAM SINGH\",\n                        \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                    },\n                    \"receiver_detail\": {\n                        \"id\": 94,\n                        \"user_name\": \"HONEY KHERA\",\n                        \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                    }\n                },\n                {\n                    \"id\": 4,\n                    \"sender_id\": 94,\n                    \"receiver_id\": 93,\n                    \"message\": \"I am fine.\",\n                    \"is_view\": 0,\n                    \"created_at\": \"2019-04-18 18:10:51\",\n                    \"updated_at\": \"2019-04-18 18:10:51\",\n                    \"sender_detail\": {\n                        \"id\": 94,\n                        \"user_name\": \"HONEY KHERA\",\n                        \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                    },\n                    \"receiver_detail\": {\n                        \"id\": 93,\n                        \"user_name\": \"SHYAM SINGH\",\n                        \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                    }\n                },\n                {\n                    \"id\": 5,\n                    \"sender_id\": 94,\n                    \"receiver_id\": 93,\n                    \"message\": \"and you\",\n                    \"is_view\": 0,\n                    \"created_at\": \"2019-04-18 18:10:57\",\n                    \"updated_at\": \"2019-04-18 18:10:57\",\n                    \"sender_detail\": {\n                        \"id\": 94,\n                        \"user_name\": \"HONEY KHERA\",\n                        \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                    },\n                    \"receiver_detail\": {\n                        \"id\": 93,\n                        \"user_name\": \"SHYAM SINGH\",\n                        \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                    }\n                }\n            ]\n        }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "SenderIdMissing",
            "description": "<p>The Sender id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ReceiverIdMissing",
            "description": "<p>The Receiver id was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Sender id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Receiver id missing.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ChatController.php",
    "groupTitle": "Chat"
  },
  {
    "type": "get",
    "url": "/api/chat-user-list",
    "title": "User list",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetChatUserList",
    "group": "Chat",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Messages user list.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>[].</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n        {\n            \"status\": false,\n            \"status_code\": 404,\n            \"message\": \"Messages user list.\",\n            \"data\": [\n                {\n                    \"id\": 90,\n                    \"user_name\": \"AKHIL PRATAP SINGH\",\n                    \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                },\n                {\n                    \"id\": 94,\n                    \"user_name\": \"HONEY KHERA\",\n                    \"profile_pic_path\": \"http://127.0.0.1:8000/img/no-image.jpg\"\n                }\n            ]\n        }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User id missing.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ChatController.php",
    "groupTitle": "Chat"
  },
  {
    "type": "post",
    "url": "/api/send-message",
    "title": "Send Message",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostSendMessage",
    "group": "Chat",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sender_id",
            "description": "<p>Sender id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "receiver_id",
            "description": "<p>Receiver id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message send successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>[].</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n        {\n            \"status\": true,\n            \"status_code\": 200,\n            \"message\": \"Message send successfully.\",\n            \"data\": {}\n        }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "SenderIdMissing",
            "description": "<p>The Sender id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ReceiverMissing",
            "description": "<p>The Receiver was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MessageMissing",
            "description": "<p>The Message was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Sender id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Receiver id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Message missing.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ChatController.php",
    "groupTitle": "Chat"
  },
  {
    "type": "get",
    "url": "/api/health-program-listing",
    "title": "Healthcare programs listing & details",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetHealthcareProgram",
    "group": "Healthcare_Program",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort id* (For guest user use resort id value -1).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Activities found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"healthcare program found.\",\n      \"data\": [       \n          {\n              \"id\": 11,\n              \"name\": \"Healthcare Package Reverse Diabetes in 3 Days\",\n              \"description\": \"<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\",\n              \"start_from\": \"14-02-2019\",\n              \"end_to\": \"09-03-2019\",\n              \"total_days\": 3,\n              \"healthcare_images\": [\n                  {\n                      \"id\": 31,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/HUjdVCzjj1A51ak7ipjUg9oKWcKQs4dyAtOaOJpT.jpeg\",\n                      \"health_program_id\": 11\n                  },\n                  {\n                      \"id\": 32,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/VcE35u8GzY1FSprjK8aQBP3DSIG5fZoLOa8XYRSy.jpeg\",\n                      \"health_program_id\": 11\n                  }\n              ],\n              \"healthcare_days\": [\n                  {\n                      \"id\": 418,\n                      \"day\": \"3\",\n                      \"description\": \"<p><strong>05:00 AM : </strong>Wake Up</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>07:00 AM :</strong> Coconut Water</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>09:00 AM :</strong> Meditation/Massage</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>12:00 AM :</strong> Lunch</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>12:30 PM : </strong>Walk</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>03:00 PM :</strong> Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>03:30 PM :</strong> Consultancy</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>04:00 PM :</strong> Routine Check-up</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>06:00 PM :</strong> Dinner</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>07:00 PM :</strong> Spritual Classes</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>08:00 PM :</strong> Bed Time</p>\",\n                      \"health_program_id\": 11\n                  },\n                  {\n                      \"id\": 416,\n                      \"day\": \"1\",\n                      \"description\": \"<p><strong>05:00 AM : </strong>Wake Up</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>07:00 AM :</strong> Coconut Water</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\\r\\n\\r\\n<hr />\",\n                      \"health_program_id\": 11\n                  },\n                  {\n                      \"id\": 417,\n                      \"day\": \"2\",\n                      \"description\": \"<p><strong>05:00 AM : </strong>Wake Up</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>07:00 AM :</strong> Coconut Water</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>09:00 AM :</strong> Meditation/Massage</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>12:00 AM :</strong> Lunch</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>12:30 PM : </strong>Walk</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>03:00 PM :</strong> Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>03:30 PM :</strong> Consultancy</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>04:00 PM :</strong> Routine Check-up</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>06:00 PM :</strong> Dinner</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>07:00 PM :</strong> Spritual Classes</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>08:00 PM :</strong> Bed Time</p>\",\n                      \"health_program_id\": 11\n                  }\n              ]\n          },\n          {\n              \"id\": 14,\n              \"name\": \"Holiday Package\",\n              \"description\": \"<p>2Night and 3 Day</p>\",\n              \"start_from\": \"15-02-2019\",\n              \"end_to\": \"31-05-2019\",\n              \"total_days\": 3,\n              \"healthcare_images\": [\n                  {\n                      \"id\": 49,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/FJ6ZhivkTUozs9FANVwNYQZHlLkXlWd8n5L8v35J.jpeg\",\n                      \"health_program_id\": 14\n                  },\n                  {\n                      \"id\": 50,\n                      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/FeYWXm2Hho1m5l3fWtNWTfVE02KM4k8r3hfO3QYS.jpeg\",\n                      \"health_program_id\": 14\n                  }\n              ],\n              \"healthcare_days\": [\n                  {\n                      \"id\": 440,\n                      \"day\": \"1\",\n                      \"description\": \"<p>1</p>\",\n                      \"health_program_id\": 14\n                  },\n                  {\n                      \"id\": 441,\n                      \"day\": \"2\",\n                      \"description\": \"<p><br />\\r\\n2</p>\",\n                      \"health_program_id\": 14\n                  },\n                  {\n                      \"id\": 442,\n                      \"day\": \"3\",\n                      \"description\": \"<p>3</p>\",\n                      \"health_program_id\": 14\n                  }\n              ]\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Resort id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/HealthcareProgramController.php",
    "groupTitle": "Healthcare_Program"
  },
  {
    "type": "get",
    "url": "/api/my-health-program",
    "title": "My Healthcare Package",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetMyHealthcarePackage",
    "group": "Healthcare_Program",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>My Health Package.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"My Health Package\",\n      \"data\": {\n      \"id\": 6,\n      \"name\": \"Reverse Diabetes in 21 Days\",\n      \"description\": \"<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\",\n      \"start_from\": \"24-01-2019\",\n      \"end_to\": \"22-01-2019\",\n      \"healthcare_images\": [\n      {\n      \"id\": 17,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/Xj6B4ayTdL3F7AkLwGxH6VrfSVzHbkBf3yUregTa.jpeg\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 22,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/dHRAYPVxQkmw9yfLVScYCN5QUvO4OJ8NqQRBI0Ag.jpeg\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 23,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/2IjaxxOCWYNtHvFs564nkSrkyyKU0TQxddp0qyt0.jpeg\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 24,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/rTGNijkeoYlZB5xJqQk9JLYU7881mj6O0PqJfns2.jpeg\",\n      \"health_program_id\": 6\n      }\n      ],\n      \"healthcare_days\": [\n      {\n      \"id\": 326,\n      \"day\": \"2\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 325,\n      \"day\": \"1\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 327,\n      \"day\": \"3\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 328,\n      \"day\": \"4\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 329,\n      \"day\": \"5\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 330,\n      \"day\": \"6\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 331,\n      \"day\": \"7\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 332,\n      \"day\": \"8\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 333,\n      \"day\": \"9\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 334,\n      \"day\": \"10\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 335,\n      \"day\": \"11\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 336,\n      \"day\": \"12\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 337,\n      \"day\": \"13\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 338,\n      \"day\": \"14\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 339,\n      \"day\": \"15\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 340,\n      \"day\": \"16\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 341,\n      \"day\": \"17\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 342,\n      \"day\": \"18\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 343,\n      \"day\": \"19\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 344,\n      \"day\": \"20\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 345,\n      \"day\": \"21\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      }\n      ]\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/HealthcareProgramController.php",
    "groupTitle": "Healthcare_Program"
  },
  {
    "type": "get",
    "url": "/api/my-upcoming-complete-program",
    "title": "My Upcoming & Completed Healthcare Package",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetMyUpcomingCompleteHealthcarePackage",
    "group": "Healthcare_Program",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Upcoming &amp; Completed Health Package.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Health Package found\",\n      \"data\": {\n      \"complete\": [\n      {\n      \"id\": 11,\n      \"name\": \"Healthcare Package Reverse Diabetes in 3 Days\",\n      \"duration\": \"01-Feb-2019 to 02-Feb-2019\",\n      \"status\": \"Completed\"\n      }\n      ],\n      \"upcoming\": [\n      {\n      \"id\": 11,\n      \"record_id\": 45,\n      \"name\": \"Healthcare Package Reverse Diabetes in 3 Days\",\n      \"duration\": \"01-Apr-2019 to 03-Apr-2019\",\n      \"status\": \"Upcoming\"\n      }\n      ],\n      \"term_condition\":\"<p>lorem ipsumis the dummy text.....\"\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/HealthcareProgramController.php",
    "groupTitle": "Healthcare_Program"
  },
  {
    "type": "post",
    "url": "/api/cancel-package",
    "title": "Cancel Healthcare Package",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostCancelHealthcareProgram",
    "group": "Healthcare_Program",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "record_id",
            "description": "<p>Package record id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Upcoming &amp; Completed Health Package.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Healthcare package cancelled successsfully\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "RecordIdMissing",
            "description": "<p>The record id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Record id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/HealthcareProgramController.php",
    "groupTitle": "Healthcare_Program"
  },
  {
    "type": "post",
    "url": "/api/healthcare-booking",
    "title": "Healthcare booking",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostHealthcareProgramBooking",
    "group": "Healthcare_Program",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "health_care_id",
            "description": "<p>health care id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Health care Package booked.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Health care Package booked\",\n      \"data\": {}\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "HealthcareIdMissing",
            "description": "<p>The healthcare id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Health care id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/HealthcareProgramController.php",
    "groupTitle": "Healthcare_Program"
  },
  {
    "type": "get",
    "url": "/api/home",
    "title": "Home",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostHome",
    "group": "Home",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>service successfully access.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"service successfully access.\",\n      \"data\": {\n      \"user\": {\n      \"id\": 149,\n      \"user_name\": \"Om\",\n      \"mobile_number\": \"8077575835\",\n      \"email_id\": \"om@mail.com\",\n      \"voter_id\": \"http://127.0.0.1:1234/img/no-image.jpg\",\n      \"aadhar_id\": null,\n      \"address1\": \"\",\n      \"city_id\": 0,\n      \"user_type_id\": 3,\n      \"no_of_rooms\": \"1\",\n      \"notification_count\": 0,\n      \"cart_count\": 0,\n      \"user_health_detail\": null,\n      \"user_booking_detail\": {\n      \"id\": 43,\n      \"room_type_id\": 1,\n      \"check_in_pin\": 7015,\n      \"check_out_pin\": 3336,\n      \"resort_room_id\": 338,\n      \"user_id\": 149,\n      \"booking_id\": \"GOIBO123456\",\n      \"source_name\": \"GOIBO\",\n      \"resort_id\": 2,\n      \"package_id\": 6,\n      \"check_in\": \"04-Mar-2019\",\n      \"check_in_time\": \"12:00:00 AM\",\n      \"check_out\": \"30-Mar-2019\",\n      \"check_out_time\": \"10:00:00 AM\",\n      \"resort\": {\n      \"id\": 2,\n      \"name\": \"Dintex\",\n      \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\",\n      \"contact_number\": \"8588936238\",\n      \"address_1\": \"U-701\"\n      },\n      \"bookingpeople_accompany\": [\n      {\n      \"id\": 23,\n      \"person_name\": \"Ankit\",\n      \"person_age\": \"10\",\n      \"person_type\": \"Child\"\n      },\n      {\n      \"id\": 24,\n      \"person_name\": \"Anshu\",\n      \"person_age\": \"25\",\n      \"person_type\": \"Adult\"\n      }\n      ],\n      \"room_type_detail\": {\n      \"id\": 1,\n      \"name\": \"Tent\",\n      \"description\": \"<p>A modern two person, lightweight hiking dome tent; it is tied to rocks as there is nowhere to drive stakes on this rock shelf</p>\\r\\n\\r\\n<p>A&nbsp;<strong>tent</strong>&nbsp;(/tɛnt/) is a&nbsp;shelter&nbsp;consisting of sheets of&nbsp;fabric&nbsp;or other material draped over, attached to a frame of poles or attached to a supporting rope. While smaller tents may be free-standing or attached to the ground, large tents are usually anchored using&nbsp;guy ropes&nbsp;tied to stakes or&nbsp;tent pegs. First used as portable homes by&nbsp;nomads, tents are now more often used for recreational&nbsp;camping&nbsp;and as temporary shelters.</p>\\r\\n\\r\\n<p>They were also used by&nbsp;Native American&nbsp;and&nbsp;Canadian aboriginal&nbsp;tribes of the&nbsp;Plains Indians, called a teepee or&nbsp;tipi, noted for its cone shape and peak&nbsp;smoke-hole, since ancient times, variously estimated from 10,000 years BCE<sup>[1]</sup>&nbsp;to 4,000 BCE.<sup>[2]</sup></p>\\r\\n\\r\\n<p>Tents range in size from &quot;bivouac&quot; structures, just big enough for one person to sleep in, up to huge&nbsp;circus tents&nbsp;capable of seating thousands of people. The bulk of this article is concerned with tents used for recreational camping which have sleeping space for one to ten people. Larger tents are discussed in a separate section below.</p>\\r\\n\\r\\n<p>Tents for recreational camping fall into two categories. Tents intended to be carried by backpackers are the smallest and lightest type. Small tents may be sufficiently light that they can be carried for long distances on a&nbsp;touring bicycle, a&nbsp;boat, or when&nbsp;backpacking.</p>\\r\\n\\r\\n<p>The second type are larger, heavier tents which are usually carried in a car or other vehicle. Depending on tent size and the experience of the person or people involved, such tents can usually be assembled (pitched) in between 5 and 25 minutes; disassembly (striking) takes a similar length of time. Some very specialised tents have spring-loaded poles and can be &#39;pitched&#39; in seconds, but take somewhat longer to &#39;strike&#39; (take down and pack).</p>\",\n      \"icon\": \"http://127.0.0.1:1234/storage/room_icon/jIkGVEx07jhjpJeVw6x1Un5cwrYBiuNC8pkpzD6i.png\"\n      },\n      \"room_detail\": {\n      \"id\": 338,\n      \"resort_id\": 2,\n      \"room_type_id\": 1,\n      \"room_no\": \"T-2\"\n      }\n      }\n      },\n      \"banners\": [\n      {\n      \"id\": 7,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/banner_images/NtMHzZqOd4usHJ6cf7VY6meo5HbZ8iW8xHPCDoY5.jpeg\"\n      },\n      {\n      \"id\": 10,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/banner_images/3VMDIqLhAeZ49ZFPtsx88cS0roApDtILPaTYH9h3.jpeg\"\n      },\n      {\n      \"id\": 11,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/banner_images/DKUj5zAQMLw37kOCbB9cdd46zYZcL0qwtO3S8K8d.jpeg\"\n      },\n      {\n      \"id\": 12,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/banner_images/zZmNNMb1940r8ydLxRX6VESxebUI2LbFvDqAlOhP.jpeg\"\n      },\n      {\n      \"id\": 14,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/banner_images/u8VvcCIk1tdx3F917f1DxrAoUR47cGecol1J8Bjs.jpeg\"\n      },\n      {\n      \"id\": 15,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/banner_images/sRYRByOcSH2B57cqf7HBcjnK3dgK5GRaPxdcVGxq.jpeg\"\n      },\n      {\n      \"id\": 16,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/banner_images/qPnHOwfPO2Se58VpDXPubbV8ZPGsdu1St9aRzBH1.jpeg\"\n      },\n      {\n      \"id\": 17,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/banner_images/Ue9UTJXpjJqzWuMSNkAyqopUxiBCCwzWy20XMknk.jpeg\"\n      },\n      {\n      \"id\": 18,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/banner_images/Zul3MqJIS4VetnRo986mSjrAfNA6GNxXzNrAPjXo.jpeg\"\n      },\n      {\n      \"id\": 21,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/banner_images/LOWd8xqvSYryFAhiRHCXoXEHU9dU0zeCCAVxb8Je.jpeg\"\n      }\n      ],\n      \"nearby_attaractions\": [\n      {\n      \"id\": 8,\n      \"name\": \"Forest Research Institute\",\n      \"description\": \"<p>For a bargain entrance fee you get to enjoy the architecture and grounds, several brilliantly old-fashioned museums, and the botanical gardens (though the latter need quite a bit of attention). We wandered into the paper-making office and got a free guided tour of a disused mill by a Dr Gupta and his staff which was fantastic. One of the best afternoons we had in Dehradun and a complete accident! This place is definitely worth a visit.</p>\",\n      \"distance\": 15,\n      \"precautions\": \"<p>One of the Iconic places in India and especially in Dehradun. Student of the Year has been shot here, and after that, this place has become one of the most visited places in the town.</p>\",\n      \"address\": \"Mason Rd | Indian Military Academy, Dehradun - 248001\",\n      \"latitude\": 25.22222,\n      \"longitude\": 36.55555,\n      \"images\": [\n      {\n      \"id\": 16,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/nearby_images/KZMoKARmBBYICyyQjwkzbApwdS4KtA8cSMWE9XAL.jpeg\"\n      },\n      {\n      \"id\": 20,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/nearby_images/qiSrpffmBDT8DO3ZqE8xeoswKqFJ7kwsesqoyzoJ.jpeg\"\n      }\n      ]\n      },\n      {\n      \"id\": 7,\n      \"name\": \"Tibetan Buddhist Temple\",\n      \"description\": \"<p>Buddha Temple is a Tibetan monestary, also called as Mindrolling Monastery and was build in 1965 by his eminence the Kochen Rinpoche and few other monks for the promotion and protection of religious &amp;amp; cultural understanding of Buddhism. Built in Japanese architecture style, Buddha Temple complex atmosphere provides a mental peace equal to Buddhist monk. Buddha temple complex was created as one of the four schools of Tibetan religion. This temple complex is known as &#39;Nyigma&#39; while other schools known as Sakya, Kagyu and Geluk respectively.</p>\",\n      \"distance\": 28,\n      \"precautions\": \"<p>Temple garden and shops are open for all seven days for but temple remains open for Sunday only for public.Visitors are requested to remove shoes before entering the main hall of Buddha temple.</p>\",\n      \"address\": \"New Basti, Clement Town Uttrakhand Dehradun-248197\",\n      \"latitude\": 30.3231,\n      \"longitude\": 78.0473,\n      \"images\": [\n      {\n      \"id\": 14,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/nearby_images/PeIZtPLOGu0nCi4WCW7nRPUT6o5sMxfjfwnz4V13.jpeg\"\n      }\n      ]\n      }\n      ],\n      \"best_offers\": [\n      {\n      \"id\": 9,\n      \"name\": \"New Year Eve Party @Le Maridien, New Delhi\",\n      \"description\": \"<p>Located close to tourist attractions in Mysore, Fortune JP Palace offers comfortable rooms, delicious food and luxuries like swimming pool.</p>\\r\\n\\r\\n<p><strong>Location:&nbsp;</strong><em>Situated in the heart of the grand old city of Mysore, the Fortune JP Palace is well-connected to many major tourist attractions. Mysore Palace is 2 km away and St. Philomena&#39;s Church a 5 minute walk from the hotel. The hotel is 15 km away from Mysore International Airport and 3 km away from Mysore Railway Station.</em></p>\\r\\n\\r\\n<p><strong>Room Amenities:&nbsp;</strong><em>Guests can choose from a total of 108 rooms that are categorised into Standard, Fortune Club rooms and Suites. The hotel also has an accessible room. Most of the rooms have an impeccable view of the Chamundi Hills and come equipped with all modern amenities. Amenities include a flat-screen TV, high-speed internet connectivity, mini-bar, electronic safe, tea/coffee maker and iron/ironing board.</em></p>\\r\\n\\r\\n<p><strong>Hotel Facilities:&nbsp;</strong><em>With laundry service and 24-hour room service, guests never have to worry about any of their daily chores during their stay. The Tulip Spa is renowned for the rejuvenating experience it offers with an array of holistic and Ayurvedic programmes to choose from. Other facilities include a swimming pool, steam room and fitness centre.</em></p>\\r\\n\\r\\n<p><strong>Dining:&nbsp;</strong><em>Orchid is the 24-hour restaurant that offers an array of culinary delight and sumptuous buffets, ideal for a luncheon meeting or a relaxed dinner. The Oriental Pavilion is open only for dinner and serves authentic Oriental cuisine in a modern, contemporary setting. Neptune Bar &amp; Lounge is the perfect place to relax and unwind after a tiring day, with an excellent selection of spirits and wines. The Terrace Grill &amp; Tandoor offers a mesmerizing view of the Chamundi Hills, combined with diffused lighting and lounge music.</em></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li><em>FREE Breakfast</em></li>\\r\\n\\t<li><em>Two bottles of mineral water on daily basis in the room</em></li>\\r\\n\\t<li><em>Fruit Basket &amp; Cookies</em></li>\\r\\n\\t<li><em>10% Discount on F&amp;b &amp; Laundry</em></li>\\r\\n\\t<li><em>Accommodation</em></li>\\r\\n</ul>\",\n      \"valid_to\": \"Mar-20-2019\",\n      \"price\": 4999,\n      \"discount\": \"10% OFF\",\n      \"discounted_price\": 4500,\n      \"offer_images\": [\n      {\n      \"id\": 23,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/teiCziEAsMEw5504WytwxptrVnZx62mBAsCxf8sg.jpeg\",\n      \"offer_id\": 9\n      },\n      {\n      \"id\": 24,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/6wBQmgwEgwmEqQfkCEjZ02eag9wmrr8G4aICPERP.jpeg\",\n      \"offer_id\": 9\n      }\n      ]\n      },\n      {\n      \"id\": 8,\n      \"name\": \"Reverse Diabetes Package for 21 Days @ Sanjeevani\",\n      \"description\": \"<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\\r\\n\\r\\n<h1><strong>Day Routine Plan</strong></h1>\\r\\n\\r\\n<p>05:00 AM: Wake Up</p>\\r\\n\\r\\n<p>05:30 AM: Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM: Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM: Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM: Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM: Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM: Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM: Lunch</p>\\r\\n\\r\\n<p>12:30 PM: Walk</p>\\r\\n\\r\\n<p>03:00 PM: Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM: Consultancy</p>\\r\\n\\r\\n<p>04:00 PM: Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM: Dinner</p>\\r\\n\\r\\n<p>07:00 PM: Spiritual Classes</p>\\r\\n\\r\\n<p>08:00 PM: Bed Time</p>\",\n      \"valid_to\": \"Jan-31-2019\",\n      \"price\": 49999,\n      \"discount\": \"10% OFF\",\n      \"discounted_price\": 45000,\n      \"offer_images\": [\n      {\n      \"id\": 21,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/8373Pl3Ku7pO4AWXg0aPgumXuXyTbTEHY54wgb5t.jpeg\",\n      \"offer_id\": 8\n      },\n      {\n      \"id\": 22,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/x8BdhjL6Vs1FES7jLTA2M860F4vR44uAPWPJyhjD.jpeg\",\n      \"offer_id\": 8\n      }\n      ]\n      },\n      {\n      \"id\": 7,\n      \"name\": \"Amazing Offer of 3N-4D @Sanjeevani Resort\",\n      \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\\r\\n\\r\\n<h1><strong>Terms &amp; Conditions</strong></h1>\\r\\n\\r\\n<ul>\\r\\n\\t<li>The free cancellation is applicable on select hotels. Please check the cancellation policy while booking. The policy will be mentioned while making the hotel booking and in the booking confirmation voucher sent to the customer.</li>\\r\\n\\t<li>The hotel cancellation policy will apply on any cancellation done by the customer.</li>\\r\\n\\t<li>There is no restriction on travel dates.</li>\\r\\n\\t<li>This is only applicable to&nbsp;online hotel bookings made via&nbsp;www.makemytrip.com&nbsp;and MakeMyTrip mobile app (Android and iOS only).</li>\\r\\n\\t<li>User Agreement and Privacy Policy at MakeMyTrip website shall apply. MakeMyTrip will be entitled to reject any claim in case there is any abuse/misuse of the offer by the customer or the cancellation/claim is not eligible under the offer.</li>\\r\\n\\t<li>Travel agents, by occupation, are barred from making bookings for their customers and MakeMyTrip reserves the right to deny the offer against such bookings or to cancel such bookings.</li>\\r\\n\\t<li>MakeMyTrip reserves the right, without notice or liability and without assigning any reasons whatsoever, to add, alter, modify, change or vary all or any of these terms and conditions or to replace, wholly or in part, this Offer by another Offer, whether similar to this Offer or not, or to withdraw it altogether at any point in time by providing appropriate notice.</li>\\r\\n\\t<li>All decisions with respect to the offer shall be at the discretion of MakeMyTrip and the same shall be final, binding and non-contestable.</li>\\r\\n\\t<li>The terms and conditions shall be governed by the laws of India. Any dispute arising out of or in relation to this offer shall be subject to the exclusive jurisdiction of competent courts in New Delhi.</li>\\r\\n\\t<li>The maximum liability of MakeMyTrip in the event of any claim arising out of this offer shall not exceed the amount under the underlying transaction paid by the customer.</li>\\r\\n\\t<li>MakeMyTrip shall not be liable to pay for any indirect, punitive, special, incidental or consequential damages arising out of or in connection with the offer.</li>\\r\\n\\t<li>Breakfast</li>\\r\\n\\t<li>Complimentary stay for children under 5 without extra bed</li>\\r\\n\\t<li>Complimentary Mineral Water Daily: 1 bottle</li>\\r\\n\\t<li>Complimentary Tea/Coffee Maker with Daily Replenishments</li>\\r\\n\\t<li>Buffet breakfast at a multicuisine restaurant</li>\\r\\n</ul>\",\n      \"valid_to\": \"Jan-31-2019\",\n      \"price\": 17999,\n      \"discount\": \"15% OFF\",\n      \"discounted_price\": 15300,\n      \"offer_images\": [\n      {\n      \"id\": 19,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/ZjOeKoMM51fz1iV9rIz1zM3RKy1mU3bNTaBreAy8.jpeg\",\n      \"offer_id\": 7\n      },\n      {\n      \"id\": 20,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/cpgxq1oAGgcMhpkFvwBBwwAUDYzilxdU6KxHNYmT.jpeg\",\n      \"offer_id\": 7\n      }\n      ]\n      },\n      {\n      \"id\": 5,\n      \"name\": \"Valentines Day Offer\",\n      \"description\": \"<p>Chocolate and flowers and officially done. This year, give your S.O. a gift they&rsquo;ll never forget&mdash;a stay at a luxurious hotel with added perks guaranteed to put you in the mood. Sweet dreams ;)</p>\\r\\n\\r\\n<p>_____________________________________________________________________</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Room Amenities:&nbsp;</strong><em>Guests can choose from a total of 108 rooms that are categorised into Standard, Fortune Club rooms and Suites. The hotel also has an accessible room. Most of the rooms have an impeccable view of the Chamundi Hills and come equipped with all modern amenities. Amenities include a flat-screen TV, high-speed internet connectivity, mini-bar, electronic safe, tea/coffee maker and iron/ironing board.</em></p>\\r\\n\\r\\n<p>_____________________________________________________________________</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Hotel Facilities:&nbsp;</strong><em>With laundry service and 24-hour room service, guests never have to worry about any of their daily chores during their stay. The Tulip Spa is renowned for the rejuvenating experience it offers with an array of holistic and Ayurvedic programmes to choose from. Other facilities include a swimming pool, steam room, and fitness centre.</em></p>\\r\\n\\r\\n<p>_____________________________________________________________________</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Dining:&nbsp;</strong><em>Orchid is the 24-hour restaurant that offers an array of culinary delight and sumptuous buffets, ideal for a luncheon meeting or a relaxed dinner. The Oriental Pavilion is open only for dinner and serves authentic Oriental cuisine in a modern, contemporary setting. Neptune Bar &amp; Lounge is the perfect place to relax and unwind after a tiring day, with an excellent selection of spirits and wines. The Terrace Grill &amp; Tandoor offers a mesmerizing view of the Chamundi Hills, combined with diffused lighting and lounge music.</em></p>\\r\\n\\r\\n<p>_____________________________________________________________________</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<ul>\\r\\n\\t<li><em>FREE Breakfast</em></li>\\r\\n\\t<li><em>Two bottles of mineral water on a daily basis in the room</em></li>\\r\\n\\t<li><em>Fruit Basket &amp; Cookies</em></li>\\r\\n\\t<li><em>10% Discount on F&amp;b &amp; Laundry</em></li>\\r\\n\\t<li><em>Accommodation</em></li>\\r\\n</ul>\",\n      \"valid_to\": \"Feb-17-2019\",\n      \"price\": 13000,\n      \"discount\": \"25% OFF\",\n      \"discounted_price\": 9750,\n      \"offer_images\": [\n      {\n      \"id\": 17,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/Cq5X48lXqVJOEcbi0yYNkKeitYboDLAyxmqmSSDV.jpeg\",\n      \"offer_id\": 5\n      }\n      ]\n      }\n      ],\n      \"health_care\": [\n      {\n      \"id\": 14,\n      \"name\": \"Holiday Package\",\n      \"description\": \"<p>2Night and 3 Day</p>\",\n      \"start_from\": \"15-02-2019\",\n      \"end_to\": \"31-05-2019\",\n      \"total_days\": 3,\n      \"healthcare_images\": [\n      {\n      \"id\": 49,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/FJ6ZhivkTUozs9FANVwNYQZHlLkXlWd8n5L8v35J.jpeg\",\n      \"health_program_id\": 14\n      },\n      {\n      \"id\": 50,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/FeYWXm2Hho1m5l3fWtNWTfVE02KM4k8r3hfO3QYS.jpeg\",\n      \"health_program_id\": 14\n      }\n      ],\n      \"healthcare_days\": [\n      {\n      \"id\": 440,\n      \"day\": \"1\",\n      \"description\": \"<p>1</p>\",\n      \"health_program_id\": 14\n      },\n      {\n      \"id\": 441,\n      \"day\": \"2\",\n      \"description\": \"<p><br />\\r\\n2</p>\",\n      \"health_program_id\": 14\n      },\n      {\n      \"id\": 442,\n      \"day\": \"3\",\n      \"description\": \"<p>3</p>\",\n      \"health_program_id\": 14\n      }\n      ]\n      },\n      {\n      \"id\": 11,\n      \"name\": \"Healthcare Package Reverse Diabetes in 3 Days\",\n      \"description\": \"<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\",\n      \"start_from\": \"14-02-2019\",\n      \"end_to\": \"09-03-2019\",\n      \"total_days\": 3,\n      \"healthcare_images\": [\n      {\n      \"id\": 31,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/HUjdVCzjj1A51ak7ipjUg9oKWcKQs4dyAtOaOJpT.jpeg\",\n      \"health_program_id\": 11\n      },\n      {\n      \"id\": 32,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/VcE35u8GzY1FSprjK8aQBP3DSIG5fZoLOa8XYRSy.jpeg\",\n      \"health_program_id\": 11\n      }\n      ],\n      \"healthcare_days\": [\n      {\n      \"id\": 418,\n      \"day\": \"3\",\n      \"description\": \"<p><strong>05:00 AM : </strong>Wake Up</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>07:00 AM :</strong> Coconut Water</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>09:00 AM :</strong> Meditation/Massage</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>12:00 AM :</strong> Lunch</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>12:30 PM : </strong>Walk</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>03:00 PM :</strong> Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>03:30 PM :</strong> Consultancy</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>04:00 PM :</strong> Routine Check-up</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>06:00 PM :</strong> Dinner</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>07:00 PM :</strong> Spritual Classes</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>08:00 PM :</strong> Bed Time</p>\",\n      \"health_program_id\": 11\n      },\n      {\n      \"id\": 416,\n      \"day\": \"1\",\n      \"description\": \"<p><strong>05:00 AM : </strong>Wake Up</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>07:00 AM :</strong> Coconut Water</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\\r\\n\\r\\n<hr />\",\n      \"health_program_id\": 11\n      },\n      {\n      \"id\": 417,\n      \"day\": \"2\",\n      \"description\": \"<p><strong>05:00 AM : </strong>Wake Up</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>07:00 AM :</strong> Coconut Water</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>09:00 AM :</strong> Meditation/Massage</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>12:00 AM :</strong> Lunch</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>12:30 PM : </strong>Walk</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>03:00 PM :</strong> Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>03:30 PM :</strong> Consultancy</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>04:00 PM :</strong> Routine Check-up</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>06:00 PM :</strong> Dinner</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>07:00 PM :</strong> Spritual Classes</p>\\r\\n\\r\\n<hr />\\r\\n<p><strong>08:00 PM :</strong> Bed Time</p>\",\n      \"health_program_id\": 11\n      }\n      ]\n      },\n      {\n      \"id\": 9,\n      \"name\": \"Healthcare Package Reverse Diabetes in 7 Days\",\n      \"description\": \"<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\",\n      \"start_from\": \"24-01-2019\",\n      \"end_to\": \"28-02-2019\",\n      \"total_days\": 7,\n      \"healthcare_images\": [\n      {\n      \"id\": 25,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/1Gtjax1vMjsVrOguQE1APXC0Jl32ZyKxJ6Lku0j6.jpeg\",\n      \"health_program_id\": 9\n      },\n      {\n      \"id\": 26,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/gNHZv5TbtoCja85UCT2DRUMWTQTIFmISfjfQUky3.jpeg\",\n      \"health_program_id\": 9\n      },\n      {\n      \"id\": 27,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/CcfvNS5TnJmvp278HJPrX3RyN5Sc7Upr4cVKWP48.png\",\n      \"health_program_id\": 9\n      }\n      ],\n      \"healthcare_days\": [\n      {\n      \"id\": 346,\n      \"day\": \"1\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 9\n      },\n      {\n      \"id\": 347,\n      \"day\": \"2\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 9\n      },\n      {\n      \"id\": 348,\n      \"day\": \"3\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 9\n      },\n      {\n      \"id\": 349,\n      \"day\": \"4\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 9\n      },\n      {\n      \"id\": 350,\n      \"day\": \"5\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 9\n      },\n      {\n      \"id\": 351,\n      \"day\": \"6\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 9\n      },\n      {\n      \"id\": 352,\n      \"day\": \"7\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 9\n      }\n      ]\n      },\n      {\n      \"id\": 8,\n      \"name\": \"Reverse Diabetes in 14 Days\",\n      \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\",\n      \"start_from\": \"02-03-2019\",\n      \"end_to\": \"25-03-2019\",\n      \"total_days\": 14,\n      \"healthcare_images\": [\n      {\n      \"id\": 21,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/vPypbA0VfuqyqyId4lqXdieGZECKTfThR7tJoAFu.jpeg\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 20,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/Nacs301RGy2W19tRktcbzJPeADaTNEtFne99GgnT.jpeg\",\n      \"health_program_id\": 8\n      }\n      ],\n      \"healthcare_days\": [\n      {\n      \"id\": 381,\n      \"day\": \"14\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 380,\n      \"day\": \"13\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 379,\n      \"day\": \"12\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 378,\n      \"day\": \"11\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 377,\n      \"day\": \"10\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 376,\n      \"day\": \"9\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 375,\n      \"day\": \"8\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 374,\n      \"day\": \"7\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 373,\n      \"day\": \"6\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 372,\n      \"day\": \"5\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 371,\n      \"day\": \"4\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 370,\n      \"day\": \"3\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 369,\n      \"day\": \"2\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      },\n      {\n      \"id\": 368,\n      \"day\": \"1\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 8\n      }\n      ]\n      },\n      {\n      \"id\": 6,\n      \"name\": \"Reverse Diabetes in 21 Days\",\n      \"description\": \"<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>___________________________________________________________________________</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\",\n      \"start_from\": \"24-01-2019\",\n      \"end_to\": \"22-01-2019\",\n      \"total_days\": 21,\n      \"healthcare_images\": [\n      {\n      \"id\": 17,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/Xj6B4ayTdL3F7AkLwGxH6VrfSVzHbkBf3yUregTa.jpeg\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 22,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/dHRAYPVxQkmw9yfLVScYCN5QUvO4OJ8NqQRBI0Ag.jpeg\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 23,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/2IjaxxOCWYNtHvFs564nkSrkyyKU0TQxddp0qyt0.jpeg\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 24,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/healthcare_images/rTGNijkeoYlZB5xJqQk9JLYU7881mj6O0PqJfns2.jpeg\",\n      \"health_program_id\": 6\n      }\n      ],\n      \"healthcare_days\": [\n      {\n      \"id\": 326,\n      \"day\": \"2\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 325,\n      \"day\": \"1\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 327,\n      \"day\": \"3\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 328,\n      \"day\": \"4\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 329,\n      \"day\": \"5\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 330,\n      \"day\": \"6\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 331,\n      \"day\": \"7\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 332,\n      \"day\": \"8\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 333,\n      \"day\": \"9\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 334,\n      \"day\": \"10\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 335,\n      \"day\": \"11\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 336,\n      \"day\": \"12\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 337,\n      \"day\": \"13\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 338,\n      \"day\": \"14\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 339,\n      \"day\": \"15\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 340,\n      \"day\": \"16\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 341,\n      \"day\": \"17\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 342,\n      \"day\": \"18\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 343,\n      \"day\": \"19\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 344,\n      \"day\": \"20\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      },\n      {\n      \"id\": 345,\n      \"day\": \"21\",\n      \"description\": \"<p>05:00 AM : Wake Up</p>\\r\\n\\r\\n<p>05:30 AM : Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM : Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM : Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM : Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM : Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM : Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM : Lunch</p>\\r\\n\\r\\n<p>12:30 PM : Walk</p>\\r\\n\\r\\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM : Consultancy</p>\\r\\n\\r\\n<p>04:00 PM : Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM : Dinner</p>\\r\\n\\r\\n<p>07:00 PM : Spritual Classes</p>\\r\\n\\r\\n<p>08:00 PM : Bed Time</p>\",\n      \"health_program_id\": 6\n      }\n      ]\n      }\n      ]\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/HomeController.php",
    "groupTitle": "Home"
  },
  {
    "type": "get",
    "url": "/api/country-list",
    "title": "Country list",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetCountryList",
    "group": "Master_Api",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Country list.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>[].</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n        {\n            \"status\": true,\n            \"status_code\": 200,\n            \"message\": \"country list\",\n            \"data\": {\n                \"countries\": [\n                    {\n                        \"id\": 1,\n                        \"conutry\": \"India\",\n                        \"calling_code\": \"+91\",\n                        \"created_by\": \"0\",\n                        \"updated_by\": \"0\",\n                        \"is_active\": 1,\n                        \"created_at\": null,\n                        \"updated_at\": null\n                    },\n                    {\n                        \"id\": 2,\n                        \"conutry\": \"USA\",\n                        \"calling_code\": \"+1\",\n                        \"created_by\": \"0\",\n                        \"updated_by\": \"0\",\n                        \"is_active\": 1,\n                        \"created_at\": null,\n                        \"updated_at\": null\n                    }\n                ]\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/LocationController.php",
    "groupTitle": "Master_Api"
  },
  {
    "type": "get",
    "url": "/api/meal-listing",
    "title": "Category wise meal listing",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetMealList",
    "group": "Meal",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort id* (For guest user use resort id value -1).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Meal list found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Meal list found\",\n      \"data\": {\n      \"meal_packages\": [\n      {\n      \"id\": 12,\n      \"name\": \"Breakfast plate\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_package_images/d1OJlyJx3ndLeYjcUREJ4R3WqWMsU0lHOFHaTEyc.jpeg\",\n      \"price\": 110,\n      \"quantity_count\": 0,\n      \"meal_items\": [\n      {\n      \"id\": 320,\n      \"description\": \"dummy,\n      \"category\": \"N\",\n      \"name\": \"Boiled Egg\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/nRJmJEkN9VsB4zIfMljsdrZMoEg8FZIhLAAbtIT0.jpeg\",\n      \"price\": 50\n      },\n      {\n      \"id\": 319,\n      \"description\": \"dummy,\n      \"category\": \"V\",\n      \"name\": \"sandwich\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/sIfdcO4ALhCtuXnjuKUQFUkLgng60aqI19xGb54W.jpeg\",\n      \"price\": 60\n      }\n      ]\n      },\n      {\n      \"id\": 17,\n      \"name\": \"Lunch  Thali\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_package_images/WMsWtVgGih3ygCElWvTB3Bne8aky9mOlEi1gBXB6.jpeg\",\n      \"price\": 300,\n      \"quantity_count\": 0,\n      \"meal_items\": [\n      {\n      \"id\": 349,\n      \"description\": \"dummy\",\n      \"category\": \"V\",\n      \"name\": \"PLAIN RICE\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/9nVLxxSxxoIJrzYptXjDh6g9HqwvKEv6kWVwZfOZ.jpeg\",\n      \"price\": 80\n      },\n      {\n      \"id\": 350,\n      \"description\": \"dummy\",\n      \"category\": \"V\",\n      \"name\": \"kadhai paneer\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/ASBKXtmGAdOx3t6U6CApm5xFol4jD4Z9Ic1KTrYr.png\",\n      \"price\": 250\n      },\n      {\n      \"id\": 351,\n      \"description\": \"dummy\",     *\n      \"category\": \"V\",\n      \"name\": \"Mix Veg\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/smHJD5kcICVSGdXwqcUCN1kmRP0NBfGbIETSwI5i.jpeg\",\n      \"price\": 180\n      },\n      {\n      \"id\": 352,\n      \"description\": \"dummy\",\n      \"category\": \"V\",\n      \"name\": \"plain roti\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/84ijg5Hmk6PzAl9PJjtWn4LDMysDcqbIQjNWKfGT.jpeg\",\n      \"price\": 40\n      },\n      {\n      \"id\": 353,\n      \"description\": \"dummy\",\n      \"category\": \"V\",\n      \"name\": \"Dal Tadka\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/6usfxv12m2LGrsjEZZDzJwFIAJUptpffhLlC6dp2.png\",\n      \"price\": 150\n      },\n      {\n      \"id\": 354,\n      \"category\": \"V\",\n      \"name\": \"Gulab Jamun\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/jAZzRh54dEuvIHb1WkqwJ6i326KsXB4t1xD9ZrIb.png\",\n      \"price\": 180\n      },\n      {\n      \"id\": 355,\n      \"category\": \"V\",\n      \"name\": \"salad\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/TEns8pKMUyNyMA4jytMSHBhUZ8aFv8JrEQQuKrLq.png\",\n      \"price\": 60\n      }\n      ]\n      },\n      {\n      \"id\": 18,\n      \"name\": \"chineese combo\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_package_images/NUGLOiA2tQzWa0wraaKNoMvNi060mlkUg140Daoa.png\",\n      \"price\": 499,\n      \"quantity_count\": 0,\n      \"meal_items\": [\n      {\n      \"id\": 356,\n      \"category\": \"V\",\n      \"name\": \"paneer chilli\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/KCYhJdLYoqMGfY1dbrdjj5jhYh81MDw2VN37xzRu.jpeg\",\n      \"price\": 120\n      },\n      {\n      \"id\": 357,\n      \"category\": \"V\",\n      \"name\": \"fried rice\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/zhbbuV8PWazi6knF34xsz4cl5X3udziYzRqG7not.jpeg\",\n      \"price\": 150\n      },\n      {\n      \"id\": 358,\n      \"category\": \"V\",\n      \"name\": \"manchurian\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/JfwGmY8ZuHVN7DbkWOrOsAXptr8eauRsJyCl01tW.jpeg\",\n      \"price\": 180\n      },\n      {\n      \"id\": 359,\n      \"category\": \"V\",\n      \"name\": \"Noddles\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/nNDZyYixSFEAEVJUS7JqzaPMc9OQv9SyoJ8iYbJS.jpeg\",\n      \"price\": 110\n      },\n      {\n      \"id\": 360,\n      \"category\": \"V\",\n      \"name\": \"momos\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/OqT8aMlBYvDbyCvEt9qp7uwYJMY2MbZHFzEc58ON.png\",\n      \"price\": 160\n      },\n      {\n      \"id\": 361,\n      \"category\": \"V\",\n      \"name\": \"Honey Chilly Potato\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/W3ad3Cw3L70II97UTxp6mds8haigE3ym5qyZuODp.jpeg\",\n      \"price\": 160\n      }\n      ]\n      },\n      {\n      \"id\": 19,\n      \"name\": \"non veg combo\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_package_images/OjG5Op6DiVXmoNz1m4C3SdjdqZ53rxqhCWoEfnSM.jpeg\",\n      \"price\": 699,\n      \"quantity_count\": 0,\n      \"meal_items\": [\n      {\n      \"id\": 476,\n      \"category\": \"V\",\n      \"name\": \"Lemonade\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/CZ38GDAHzP1GZci06uqgtujD1XUbEiP2QfToQnW3.png\",\n      \"price\": 100\n      },\n      {\n      \"id\": 475,\n      \"category\": \"N\",\n      \"name\": \"chicken curry\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/aGtC5OCtA61SCVP7gJWqJoP4X9YR9V5dKs1e5pyb.jpeg\",\n      \"price\": 250\n      },\n      {\n      \"id\": 474,\n      \"category\": \"N\",\n      \"name\": \"chicken korma\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/csYH8B1Y3qkiBbaY6UkXG1tPnBwI0uv1ZoQU0sDk.png\",\n      \"price\": 250\n      },\n      {\n      \"id\": 473,\n      \"category\": \"N\",\n      \"name\": \"chicken lollypop\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/QNQb0Kxqz4PnFOFagMQGh6IRKlrxt2JOBuSr7oxx.jpeg\",\n      \"price\": 280\n      }\n      ]\n      },\n      {\n      \"id\": 20,\n      \"name\": \"north indian meal\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_package_images/FrQVok1muRTbH81WBsRwd9GvSSN40KE5CTU49Ni7.jpeg\",\n      \"price\": 599,\n      \"quantity_count\": 0,\n      \"meal_items\": [\n      {\n      \"id\": 484,\n      \"category\": \"V\",\n      \"name\": \"salad\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/TEns8pKMUyNyMA4jytMSHBhUZ8aFv8JrEQQuKrLq.png\",\n      \"price\": 60\n      },\n      {\n      \"id\": 483,\n      \"category\": \"V\",\n      \"name\": \"Gulab Jamun\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/jAZzRh54dEuvIHb1WkqwJ6i326KsXB4t1xD9ZrIb.png\",\n      \"price\": 180\n      },\n      {\n      \"id\": 482,\n      \"category\": \"V\",\n      \"name\": \"Gobhi Aloo\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/vwxpkeC2NumVWn8aFbH8sn1RGsTxLSyybDu4my8T.jpeg\",\n      \"price\": 160\n      },\n      {\n      \"id\": 481,\n      \"category\": \"V\",\n      \"name\": \"Dal Tadka\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/6usfxv12m2LGrsjEZZDzJwFIAJUptpffhLlC6dp2.png\",\n      \"price\": 150\n      },\n      {\n      \"id\": 480,\n      \"category\": \"V\",\n      \"name\": \"fried rice\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/zhbbuV8PWazi6knF34xsz4cl5X3udziYzRqG7not.jpeg\",\n      \"price\": 150\n      },\n      {\n      \"id\": 479,\n      \"category\": \"V\",\n      \"name\": \"Mix Veg\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/smHJD5kcICVSGdXwqcUCN1kmRP0NBfGbIETSwI5i.jpeg\",\n      \"price\": 180\n      },\n      {\n      \"id\": 478,\n      \"category\": \"V\",\n      \"name\": \"kadhai paneer\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/ASBKXtmGAdOx3t6U6CApm5xFol4jD4Z9Ic1KTrYr.png\",\n      \"price\": 250\n      },\n      {\n      \"id\": 477,\n      \"category\": \"V\",\n      \"name\": \"sahi paneer\",\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/dH7a9n2oAjLDXLpojsTCJryvfWHDU9TfVTZcnvi1.png\",\n      \"price\": 280\n      }\n      ]\n      }\n      ],\n      \"category_meal\": [\n      {\n      \"id\": 1,\n      \"name\": \"Starter\",\n      \"menu_items\": [\n      {\n      \"id\": 71,\n      \"name\": \"paneer tikka\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/kLWKjpmGYiX26nNIQmhB2apz5ksljU3qHxmHVMx0.jpeg\",\n      \"price\": 160,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 73,\n      \"name\": \"paneer chilli\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/KCYhJdLYoqMGfY1dbrdjj5jhYh81MDw2VN37xzRu.jpeg\",\n      \"price\": 120,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 94,\n      \"name\": \"tandoori chaap\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/oaywSvhvfc0zgKhnQ56bxWU8xrJeKs2nPKpz2JSO.jpeg\",\n      \"price\": 140,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 97,\n      \"name\": \"chicken lollypop\",\n      \"category\": \"N\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/QNQb0Kxqz4PnFOFagMQGh6IRKlrxt2JOBuSr7oxx.jpeg\",\n      \"price\": 280,\n      \"quantity_count\": 0\n      }\n      ]\n      },\n      {\n      \"id\": 2,\n      \"name\": \"Main Course\",\n      \"menu_items\": [\n      {\n      \"id\": 64,\n      \"name\": \"RAJMA\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/pXsMGTYbpM1wY49aI1owtNR49qiNQPDYOKuXW26V.jpeg\",\n      \"price\": 110,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 65,\n      \"name\": \"PLAIN RICE\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/9nVLxxSxxoIJrzYptXjDh6g9HqwvKEv6kWVwZfOZ.jpeg\",\n      \"price\": 80,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 67,\n      \"name\": \"CHOLE BHATURE\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/k7QYBVtKUdMcDQtzqZq0ab9aJDloUhMf7zDQ4lnF.jpeg\",\n      \"price\": 80,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 72,\n      \"name\": \"chicken biryani\",\n      \"category\": \"N\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/ZFOEhkPJNVBn4j7QUYT4JMkGG1imB8Ydt2vDH4d0.jpeg\",\n      \"price\": 250,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 78,\n      \"name\": \"paneer do-pyaza\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/UwvJiWEDgg8ouxhKsrc63HO2LsyzE1fjmjNlQciE.jpeg\",\n      \"price\": 250,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 79,\n      \"name\": \"sahi paneer\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/dH7a9n2oAjLDXLpojsTCJryvfWHDU9TfVTZcnvi1.png\",\n      \"price\": 280,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 80,\n      \"name\": \"kadhai paneer\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/ASBKXtmGAdOx3t6U6CApm5xFol4jD4Z9Ic1KTrYr.png\",\n      \"price\": 250,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 81,\n      \"name\": \"Mix Veg\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/smHJD5kcICVSGdXwqcUCN1kmRP0NBfGbIETSwI5i.jpeg\",\n      \"price\": 180,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 82,\n      \"name\": \"fried rice\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/zhbbuV8PWazi6knF34xsz4cl5X3udziYzRqG7not.jpeg\",\n      \"price\": 150,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 83,\n      \"name\": \"plain roti\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/84ijg5Hmk6PzAl9PJjtWn4LDMysDcqbIQjNWKfGT.jpeg\",\n      \"price\": 40,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 90,\n      \"name\": \"manchurian\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/JfwGmY8ZuHVN7DbkWOrOsAXptr8eauRsJyCl01tW.jpeg\",\n      \"price\": 180,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 91,\n      \"name\": \"Dal Tadka\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/6usfxv12m2LGrsjEZZDzJwFIAJUptpffhLlC6dp2.png\",\n      \"price\": 150,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 95,\n      \"name\": \"Chaap\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/kIhETAhnq4xpy1H9NvVXDP74YNQ8MEAnTVUQh9zh.jpeg\",\n      \"price\": 210,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 99,\n      \"name\": \"chicken korma\",\n      \"category\": \"N\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/csYH8B1Y3qkiBbaY6UkXG1tPnBwI0uv1ZoQU0sDk.png\",\n      \"price\": 250,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 100,\n      \"name\": \"chicken curry\",\n      \"category\": \"N\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/aGtC5OCtA61SCVP7gJWqJoP4X9YR9V5dKs1e5pyb.jpeg\",\n      \"price\": 250,\n      \"quantity_count\": 0\n      }\n      ]\n      },\n      {\n      \"id\": 4,\n      \"name\": \"Vegetables\",\n      \"menu_items\": [\n      {\n      \"id\": 89,\n      \"name\": \"Gobhi Aloo\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/vwxpkeC2NumVWn8aFbH8sn1RGsTxLSyybDu4my8T.jpeg\",\n      \"price\": 160,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 102,\n      \"name\": \"Aloo Shimla mirch\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/eAd3IXUZaskpB6YRXt6cyURl0boOcVEka1cglME7.jpeg\",\n      \"price\": 110,\n      \"quantity_count\": 0\n      }\n      ]\n      },\n      {\n      \"id\": 5,\n      \"name\": \"Desserts\",\n      \"menu_items\": [\n      {\n      \"id\": 85,\n      \"name\": \"Moong Dal halwa\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/MlNwkXbTniqYIiqP4hu2IqQ6Aax75gPLbyXMCiLI.png\",\n      \"price\": 210,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 87,\n      \"name\": \"Rabdi\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/lztOqLHyrFKUHVosijAA9oMbHo0nfxe2UfdddIRq.png\",\n      \"price\": 210,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 88,\n      \"name\": \"Gulab Jamun\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/jAZzRh54dEuvIHb1WkqwJ6i326KsXB4t1xD9ZrIb.png\",\n      \"price\": 180,\n      \"quantity_count\": 0\n      }\n      ]\n      },\n      {\n      \"id\": 6,\n      \"name\": \"Miscellaneous\",\n      \"menu_items\": [\n      {\n      \"id\": 68,\n      \"name\": \"sandwich\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/sIfdcO4ALhCtuXnjuKUQFUkLgng60aqI19xGb54W.jpeg\",\n      \"price\": 60,\n      \"quantity_count\": 0\n      }\n      ]\n      },\n      {\n      \"id\": 9,\n      \"name\": \"Beverages\",\n      \"menu_items\": [\n      {\n      \"id\": 103,\n      \"name\": \"Lemonade\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/CZ38GDAHzP1GZci06uqgtujD1XUbEiP2QfToQnW3.png\",\n      \"price\": 100,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 104,\n      \"name\": \"Vanilla Shake\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/k1qXLXvanNIBBfTzJMIEh8EoKDFMSiT1BfOcdS48.png\",\n      \"price\": 120,\n      \"quantity_count\": 0\n      }\n      ]\n      },\n      {\n      \"id\": 12,\n      \"name\": \"Appetizers\",\n      \"menu_items\": [\n      {\n      \"id\": 69,\n      \"name\": \"Boiled Egg\",\n      \"category\": \"N\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/nRJmJEkN9VsB4zIfMljsdrZMoEg8FZIhLAAbtIT0.jpeg\",\n      \"price\": 50,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 70,\n      \"name\": \"samosa\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/MHpic0E7NvA9tQ8OTaIjOo66BXaR90vqYeNoUe59.jpeg\",\n      \"price\": 60,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 84,\n      \"name\": \"Noddles\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/nNDZyYixSFEAEVJUS7JqzaPMc9OQv9SyoJ8iYbJS.jpeg\",\n      \"price\": 110,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 86,\n      \"name\": \"momos\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/OqT8aMlBYvDbyCvEt9qp7uwYJMY2MbZHFzEc58ON.png\",\n      \"price\": 160,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 92,\n      \"name\": \"Honey Chilly Potato\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/W3ad3Cw3L70II97UTxp6mds8haigE3ym5qyZuODp.jpeg\",\n      \"price\": 160,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 93,\n      \"name\": \"pav bhaji\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/amzN3YLVsnRCXPXaeTqY4EYf1W9rDKXpHLo0DhdU.png\",\n      \"price\": 110,\n      \"quantity_count\": 0\n      },\n      {\n      \"id\": 96,\n      \"name\": \"salad\",\n      \"category\": \"V\",\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/meal_images/TEns8pKMUyNyMA4jytMSHBhUZ8aFv8JrEQQuKrLq.png\",\n      \"price\": 60,\n      \"quantity_count\": 0\n      }\n      ]\n      }\n      ]\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Resort id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/MealController.php",
    "groupTitle": "Meal"
  },
  {
    "type": "get",
    "url": "/api/notification-list",
    "title": "Notification list",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetNotificationList",
    "group": "Notification",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Notifications.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Json Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Notifications\",\n   \"data\": [\n       {\n           \"id\": 1,\n           \"title\": \"Lorem Ipsum\",\n           \"message\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\",\n           \"type\": 1,\n           \"date\": \"27-Nov-2018\",\n           \"time\": \"05:00:00 AM\"\n       },\n       {\n           \"id\": 2,\n           \"title\": \"Lorem Ipsum\",\n           \"message\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\",\n           \"type\": 1,\n           \"date\": \"27-Nov-2018\",\n           \"time\": \"05:00:00 AM\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"User id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/NotificationController.php",
    "groupTitle": "Notification"
  },
  {
    "type": "get",
    "url": "/api/offer-listing",
    "title": "Offer listing & details",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetOfferListDetail",
    "group": "Offer",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort Id* (For guest user use resort id value -1).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>offers found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"offers found\",\n      \"data\": [\n      {\n      \"id\": 5,\n      \"name\": \"Valentines Day Offer\",\n      \"description\": \"<p>Chocolate and flowers and officially done. This year, give your S.O. a gift they&rsquo;ll never forget&mdash;a stay at a luxurious hotel with added perks guaranteed to put you in the mood. Sweet dreams ;)</p>\\r\\n\\r\\n<p>_____________________________________________________________________</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Room Amenities:&nbsp;</strong><em>Guests can choose from a total of 108 rooms that are categorised into Standard, Fortune Club rooms and Suites. The hotel also has an accessible room. Most of the rooms have an impeccable view of the Chamundi Hills and come equipped with all modern amenities. Amenities include a flat-screen TV, high-speed internet connectivity, mini-bar, electronic safe, tea/coffee maker and iron/ironing board.</em></p>\\r\\n\\r\\n<p>_____________________________________________________________________</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Hotel Facilities:&nbsp;</strong><em>With laundry service and 24-hour room service, guests never have to worry about any of their daily chores during their stay. The Tulip Spa is renowned for the rejuvenating experience it offers with an array of holistic and Ayurvedic programmes to choose from. Other facilities include a swimming pool, steam room, and fitness centre.</em></p>\\r\\n\\r\\n<p>_____________________________________________________________________</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Dining:&nbsp;</strong><em>Orchid is the 24-hour restaurant that offers an array of culinary delight and sumptuous buffets, ideal for a luncheon meeting or a relaxed dinner. The Oriental Pavilion is open only for dinner and serves authentic Oriental cuisine in a modern, contemporary setting. Neptune Bar &amp; Lounge is the perfect place to relax and unwind after a tiring day, with an excellent selection of spirits and wines. The Terrace Grill &amp; Tandoor offers a mesmerizing view of the Chamundi Hills, combined with diffused lighting and lounge music.</em></p>\\r\\n\\r\\n<p>_____________________________________________________________________</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<ul>\\r\\n\\t<li><em>FREE Breakfast</em></li>\\r\\n\\t<li><em>Two bottles of mineral water on a daily basis in the room</em></li>\\r\\n\\t<li><em>Fruit Basket &amp; Cookies</em></li>\\r\\n\\t<li><em>10% Discount on F&amp;b &amp; Laundry</em></li>\\r\\n\\t<li><em>Accommodation</em></li>\\r\\n</ul>\",\n      \"valid_to\": \"Feb-17-2019\",\n      \"price\": 13000,\n      \"discount\": \"25% OFF\",\n      \"discounted_price\": 9750,\n      \"offer_images\": [\n      {\n      \"id\": 17,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/Cq5X48lXqVJOEcbi0yYNkKeitYboDLAyxmqmSSDV.jpeg\",\n      \"offer_id\": 5\n      }\n      ]\n      },\n      {\n      \"id\": 7,\n      \"name\": \"Amazing Offer of 3N-4D @Sanjeevani Resort\",\n      \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\\r\\n\\r\\n<h1><strong>Terms &amp; Conditions</strong></h1>\\r\\n\\r\\n<ul>\\r\\n\\t<li>The free cancellation is applicable on select hotels. Please check the cancellation policy while booking. The policy will be mentioned while making the hotel booking and in the booking confirmation voucher sent to the customer.</li>\\r\\n\\t<li>The hotel cancellation policy will apply on any cancellation done by the customer.</li>\\r\\n\\t<li>There is no restriction on travel dates.</li>\\r\\n\\t<li>This is only applicable to&nbsp;online hotel bookings made via&nbsp;www.makemytrip.com&nbsp;and MakeMyTrip mobile app (Android and iOS only).</li>\\r\\n\\t<li>User Agreement and Privacy Policy at MakeMyTrip website shall apply. MakeMyTrip will be entitled to reject any claim in case there is any abuse/misuse of the offer by the customer or the cancellation/claim is not eligible under the offer.</li>\\r\\n\\t<li>Travel agents, by occupation, are barred from making bookings for their customers and MakeMyTrip reserves the right to deny the offer against such bookings or to cancel such bookings.</li>\\r\\n\\t<li>MakeMyTrip reserves the right, without notice or liability and without assigning any reasons whatsoever, to add, alter, modify, change or vary all or any of these terms and conditions or to replace, wholly or in part, this Offer by another Offer, whether similar to this Offer or not, or to withdraw it altogether at any point in time by providing appropriate notice.</li>\\r\\n\\t<li>All decisions with respect to the offer shall be at the discretion of MakeMyTrip and the same shall be final, binding and non-contestable.</li>\\r\\n\\t<li>The terms and conditions shall be governed by the laws of India. Any dispute arising out of or in relation to this offer shall be subject to the exclusive jurisdiction of competent courts in New Delhi.</li>\\r\\n\\t<li>The maximum liability of MakeMyTrip in the event of any claim arising out of this offer shall not exceed the amount under the underlying transaction paid by the customer.</li>\\r\\n\\t<li>MakeMyTrip shall not be liable to pay for any indirect, punitive, special, incidental or consequential damages arising out of or in connection with the offer.</li>\\r\\n\\t<li>Breakfast</li>\\r\\n\\t<li>Complimentary stay for children under 5 without extra bed</li>\\r\\n\\t<li>Complimentary Mineral Water Daily: 1 bottle</li>\\r\\n\\t<li>Complimentary Tea/Coffee Maker with Daily Replenishments</li>\\r\\n\\t<li>Buffet breakfast at a multicuisine restaurant</li>\\r\\n</ul>\",\n      \"valid_to\": \"Jan-31-2019\",\n      \"price\": 17999,\n      \"discount\": \"15% OFF\",\n      \"discounted_price\": 15300,\n      \"offer_images\": [\n      {\n      \"id\": 19,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/ZjOeKoMM51fz1iV9rIz1zM3RKy1mU3bNTaBreAy8.jpeg\",\n      \"offer_id\": 7\n      },\n      {\n      \"id\": 20,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/cpgxq1oAGgcMhpkFvwBBwwAUDYzilxdU6KxHNYmT.jpeg\",\n      \"offer_id\": 7\n      }\n      ]\n      },\n      {\n      \"id\": 8,\n      \"name\": \"Reverse Diabetes Package for 21 Days @ Sanjeevani\",\n      \"description\": \"<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\\r\\n\\r\\n<h1><strong>Day Routine Plan</strong></h1>\\r\\n\\r\\n<p>05:00 AM: Wake Up</p>\\r\\n\\r\\n<p>05:30 AM: Fasting Sugar</p>\\r\\n\\r\\n<p>05:45 AM: Tulsi - Ginger Tea</p>\\r\\n\\r\\n<p>06:00 AM: Walk/Yoga</p>\\r\\n\\r\\n<p>07:00 AM: Coconut Water</p>\\r\\n\\r\\n<p>08:00 AM: Salad Breakfast</p>\\r\\n\\r\\n<p>09:00 AM: Meditation/Massage</p>\\r\\n\\r\\n<p>12:00 AM: Lunch</p>\\r\\n\\r\\n<p>12:30 PM: Walk</p>\\r\\n\\r\\n<p>03:00 PM: Banana/Cashew/Almond Shake</p>\\r\\n\\r\\n<p>03:30 PM: Consultancy</p>\\r\\n\\r\\n<p>04:00 PM: Routine Check-up</p>\\r\\n\\r\\n<p>06:00 PM: Dinner</p>\\r\\n\\r\\n<p>07:00 PM: Spiritual Classes</p>\\r\\n\\r\\n<p>08:00 PM: Bed Time</p>\",\n      \"valid_to\": \"Jan-31-2019\",\n      \"price\": 49999,\n      \"discount\": \"10% OFF\",\n      \"discounted_price\": 45000,\n      \"offer_images\": [\n      {\n      \"id\": 21,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/8373Pl3Ku7pO4AWXg0aPgumXuXyTbTEHY54wgb5t.jpeg\",\n      \"offer_id\": 8\n      },\n      {\n      \"id\": 22,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/x8BdhjL6Vs1FES7jLTA2M860F4vR44uAPWPJyhjD.jpeg\",\n      \"offer_id\": 8\n      }\n      ]\n      },\n      {\n      \"id\": 9,\n      \"name\": \"New Year Eve Party @Le Maridien, New Delhi\",\n      \"description\": \"<p>Located close to tourist attractions in Mysore, Fortune JP Palace offers comfortable rooms, delicious food and luxuries like swimming pool.</p>\\r\\n\\r\\n<p><strong>Location:&nbsp;</strong><em>Situated in the heart of the grand old city of Mysore, the Fortune JP Palace is well-connected to many major tourist attractions. Mysore Palace is 2 km away and St. Philomena&#39;s Church a 5 minute walk from the hotel. The hotel is 15 km away from Mysore International Airport and 3 km away from Mysore Railway Station.</em></p>\\r\\n\\r\\n<p><strong>Room Amenities:&nbsp;</strong><em>Guests can choose from a total of 108 rooms that are categorised into Standard, Fortune Club rooms and Suites. The hotel also has an accessible room. Most of the rooms have an impeccable view of the Chamundi Hills and come equipped with all modern amenities. Amenities include a flat-screen TV, high-speed internet connectivity, mini-bar, electronic safe, tea/coffee maker and iron/ironing board.</em></p>\\r\\n\\r\\n<p><strong>Hotel Facilities:&nbsp;</strong><em>With laundry service and 24-hour room service, guests never have to worry about any of their daily chores during their stay. The Tulip Spa is renowned for the rejuvenating experience it offers with an array of holistic and Ayurvedic programmes to choose from. Other facilities include a swimming pool, steam room and fitness centre.</em></p>\\r\\n\\r\\n<p><strong>Dining:&nbsp;</strong><em>Orchid is the 24-hour restaurant that offers an array of culinary delight and sumptuous buffets, ideal for a luncheon meeting or a relaxed dinner. The Oriental Pavilion is open only for dinner and serves authentic Oriental cuisine in a modern, contemporary setting. Neptune Bar &amp; Lounge is the perfect place to relax and unwind after a tiring day, with an excellent selection of spirits and wines. The Terrace Grill &amp; Tandoor offers a mesmerizing view of the Chamundi Hills, combined with diffused lighting and lounge music.</em></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li><em>FREE Breakfast</em></li>\\r\\n\\t<li><em>Two bottles of mineral water on daily basis in the room</em></li>\\r\\n\\t<li><em>Fruit Basket &amp; Cookies</em></li>\\r\\n\\t<li><em>10% Discount on F&amp;b &amp; Laundry</em></li>\\r\\n\\t<li><em>Accommodation</em></li>\\r\\n</ul>\",\n      \"valid_to\": \"Mar-20-2019\",\n      \"price\": 4999,\n      \"discount\": \"10% OFF\",\n      \"discounted_price\": 4500,\n      \"offer_images\": [\n      {\n      \"id\": 23,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/teiCziEAsMEw5504WytwxptrVnZx62mBAsCxf8sg.jpeg\",\n      \"offer_id\": 9\n      },\n      {\n      \"id\": 24,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/offer_images/6wBQmgwEgwmEqQfkCEjZ02eag9wmrr8G4aICPERP.jpeg\",\n      \"offer_id\": 9\n      }\n      ]\n      }\n      ]\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Resort id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/OfferController.php",
    "groupTitle": "Offer"
  },
  {
    "type": "get",
    "url": "/api/invoice-list-detail",
    "title": "Invoice listing & details",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetInvoiceListDetail",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>invoices list found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>invoice detail.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Order created succeffully.\",\n      \"data\": {\n          \"total_amount\": 0,\n          \"outstanding_amount\": 0,\n          \"paid_amount\": 0,\n          \"discount_price\": \"0\",\n          \"discount_percentage\": 0,\n          \"booking_detail\": {\n              \"booking_amount\": 1500,\n              \"booking_amount_type\": \"Outstanding\",\n              \"booking_source\": \"\"\n              },\n          \"invoices\": [\n              {\n                  \"id\": 5,\n                  \"invoice_id\": \"1544009535\",\n                  \"item_total_amount\": 1175,\n                  \"gst_amount\": 0,\n                  \"total_amount\": 1175,\n                  \"created_on\": \"05-12-2018\",\n                  \"order_items\": [\n                      {\n                          \"id\": 13,\n                          \"meal_item_name\": \"Pepsi\",\n                          \"quantity\": 2,\n                          \"price\": 55,\n                          \"meal_order_id\": 5\n                      },\n                      {\n                          \"id\": 14,\n                          \"meal_item_name\": \"Panner\",\n                          \"quantity\": 3,\n                          \"price\": 120,\n                          \"meal_order_id\": 5\n                      },\n                      {\n                          \"id\": 15,\n                          \"meal_item_name\": \"test\",\n                          \"quantity\": 3,\n                          \"price\": 1000,\n                          \"meal_order_id\": 5\n                      }\n                  ]\n              },\n              {\n                  \"id\": 6,\n                  \"invoice_id\": \"1544009626\",\n                  \"item_total_amount\": 1175,\n                  \"gst_amount\": 0,\n                  \"total_amount\": 1175,\n                  \"created_on\": \"05-12-2018\",\n                  \"order_items\": [\n                      {\n                          \"id\": 16,\n                          \"meal_item_name\": \"Pepsi\",\n                          \"quantity\": 2,\n                          \"price\": 55,\n                          \"meal_order_id\": 6\n                      },\n                      {\n                          \"id\": 17,\n                          \"meal_item_name\": \"Panner\",\n                          \"quantity\": 3,\n                          \"price\": 120,\n                          \"meal_order_id\": 6\n                      },\n                      {\n                          \"id\": 18,\n                          \"meal_item_name\": \"test\",\n                          \"quantity\": 3,\n                          \"price\": 1000,\n                          \"meal_order_id\": 6\n                      }\n                  ]\n              },\n              {\n                  \"id\": 7,\n                  \"invoice_id\": \"1544009691\",\n                  \"item_total_amount\": 1175,\n                  \"gst_amount\": 0,\n                  \"total_amount\": 1175,\n                  \"created_on\": \"05-12-2018\",\n                  \"order_items\": [\n                      {\n                          \"id\": 19,\n                          \"meal_item_name\": \"Pepsi\",\n                          \"quantity\": 2,\n                          \"price\": 55,\n                          \"meal_order_id\": 7\n                      },\n                      {\n                          \"id\": 20,\n                          \"meal_item_name\": \"Panner\",\n                          \"quantity\": 3,\n                          \"price\": 120,\n                          \"meal_order_id\": 7\n                      },\n                      {\n                          \"id\": 21,\n                          \"meal_item_name\": \"test\",\n                          \"quantity\": 3,\n                          \"price\": 1000,\n                          \"meal_order_id\": 7\n                      }\n                  ]\n              }\n          ]\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User id missing.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/OrderController.php",
    "groupTitle": "Order"
  },
  {
    "type": "get",
    "url": "/api/my-cart",
    "title": "My cart",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetMyCart",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>my cart list.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>cart detail.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"my cart list\",\n      \"data\": {\n      \"cart_items\": [\n      {\n      \"id\": 218,\n      \"type\": 1,\n      \"item_id\": 69,\n      \"image_url\": \"http://127.0.0.1:1234/storage/meal_images/nRJmJEkN9VsB4zIfMljsdrZMoEg8FZIhLAAbtIT0.jpeg\",\n      \"category\": \"N\",\n      \"item_name\": \"Boiled Egg\",\n      \"item_price\": 50,\n      \"quantity\": 1\n      }\n      ],\n      \"total_no_item\": 1,\n      \"item_amount\": 50,\n      \"gst\": \"3\",\n      \"gst_percentage\": \"5%\",\n      \"total_amount\": \"53\"\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidUser",
            "description": "<p>The user is invalid.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Invalid user.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CartController.php",
    "groupTitle": "Order"
  },
  {
    "type": "post",
    "url": "/api/add-item-cart",
    "title": "Add item to cart",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostAddItemCart",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>1=&gt;Meal item, 2=&gt; Meal package Item*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "meal_item_id",
            "description": "<p>Meal item id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "meal_package_id",
            "description": "<p>Meal Package Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "quantity",
            "description": "<p>Quantity*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flag",
            "description": "<p>Increment or add =&gt; 1, Decrement =&gt; 2*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Item added to cart.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>cart detail.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Item added to cart\",\n      \"data\": {\n      \"cart_count\": 1,\n      \"quantity_count\": \"1\"\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "typeMissing",
            "description": "<p>The type was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "mealItemIdMissing",
            "description": "<p>The meal_item_id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "quantityMissing",
            "description": "<p>The quantity was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "flagMissing",
            "description": "<p>The flag was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidUser",
            "description": "<p>The user is invalid.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"type missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Meal item id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"quantity missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"flag missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Invalid user.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CartController.php",
    "groupTitle": "Order"
  },
  {
    "type": "post",
    "url": "/api/create-order",
    "title": "Create Order",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostCreateOrder",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Order create successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>invoice Id.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"We will serve your food soon.\",\n      \"data\": {\n      \"invoice_id\": 1551681813,\n      \"total_amount\": 53\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidUser",
            "description": "<p>The user is invalid.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidResort",
            "description": "<p>The resort is invalid.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Invalid user.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Resort id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Invalid resort.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/OrderController.php",
    "groupTitle": "Order"
  },
  {
    "type": "get",
    "url": "/api/nearby-list-detail",
    "title": "Nearby place list & detail",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetNearbyListDetail",
    "group": "Resort",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Nearby place found found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Json data.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Nearby places found.\",\n      \"data\": {\n      \"nearby\": [\n      {\n      \"id\": 7,\n      \"name\": \"Tibetan Buddhist Temple\",\n      \"description\": \"<p>Buddha Temple is a Tibetan monestary, also called as Mindrolling Monastery and was build in 1965 by his eminence the Kochen Rinpoche and few other monks for the promotion and protection of religious &amp;amp; cultural understanding of Buddhism. Built in Japanese architecture style, Buddha Temple complex atmosphere provides a mental peace equal to Buddhist monk. Buddha temple complex was created as one of the four schools of Tibetan religion. This temple complex is known as &#39;Nyigma&#39; while other schools known as Sakya, Kagyu and Geluk respectively.</p>\",\n      \"distance\": 28,\n      \"precautions\": \"<p>Temple garden and shops are open for all seven days for but temple remains open for Sunday only for public.Visitors are requested to remove shoes before entering the main hall of Buddha temple.</p>\",\n      \"address\": \"New Basti, Clement Town Uttrakhand Dehradun-248197\",\n      \"latitude\": 30.3231,\n      \"longitude\": 78.0473,\n      \"images\": [\n      {\n      \"id\": 14,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/nearby_images/PeIZtPLOGu0nCi4WCW7nRPUT6o5sMxfjfwnz4V13.jpeg\"\n      }\n      ]\n      },\n      {\n      \"id\": 8,\n      \"name\": \"Forest Research Institute\",\n      \"description\": \"<p>For a bargain entrance fee you get to enjoy the architecture and grounds, several brilliantly old-fashioned museums, and the botanical gardens (though the latter need quite a bit of attention). We wandered into the paper-making office and got a free guided tour of a disused mill by a Dr Gupta and his staff which was fantastic. One of the best afternoons we had in Dehradun and a complete accident! This place is definitely worth a visit.</p>\",\n      \"distance\": 15,\n      \"precautions\": \"<p>One of the Iconic places in India and especially in Dehradun. Student of the Year has been shot here, and after that, this place has become one of the most visited places in the town.</p>\",\n      \"address\": \"Mason Rd | Indian Military Academy, Dehradun - 248001\",\n      \"latitude\": 25.22222,\n      \"longitude\": 36.55555,\n      \"images\": [\n      {\n      \"id\": 16,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/nearby_images/KZMoKARmBBYICyyQjwkzbApwdS4KtA8cSMWE9XAL.jpeg\"\n      },\n      {\n      \"id\": 20,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/nearby_images/qiSrpffmBDT8DO3ZqE8xeoswKqFJ7kwsesqoyzoJ.jpeg\"\n      }\n      ]\n      }\n      ]\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Resort id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User id missing.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/NearbyController.php",
    "groupTitle": "Resort"
  },
  {
    "type": "get",
    "url": "/api/resort-detail",
    "title": "Resort detail",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetResortDetail",
    "group": "Resort",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Resort found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Json data.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Resort found.\",\n      \"data\": {\n      \"resort\": {\n      \"id\": 2,\n      \"amenities\": \"1#2#3#4#5#6#7#8#10\",\n      \"other_amenities\": \"Other Amenity\",\n      \"name\": \"Dintex\",\n      \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\",\n      \"address\": \"U-701\",\n      \"latitude\": 28.5355,\n      \"longitude\": 77.391,\n      \"room_types\": [\n      {\n      \"id\": 1,\n      \"name\": \"Tent\",\n      \"icon\": \"http://127.0.0.1:1234/storage/room_icon/jIkGVEx07jhjpJeVw6x1Un5cwrYBiuNC8pkpzD6i.png\",\n      \"description\": \"<p>A modern two person, lightweight hiking dome tent; it is tied to rocks as there is nowhere to drive stakes on this rock shelf</p>\\r\\n\\r\\n<p>A&nbsp;<strong>tent</strong>&nbsp;(/tɛnt/) is a&nbsp;shelter&nbsp;consisting of sheets of&nbsp;fabric&nbsp;or other material draped over, attached to a frame of poles or attached to a supporting rope. While smaller tents may be free-standing or attached to the ground, large tents are usually anchored using&nbsp;guy ropes&nbsp;tied to stakes or&nbsp;tent pegs. First used as portable homes by&nbsp;nomads, tents are now more often used for recreational&nbsp;camping&nbsp;and as temporary shelters.</p>\\r\\n\\r\\n<p>They were also used by&nbsp;Native American&nbsp;and&nbsp;Canadian aboriginal&nbsp;tribes of the&nbsp;Plains Indians, called a teepee or&nbsp;tipi, noted for its cone shape and peak&nbsp;smoke-hole, since ancient times, variously estimated from 10,000 years BCE<sup>[1]</sup>&nbsp;to 4,000 BCE.<sup>[2]</sup></p>\\r\\n\\r\\n<p>Tents range in size from &quot;bivouac&quot; structures, just big enough for one person to sleep in, up to huge&nbsp;circus tents&nbsp;capable of seating thousands of people. The bulk of this article is concerned with tents used for recreational camping which have sleeping space for one to ten people. Larger tents are discussed in a separate section below.</p>\\r\\n\\r\\n<p>Tents for recreational camping fall into two categories. Tents intended to be carried by backpackers are the smallest and lightest type. Small tents may be sufficiently light that they can be carried for long distances on a&nbsp;touring bicycle, a&nbsp;boat, or when&nbsp;backpacking.</p>\\r\\n\\r\\n<p>The second type are larger, heavier tents which are usually carried in a car or other vehicle. Depending on tent size and the experience of the person or people involved, such tents can usually be assembled (pitched) in between 5 and 25 minutes; disassembly (striking) takes a similar length of time. Some very specialised tents have spring-loaded poles and can be &#39;pitched&#39; in seconds, but take somewhat longer to &#39;strike&#39; (take down and pack).</p>\",\n      \"room_images\": [\n      {\n      \"id\": 15,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/room_images/n1nqaIsGBJ6Gy1vA25y5uR3WisGNd1mPpmf7zqFE.jpeg\"\n      },\n      {\n      \"id\": 16,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/room_images/5vX4d5MPS7DPWv2dqfffDeCVqhJqQOLYS2rNf3PV.jpeg\"\n      },\n      {\n      \"id\": 17,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/room_images/QeW6Q1awh2HiHI88QbnGHV4oXA2Mq5IVk6E681xE.jpeg\"\n      }\n      ]\n      },\n      {\n      \"id\": 4,\n      \"name\": \"Villa\",\n      \"icon\": \"http://127.0.0.1:1234/storage/room_icon/NhK1cwngieiju9smBG58SqQgJGE7gQfaymDMGTMu.png\",\n      \"description\": \"<p><strong>Villa </strong>is a house of 240 square meters (2583 sq.ft) that sits on a property of 10,000 square meters (108,000 sq.ft).</p>\\r\\n\\r\\n<p>It has several balconies and terraces; and is suitable for a&nbsp;<strong>maximum of ten people (8+2).</strong></p>\\r\\n\\r\\n<p>The Villa<strong>&nbsp;has two floors</strong>, with<strong>&nbsp;four bedrooms</strong>&nbsp;(2 master suites and 2 guest rooms) and four bathrooms, as well as a 4000 square meter (43,000 sq. ft) garden. Exotic Ip&eacute; hardwood flooring is laid throughout the house.</p>\\r\\n\\r\\n<p>The Villa is set behind an automatic wide gate with plenty of covered parking spaces.&nbsp; From the parking area, the house can be easily accessed (just one step) for all types of guests.</p>\\r\\n\\r\\n<p>Villa Miragalli is fully furnished with&nbsp;<strong>personalized A/C</strong>&nbsp;and heating throughout the entire house and bedrooms, as well as a&nbsp;<strong>hot tub</strong>&nbsp;(which can be enjoyed all year), an&nbsp;<strong>infinity and heated swimming pool,</strong>&nbsp;outdoor kitchen, gazebo, barbecue, hammock,&nbsp;<strong>Sky TV</strong>, Playstation 3, home theater system, iPod station, Bose sound system, alarm,<strong>&nbsp;free fast Wi-Fi</strong>&nbsp;(bring your laptop or smartphone), and all the comforts you need to make this your home away from home.</p>\\r\\n\\r\\n<p><strong><em>Top Floor</em></strong></p>\\r\\n\\r\\n<p><strong>Living Area</strong></p>\\r\\n\\r\\n<p>The main entrance places you on the top floor, where you enter into the spacious living area (60 square meters; 645 sq. ft).&nbsp; In this living room, you and your loved ones can sink into the three comfortable sofas, where you will enjoy the warmth of the beautiful fireplace.&nbsp; One of these sofas converts into a double bed.&nbsp; You can also choose from hundreds of international channels on Sky TV or&nbsp;<strong>play PlayStation 3 on the 47&rdquo; Smart TV.</strong></p>\\r\\n\\r\\n<p><strong>Kitchen</strong></p>\\r\\n\\r\\n<p>The large and beautiful kitchen (30 square meters; 323 sq. ft) can also be accessed from the patio.&nbsp;<strong>&nbsp;It is fully equipped</strong>&nbsp;with refrigerator/freezer, six-ring gas stove, dishwasher, wine refrigerator, pots and pans, plates and silverware, American coffee maker,ice maker, Espresso coffee maker,Moka coffee maker, toaster, blender, ice machine and microwave.&nbsp; The kitchen is also linked to the dining area, which is&nbsp; furnished with a spectacularly large round table, made of lava stone and a bench built into a stone wall. Throughout the house, you can enjoy the beautiful seascape view.</p>\",\n      \"room_images\": [\n      {\n      \"id\": 13,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/room_images/UQktkirCPW3wqypGTOwxs4fHNd1bN5RCq2T2axKV.jpeg\"\n      }\n      ]\n      },\n      {\n      \"id\": 2,\n      \"name\": \"Cottage\",\n      \"icon\": \"http://127.0.0.1:1234/storage/room_icon/nwTzl8N78rgaO01KkJGwUjYesgMeyp2uSKaBCGJC.png\",\n      \"description\": \"<p>A&nbsp;<strong>cottage</strong>&nbsp;is, typically, a small house. It may carry the connotation of being an old or old-fashioned building. In modern usage, a cottage is usually a modest, often cosy dwelling, typically in a&nbsp;rural&nbsp;or semi-rural location.</p>\\r\\n\\r\\n<p>The word comes from the&nbsp;architecture of England, where it originally referred to a house with ground floor living space and an upper floor of one or more bedrooms fitting under the eaves. In&nbsp;British English&nbsp;the term now denotes a small dwelling of traditional build, although it can also be applied to modern construction designed to resemble traditional houses (&quot;mockcottages&quot;). Cottages may be detached houses, or&nbsp;terraced, such as those built to house workers in mining villages. The&nbsp;tied accommodation&nbsp;provided to farm workers was usually a cottage, see&nbsp;cottage garden. Peasant farmers were once known as&nbsp;cotters.</p>\\r\\n\\r\\n<p>The&nbsp;holiday cottage&nbsp;exists in many cultures under different names. In&nbsp;American English, &quot;cottage&quot; is one term for such holiday homes, although they may also be called a &quot;cabin&quot;, &quot;chalet&quot;, or even &quot;camp&quot;. In certain countries (e.g.&nbsp;Scandinavia,&nbsp;Baltics, and&nbsp;Russia) the term &quot;cottage&quot; has local synonyms: In Finnish&nbsp;<em>m&ouml;kki</em>, in Estonian&nbsp;<em>suvila</em>, in Swedish&nbsp;<em>stuga</em>, in Norwegian&nbsp;<em>hytte</em>&nbsp;(from the German word&nbsp;<em>H&uuml;tte</em>), in Slovak&nbsp;<em>chalupa</em>, in Russian&nbsp;<em>дача</em>&nbsp;(<em>dacha</em>, which can refer to a vacation/summer home, often located near a body of water).</p>\\r\\n\\r\\n<p>There are cottage-style dwellings in American cities that were built primarily for the purpose of housing slaves.</p>\\r\\n\\r\\n<p>In places such as Canada, &quot;cottage&quot; carries no connotations of size (compare with&nbsp;vicarage&nbsp;or&nbsp;hermitage).</p>\",\n      \"room_images\": [\n      {\n      \"id\": 14,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/room_images/NILsFkRMjeOC8Tgh1TWklF1MQmkMHx8PqTtaT5X0.jpeg\"\n      }\n      ]\n      }\n      ],\n      \"resort_images\": [\n      {\n      \"id\": 137,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/DynGNPt3xDthCm4XQVBrS87yLxTDfQGmkH7ajXYa.jpeg\",\n      \"resort_id\": 2\n      },\n      {\n      \"id\": 136,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/u4jxf7wGLFDUbvCMMhxmIG8eGO3EVyco04bzJgvL.jpeg\",\n      \"resort_id\": 2\n      },\n      {\n      \"id\": 84,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/qp51L9T46MSA3sAjFSULwtH4dhgBuaUal2G2fm4z.jpeg\",\n      \"resort_id\": 2\n      },\n      {\n      \"id\": 117,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/uQ5JQpmF8yfyKZngz9DjGjIauHPlzH5qGmREUCTc.jpeg\",\n      \"resort_id\": 2\n      }\n      ],\n      \"resort_amenities\": [\n      {\n      \"id\": 1,\n      \"resort_id\": 2,\n      \"name\": \"Gym\",\n      \"icon\": null\n      },\n      {\n      \"id\": 2,\n      \"resort_id\": 2,\n      \"name\": \"SPA\",\n      \"icon\": null\n      },\n      {\n      \"id\": 14,\n      \"resort_id\": 2,\n      \"name\": \"Cricket\",\n      \"icon\": null\n      },\n      {\n      \"id\": 15,\n      \"resort_id\": 2,\n      \"name\": \"Movie Library\",\n      \"icon\": null\n      }\n      ],\n      \"resort_near_by_places\": [\n      {\n      \"id\": 7,\n      \"name\": \"Tibetan Buddhist Temple\",\n      \"distance_from_resort\": 28,\n      \"resort_id\": 2\n      },\n      {\n      \"id\": 8,\n      \"name\": \"Forest Research Institute\",\n      \"distance_from_resort\": 15,\n      \"resort_id\": 2\n      }\n      ]\n      },\n      \"resort_amenities\": [\n      {\n      \"amenity_id\": \"1\"\n      },\n      {\n      \"amenity_id\": \"2\"\n      },\n      {\n      \"amenity_id\": \"3\"\n      },\n      {\n      \"amenity_id\": \"4\"\n      },\n      {\n      \"amenity_id\": \"5\"\n      },\n      {\n      \"amenity_id\": \"6\"\n      },\n      {\n      \"amenity_id\": \"7\"\n      },\n      {\n      \"amenity_id\": \"8\"\n      },\n      {\n      \"amenity_id\": \"10\"\n      }\n      ],\n      \"resort_other_amenities\": [\n      {\n      \"name\": \"Other Amenity\"\n      }\n      ]\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Resort id missing.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ResortController.php",
    "groupTitle": "Resort"
  },
  {
    "type": "get",
    "url": "/api/resort-listing",
    "title": "Resort listing",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetResortListing",
    "group": "Resort",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Resorts found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Json data.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"resorts found\",\n      \"data\": [\n      {\n      \"id\": 1,\n      \"name\": \"Sanjeevani Resorts & Tents\",\n      \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\\r\\n\\r\\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>\\r\\n\\r\\n<p>Sanjeevani&rsquo;s 12 months Free from Life Style Disease Package</p>\\r\\n\\r\\n<p><br />\\r\\nBecome a member and be free from Life style Disease such as Diabetes<br />\\r\\nMembers are required to attend Seven days residential retreat at Sanjeevani, Dehradun to kick start your reverse diabetes therapy. During your stay you will be provided Diabetes Tests, Yoga, Meditation, Vegan Diet, Massage Therapy, Trekking and Training.<br />\\r\\nIn addition, you will be provided with a free Glucometer with 25 strips for self check on fortnight basis and to update our Relationship Manager allotted to you by us.&nbsp;<br />\\r\\nDaily Routine Call/SMS/App alerts from Sanjeevani<br />\\r\\n&bull; Wake-Up<br />\\r\\n&bull; Yoga/Walk<br />\\r\\n&bull; Breakfast<br />\\r\\n&bull; Lunch<br />\\r\\n&bull; Snacks<br />\\r\\n&bull; Dinner<br />\\r\\nWeekly Call from Dietician/Doctor/Therapist<br />\\r\\nConsultation call (time for each individual will be given separately)</p>\\r\\n\\r\\n<p><br />\\r\\n<strong>Free Tests:</strong><br />\\r\\nHba1c, Vitamin-B12 and Vitamin-D test every quarter and C-peptide test after 12 months program&nbsp;</p>\\r\\n\\r\\n<p><br />\\r\\n<strong>Progress Report</strong><br />\\r\\nYou will be updated for your progress report timely &amp; Your Medical history will be maintained by us that you can access online anytime.</p>\\r\\n\\r\\n<p><br />\\r\\n<strong>Note:</strong><br />\\r\\nConsultation with our experts is available anytime between between 10 AM and 6 PM. This is a 1 year membership program for limited people, specially who are suffering from Life style diseases such as Diabetes, Thyroid, Heart, Kidney, Arthritis, ED-PE, etc</p>\",\n      \"address\": \"Horawala, Dehradun UttraKhand India\",\n      \"resort_images\": [\n      {\n      \"id\": 25,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/ymENq0tEvnDgPRdAV3Y7mQaKvhX06Uj8jpJbuvdv.jpeg\",\n      \"resort_id\": 1\n      },\n      {\n      \"id\": 24,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/pzRNJJ2T2EPe39rN9ax7VZf4GxM8UqBurIzKnl37.jpeg\",\n      \"resort_id\": 1\n      },\n      {\n      \"id\": 23,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/YmCu1wPzsAD8lfyBwagZOJH8i5klDdZ8vrM20kg3.jpeg\",\n      \"resort_id\": 1\n      }\n      ]\n      },\n      {\n      \"id\": 2,\n      \"name\": \"Dintex\",\n      \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\",\n      \"address\": \"U-701\",\n      \"resort_images\": [\n      {\n      \"id\": 137,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/DynGNPt3xDthCm4XQVBrS87yLxTDfQGmkH7ajXYa.jpeg\",\n      \"resort_id\": 2\n      },\n      {\n      \"id\": 136,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/u4jxf7wGLFDUbvCMMhxmIG8eGO3EVyco04bzJgvL.jpeg\",\n      \"resort_id\": 2\n      },\n      {\n      \"id\": 84,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/qp51L9T46MSA3sAjFSULwtH4dhgBuaUal2G2fm4z.jpeg\",\n      \"resort_id\": 2\n      },\n      {\n      \"id\": 117,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/uQ5JQpmF8yfyKZngz9DjGjIauHPlzH5qGmREUCTc.jpeg\",\n      \"resort_id\": 2\n      }\n      ]\n      },\n      {\n      \"id\": 3,\n      \"name\": \"Shaheen Bagh (a boutique resort & spa)\",\n      \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\",\n      \"address\": \"Shigally School Road Jamniwala, Guniyal Gaon\",\n      \"resort_images\": [\n      {\n      \"id\": 53,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/73OZaSDAUmTeWKVG5XvSIw38d7wkkAkyITdvvNFd.jpeg\",\n      \"resort_id\": 3\n      },\n      {\n      \"id\": 52,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/51YWRpbZnDThLJfEiMZriEwz4m3ycxao2JL5X5vN.png\",\n      \"resort_id\": 3\n      }\n      ]\n      },\n      {\n      \"id\": 4,\n      \"name\": \"Shinura Nature Retreat\",\n      \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\",\n      \"address\": \"Abhimanyu Cricket Academy, Jamniwala Hills Near Guniya Near, Dehradun,\",\n      \"resort_images\": [\n      {\n      \"id\": 130,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/9C2PRgGBq2gHNTFZctD6J9jiyrXX4sJMwXskKC9U.jpeg\",\n      \"resort_id\": 4\n      },\n      {\n      \"id\": 128,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/k6hAqSMZKULtsGfk5VFssrljKVKMGIHGzZzFkODE.jpeg\",\n      \"resort_id\": 4\n      },\n      {\n      \"id\": 125,\n      \"banner_image_url\": \"http://127.0.0.1:1234/storage/resort_images/wvIzJp6lXAGAeQAEV7Tx2AcH7ChwdHgF1fTcLe3R.jpeg\",\n      \"resort_id\": 4\n      }\n      ]\n      }\n      ]\n      }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ResortController.php",
    "groupTitle": "Resort"
  },
  {
    "type": "get",
    "url": "/api/order-request-list",
    "title": "Order & Request list",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetOrderRequestlist",
    "group": "Services",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Order &amp; Request found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Services list\",\n      \"data\": {\n      \"ongoing_services\": [\n      {\n      \"id\": 67,\n      \"record_id\": 67,\n      \"name\": \"1551681813\",\n      \"icon\": \"http://devsanjeevani.dbaquincy.com/img/my_meal.png\",\n      \"date\": \"04-Mar-2019\",\n      \"time\": \"12:13 PM\",\n      \"date_time\": \"04-03-2019 12:13:33\",\n      \"total_item_count\": 1,\n      \"total_amount\": 53,\n      \"status_id\": 1,\n      \"status\": \"Pending\",\n      \"acceptd_by\": \"\",\n      \"type\": 4\n      }\n      ],\n      \"complete_services\": [\n      {\n      \"id\": 120,\n      \"record_id\": 120,\n      \"name\": \"Room Cleaning\",\n      \"icon\": \"http://127.0.0.1:1234/storage/Service_icon/bG8tskL0dmA4XmCjBWC35v01uauybI9YyvKx0apH.png\",\n      \"date\": \"04-Mar-2019\",\n      \"time\": \"12:23 PM\",\n      \"date_time\": \"04-03-2019 12:23:31\",\n      \"status_id\": 4,\n      \"status\": \"Completed\",\n      \"acceptd_by\": \"Ankit Sharma\",\n      \"type\": 1,\n      \"staff_reasons\": null,\n      \"staff_comment\": null\n      }\n      ]\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "OrderRequestNotFound",
            "description": "<p>The Order &amp; Request not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The User id missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Order & Request not found.\",\n      \"data\": {\n          \"order_request\": []\n      }\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"user id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ServiceController.php",
    "groupTitle": "Services"
  },
  {
    "type": "get",
    "url": "/api/services-list",
    "title": "All services list",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetServiceList",
    "group": "Services",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort Id (For guest user use resort id value -1).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Services listing.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Services listing.\",\n   \"data\": {\n       \"housekeeping\": [\n           {\n               \"id\": 1,\n               \"name\": \"Air conditioner\",\n               \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/cWpiFZ9YG4duaP7Cfch2DgeVn3AYdSBAZPWFkd6g.png\",\n               \"questions\": [\n                   {\n                       \"name\": \"question 1\"\n                   },\n                   {\n                       \"name\": \"question 2\"\n                   }\n               ]\n           },\n           {\n               \"id\": 3,\n               \"name\": \"Air conditioners\",\n               \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/i0hRXnlJoVdUcSENmCNxvHANVZ1drvwyFqtVB14O.png\",\n               \"questions\": [\n                    {\n                       \"name\": \"question 1\"\n                    },\n                   {\n                       \"name\": \"question 2\"\n                   }\n               ]\n           }\n       ],\n       \"issues\": [\n           {\n                \"id\": 2,\n               \"name\": \"Room Cleaning\",\n               \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/i0hRXnlJoVdUcSENmCNxvHANVZ1drvwyFqtVB14O.png\",\n               \"questions\": [\n                   {\n                       \"name\": \"question 1\"\n                   }\n               ]\n          },\n          {\n              \"id\": 4,\n              \"name\": \"Do Not Disturbe\",\n              \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/i0hRXnlJoVdUcSENmCNxvHANVZ1drvwyFqtVB14O.png\",\n              \"questions\": [\n                  {\n                      \"name\": \"question 1\"\n                  },\n                  {\n                      \"name\": \"question 2\"\n                  }\n              ]\n          }\n      ]\n  }\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ServiceController.php",
    "groupTitle": "Services"
  },
  {
    "type": "post",
    "url": "/api/approve-service-request",
    "title": "Approve service Request",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostApproveServicerequest",
    "group": "Services",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type* (1 =&gt; for issues &amp; housekeeping, 4 =&gt; for Meals).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "record_id",
            "description": "<p>record_id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Service approved successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Service approved successfully.\",\n\"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnauthorizedUser",
            "description": "<p>The user is unauthorized.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "RecordIdMissing",
            "description": "<p>The service id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n     \"status\": false,\n     \"status_code\": 404,\n     \"message\": \"User id missing.\",\n     \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Unauthorized user.\",\n    \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"service id missing.\",\n    \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ServiceController.php",
    "groupTitle": "Services"
  },
  {
    "type": "post",
    "url": "/api/reject-service-request",
    "title": "Reject service Request",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostApproveServicerequest",
    "group": "Services",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "record_id",
            "description": "<p>Record id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type*(1 =&gt; for issues &amp; housekeeping, 4 =&gt; for Meals).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "comment",
            "description": "<p>comment*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Service approved successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Service rejected successfully.\",\n\"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnauthorizedUser",
            "description": "<p>The user is unauthorized.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResordIdMissing",
            "description": "<p>The record id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n     \"status\": false,\n     \"status_code\": 404,\n     \"message\": \"User id missing.\",\n     \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Unauthorized user.\",\n    \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"record id missing.\",\n    \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ServiceController.php",
    "groupTitle": "Services"
  },
  {
    "type": "post",
    "url": "/api/raise-service-request",
    "title": "Raise service Request",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostRaiseServicerequest",
    "group": "Services",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "service_id",
            "description": "<p>Service id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "question_id",
            "description": "<p>questions by comma separated.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "comment",
            "description": "<p>Comment.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Request successfully created.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Our staff member will contact you soon.\",\n      \"data\": {}\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnauthorizedUser",
            "description": "<p>The user is unauthorized.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ServiceIdMissing",
            "description": "<p>The service id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidResort",
            "description": "<p>The resort is invalid.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidService",
            "description": "<p>The service is invalid.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n     \"status\": false,\n     \"status_code\": 404,\n     \"message\": \"User id missing.\",\n     \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Unauthorized user.\",\n    \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"service id missing.\",\n    \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"resort id missing.\",\n    \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Invalid resort.\",\n    \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Invalid service.\",\n    \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ServiceController.php",
    "groupTitle": "Services"
  },
  {
    "type": "get",
    "url": "/api/duty-status",
    "title": "Duty status",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetDutyStatus",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>Staff user id(required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Request accepted</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": true,\n  \"status_code\": 200,\n  \"message\": \"Duty status.\",\n  \"data\": {\n     \"duty_status\" : 1\n     \"is_booking\" : 1\n   }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"status\": false,\n  \"status_code\": 404,\n  \"message\": \"User id missing.\",\n  \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "get",
    "url": "/api/myjobs",
    "title": "Myjobs",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetMyjobs",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>Staff user id(required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>My jobs</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"My jobs.\",\n   \"data\": {\n       \"ongoing_jobs\": [\n           {\n              \"id\": 1,\n              \"service_name\": \"Do Not Disturbe\",\n              \"service_comment\": \"\",\n              \"service_icon\": \"http://127.0.0.1:8000/storage/Service_icon\",\n              \"user_name\": \"Hariom Gangwar\",\n              \"room_no\": \"300\",\n              \"created_at\": \"18:22 pm\"\n              \"type\": 1\n           },\n           {\n               \"id\": 1,\n               \"record_id\": 1,\n               \"name\": \"1544722346\",\n               \"icon\": \"\",\n               \"date\": \"13-12-2018\",\n               \"time\": \"17:32 pm\",\n               \"total_item_count\": 1,\n               \"total_amount\": 240.6,\n               \"status_id\": 1,\n               \"status\": \"Confirmed\",\n               \"acceptd_by\": \"\",\n               \"type\": 4\n           }\n       ],\n       \"under_approval_jobs\": [],\n       \"completed_jobs\": []\n   }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"status\": false,\n  \"status_code\": 404,\n  \"message\": \"User id missing.\",\n  \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "get",
    "url": "/api/room-type-list",
    "title": "Room Type & Package List",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "Getroomtypelist",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "check_in",
            "description": "<p>Check In Date*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "check_out",
            "description": "<p>Check Out Date*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort Id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Resort",
            "description": "<p>room list</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>{}.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Resort room & Package list\",\n      \"data\": {\n          \"room_list\": [\n              {\n                  \"id\": 1,\n                  \"room_type\": \"Tent\",\n                  \"rooms\": [\n                      {\n                          \"id\": 52,\n                          \"room_no\": \"t-2\"\n                      },\n                      {\n                          \"id\": 53,\n                          \"room_no\": \"T-3\"\n                      },\n                      {\n                          \"id\": 54,\n                          \"room_no\": \"T-4\"\n                      },\n                      {\n                          \"id\": 55,\n                          \"room_no\": \"T-5\"\n                      },\n                      {\n                          \"id\": 56,\n                          \"room_no\": \"T-6\"\n                      }\n                  ]\n              },\n              {\n                  \"id\": 2,\n                  \"room_type\": \"Cottage\",\n                  \"rooms\": [\n                      {\n                          \"id\": 50,\n                          \"room_no\": \"C-1\"\n                      },\n                      {\n                          \"id\": 57,\n                          \"room_no\": \"C-3\"\n                      },\n                      {\n                          \"id\": 58,\n                          \"room_no\": \"C-2\"\n                      },\n                      {\n                          \"id\": 59,\n                          \"room_no\": \"C-4\"\n                      }\n                  ]\n              },\n              {\n                  \"id\": 4,\n                  \"room_type\": \"Villa\",\n                  \"rooms\": [\n                      {\n                          \"id\": 51,\n                          \"room_no\": \"V-1\"\n                      }\n                  ]\n              },\n              {\n                  \"id\": 8,\n                  \"room_type\": \"Dummy\",\n                  \"rooms\": [\n                      []\n                  ]\n              }\n          ],\n          \"packages\": [\n              {\n                  \"id\": 1,\n                  \"name\": \"Healthcare Package Reverse Diabetes in 3 Days\"\n              },\n              {\n                  \"id\": 3,\n                  \"name\": \"Healthcare Package Reverse Diabetes in 7 Days\"\n              },\n              {\n                  \"id\": 4,\n                  \"name\": \"Reverse Diabetes in 14 Days\"\n              },\n              {\n                  \"id\": 5,\n                  \"name\": \"Reverse Diabetes in 21 Days\"\n              }\n          ]\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "CheckInMissing",
            "description": "<p>The Check In date missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "CheckOutMissing",
            "description": "<p>The Check Out date missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The Resort Id date missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"Check In missing.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"Check Out missing.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"Resort Id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "get",
    "url": "/api/search-user",
    "title": "Search User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "Getsearchuser",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "search_keyword",
            "description": "<p>Search keyword*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "User",
            "description": "<p>list</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>{}.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"status\": true,\n     \"status_code\": 200,\n     \"message\": \"user list\",\n     \"data\": {\n         \"user_list\": [\n             {\n                 \"id\": 81,\n                 \"name\": \"Hariom Gangwar\",\n                 \"email_id\": \"hariom4037@gmail.com\",\n                 \"mobile_number\": \"8077575834\",\n                 \"country_code\": \"\"\n             },\n             {\n                 \"id\": 114,\n                 \"name\": \"\",\n                 \"email_id\": \"\",\n                 \"mobile_number\": \"8077575832\",\n                 \"country_code\": \"\"\n             },\n             {\n                 \"id\": 117,\n                 \"name\": \"Ankit Singh\",\n                 \"email_id\": \"ankit@yopmail.com\",\n                 \"mobile_number\": \"8077575837\",\n                 \"country_code\": \"\"\n             },\n             {\n                 \"id\": 118,\n                 \"name\": \"Ankit Singh\",\n                 \"email_id\": \"ankit@yopmail.com\",\n                 \"mobile_number\": \"8077575835\",\n                 \"country_code\": \"\"\n             }\n         ]\n     }\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "SeacrhKeywordMissing",
            "description": "<p>Search keyword missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"Search Keyword missing.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "get",
    "url": "/api/get-bookings",
    "title": "User booking list",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "Getuserbookings",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User Id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Booking",
            "description": "<p>list</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>{}.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"booking list\",\n      \"data\": [\n          {\n              \"source_name\": \"Makemy trip\",\n              \"source_id\": \"QWERTY12345\",\n              \"resort\": \"Sanjeevani Resorts & Tents\",\n              \"package\": \"Healthcare Package Reverse Diabetes in 3 Days\",\n              \"check_in\": \"31-May-2019 12:00 PM\",\n              \"check_out\": \"31-May-2019 01:00 PM\",\n              \"room_no\": \"T-1\",\n              \"status\": \"Completed\"\n          },\n          {\n              \"source_name\": \"GOIBIBO\",\n              \"source_id\": \"GOIBIBO007\",\n              \"resort\": \"Sanjeevani Resorts & Tents\",\n              \"package\": \"Healthcare Package Reverse Diabetes in 7 Days\",\n              \"check_in\": \"31-May-2019 02:00 PM\",\n              \"check_out\": \"31-May-2019 04:00 PM\",\n              \"room_no\": \"T-3\",\n              \"status\": \"Cancelled\"\n          },\n          {\n              \"source_name\": \"XYZ\",\n              \"source_id\": \"12345XYZ\",\n              \"resort\": \"Sanjeevani Resorts & Tents\",\n              \"package\": \"Healthcare Package Reverse Diabetes in 3 Days\",\n              \"check_in\": \"01-Jun-2019 12:00 AM\",\n              \"check_out\": \"10-Jun-2019 12:00 AM\",\n              \"room_no\": \"t-2\",\n              \"status\": \"Current\"\n          },\n          {\n              \"source_name\": \"XYZ\",\n              \"source_id\": \"12345XYZ\",\n              \"resort\": \"Sanjeevani Resorts & Tents\",\n              \"package\": \"Healthcare Package Reverse Diabetes in 3 Days\",\n              \"check_in\": \"01-Jun-2019 12:00 AM\",\n              \"check_out\": \"10-Jun-2019 12:00 AM\",\n              \"room_no\": \"t-2\",\n              \"status\": \"Current\"\n          },\n          {\n              \"source_name\": \"XYZ\",\n              \"source_id\": \"12345XYZ\",\n              \"resort\": \"Sanjeevani Resorts & Tents\",\n              \"package\": \"Healthcare Package Reverse Diabetes in 3 Days\",\n              \"check_in\": \"01-Jun-2019 12:00 AM\",\n              \"check_out\": \"10-Jun-2019 12:00 AM\",\n              \"room_no\": \"t-2\",\n              \"status\": \"Current\"\n          },\n          {\n              \"source_name\": \"XYZ\",\n              \"source_id\": \"12345XYZ\",\n              \"resort\": \"Sanjeevani Resorts & Tents\",\n              \"package\": \"Healthcare Package Reverse Diabetes in 3 Days\",\n              \"check_in\": \"01-Jun-2019 12:00 AM\",\n              \"check_out\": \"10-Jun-2019 12:00 AM\",\n              \"room_no\": \"t-2\",\n              \"status\": \"Current\"\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>User Id missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"User Id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "post",
    "url": "/api/accept-reject-meal-order",
    "title": "Accept/Reject meal order.",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "POSTAcceptRejectMealOrer",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_id",
            "description": "<p>Order id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>1=&gt;Accepted order, -1=&gt; Rejected Order .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Order accepted successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": true,\n  \"status_code\": 200,\n  \"message\": \"Order accepted successfully.\",\n  \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "post",
    "url": "/api/job-mark-complete",
    "title": "My Job mark as completed",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "POSTMyjobMarkComplete",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>Staff user id(required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "job_id",
            "description": "<p>Job Id(required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Your job status has been changed. Now your job in under approval.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": true,\n  \"status_code\": 200,\n  \"message\": \"Your job status has been changed. Now your job in under approval.\",\n  \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "JobIdMissing",
            "description": "<p>The job id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"status\": false,\n  \"status_code\": 404,\n  \"message\": \"User id missing.\",\n  \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"Job id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "post",
    "url": "/api/job-mark-notresolve",
    "title": "My Job mark as not resolve",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "POSTMyjobMarkNotResolve",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>Staff user id(required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "job_id",
            "description": "<p>Job Id(required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "reasons",
            "description": "<p>Reasons (with comma separated).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "comment",
            "description": "<p>Comment.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Your job status has been changed.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": true,\n  \"status_code\": 200,\n  \"message\": \"Your job status has been changed.\",\n  \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "JobIdMissing",
            "description": "<p>The job id is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"status\": false,\n  \"status_code\": 404,\n  \"message\": \"User id missing.\",\n  \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"Job id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "post",
    "url": "/api/service-request-accept",
    "title": "Service Request Accept",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostServicerequestaccept",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "request_id",
            "description": "<p>Service Request id(required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>Staff user id(required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Request accepted</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": true,\n  \"status_code\": 200,\n  \"message\": \"Request accepted.\",\n  \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "RequestIdMissing",
            "description": "<p>The request id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"Request id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"status\": false,\n  \"status_code\": 404,\n  \"message\": \"User id missing.\",\n  \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "get",
    "url": "/api/service-request-list",
    "title": "Service Request Listing",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          }
        ]
      }
    },
    "name": "PostServicerequestlist",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Service request found..</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Service request found.\",\n   \"data\": {\n           \"services\": [\n              {\n                   \"id\": 1,\n                   \"service_name\": \"Do Not Disturbe\",\n                   \"service_comment\": \"\",\n                   \"service_icon\": \"http://127.0.0.1:8000/storage/Service_icon/XfNlJoZ3L4Pj0dbM8lJIyIXtkqTK4FXaANlUwwOo.jpeg\",\n                   \"user_name\": \"Hariom Gangwar\",\n                   \"room_no\": \"300\",\n                   \"created_at\": \"17:11 pm\"\n               }\n           ],\n       \"meal_orders\": [\n           {\n               \"id\": 1,\n               \"invoice_id\": \"1544634201\",\n               \"item_total_amount\": 240.6,\n               \"gst_amount\": 0,\n               \"total_amount\": 240.6,\n               \"user_name\": \"Hariom Gangwar\",\n               \"room_no\": \"300\",\n               \"created_at\": \"17:03 pm\",\n               \"meal_item_count\": 1,\n               \"meal_items\": [\n                   {\n                       \"id\": 1,\n                       \"meal_item_name\": \"sadsad\",\n                       \"price\": 120,\n                       \"quantity\": 2,\n                       \"image_url\": \"\"\n                   }\n               ]\n           }\n       ],\n      \"amenities\": [\n          {\n              \"id\": 2,\n              \"name\": \"sadsaGym\",\n              \"icon\": null,\n              \"booking_count\": 1\n          },\n          {\n              \"id\": 1,\n              \"name\": \"Gym\",\n              \"icon\": null,\n              \"booking_count\": 0\n          }\n      ]\n   }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ResortIdMissing",
            "description": "<p>The resort id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidResort",
            "description": "<p>The resort is invalid.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"Resort id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"status\": false,\n  \"status_code\": 404,\n  \"message\": \"Invalid resort.\",\n  \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "post",
    "url": "/api/update-push-status",
    "title": "Update push status",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          }
        ]
      }
    },
    "name": "PostUpdatePushStatus",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Status updated</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>{}.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Service request found.\",\n   \"data\": {}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StatusMissing",
            "description": "<p>The status was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"status missing.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "post",
    "url": "/api/add-user",
    "title": "Add User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          }
        ]
      }
    },
    "name": "Postadduser",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile_number",
            "description": "<p>Mobile Number*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_name",
            "description": "<p>User Name*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "country_code",
            "description": "<p>Country code*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email_id",
            "description": "<p>Email id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_room_type_id",
            "description": "<p>Resort room type Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_room_id",
            "description": "<p>Resort room Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_source_name",
            "description": "<p>Booking Source name*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_source_id",
            "description": "<p>Booking Source Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_source",
            "description": "<p>Booking source*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_amount",
            "description": "<p>Booking amount*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_amount_type",
            "description": "<p>Booking amount type* (1 =&gt; Prepaid, 2 =&gt; Outstanding).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "package_id",
            "description": "<p>Package Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "check_in",
            "description": "<p>Check In date time*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "check_out",
            "description": "<p>Check Out date time*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_membership",
            "description": "<p>Membership (0 or 1).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "membership_id",
            "description": "<p>Membership Id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "membership_from",
            "description": "<p>Membership From.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "membership_till",
            "description": "<p>Membership Till.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_medical",
            "description": "<p>Medical (0 or 1).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_diabeties",
            "description": "<p>Diabetirs (0 or 1).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_ppa",
            "description": "<p>PPA (0 or 1).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "hba_1c",
            "description": "<p>HBA_1C (0 or 1).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fasting",
            "description": "<p>Fasting.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bp",
            "description": "<p>BP.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "insullin_dependency",
            "description": "<p>Insullin dependency.</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "medical_documents",
            "description": "<p>Medical document.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "discount",
            "description": "<p>Discount.</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "person_name",
            "description": "<p>Person name.</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "person_age",
            "description": "<p>Person age.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Something",
            "description": "<p>went be wrong</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>{}.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n     \"status\": true,\n    \"status_code\": 200,\n    \"message\": \"User registered successfully\",\n     \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "post",
    "url": "/api/create-booking",
    "title": "Create user booking.",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "Postcreateuserbooking",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "check_in",
            "description": "<p>Check In(YYYY-MM-DD H:i:s)*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "check_out",
            "description": "<p>Check Out(YYYY-MM-DD H:i:s)*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_id",
            "description": "<p>Resort Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_room_type_id",
            "description": "<p>Resort room type Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "resort_room_id",
            "description": "<p>Resort room Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_source_name",
            "description": "<p>Booking source name*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_source_id",
            "description": "<p>Booking source Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_source",
            "description": "<p>Booking source*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_amount",
            "description": "<p>Booking amount*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_amount_type",
            "description": "<p>Booking amount type* (1 =&gt; Prepaid, 2 =&gt; Outstanding).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "package_id",
            "description": "<p>Package Id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "person_name",
            "description": "<p>Person name.</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "person_age",
            "description": "<p>Person age.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Booking",
            "description": "<p>list</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>{}.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"User booking created successfully.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>User Id missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n   \"status\": false,\n   \"status_code\": 404,\n   \"message\": \"User Id missing.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "get",
    "url": "/api/amenities-bookings-details",
    "title": "Amenity bookings detail.",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          }
        ]
      }
    },
    "name": "getAmenityBookingsDetail",
    "group": "Staff_Service",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "amenity_id",
            "description": "<p>Amenity id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_date",
            "description": "<p>Booking date id* (format yy-mm-dd).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>bookings details</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"booking detail\",\n      \"data\": [\n          {\n              \"slot\": \"04:00-05:00\",\n              \"bookings\": [\n                  {\n                      \"id\": 1,\n                      \"user_name\": \"Hariom Gangwar\",\n                      \"room_no\": \"100\",\n                      \"created_at\": \"13-12-18 05:48 PM\"\n                  }\n              ]\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StaffController.php",
    "groupTitle": "Staff_Service"
  },
  {
    "type": "get",
    "url": "/api/get-checkin-detail",
    "title": "Get Check-In detail",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetCheckInDetail",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>User check In detail.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>{}.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"User.\",\n      \"data\": {\n      \"checkin_detail\": {\n      \"id\": 149,\n      \"cart_count\": 0,\n      \"user_name\": \"Om\",\n      \"first_name\": \"Om\",\n      \"mid_name\": \"\",\n      \"last_name\": \"\",\n      \"email_id\": \"om@mail.com\",\n      \"user_type_id\": 3,\n      \"is_checked_in\": false,\n      \"address\": \"\",\n      \"state\": \"\",\n      \"city\": \"\",\n      \"pincode\": \"\",\n      \"screen_name\": \"\",\n      \"profile_pic_path\": \"http://127.0.0.1:1234/img/no-image.jpg\",\n      \"mobile_number\": \"8077575835\",\n      \"source_name\": \"GOIBO\",\n      \"source_id\": \"GOIBO123456\",\n      \"resort_room_no\": \"T-2\",\n      \"room_type\": \"Tent\",\n      \"check_in_pin\": 7015,\n      \"check_out_pin\": 3336,\n      \"check_in_date\": \"04-Mar-2019\",\n      \"check_in_time\": \"12:00 AM\",\n      \"check_out_date\": \"30-Mar-2019\",\n      \"check_out_time\": \"10:00 AM\",\n      \"booking_id\": \"GOIBO123456\",\n      \"no_of_guest\": \"1 Adult and 1 Child\",\n      \"guest_detail\": [\n      {\n      \"id\": 23,\n      \"person_name\": \"Ankit\",\n      \"person_age\": \"10\",\n      \"person_type\": \"Child\"\n      },\n      {\n      \"id\": 24,\n      \"person_name\": \"Anshu\",\n      \"person_age\": \"25\",\n      \"person_type\": \"Adult\"\n      }\n      ],\n      \"membership\": {\n      \"membership_id\": \"ABCDE\",\n      \"valid_from\": \"04-Mar-2019 12:00 AM\",\n      \"valid_till\": \"07-Mar-2019 12:00 AM\"\n      },\n      \"resort\": {\n      \"id\": 2,\n      \"name\": \"Dintex\",\n      \"description\": \"<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\\r\\n\\r\\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\",\n      \"amenities\": \"1#2#3#4#5#6#7#8#10\",\n      \"other_amenities\": \"Other Amenity\",\n      \"contact_number\": \"8588936238\",\n      \"other_contact_number\": null,\n      \"address_1\": \"U-701\",\n      \"address_2\": null,\n      \"address_3\": null,\n      \"pincode\": 201301,\n      \"city_id\": 181,\n      \"latitude\": 28.5355,\n      \"longitude\": 77.391,\n      \"is_active\": 1,\n      \"domain_id\": 0,\n      \"created_by\": \"1\",\n      \"updated_by\": \"1\",\n      \"created_at\": \"2018-12-20 21:19:14\",\n      \"updated_at\": \"2019-02-21 08:12:15\",\n      \"deleted_at\": null\n      }\n      }\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/api/user-counts",
    "title": "User counts",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetUserCounts",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Conts.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"counts\",\n      \"data\": {\n          \"notification_count\": 0\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/change-password",
    "title": "Change User Password",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostChangePassword",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>New Password*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "confirm_password",
            "description": "<p>Confirm Password.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Password Changed successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Password Changed successfully.\",\n\"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidUser",
            "description": "<p>The user is invalid.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NewPasswordMissing",
            "description": "<p>The new password was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ConfirmPasswordMissing",
            "description": "<p>The confirm password was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Invalid user.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"New Password missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Confirm Password missing.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/check-in",
    "title": "Check In user",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostCheckIn",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "aadhar_id",
            "description": "<p>User aadhar id document*.</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "other_aadhar_id",
            "description": "<p>User Other side aadhar id document*.</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "other_id",
            "description": "<p>User other document.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>User check-in successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"User check-in successfully.\",\n      \"data\": {\n      \"id\": 149,\n      \"discount\": 10,\n      \"salutation_id\": 0,\n      \"user_name\": \"Om\",\n      \"first_name\": \"Om\",\n      \"mid_name\": \"\",\n      \"last_name\": \"\",\n      \"gender\": null,\n      \"user_type_id\": 3,\n      \"designation_id\": 0,\n      \"department_id\": 0,\n      \"city_id\": 0,\n      \"language_id\": 0,\n      \"email_id\": \"om@mail.com\",\n      \"alternate_email_id\": null,\n      \"screen_name\": \"\",\n      \"date_of_joining\": null,\n      \"authority_id\": \"0\",\n      \"user_id_RA\": null,\n      \"date_of_birth\": null,\n      \"profile_pic_path\": \"http://127.0.0.1:1234/img/no-image.jpg\",\n      \"id_card\": null,\n      \"is_user_loked\": 0,\n      \"mobile_number\": \"8077575835\",\n      \"other_contact_number\": null,\n      \"address1\": \"\",\n      \"address2\": null,\n      \"address3\": null,\n      \"pincode\": \"\",\n      \"secuity_question\": null,\n      \"secuity_questio_answer\": null,\n      \"ref_time_zone_id\": null,\n      \"login_expiry_date\": null,\n      \"other_info\": null,\n      \"password\": \"$2y$10$EeEc0jxjDXyE/rH0Ri20lObAg2JjpMBHeOFsYQLo.zmgzG4oF1K/.\",\n      \"remember_token\": null,\n      \"aadhar_id\": \"http://127.0.0.1:1234/storage/aadhar_id/lH9ghKYDYDDrBYstCe7IlJyJbCwVttZuWa0DC7jc.png\",\n      \"other_aadhar_id\": \"http://127.0.0.1:1234/storage/other_aadhar_id/oHBhMKEU8XBLpliH5ja4nRW465iolmRcRRnJg1W6.png\",\n      \"voter_id\": \"http://127.0.0.1:1234/img/no-image.jpg\",\n      \"authorise_amenities_id\": null,\n      \"is_service_authorise\": 0,\n      \"is_meal_authorise\": 0,\n      \"device_token\": \"153dsf45dsf4d5s31f32ds1f32ds1f32ds1f32s\",\n      \"device_type\": \"Android\",\n      \"device_id\": null,\n      \"is_active\": 1,\n      \"domain_id\": 0,\n      \"otp\": \"2062\",\n      \"oath_token\": null,\n      \"created_by\": \"1\",\n      \"updated_by\": \"1\",\n      \"created_at\": \"2019-03-04 10:18:06\",\n      \"updated_at\": \"2019-03-04 12:03:48\",\n      \"is_checked_in\": true\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "AadharIdMissing",
            "description": "<p>The aadhar document missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "AadharIdNotValidFile",
            "description": "<p>The aadhar document not valid file type.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "OtherIdNotValidFile",
            "description": "<p>The other document not valid file type.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidUser",
            "description": "<p>This user was invalid.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User Id missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Aadhar id missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"aadhar id not valid file type.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"other id not valid file type.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Invalid user.\",\n \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/state-city-list",
    "title": "State City list",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostStateCity",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "country_id",
            "description": "<p>Country id*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>state and city listing.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>state city array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"state and city listing\",\n      \"data\": [\n          {\n              \"id\": 1,\n              \"state_name\": \"Andaman & Nicobar Islands\",\n              \"cities\": [\n                  {\n                      \"id\": 93,\n                      \"city_name\": \"Carnicobar\",\n                      \"state\": null\n                  },\n                  {\n                      \"id\": 149,\n                      \"city_name\": \"Diglipur\",\n                      \"state\": null\n*                   },\n                  {\n                      \"id\": 174,\n                      \"city_name\": \"Ferrargunj\",\n                      \"state\": null\n                  },\n                  {\n                      \"id\": 220,\n                      \"city_name\": \"Hut Bay\",\n                      \"state\": null\n                  },\n                  {\n                      \"id\": 331,\n                      \"city_name\": \"Mayabander\",\n                      \"state\": null\n                  },\n.........",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/update-device-token",
    "title": "Update Device Token",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          }
        ]
      }
    },
    "name": "PostUpdateDeviceToken",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_token",
            "description": "<p>Device Token*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_type",
            "description": "<p>Device Type* (Android or Iphone).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_id",
            "description": "<p>Unique Device ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Device token updated successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Device token updated successfully.\",\n   \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/update-profile",
    "title": "Update user profile",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostUpdateUserProfile",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "full_name",
            "description": "<p>Full name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email_id",
            "description": "<p>Email Id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>Address.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pincode",
            "description": "<p>Pincode.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city_id",
            "description": "<p>City id.</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "profile_pic",
            "description": "<p>Profile Pic.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Profile update succesfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Profile update succesfully.\",\n      \"data\": {\n      \"id\": 149,\n      \"user_name\": \"Om\",\n      \"first_name\": \"Om\",\n      \"last_name\": \"\",\n      \"email_id\": \"om@mail.com\",\n      \"profile_pic_path\": \"http://127.0.0.1:1234/img/no-image.jpg\",\n      \"address1\": \"\",\n      \"pincode\": \"\",\n      \"city_id\": 0,\n      \"state\": \"\",\n      \"city\": \"\",\n      \"membership_id\": \"ABCDE\",\n      \"valid_from\": \"04-Mar-2019 12:00 AM\",\n      \"valid_till\": \"07-Mar-2019 12:00 AM\"\n      }\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NotValidFileType",
            "description": "<p>The profile pic not valid file type.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Profile pic not valid file type.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  }
] });

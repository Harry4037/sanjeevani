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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Activities found.\",\n   \"data\": [\n       {\n           \"id\": 2,\n           \"name\": \"Activity\",\n           \"description\": \"<p>tretretwfdsf</p>\\r\\n\\r\\n<p>gffdwerew</p>\",\n           \"address\": \"sector 62, Noida, UP\",\n           \"latitude\": \"28.608510\",\n           \"longitude\": \"77.347370\",\n           \"is_booking_avaliable\": true,\n           \"activity_images\": [\n               {\n                   \"id\": 2,\n                   \"banner_image_url\": \"http://127.0.0.1:8000/storage/activity_images/ekD0YEH9vfWaSqFIyeufWzroj3MmH2HMQOJHwGNV.jpeg\",\n                   \"amenity_id\": 2\n               }\n           ]\n       }\n   ]\n}",
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
            "description": "<p>Booking date (dd/mm/yyyy).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "from_time",
            "description": "<p>From Time (24 hours format).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "to_time",
            "description": "<p>To Time (24 hours format).</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Anemities found.\",\n   \"data\": [\n       {\n           \"id\": 1,\n           \"name\": \"Gym\",\n           \"description\": \"<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Opening Timings</strong>:-</p>\\r\\n\\r\\n<p>9:00 AM to 11:00 AM</p>\\r\\n<p>5:00 PM to 7:00 PM</p>\\r\\n\",\n           \"address\": \"sector 62, Noida, UP\",\n           \"is_booking_avaliable\": false,\n           \"amenity_images\": [\n               {\n                   \"id\": 1,\n                   \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/amenities_images/ptjHTnrFSngDDbqO20ZHl4YDy035S0z1cIuop8EC.jpeg\",\n                   \"amenity_id\": 1\n               },\n               {\n                   \"id\": 2,\n                   \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/amenities_images/xQvt0XF682PO9gzaA05gTB2MQKP0ZH62XYGsgn2i.jpeg\",\n                   \"amenity_id\": 1\n               }\n           ]\n       },\n       {\n           \"id\": 2,\n           \"name\": \"SPA\",\n           \"description\": \"<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Timings</strong>:-</p>\\r\\n\\r\\n<p>9:00 AM to 10:00 AM</p>\\r\\n<p>4:00 PM to 5:00 PM</p>\\r\\n\",\n           \"address\": \"sector 62, Noida, UP\",\n           \"is_booking_avaliable\": true,\n           \"amenity_images\": [\n               {\n                   \"id\": 3,\n                   \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/amenities_images/NqHeZs8Qw9gIyuRNNg3YgtD3JrS0Cx5QH8OmYaAy.jpeg\",\n                   \"amenity_id\": 2\n               },\n               {\n                   \"id\": 4,\n                   \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/amenities_images/kVkodMPi1Y5QfPKeOjY8LXbf0tiKoOS4sHbaQOMu.jpeg\",\n                   \"amenity_id\": 2\n               }\n           ]\n       }\n   ]\n}",
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
            "description": "<p>Booking date (dd/mm/yyyy).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "from_time",
            "description": "<p>From Time (24 hours format).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "to_time",
            "description": "<p>To Time (24 hours format).</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"OTP verified successfully.\",\n   \"data\": {\n       \"id\": 2,\n       \"user_name\": \"Hariom\",\n       \"first_name\": \"Hariom\",\n       \"mid_name\": null,\n       \"last_name\": \"\",\n       \"email_id\": \"hariom4037@gmail.com\",\n       \"user_type_id\": 3,\n       \"address\": null,\n       \"state\": \"UP\",\n       \"city\": \"Noida\",\n       \"screen_name\": null,\n       \"profile_pic_path\": null,\n       \"mobile_number\": \"9808243372\",\n       \"token_type\": \"Bearer\",\n       \"access_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijg2ZjM5ZTA0ZjQxN2\n         QwNDNhZmRkYWY4NDJlNTNlNTQ3NjMxYzJkMTdkMThmZDVlM2VhMTk1OTc3MGZmZjQzMWE2NjI1ZjI\n0YzE5NDk1ZjllIn0.eyJhdWQiOiIxIiwianRpIjoiODZmMzllMDRmNDE3ZDA0M2FmZGRhZjg0MmU1M2U1NDc2M\nzFjMmQxN2QxOGZkNWUzZWExOTU5NzcwZmZmNDMxYTY2MjVmMjRjMTk0OTVmOWUiLCJpYXQiOjE1NDIyNTU5MDY\nsIm5iZiI6MTU0MjI1NTkwNiwiZXhwIjoxNTczNzkxOTA2LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.qnRi5ZXrBR\nYk2DJdNi8GbsRkb9g3g26MoBinbHJdGYS0hEfYiItve5yAhRmvQhPiIW_GXIhKRKPAcGmy1tHsneiUEScDjD35EW\nZwd39bpQGDx_VQAGp5JlM2rlj5KOVv52BqFiyLiod8621eevI7SvduWm7VojLFXPRqsWbCilVcQQB5WPIFdTNfor\ng3giro7Qa_nzmEZH_iUl0_955HWHx9L9XmuSg9pznePzcDqbyG4M7gB6guJUk0hIUP3cO3Aueu91LZtsA-jGXRkj\ndT2S9ONpVRWewl1aksPzjYFxtdUSfH2PQveGWsCMCka85i1B5v1JlyqDb38gNeWbB3Gqy8-2rV9AYS5gYy1lAgCv\nxrR9XoElyyguLU_BHQCMuU7_-034A1UbHZfg9_r3IR85_u25McRvSTHiZWPQXVDD2tHh5zLyhyDJjcD_Bh9jMxSE\n9E3b9HruJiJv8DVhTkvW6re95astIZe5X7oW8j7fDHvwWBUMdBfSnnBcyCp-6HVl6nByxevw3-OV_ugsCDuhsOKWw\njaUT4KkyJFxFjKjmbSQautj2FBum3Vy85fOMkgye_8rfYADsKXw81RQjixkflRfmifP4Ii68tES77apdXGqxJricNc\nVSBPzBiUThcnPCd_X8f4-vuQwp3KM-Jn8-rC0RT1lUHhlnHPyEzAmQ\",\n       \"source_name\": \"Make my trip\",\n       \"source_id\": \"QWERT123456\",\n       \"resort_room_no\": 1,\n       \"room_type\": \"Delux\",\n       \"check_in_date\": \"15-Nov-2018\",\n       \"check_in_time\": \"00:00 AM\",\n       \"check_out_date\": \"17-Nov-2018\",\n       \"check_out_time\": \"00:00 AM\",\n       \"booking_id\": 1,\n       \"no_of_guest\": \"1 Adult and 2 Child\",\n       \"guest_detail\": [\n           {\n               \"id\": 1,\n               \"person_name\": \"Ankit\",\n               \"person_age\": \"25\",\n               \"person_type\": \"Adult\"\n           },\n           {\n               \"id\": 2,\n               \"person_name\": \"Anshu\",\n               \"person_age\": \"5\",\n               \"person_type\": \"Child\"\n           },\n           {\n               \"id\": 3,\n               \"person_name\": \"om\",\n               \"person_age\": \"10\",\n               \"person_type\": \"Child\"\n           }\n       ],\n       \"resort\": {\n           \"id\": 1,\n           \"name\": \"Parth Inn\",\n           \"description\": \"<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\",\n           \"contact_number\": \"9808243372\",\n           \"other_contact_number\": null,\n           \"address_1\": \"Sector 66\",\n           \"address_2\": null,\n           \"address_3\": null,\n           \"pincode\": 243601,\n           \"city_id\": 50,\n           \"latitude\": 0,\n           \"longitude\": 0,\n           \"is_active\": 1,\n           \"domain_id\": 0,\n           \"created_by\": \"1\",\n           \"updated_by\": \"1\",\n           \"created_at\": \"2018-11-14 13:51:50\",\n           \"updated_at\": \"2018-11-14 13:52:58\"\n       }\n   }\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"service successfully access.\",\n\"data\":{\n\"user\":{\n\"id\": 2,\n\"user_name\": null,\n\"first_name\": null,\n\"mid_name\": null,\n\"last_name\": null,\n\"email_id\": null,\n\"user_type_id\": 3,\n\"address\": null,\n\"screen_name\": null,\n\"profile_pic_path\": null,\n\"mobile_number\": \"8077575835\",\n\"source_name\": \"Source Name\",\n\"source_id\": \"Source Id\",\n\"resort\":{\"id\": 1, \"name\": \"Parth Inn\", \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.\",…},\n\"booking\":{}\n},\n\"banners\": [\n   {\n       \"id\": 1,\n       \"banner_image_url\": \"http://127.0.0.1:8000/storage/Banner/5zR5E72L3GDGglqaCQWveafypHYVhEjunOXVzKlx.jpeg\"\n   },\n   {\n       \"id\": 2,\n       \"banner_image_url\": \"http://127.0.0.1:8000/storage/Banner/2qQnTA8jAuT9eNV7UHXY561xYrZHxXHYWcXILaXO.jpeg\"\n   }\n ]\n}\n}",
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
            "description": "<p>User id.</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Nearby places found.\",\n\"data\": {\n\"nearby\": [\n{\n\"id\": 1,\n\"name\": \"Ever green Sweet\",\n\"description\": \"Lore ipsum is the dummy text\",\n\"distance\": 10,\n\"precautions\": \"Lore ipsum is the dummy\",\n\"address\": \"noida\",\n\"latitude\": \"28.608510\",\n\"longitude\": \"77.347370\",\n\"images\": [\n{\n\"id\": 1,\n\"banner_image_url\": \"http://127.0.0.1:8000/storage/Nearby/ExD6n45wLqb6U3NdEZ34vLjSDdntyUEWA9J6kUNu.jpeg\"\n},\n{\n\"id\": 2,\n\"banner_image_url\": \"http://127.0.0.1:8000/storage/Nearby/u5SKjA8LzMoIabk87njPSg5nTcFaAFgKkgZN2z1f.jpeg\"\n}\n]\n},\n{\n\"id\": 2,\n\"name\": \"Testing\",\n\"description\": \"jhkjhjh\",\n\"distance\": 10,\n\"precautions\": \"kjhkjhkjhkj\",\n\"address\": \"noida\",\n\"latitude\": \"28.608510\",\n\"longitude\": \"77.347370\",\n\"images\": [\n{\n\"id\": \"http://127.0.0.1:8000/storage/Nearby/qM3wyREsrYaOltoKitTxl75Jxd41Cqy5i8VZy95h.jpeg\"\n}\n]\n}\n]\n}\n}",
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
            "field": "user_id",
            "description": "<p>User id.</p>"
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Resort found.\",\n      \"data\": {\n          \"resort\": {\n              \"id\": 1,\n              \"name\": \"Parth Inn\",\n              \"description\": \"<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\",\n              \"address\": \"sector 63\",\n              \"room_types\": [\n                  {\n                      \"id\": 1,\n                      \"name\": \"Tent\"\n                  },\n                  {\n                      \"id\": 2,\n                      \"name\": \"Cottage\"\n                  },\n                  {\n                      \"id\": 3,\n                      \"name\": \"Delux Room\"\n                  }\n              ],\n              \"resort_images\": [\n                  {\n                      \"id\": 1,\n                      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/Resort/ptjHTnrFSngDDbqO20ZHl4YDy035S0z1cIuop8EC.jpeg\",\n                      \"resort_id\": 1\n                  },\n                  {\n                      \"id\": 2,\n                      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/Resort/xQvt0XF682PO9gzaA05gTB2MQKP0ZH62XYGsgn2i.jpeg\",\n                      \"resort_id\": 1\n                  },\n                  {\n                      \"id\": 3,\n                      \"image_name\": \"http://sanjeevani.dbaquincy.com/storage/Resort/NqHeZs8Qw9gIyuRNNg3YgtD3JrS0Cx5QH8OmYaAy.jpeg\",\n                      \"resort_id\": 1\n                  },\n                  {\n                      \"id\": 4,\n                      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/Resort/kVkodMPi1Y5QfPKeOjY8LXbf0tiKoOS4sHbaQOMu.jpeg\",\n                      \"resort_id\": 1\n                  }\n              ],\n              \"resort_amenities\": [\n                  {\n                      \"id\": 1,\n                      \"resort_id\": 1,\n                      \"name\": \"Gym\"\n                  },\n                  {\n                      \"id\": 2,\n                      \"resort_id\": 1,\n                      \"name\": \"SPA\"\n                  }\n              ],\n              \"resort_near_by_places\": [\n                  {\n                      \"id\": 1,\n                      \"name\": \"Water Fall\",\n                      \"distance_from_resort\": 25,\n                      \"resort_id\": 1\n                  },\n                  {\n                      \"id\": 2,\n                      \"name\": \"Nilgri forest\",\n                      \"distance_from_resort\": 10,\n                      \"resort_id\": 1\n                  }\n              ]\n          }\n      }\n  }",
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"resorts found\",\n   \"data\": [\n          {\n           \"id\": 1,\n           \"name\": \"Parth Inn\",\n           \"description\": \"<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\",\n           \"address\": \"Secotr 66\",\n           \"resort_images\": [\n               {\n                   \"id\": 1,\n                   \"banner_image_url\": \"http://127.0.0.1:8000/storage/resort_images/VSDtAK5sVV7tcJadizsWBnlDsvzg2Zh8E5PAY2yG.jpeg\",\n                   \"resort_id\": 1\n               },\n               {\n                   \"id\": 2,\n                   \"banner_image_url\": \"http://127.0.0.1:8000/storage/resort_images/eaxPGN8eFHbOuVRzzWpwWBQr5X93ynaNsFbwlXLC.jpeg\",\n                   \"resort_id\": 1\n               },\n               {\n                   \"id\": 3,\n                   \"banner_image_url\": \"http://127.0.0.1:8000/storage/resort_images/gTuqwCLAVaSklGpvJJHvEz2Aa6DUENpSVjqIGEUC.jpeg\",\n                   \"resort_id\": 1\n               },\n               {\n                   \"id\": 4,\n                   \"banner_image_url\": \"http://127.0.0.1:8000/storage/resort_images/4VXIhvL8Xp4wQk3rrkoqODEGuHOH4zMB4nSZZsvp.jpeg\",\n                   \"resort_id\": 1\n               }\n           ]\n       }\n   ]\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Order & Request found.\",\n   \"data\": {\n       \"order_request\": [\n          {\n               \"id\": 1,\n               \"comment\": \"\",\n               \"service_id\": 1,\n               \"question_id\": 1,\n               \"request_status_id\": 1,\n               \"accepted_by_id\": 1,\n               \"date\": \"15-11-2018\",\n               \"time\": \"04:31:35 AM\",\n               \"service_detail\": {\n                   \"id\": 1,\n                   \"name\": \"Iron\",\n                   \"type_id\": 1,\n                   \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/O43z5c9J2lUhL1iRmQHNietloHjRLHbpiD842V2X.jpeg\",\n                   \"service_type\": {\n                       \"id\": 1,\n                       \"name\": \"Housekeeping\"\n                   }\n               },\n               \"question_detail\": {\n                   \"id\": 1,\n                   \"name\": \"Lorem Ipsum is simply dummy text\"\n               },\n               \"request_status\": {\n                   \"id\": 1,\n                   \"status\": \"Pending\"\n               },\n               \"accepted_by\": {\n                   \"id\": 1,\n                   \"user_name\": \"Admin\",\n                   \"first_name\": \"Admin\",\n                   \"last_name\": null\n               }\n           }\n       ]\n   }\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Services listing.\",\n   \"data\": {\n       \"housekeeping\": [\n           {\n               \"id\": 1,\n               \"name\": \"Air conditioner\",\n               \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/cWpiFZ9YG4duaP7Cfch2DgeVn3AYdSBAZPWFkd6g.png\",\n               \"questions\": [\n                   {\n                       \"id\": 1,\n                       \"name\": \"question 1\"\n                   },\n                   {\n                       \"id\": 2,\n                       \"name\": \"question 2\"\n                   }\n               ]\n           },\n           {\n               \"id\": 3,\n               \"name\": \"Air conditioners\",\n               \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/i0hRXnlJoVdUcSENmCNxvHANVZ1drvwyFqtVB14O.png\",\n               \"questions\": [\n                    {\n                       \"id\": 1,\n                       \"name\": \"question 1\"\n                    },\n                   {\n                       \"id\": 2,\n                       \"name\": \"question 2\"\n                   }\n               ]\n           }\n       ],\n       \"issues\": [\n           {\n                \"id\": 2,\n               \"name\": \"Room Cleaning\",\n               \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/i0hRXnlJoVdUcSENmCNxvHANVZ1drvwyFqtVB14O.png\",\n               \"questions\": [\n                   {\n                       \"id\": 1,\n                       \"name\": \"question 1\"\n                   }\n               ]\n          },\n          {\n              \"id\": 4,\n              \"name\": \"Do Not Disturbe\",\n              \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/i0hRXnlJoVdUcSENmCNxvHANVZ1drvwyFqtVB14O.png\",\n              \"questions\": [\n                  {\n                      \"id\": 1,\n                      \"name\": \"question 1\"\n                  },\n                  {\n                      \"id\": 2,\n                      \"name\": \"question 2\"\n                  }\n              ]\n          }\n      ]\n  }\n}",
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
            "field": "service_id",
            "description": "<p>Service id*.</p>"
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
            "field": "ServiceIdMissing",
            "description": "<p>The service id is missing.</p>"
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
            "description": "<p>Service id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "question_id",
            "description": "<p>question id.</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Request successfully created.\",\n\"data\": {}\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"My jobs.\",\n   \"data\": {\n       \"ongoing_jobs\": [\n           {\n               \"id\": 1,\n               \"comment\": \"\",\n               \"question_id\": 1,\n               \"service_id\": 1,\n               \"request_status_id\": 2,\n               \"user_id\": 2,\n               \"service_detail\": {\n                   \"id\": 1,\n                   \"name\": \"Air conditioner\",\n                   \"type_id\": 1,\n                   \"service_type\": {\n                       \"id\": 1,\n                       \"name\": \"Housekeeping\"\n                   }\n               },\n               \"question_detail\": {\n                   \"id\": 1,\n                   \"name\": \"question 1\"\n               },\n               \"request_status\": {\n                   \"id\": 2,\n                   \"status\": \"On going\"\n               },\n               \"user_detail\": {\n                   \"id\": 2,\n                   \"user_name\": \"Hariom Gangwar\",\n                   \"email_id\": \"hariom4037@gmail.com\",\n                   \"mobile_number\": \"9999999999\",\n                   \"user_booking_detail\": {\n                       \"id\": 1,\n                       \"user_id\": 2,\n                       \"source_name\": \"Makemy trip\",\n                       \"source_id\": \"QWERTY12345\",\n                       \"resort_id\": 1,\n                       \"resort\": {\n                           \"id\": 1,\n                           \"name\": \"Parth Inn\",\n                           \"description\": \"<p>Lorem ipsum</p>\",\n                           \"contact_number\": \"9999999999\",\n                           \"address_1\": \"sector 63\"\n                       },\n                       \"room_booking\": {\n                           \"id\": 1,\n                           \"check_in\": \"2018-11-06 00:00:00\",\n                           \"check_out\": \"2018-11-06 00:00:00\",\n                           \"room_type_id\": 2,\n                           \"resort_room_id\": 3,\n                           \"room_type\": {\n                               \"id\": 2,\n                               \"name\": \"Cottage\"\n                           },\n                           \"resort_room\": {\n                               \"id\": 3,\n                               \"room_no\": \"105\"\n                           }\n                       },\n                       \"bookingpeople_accompany\": [\n                           {\n                               \"id\": 1,\n                               \"person_name\": \"Ankit\",\n                               \"person_age\": \"25\",\n                               \"person_type\": \"Adult\"\n                           },\n                           {\n                               \"id\": 2,\n                               \"person_name\": \"Anshi\",\n                               \"person_age\": \"5\",\n                               \"person_type\": \"Child\"\n                           }\n                       ]\n                   }\n               }\n           }\n       ],\n       \"under_approval_jobs\": [],\n       \"completed_jobs\": []\n   }\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Service request found.\",\n   \"data\": [\n       {\n           \"id\": 1,\n           \"comment\": \"\",\n           \"service_id\": 1,\n           \"user_id\": 2,\n           \"question_id\": 1,\n           \"question_detail\": {\n               \"id\": 1,\n               \"question\": \"question 1\"\n           },\n           \"service_detail\": {\n               \"id\": 1,\n               \"name\": \"Air conditioner\",\n               \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/se9y9nUSeTSmoYw90EloODuyFUDyF1w86h3ngTll.jpeg\",\n               \"type_id\": 1,\n               \"service_type\": {\n                   \"id\": 1,\n                   \"name\": \"Housekeeping\"\n               }\n           },\n           \"user_detail\": {\n               \"id\": 2,\n               \"user_name\": \"Hariom Gangwar\",\n               \"email_id\": \"hariom4037@gmail.com\",\n               \"mobile_number\": \"9999999999\",\n               \"user_booking_detail\": {\n                   \"id\": 1,\n                   \"user_id\": 2,\n                   \"source_name\": \"Makemy trip\",\n                   \"source_id\": \"QWERTY12345\",\n                   \"resort_id\": 1,\n                  \"resort\": {\n                       \"id\": 1,\n                       \"name\": \"Parth Inn\",\n                       \"description\": \"<p>Lorem ipsum</p>\",\n                       \"contact_number\": \"9999999999\",\n                       \"address_1\": \"sector 63\"\n                   },\n                   \"room_booking\": {\n                       \"id\": 1,\n                       \"check_in\": \"2018-11-06 00:00:00\",\n                       \"check_out\": \"2018-11-06 00:00:00\",\n                       \"room_type_id\": 2,\n                       \"resort_room_id\": 3,\n                       \"room_type\": {\n                           \"id\": 2,\n                           \"name\": \"Cottage\"\n                       },\n                      \"resort_room\": {\n                           \"id\": 3,\n                           \"room_no\": \"105\"\n                       }\n                   },\n                  \"bookingpeople_accompany\": [\n                       {\n                           \"id\": 1,\n                           \"person_name\": \"Ankit\",\n                           \"person_age\": \"25\",\n                           \"person_type\": \"Adult\"\n                       },\n                       {\n                           \"id\": 2,\n                           \"person_name\": \"Anshi\",\n                           \"person_age\": \"5\",\n                           \"person_type\": \"Child\"\n                      }\n                  ]\n              }\n          }\n       }\n   ]\n}",
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
            "field": "old_password",
            "description": "<p>old Password.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>New Password.</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n \"status\": true,\n \"message\": \"User check-in successfully.\",\n \"data\": []\n}",
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
            "description": "<p>Full name.</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Profile update succesfully.\",\n\"data\": {}\n}",
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

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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"OTP verified successfully.\",\n   \"data\": {\n       \"id\": 2,\n       \"user_name\": \"Hariom\",\n       \"first_name\": \"Hariom\",\n       \"mid_name\": null,\n       \"last_name\": \"\",\n       \"email_id\": \"hariom4037@gmail.com\",\n       \"user_type_id\": 3,\n       \"is_checked_in\": false,\n       \"address\": null,\n       \"state\": \"UP\",\n       \"city\": \"Noida\",\n       \"pincode\": \"201301\",\n       \"screen_name\": null,\n       \"profile_pic_path\": null,\n       \"mobile_number\": \"9808243372\",\n       \"token_type\": \"Bearer\",\n       \"access_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijg2ZjM5ZTA0ZjQxN2\n         QwNDNhZmRkYWY4NDJlNTNlNTQ3NjMxYzJkMTdkMThmZDVlM2VhMTk1OTc3MGZmZjQzMWE2NjI1ZjI\n0YzE5NDk1ZjllIn0.eyJhdWQiOiIxIiwianRpIjoiODZmMzllMDRmNDE3ZDA0M2FmZGRhZjg0MmU1M2U1NDc2M\nzFjMmQxN2QxOGZkNWUzZWExOTU5NzcwZmZmNDMxYTY2MjVmMjRjMTk0OTVmOWUiLCJpYXQiOjE1NDIyNTU5MDY\nsIm5iZiI6MTU0MjI1NTkwNiwiZXhwIjoxNTczNzkxOTA2LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.qnRi5ZXrBR\nYk2DJdNi8GbsRkb9g3g26MoBinbHJdGYS0hEfYiItve5yAhRmvQhPiIW_GXIhKRKPAcGmy1tHsneiUEScDjD35EW\nZwd39bpQGDx_VQAGp5JlM2rlj5KOVv52BqFiyLiod8621eevI7SvduWm7VojLFXPRqsWbCilVcQQB5WPIFdTNfor\ng3giro7Qa_nzmEZH_iUl0_955HWHx9L9XmuSg9pznePzcDqbyG4M7gB6guJUk0hIUP3cO3Aueu91LZtsA-jGXRkj\ndT2S9ONpVRWewl1aksPzjYFxtdUSfH2PQveGWsCMCka85i1B5v1JlyqDb38gNeWbB3Gqy8-2rV9AYS5gYy1lAgCv\nxrR9XoElyyguLU_BHQCMuU7_-034A1UbHZfg9_r3IR85_u25McRvSTHiZWPQXVDD2tHh5zLyhyDJjcD_Bh9jMxSE\n9E3b9HruJiJv8DVhTkvW6re95astIZe5X7oW8j7fDHvwWBUMdBfSnnBcyCp-6HVl6nByxevw3-OV_ugsCDuhsOKWw\njaUT4KkyJFxFjKjmbSQautj2FBum3Vy85fOMkgye_8rfYADsKXw81RQjixkflRfmifP4Ii68tES77apdXGqxJricNc\nVSBPzBiUThcnPCd_X8f4-vuQwp3KM-Jn8-rC0RT1lUHhlnHPyEzAmQ\",\n       \"source_name\": \"Make my trip\",\n       \"source_id\": \"QWERT123456\",\n       \"resort_room_no\": 1,\n       \"room_type\": \"Delux\",\n       \"check_in_date\": \"15-Nov-2018\",\n       \"check_in_time\": \"00:00 AM\",\n       \"check_out_date\": \"17-Nov-2018\",\n       \"check_out_time\": \"00:00 AM\",\n       \"booking_id\": 1,\n       \"no_of_guest\": \"1 Adult and 2 Child\",\n       \"guest_detail\": [\n           {\n               \"id\": 1,\n               \"person_name\": \"Ankit\",\n               \"person_age\": \"25\",\n               \"person_type\": \"Adult\"\n           },\n           {\n               \"id\": 2,\n               \"person_name\": \"Anshu\",\n               \"person_age\": \"5\",\n               \"person_type\": \"Child\"\n           },\n           {\n               \"id\": 3,\n               \"person_name\": \"om\",\n               \"person_age\": \"10\",\n               \"person_type\": \"Child\"\n           }\n       ],\n       \"resort\": {\n           \"id\": 1,\n           \"name\": \"Parth Inn\",\n           \"description\": \"<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\",\n           \"contact_number\": \"9808243372\",\n           \"other_contact_number\": null,\n           \"address_1\": \"Sector 66\",\n           \"address_2\": null,\n           \"address_3\": null,\n           \"pincode\": 243601,\n           \"city_id\": 50,\n           \"latitude\": 0,\n           \"longitude\": 0,\n           \"is_active\": 1,\n           \"domain_id\": 0,\n           \"created_by\": \"1\",\n           \"updated_by\": \"1\",\n           \"created_at\": \"2018-11-14 13:51:50\",\n           \"updated_at\": \"2018-11-14 13:52:58\"\n       }\n   }\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"healthcare program found.\",\n   \"data\": [\n       {\n           \"id\": 1,\n           \"name\": \"Diabetes Program\",\n           \"description\": \"<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>\",\n           \"start_from\": \"24-11-2018\",\n           \"end_to\": \"27-11-2018\",\n           \"total_days\": 4,\n           \"healthcare_images\": [\n               {\n                   \"id\": 1,\n                   \"banner_image_url\": \"http://127.0.0.1:8000/storage/offer_images/6ucWdCWKsZeZPDfIxfGVlzbg4VtjpLXG8HhpON8g.jpeg\",\n                   \"health_program_id\": 1\n               },\n               {\n                   \"id\": 2,\n                   \"banner_image_url\": \"http://127.0.0.1:8000/storage/offer_images/QKSTxwKTkrHBY1vp3OmMNSONGjse5lUT27xo8PXf.jpeg\",\n                   \"health_program_id\": 1\n               }\n           ],\n           \"healthcare_days\": [\n               {\n                   \"id\": 1,\n                   \"day\": \"1\",\n                   \"description\": \"<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>\",\n                   \"health_program_id\": 1\n               },\n               {\n                   \"id\": 2,\n                   \"day\": \"2\",\n                   \"description\": \"<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>\",\n                   \"health_program_id\": 1\n               },\n               {\n                   \"id\": 3,\n                   \"day\": \"3\",\n                   \"description\": \"<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>\",\n                   \"health_program_id\": 1\n               },\n               {\n                   \"id\": 4,\n                   \"day\": \"4\",\n                   \"description\": \"<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>\",\n                   \"health_program_id\": 1\n               }\n           ]\n       }\n   ]\n}",
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"My Health Package\",\n      \"data\": {\n          \"id\": 2,\n          \"name\": \"Healthcare Package\",\n          \"description\": \"<p>Testing</p>\",\n          \"start_from\": \"28-11-2018\",\n          \"end_to\": \"28-11-2018\",\n          \"healthcare_images\": [\n              {\n                  \"id\": 2,\n                  \"banner_image_url\": \"http://127.0.0.1:8000/storage/healthcare_images/58PUwfdKYmUzP4hO8WdQMLLrhuhUAbXXp5WoNgNO.jpeg\",\n                  \"health_program_id\": 2\n              },\n              {\n                  \"id\": 3,\n                  \"banner_image_url\": \"http://127.0.0.1:8000/storage/healthcare_images/m9MW1Nb8LWCMrZa992hcHoLSPgBlMkkjw9fsKAri.jpeg\",\n                  \"health_program_id\": 2\n              }\n          ],\n          \"healthcare_days\": [\n              {\n                  \"id\": 4,\n                  \"day\": \"1\",\n                  \"description\": \"<p>Testing</p>\",\n                  \"health_program_id\": 2\n              },\n              {\n                  \"id\": 5,\n                  \"day\": \"2\",\n                  \"description\": \"<p>Testing</p>\",\n                  \"health_program_id\": 2\n              },\n              {\n                  \"id\": 6,\n                  \"day\": \"3\",\n                  \"description\": \"<p>Testing</p>\",\n                  \"health_program_id\": 2\n              }\n          ]\n      }\n  }",
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Health Package found\",\n      \"data\": {\n          \"upcoming\": [\n              {\n                  \"id\": 2,\n                  \"name\": \"Healthcare Package\",\n                  \"duration\": \"28-11-2018 to 28-11-2018\",\n                  \"status\": \"Booking Confirmed\"\n              }\n          ],\n          \"complete\": [\n              {\n                  \"id\": 2,\n                  \"name\": \"Healthcare Package\",\n                  \"duration\": \"28-11-2018 to 28-11-2018\",\n                  \"status\": \"Booking Confirmed\"\n              }\n          ]\n      }\n  }",
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"service successfully access.\",\n      \"data\": {\n      \"user\": {\n      \"id\": 3,\n      \"user_name\": \"Amit Singh\",\n      \"mobile_number\": \"8888888888\",\n      \"email_id\": \"amit@mail.com\",\n      \"voter_id\": null,\n      \"aadhar_id\": null,\n      \"address1\": null,\n      \"city_id\": 87,\n      \"user_type_id\": 3,\n      \"no_of_rooms\": \"1\",\n      \"user_health_detail\": {\n      \"id\": 2,\n      \"user_id\": 3,\n      \"medical_documents\": \"http://sanjeevani.dbaquincy.com/storage/medical_document/rU4C2wTS2oMnTakZpfFf8zd7LNS6Oe4b3ISx7pxP.jpeg\",\n      \"fasting\": \"Fasting\",\n      \"bp\": \"BP\",\n      \"insullin_dependency\": \"insuline\",\n      \"diabeties\": \"yes\",\n      \"ppa\": \"yes\",\n      \"hba_1c\": \"yes\"\n      },\n      \"user_booking_detail\": {\n      \"id\": 2,\n      \"user_id\": 3,\n      \"booking_id\": \"ZXC12345\",\n      \"source_name\": \"Makemy trip\",\n      \"resort_id\": 2,\n      \"package_id\": 1,\n      \"resort\": {\n      \"id\": 2,\n      \"name\": \"Royal Heritage Resor\",\n      \"description\": \"<p>There are six independent hut style accomodations, which come with double occupancy rooms and living cum dining areas. There are 12 standard rooms as well, and each room comes with various amenities such as high speed internet access, Bose CD System and much more.</p>\",\n      \"contact_number\": \"9808243372\",\n      \"address_1\": \"city center of Leh\"\n      },\n      \"room_booking\": {\n      \"id\": 2,\n      \"check_in\": \"16-11-2018\",\n      \"check_in_time\": \"12:00:00 AM\",\n      \"check_out\": \"22-11-2018\",\n      \"check_out_time\": \"12:00:00 AM\",\n      \"room_type_id\": 1,\n      \"resort_room_id\": 21,\n      \"room_type\": {\n      \"id\": 1,\n      \"name\": \"Tent\"\n      },\n      \"resort_room\": null\n      },\n      \"bookingpeople_accompany\": [\n      {\n      \"id\": 4,\n      \"person_name\": \"Maan singh\",\n      \"person_age\": \"35\",\n      \"person_type\": \"Adult\"\n      },\n      {\n      \"id\": 5,\n      \"person_name\": \"Pratiraksha\",\n      \"person_age\": \"5\",\n      \"person_type\": \"Child\"\n      }\n      ]\n      }\n      },\n      \"banners\": [\n      {\n      \"id\": 1,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/banner_images/fozc4dLglmoMnMFr9XADAjgZrRJt6MM339LBtOof.jpeg\"\n      },\n      {\n      \"id\": 2,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/banner_images/pQH8non1kv3GsVNmTUo8u0q2NKWfL9K6z5Zau8Wq.jpeg\"\n      },\n      {\n      \"id\": 3,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/banner_images/qN0RhbeOvz93GmXi2pJrfzffwyslrVXEXDdk6lxZ.jpeg\"\n      },\n      {\n      \"id\": 4,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/banner_images/VcdwF9xCFN7FnlxFQWIFv1YVAbSOLq9WANUHxmzD.jpeg\"\n      },\n      {\n      \"id\": 5,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/banner_images/ZgI7mMDQuvSODcIwcKGi00xcdLlZe721WO6PeLJW.jpeg\"\n      }\n      ],\n      \"nearby_attaractions\": [\n      {\n      \"id\": 1,\n      \"name\": \"Water Fall\"\n      },\n      {\n      \"id\": 2,\n      \"name\": \"Nilgiri Forest\"\n      },\n      {\n      \"id\": 3,\n      \"name\": \"Bird sanctuary\"\n      },\n      {\n      \"id\": 4,\n      \"name\": \"Water Fall New\"\n      },\n      {\n      \"id\": 5,\n      \"name\": \"Nilgiri Forest\"\n      }\n      ],\n      \"best_offers\": [\n      {\n      \"id\": 1,\n      \"name\": \"3 Days, 3 Nights\",\n      \"price\": 2100,\n      \"discount\": \"10% OFF\",\n      \"discounted_price\": 1890,\n      \"offer_images\": [\n      {\n      \"id\": 1,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/offer_images/AvgLdM35wzdYPDGf6qshxzwBXXbxEznofnIwx2Br.jpeg\",\n      \"offer_id\": 1\n      },\n      {\n      \"id\": 2,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/offer_images/Hav6f0MNfvvqHW0ppsROIBDLcwlhFgfxRKhZELkC.jpeg\",\n      \"offer_id\": 1\n      }\n      ]\n      },\n      {\n      \"id\": 2,\n      \"name\": \"3 Days, 2 Nights\",\n      \"price\": 5000,\n      \"discount\": \"20% OFF\",\n      \"discounted_price\": 4000,\n      \"offer_images\": [\n      {\n      \"id\": 3,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/offer_images/hJvW1nKfqDArBg4zjJPtnSozN63WOBD7fkcNC0V2.jpeg\",\n      \"offer_id\": 2\n      },\n      {\n      \"id\": 4,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/offer_images/i9ny0wdWBuJMrRI0n0pevbZHS2SdMrmy4vQ4DTUK.jpeg\",\n      \"offer_id\": 2\n      }\n      ]\n      }\n      ],\n      \"health_care\": [\n      {\n      \"id\": 1,\n      \"name\": \"Diabetes Program\",\n      \"healthcare_images\": [\n      {\n      \"id\": 1,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/offer_images/AvgLdM35wzdYPDGf6qshxzwBXXbxEznofnIwx2Br.jpeg\",\n      \"health_program_id\": 1\n      },\n      {\n      \"id\": 2,\n      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/offer_images/Hav6f0MNfvvqHW0ppsROIBDLcwlhFgfxRKhZELkC.jpeg\",\n      \"health_program_id\": 1\n      }\n      ]\n      }\n      ]\n      }\n  }",
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
            "description": "<p>Resort id*.</p>"
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Meal list found\",\n      \"data\": {\n          \"meal_packages\": [\n              {\n                  \"id\": 1,\n                  \"name\": \"Package 1\",\n                  \"image_url\": \"http://127.0.0.1:8000/storage/meal_package_images/bJfZEM2qedVLzQSHaPNLCezULofRgDol14MEjak8.jpeg\",\n                  \"price\": 1100,\n                  \"quantity_count\": 0,\n                  \"meal_items\": [\n                      {\n                          \"id\": 1,\n                          \"name\": \"Aloo tikki\",\n                          \"image_url\": \"http://127.0.0.1:8000/storage/meal_images/XxV3OiCh3XC6Js2Q0MAsCLkjpBwnThd4J6L54XTG.jpeg\",\n                          \"price\": 500\n                      },\n                      {\n                          \"id\": 2,\n                          \"name\": \"Chees puff\",\n                          \"image_url\": \"http://127.0.0.1:8000/storage/meal_images/MDkVNWyReK39GTIu8gzEdTRcsyXNPrxgCIg4mfse.png\",\n                          \"price\": 1200\n                      },\n                      {\n                          \"id\": 3,\n                          \"name\": \"Furti\",\n                          \"image_url\": \"http://127.0.0.1:8000/storage/meal_images/LJpF4r1MOC20jKgFlUOp6CRX30WhlZD5zbqEkDq5.png\",\n                          \"price\": 60\n                      }\n                  ]\n              },\n              {\n                  \"id\": 2,\n                  \"name\": \"Package 2\",\n                  \"image_url\": \"http://127.0.0.1:8000/storage/meal_package_images/IMfrpkKB0EE4cSmWD848vD3VOjgf2Lp7JYMnKvJF.png\",\n                  \"price\": 850,\n                  \"quantity_count\": 0,\n                  \"meal_items\": [\n                      {\n                          \"id\": 4,\n                          \"name\": \"Dal Makkhni\",\n                          \"image_url\": \"http://127.0.0.1:8000/storage/meal_images/iqbEho8dXoQ8TzasM6wSjdJAy4H7zs94ZtGHWiZw.jpeg\",\n                          \"price\": 200\n                      },\n                      {\n                          \"id\": 5,\n                          \"name\": \"Dal Tadka\",\n                          \"image_url\": \"http://127.0.0.1:8000/storage/meal_images/SdFRP8PvNOkvH7Ohb2fWjwVxYq9fqNrl2tib2WxC.png\",\n                          \"price\": 180\n                      },\n                      {\n                          \"id\": 6,\n                          \"name\": \"Sprite\",\n                          \"image_url\": \"http://127.0.0.1:8000/storage/meal_images/UZxxbKeaBDydPIbME6Qi0RySAUqe7r23TvGCODtr.jpeg\",\n                          \"price\": 55\n                      }\n                  ]\n              }\n          ],\n          \"category_meal\": [\n              {\n                  \"id\": 2,\n                  \"name\": \"Starters\",\n                  \"menu_items\": [\n                      {\n                          \"id\": 4,\n                          \"name\": \"Aloo tikki\",\n                          \"banner_image_url\": \"http://127.0.0.1:8000/storage/meal_images/XxV3OiCh3XC6Js2Q0MAsCLkjpBwnThd4J6L54XTG.jpeg\",\n                          \"price\": 500,\n                          \"quantity_count\": 4\n                      },\n                      {\n                          \"id\": 5,\n                          \"name\": \"Chees puff\",\n                          \"banner_image_url\": \"http://127.0.0.1:8000/storage/meal_images/MDkVNWyReK39GTIu8gzEdTRcsyXNPrxgCIg4mfse.png\",\n                          \"price\": 1200,\n                          \"quantity_count\": 1\n                      }\n                  ]\n              },\n              {\n                  \"id\": 3,\n                  \"name\": \"Main Course\",\n                  \"menu_items\": [\n                      {\n                          \"id\": 6,\n                          \"name\": \"Dal Makkhni\",\n                          \"banner_image_url\": \"http://127.0.0.1:8000/storage/meal_images/iqbEho8dXoQ8TzasM6wSjdJAy4H7zs94ZtGHWiZw.jpeg\",\n                          \"price\": 200,\n                          \"quantity_count\": 0\n                      },\n                      {\n                          \"id\": 7,\n                          \"name\": \"Dal Tadka\",\n                          \"banner_image_url\": \"http://127.0.0.1:8000/storage/meal_images/SdFRP8PvNOkvH7Ohb2fWjwVxYq9fqNrl2tib2WxC.png\",\n                          \"price\": 180,\n                          \"quantity_count\": 0\n                      },\n                      {\n                          \"id\": 8,\n                          \"name\": \"Matar Paneer\",\n                          \"banner_image_url\": \"http://127.0.0.1:8000/storage/meal_images/SLbPjB8yDlzp5j0KDWkMThSGJ1aRbVrm5Xel06mK.jpeg\",\n                          \"price\": 550,\n                          \"quantity_count\": 0\n                      }\n                  ]\n              },\n              {\n                  \"id\": 4,\n                  \"name\": \"Breads\",\n                  \"menu_items\": [\n                      {\n                          \"id\": 9,\n                          \"name\": \"Tandoori roti\",\n                          \"banner_image_url\": \"http://127.0.0.1:8000/storage/meal_images/bAYr15Pu7XrODtdK1QHy7eqJMWpdPRVT0iGHuizR.jpeg\",\n                          \"price\": 10,\n                          \"quantity_count\": 0\n                      },\n                      {\n                          \"id\": 10,\n                          \"name\": \"Tawa roti\",\n                          \"banner_image_url\": \"http://127.0.0.1:8000/storage/meal_images/JOkgivUsvPLzzl2iHrjPjEKeJeR5iAMK3b91rmaD.jpeg\",\n                          \"price\": 5,\n                          \"quantity_count\": 0\n                      }\n                  ]\n              },\n              {\n                  \"id\": 5,\n                  \"name\": \"Drinks\",\n                  \"menu_items\": [\n                      {\n                          \"id\": 11,\n                          \"name\": \"Sprite\",\n                          \"banner_image_url\": \"http://127.0.0.1:8000/storage/meal_images/UZxxbKeaBDydPIbME6Qi0RySAUqe7r23TvGCODtr.jpeg\",\n                          \"price\": 55,\n                          \"quantity_count\": 0\n                      },\n                      {\n                          \"id\": 12,\n                          \"name\": \"Furti\",\n                          \"banner_image_url\": \"http://127.0.0.1:8000/storage/meal_images/LJpF4r1MOC20jKgFlUOp6CRX30WhlZD5zbqEkDq5.png\",\n                          \"price\": 60,\n                          \"quantity_count\": 0\n                      }\n                  ]\n              }\n          ]\n      }\n  }",
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"offers found\",\n   \"data\": [\n       {\n           \"id\": 2,\n           \"name\": \"3 days, 3 nights\",\n          \"description\": \"<h1><strong>3 days, 3 nights</strong></h1>\\n\\n<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>\\n\\n<ul>\\n\\t<li>\\n\\t<h1>but also the leap into electronic typesetting, remaining essentially unchanged.</h1>\\n\\t</li>\\n\\t<li>\\n\\t<h1>It was popularised in the 1960s with the release of Letraset sheets containing</h1>\\n\\t</li>\\n\\t<li>\\n\\t<h1>Lorem Ipsum passages, and more recently with desktop publishing software</h1>\\n\\t</li>\\n\\t<li>\\n\\t<h1>like Aldus PageMaker including versions of Lorem Ipsum</h1>\\n\\t</li>\\n</ul>\\n\",\n           \"valid_to\": \"Nov-21-2018\",\n           \"price\": 500,\n           \"discount\": \"10% OFF\",\n           \"discounted_price\": 450,\n           \"offer_images\": [\n               {\n                   \"id\": 2,\n                   \"banner_image_url\": \"http://127.0.0.1:8000/storage/offer_images/QKSTxwKTkrHBY1vp3OmMNSONGjse5lUT27xo8PXf.jpeg\",\n                   \"offer_id\": 2\n               },\n               {\n                   \"id\": 3,\n                   \"banner_image_url\": \"http://127.0.0.1:8000/storage/offer_images/KBv5Q07WSicZDST5Wf42U2iFhSivLMh6TsK5frcE.jpeg\",\n                   \"offer_id\": 2\n               }\n           ]\n       }\n   ]\n}",
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Order created succeffully.\",\n      \"data\": {\n          \"total_amount\": 0,\n          \"outstanding_amount\": 0,\n          \"paid_amount\": 0,\n          \"invoices\": [\n              {\n                  \"id\": 5,\n                  \"invoice_id\": \"1544009535\",\n                  \"item_total_amount\": 1175,\n                  \"gst_amount\": 0,\n                  \"total_amount\": 1175,\n                  \"created_on\": \"05-12-2018\",\n                  \"order_items\": [\n                      {\n                          \"id\": 13,\n                          \"meal_item_name\": \"Pepsi\",\n                          \"quantity\": 2,\n                          \"price\": 55,\n                          \"meal_order_id\": 5\n                      },\n                      {\n                          \"id\": 14,\n                          \"meal_item_name\": \"Panner\",\n                          \"quantity\": 3,\n                          \"price\": 120,\n                          \"meal_order_id\": 5\n                      },\n                      {\n                          \"id\": 15,\n                          \"meal_item_name\": \"test\",\n                          \"quantity\": 3,\n                          \"price\": 1000,\n                          \"meal_order_id\": 5\n                      }\n                  ]\n              },\n              {\n                  \"id\": 6,\n                  \"invoice_id\": \"1544009626\",\n                  \"item_total_amount\": 1175,\n                  \"gst_amount\": 0,\n                  \"total_amount\": 1175,\n                  \"created_on\": \"05-12-2018\",\n                  \"order_items\": [\n                      {\n                          \"id\": 16,\n                          \"meal_item_name\": \"Pepsi\",\n                          \"quantity\": 2,\n                          \"price\": 55,\n                          \"meal_order_id\": 6\n                      },\n                      {\n                          \"id\": 17,\n                          \"meal_item_name\": \"Panner\",\n                          \"quantity\": 3,\n                          \"price\": 120,\n                          \"meal_order_id\": 6\n                      },\n                      {\n                          \"id\": 18,\n                          \"meal_item_name\": \"test\",\n                          \"quantity\": 3,\n                          \"price\": 1000,\n                          \"meal_order_id\": 6\n                      }\n                  ]\n              },\n              {\n                  \"id\": 7,\n                  \"invoice_id\": \"1544009691\",\n                  \"item_total_amount\": 1175,\n                  \"gst_amount\": 0,\n                  \"total_amount\": 1175,\n                  \"created_on\": \"05-12-2018\",\n                  \"order_items\": [\n                      {\n                          \"id\": 19,\n                          \"meal_item_name\": \"Pepsi\",\n                          \"quantity\": 2,\n                          \"price\": 55,\n                          \"meal_order_id\": 7\n                      },\n                      {\n                          \"id\": 20,\n                          \"meal_item_name\": \"Panner\",\n                          \"quantity\": 3,\n                          \"price\": 120,\n                          \"meal_order_id\": 7\n                      },\n                      {\n                          \"id\": 21,\n                          \"meal_item_name\": \"test\",\n                          \"quantity\": 3,\n                          \"price\": 1000,\n                          \"meal_order_id\": 7\n                      }\n                  ]\n              }\n          ]\n      }\n  }",
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
          "content": "HTTP/1.1 200 OK\n      {\n          \"status\": true,\n          \"status_code\": 200,\n          \"message\": \"my cart list\",\n          \"data\": {\n              \"cart_items\": [\n                  {\n                      \"id\": 1,\n                      \"type\": 1,\n                      \"item_id\": 1,\n                      \"image_url\": \"http://127.0.0.1:8000/storage/meal_images/yo3fjabmiRMkZJORW2vK3hiUuZd8MrCTM7pQBVlM.jpeg\",\n                      \"item_name\": \"Pepsi\",\n                      \"item_price\": 55,\n                      \"quantity\": 2\n                  },\n                  {\n                      \"id\": 2,\n                      \"type\": 1,\n                      \"item_id\": 2,\n                      \"image_url\": \"http://127.0.0.1:8000/storage/meal_images/eJN5RZidujhG0OYqg0l9Sk62BZu3WYnhThLGZAOn.jpeg\",\n                      \"item_name\": \"Panner\",\n                      \"item_price\": 120,\n                      \"quantity\": 3\n                  },\n                  {\n                      \"id\": 3,\n                      \"type\": 2,\n                      \"item_id\": 1,\n                      \"image_url\": \"http://127.0.0.1:8000/storage/meal_package_images/wS2vOgqhIl4uzR3UZBcuXQBbaPohOtA85eXE9k2Z.jpeg\",\n                      \"item_name\": \"test\",\n                      \"item_price\": 1000,\n                      \"quantity\": 3\n                  }\n              ],\n              \"total_no_item\": 3,\n              \"item_amount\": 1175,\n              \"gst\": 0,\n              \"total_amount\": 1175\n          }\n      }",
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
            "description": "<p>1=&gt;Meal item, 2=&gt; Meal package Item.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "meal_item_id",
            "description": "<p>Meal item id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "meal_package_id",
            "description": "<p>Meal Package Id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "quantity",
            "description": "<p>Quantity.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flag",
            "description": "<p>Increment or add =&gt; 1, Decrement =&gt; 2.</p>"
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Item added to cart\",\n      \"data\": {\n          \"cart_count\": 4,\n          \"quantity_count\": 2\n      }\n  }",
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Order created succeffully.\",\n   \"data\": {\n       \"invoice_id\": 1544009691,\n       \"total_amount\": 1175\n   }\n}",
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Resort found.\",\n      \"data\": {\n          \"resort\": {\n              \"id\": 1,\n              \"name\": \"Parth Inn\",\n              \"description\": \"<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\",\n              \"address\": \"sector 63\",\n              \"latitude\": \"12.124565\",\n              \"longitude\": \"13.213245\",\n              \"room_types\": [\n                  {\n                      \"id\": 1,\n                      \"name\": \"Tent\",\n                      \"icon\": \"http://127.0.0.1:8000/storage/room_type_icon\",\n                      \"description\": \"<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s,</p>\",\n                       \"room_images\": [\n                          {\n                              \"id\": 1,\n                              \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/room_images/Q2czItOa8fzuQ25kNsXRYTQxI3AP9CAHrBvVi068.jpeg\"\n                          },\n                          {\n                              \"id\": 2,\n                              \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/room_images/WInHZfmKjbhbFL6nsjR1liQGOUKTXWtDth0TR6Bv.jpeg\"\n                          }\n                      ]\n                  },\n                  {\n                      \"id\": 2,\n                      \"name\": \"Cottage\",\n                      \"icon\": \"http://127.0.0.1:8000/storage/room_type_icon\",\n                      \"description\": \"<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s,</p>\",\n                       \"room_images\": [\n                          {\n                              \"id\": 1,\n                              \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/room_images/Q2czItOa8fzuQ25kNsXRYTQxI3AP9CAHrBvVi068.jpeg\"\n                          },\n                          {\n                              \"id\": 2,\n                              \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/room_images/WInHZfmKjbhbFL6nsjR1liQGOUKTXWtDth0TR6Bv.jpeg\"\n                          }\n                      ]\n                  },\n                  {\n                      \"id\": 3,\n                      \"name\": \"Delux Room\",\n                      \"icon\": \"http://127.0.0.1:8000/storage/room_type_icon\",\n                      \"description\": \"<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s,</p>\",\n                       \"room_images\": [\n                          {\n                              \"id\": 1,\n                              \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/room_images/Q2czItOa8fzuQ25kNsXRYTQxI3AP9CAHrBvVi068.jpeg\"\n                          },\n                          {\n                              \"id\": 2,\n                              \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/room_images/WInHZfmKjbhbFL6nsjR1liQGOUKTXWtDth0TR6Bv.jpeg\"\n                          }\n                      ]\n                  }\n              ],\n              \"resort_images\": [\n                  {\n                      \"id\": 1,\n                      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/Resort/ptjHTnrFSngDDbqO20ZHl4YDy035S0z1cIuop8EC.jpeg\",\n                      \"resort_id\": 1\n                  },\n                  {\n                      \"id\": 2,\n                      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/Resort/xQvt0XF682PO9gzaA05gTB2MQKP0ZH62XYGsgn2i.jpeg\",\n                      \"resort_id\": 1\n                  },\n                  {\n                      \"id\": 3,\n                      \"image_name\": \"http://sanjeevani.dbaquincy.com/storage/Resort/NqHeZs8Qw9gIyuRNNg3YgtD3JrS0Cx5QH8OmYaAy.jpeg\",\n                      \"resort_id\": 1\n                  },\n                  {\n                      \"id\": 4,\n                      \"banner_image_url\": \"http://sanjeevani.dbaquincy.com/storage/Resort/kVkodMPi1Y5QfPKeOjY8LXbf0tiKoOS4sHbaQOMu.jpeg\",\n                      \"resort_id\": 1\n                  }\n              ],\n              \"resort_amenities\": [\n                  {\n                      \"id\": 1,\n                      \"resort_id\": 1,\n                      \"name\": \"Gym\",\n                      \"icon\": \"http://127.0.0.1:8000/storage/amenities_icon\"\n                  },\n                  {\n                      \"id\": 2,\n                      \"resort_id\": 1,\n                      \"name\": \"SPA\",\n                      \"icon\": \"http://127.0.0.1:8000/storage/amenities_icon\"\n                  }\n              ],\n              \"resort_near_by_places\": [\n                  {\n                      \"id\": 1,\n                      \"name\": \"Water Fall\",\n                      \"distance_from_resort\": 25,\n                      \"resort_id\": 1\n                  },\n                  {\n                      \"id\": 2,\n                      \"name\": \"Nilgri forest\",\n                      \"distance_from_resort\": 10,\n                      \"resort_id\": 1\n                  }\n              ]\n          }\n      }\n  }",
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Services list\",\n      \"data\": {\n          \"ongoing_services\": [],\n          \"complete_services\": [\n              {\n                  \"id\": 1,\n                  \"name\": \"Do Not Disturbe\",\n                  \"icon\": \"http://127.0.0.1:8000/storage/Service_icon/XfNlJoZ3L4Pj0dbM8lJIyIXtkqTK4FXaANlUwwOo.jpeg\",\n                  \"date\": \"13-12-2018\",\n                  \"time\": \"04:53:09 PM\",\n                  \"status_id\": 4,\n                  \"status\": \"Completed\",\n                  \"acceptd_by\": \"\",\n                  \"type\": 1\n              },\n              {\n                  \"id\": 1,\n                  \"record_id\": 2,\n                  \"name\": \"sadsaGym\",\n                  \"icon\": \"\",\n                  \"date\": \"13-12-2018\",\n                  \"time\": \"17:48 pm\",\n                  \"status_id\": 1,\n                  \"status\": \"Booked\",\n                  \"acceptd_by\": \"\",\n                  \"type\": 2\n              },\n              {\n                  \"id\": 1,\n                  \"record_id\": 1,\n                  \"name\": \"Gym\",\n                  \"icon\": \"\",\n                  \"date\": \"13-12-2018\",\n                  \"time\": \"19:05 pm\",\n                  \"status_id\": 1,\n                  \"status\": \"Booked\",\n                  \"acceptd_by\": \"\",\n                  \"type\": 3\n              },\n              {\n                  \"id\": 1,\n                  \"record_id\": 1,\n                  \"name\": \"1544722346\",\n                  \"icon\": \"\",\n                  \"date\": \"13-12-2018\",\n                  \"time\": \"17:32 pm\",\n                  \"total_item_count\": 1,\n                  \"total_amount\": 240.6,\n                  \"status_id\": 1,\n                  \"status\": \"Confirmed\",\n                  \"acceptd_by\": \"\",\n                  \"type\": 4\n              }\n          ]\n      }\n  }",
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"My jobs.\",\n   \"data\": {\n       \"ongoing_jobs\": [\n           {\n              \"id\": 1,\n              \"service_name\": \"Do Not Disturbe\",\n              \"service_comment\": \"\",\n              \"service_icon\": \"http://127.0.0.1:8000/storage/Service_icon\",\n              \"user_name\": \"Hariom Gangwar\",\n              \"room_no\": \"300\",\n              \"created_at\": \"18:22 pm\"\n           }\n       ],\n       \"under_approval_jobs\": [],\n       \"completed_jobs\": []\n   }\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Service request found.\",\n   \"data\": {\n      \"services\": {\n           \"services\": [\n              {\n                   \"id\": 1,\n                   \"service_name\": \"Do Not Disturbe\",\n                   \"service_comment\": \"\",\n                   \"service_icon\": \"http://127.0.0.1:8000/storage/Service_icon/XfNlJoZ3L4Pj0dbM8lJIyIXtkqTK4FXaANlUwwOo.jpeg\",\n                   \"user_name\": \"Hariom Gangwar\",\n                   \"room_no\": \"300\",\n                   \"created_at\": \"17:11 pm\"\n               }\n           ]\n       },\n       \"meal_orders\": [\n           {\n               \"id\": 1,\n               \"invoice_id\": \"1544634201\",\n               \"item_total_amount\": 240.6,\n               \"gst_amount\": 0,\n               \"total_amount\": 240.6,\n               \"user_name\": \"Hariom Gangwar\",\n               \"room_no\": \"300\",\n               \"created_at\": \"17:03 pm\",\n               \"meal_item_count\": 1,\n               \"meal_items\": [\n                   {\n                       \"id\": 1,\n                       \"meal_item_name\": \"sadsad\",\n                       \"price\": 120,\n                       \"quantity\": 2,\n                       \"image_url\": \"\"\n                   }\n               ]\n           }\n       ],\n       \"amenities\": []\n   }\n}",
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
    "type": "get",
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
    "name": "GetStateCity",
    "group": "User",
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
          "content": "HTTP/1.1 200 OK\n  {\n    \"id\": 2,\n    \"salutation_id\": 0,\n    \"user_name\": null,\n    \"first_name\": null,\n    \"mid_name\": null,\n    \"last_name\": null,\n    \"gender\": null,\n    \"user_type_id\": 4,\n    \"designation_id\": 0,\n    \"department_id\": 0,\n    \"city_id\": 0,\n    \"language_id\": 0,\n    \"email_id\": null,\n    \"alternate_email_id\": null,\n    \"screen_name\": null,\n    \"date_of_joining\": null,\n    \"authority_id\": \"0\",\n    \"user_id_RA\": null,\n    \"date_of_birth\": null,\n    \"profile_pic_path\": \"http://127.0.0.1:8000/storage/profile_pic\",\n    \"id_card\": null,\n    \"is_user_loked\": 0,\n    \"mobile_number\": \"9999999999\",\n    \"other_contact_number\": null,\n    \"address1\": null,\n    \"address2\": null,\n    \"address3\": null,\n    \"pincode\": null,\n    \"secuity_question\": null,\n    \"secuity_questio_answer\": null,\n    \"ref_time_zone_id\": null,\n    \"login_expiry_date\": null,\n    \"other_info\": null,\n    \"password\": \"$2y$10$GqnkutHraNcdrbOw5gFEoe7nR.nJiP9ShiKm2jbtdpELGLLwbbtvK\",\n    \"remember_token\": null,\n    \"aadhar_id\": \"7SKegf9AESUmVrLhzoWsiEG9xL5RFbwkQyAFPx0J.jpeg\",\n    \"voter_id\": null,\n    \"is_active\": 1,\n    \"domain_id\": 0,\n    \"otp\": \"9999\",\n    \"oath_token\": null,\n    \"created_by\": \"0\",\n    \"updated_by\": \"0\",\n    \"created_at\": \"2018-12-04 09:05:25\",\n    \"updated_at\": \"2018-12-04 09:07:07\",\n    \"is_checked_in\": true,\n    \"user_booking_detail\": null\n}",
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Profile update succesfully.\",\n      \"data\": {\n          \"id\": 2,\n          \"user_name\": \"Hariom Gangwar n\",\n          \"first_name\": \"Hariom\",\n          \"last_name\": \"Gangwar\",\n          \"email_id\": \"hariom4037@gmail.com\",\n          \"profile_pic_path\": \"http://127.0.0.1:8000/storage/profile_pic/Kq6zsnPUpHQRWax8bladuQxs9zSxDxr0IE7VkAMI.jpeg\",\n          \"address1\": \"test\",\n          \"pincode\": \"222222\",\n          \"city_id\": 63,\n          \"state\": \"West Bengal\",\n          \"city\": \"Asansol\"\n      }\n  }",
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

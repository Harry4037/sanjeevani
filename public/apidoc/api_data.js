define({ "api": [
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
            "description": "<p>OTP send successfully.</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n \"status\": true,\n \"message\": \"OTP send successfully.\",\n \"data\": {}\n}",
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
            "description": "<p>The mobile number of the User was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserTypeMissing",
            "description": "<p>The User type was missing.</p>"
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
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"message\": \"Mobile number missing.\",\n\"data\":{}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"message\": \"User type missing.\",\n\"data\":{}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"message\": \"Mobile number should be 10 digit.\",\n\"data\":{}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"message\": \"User type invalid.\",\n\"data\":{}\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"OTP verified successfully.\",\n\"data\":{\n\"id\": 2,\n\"user_name\": null,\n\"first_name\": null,\n\"mid_name\": null,\n\"last_name\": null,\n\"email_id\": null,\n\"user_type_id\": 3,\n\"address\": null,\n\"screen_name\": null,\n\"profile_pic_path\": null,\n\"mobile_number\": \"8077575835\",\n\"token_type\": \"Bearer\",\n\"access_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU1OGZlMmI1NjcxN2Q3MDI2YmFhNmEzMjAxNmYxY2ZlODU5NDVjMGQ5YmI1MjFmZWViZTBjZmQ2MmI3MmE5NDU1YmM3NDU4NGI4ZWQxZDZmIn0.eyJhdWQiOiIxIiwianRpIjoiZTU4ZmUyYjU2NzE3ZDcwMjZiYWE2YTMyMDE2ZjFjZmU4NTk0NWMwZDliYjUyMWZlZWJlMGNmZDYyYjcyYTk0NTViYzc0NTg0YjhlZDFkNmYiLCJpYXQiOjE1NDA2NTk3NTQsIm5iZiI6MTU0MDY1OTc1NCwiZXhwIjoxNTcyMTk1NzU0LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.NQCP1kv1nQzvK9ExA0KCug-kXSE23heVLUL-1BuxB8tY6w_cI7XJ4ETAMBiZvIcgepyd_MjU-ngVRkx6WQCIhn4JJ2Zmu6ULUDSPeFWN2BwLcxRl-DziLixcyYTEWzY8LLrCxK7qtjD39_fOZFmW81wFlIfyBfwCpmKJenmR-GxMB4Ltbs-mHbQQs9Xwazi_JgtVc4oPJmHXrBGpXD4nU8ULSkDXbyH6VNkaJbGjvjqQplmRXbns6U04110hkWDUoMn2FmRyuuBj10aMMVrcsqi4yUP2IDlKXTTfnH8x5Ae6zzX0LHZJFiWE3KNZFXsaamVQfCHHnUAnPKFW3SHUBzUKjWXfFB6G0WsiM_dcZsGduu9Qnd-PpiMcWq8Uhq31FMBl2qHNenX_1mwpM0p3sfnYotVQaoNUu9-2IM1zmRXCEoGA3SsDto7nfdChdBPh6Z-6VILo2AqzkhzuYpRuNyHcvv2bOAXH1RgXbeH1A4ru0_glMKTp2jwd9IStJdkCMdADk_sUo31oeEMtkApRzYZc1qzWENtNdYWtpniADOHlMpJe1lv7X3qsgnI3hD7uZNZlZ72-xj5M15SvDCBW3uLWXd0TioI0s3311wzX9Li8HdjAcjwRsJJy1xij4NJgdEE9UZ_6jGyHt6ghEhdBgL691xUrwI1fAaHe0aLZSKA\",\n\"source_name\": \"Source Name\",\n\"source_id\": \"Source Id\",\n\"resort\":{\"id\": 1, \"name\": \"Parth Inn\", \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.\",…}\n}\n}",
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
            "description": "<p>The User Type was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidUserType",
            "description": "<p>The User invalid user type.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "IncorrectOTP",
            "description": "<p>The OTP is incorrect.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"message\": \"Mobile number missing.\",\n\"data\":{}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"message\": \"Mobile number should be 10 digit.\",\n\"data\":{}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"OTP missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User type missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"message\": \"User type invalid.\",\n\"data\":{}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n\"status\": false,\n\"message\": \"Incorrect OTP.\",\n\"data\":{}\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"service successfully access.\",\n\"data\":{\n\"user\":{\n\"id\": 2,\n\"user_name\": null,\n\"first_name\": null,\n\"mid_name\": null,\n\"last_name\": null,\n\"email_id\": null,\n\"user_type_id\": 3,\n\"address\": null,\n\"screen_name\": null,\n\"profile_pic_path\": null,\n\"mobile_number\": \"8077575835\",\n\"source_name\": \"Source Name\",\n\"source_id\": \"Source Id\",\n\"resort\":{\"id\": 1, \"name\": \"Parth Inn\", \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.\",…},\n\"booking\":{}\n},\n\"banners\":[]\n}\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Nearby places found.\",\n\"data\": {\n\"nearby\": [\n{\n\"id\": 1,\n\"name\": \"Ever green Sweet\",\n\"description\": \"Lore ipsum is the dummy text\",\n\"distance\": 10,\n\"precautions\": \"Lore ipsum is the dummy\",\n\"address\": \"noida\",\n\"images\": [\n{\n\"id\": \"http://127.0.0.1:8000/storage/Nearby/ExD6n45wLqb6U3NdEZ34vLjSDdntyUEWA9J6kUNu.jpeg\"\n},\n{\n\"id\": \"http://127.0.0.1:8000/storage/Nearby/u5SKjA8LzMoIabk87njPSg5nTcFaAFgKkgZN2z1f.jpeg\"\n}\n]\n},\n{\n\"id\": 2,\n\"name\": \"Testing\",\n\"description\": \"jhkjhjh\",\n\"distance\": 10,\n\"precautions\": \"kjhkjhkjhkj\",\n\"address\": \"noida\",\n\"images\": [\n{\n\"id\": \"http://127.0.0.1:8000/storage/Nearby/qM3wyREsrYaOltoKitTxl75Jxd41Cqy5i8VZy95h.jpeg\"\n}\n]\n}\n]\n}\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Resort found.\",\n\"data\":{\n\"resort\":{\n\"id\": 1,\n\"name\": \"Parth Inn\",\n\"description\": \"resort description\",\n\"contact_number\": \"9999999999\",\n\"other_contact_number\": null,\n\"address_1\": \"Noida\",\n\"address_2\": null,\n\"address_3\": null,\n\"pincode\": 201301,\n\"city_id\": 1,\n\"latitude\": 0,\n\"longitude\": 0,\n\"is_active\": 1,\n\"domain_id\": 0,\n\"created_by\": \"1\",\n\"updated_by\": \"1\",\n\"created_at\": \"2018-10-23 18:43:57\",\n\"updated_at\": \"2018-10-23 18:48:48\"\n},\n\"images\":[\n{\n\"id\": 1,\n\"image\": \"http://sanjeevani.dbaquincy.com//storage/Resort/vRjSo14bSmWYs3Iuf3lHLVcItYuR5Ib9wrn8jFny.jpeg\"\n},\n{\n\"id\": 2,\n\"image\": \"http://sanjeevani.dbaquincy.com//storage/Resort/56aJrFsQGrr2mvw6xEw9B1jwcutzH3SKiSxnSWmP.jpeg\"\n},\n{\n\"id\": 3,\n\"image\": \"http://sanjeevani.dbaquincy.com//storage/Resort/3HY6kUbXtN4A4HlYHoeqDzri7D1L7E3K04Xm6VxL.jpeg\"\n},\n{\n\"id\": 4,\n\"image\": \"http://sanjeevani.dbaquincy.com//storage/Resort/SQ2PLNjBNKeGicszxZqApeK0nII1iqi08XPkwWqa.jpeg\"\n}\n]\n}\n}",
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Services listing.\",\n\"data\": {\n\"housekeeping\": [\n{\n\"id\": 1,\n\"name\": \"Room Cleaning\",\n\"type\": \"Housekeeping\",\n\"icon\": \"\",\n\"is_active\": 1,\n\"created_by\": \"1\",\n\"updated_by\": \"1\",\n\"created_at\": \"2018-10-22 09:30:58\",\n\"updated_at\": \"2018-10-22 09:40:52\"\n},\n{\n\"id\": 3,\n\"name\": \"Do Not Disturb\",\n\"type\": \"Housekeeping\",\n\"icon\": \"\",\n\"is_active\": 1,\n\"created_by\": \"1\",\n\"updated_by\": \"1\",\n\"created_at\": \"2018-10-22 09:31:42\",\n\"updated_at\": \"2018-10-22 09:31:42\"\n}\n],\n\"issues\": [\n{\n\"id\": 4,\n\"name\": \"Shower\",\n\"type\": \"Issue\",\n\"icon\": \"\",\n\"is_active\": 1,\n\"created_by\": \"1\",\n\"updated_by\": \"1\",\n\"created_at\": \"2018-10-22 09:31:54\",\n\"updated_at\": \"2018-10-22 09:31:54\"\n}\n]\n}\n}",
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
            "description": "<p>question id's by comma separated.</p>"
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
            "field": "ServiceIdMissing",
            "description": "<p>The service id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserIdMissing",
            "description": "<p>The user id was missing.</p>"
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
            "field": "InvalidService",
            "description": "<p>The service is invalid.</p>"
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
            "field": "InvalidUser",
            "description": "<p>The user is invalid.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"service id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User id missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"resort id missing\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Invalid service\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Invalid resort\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Invalid user\",\n \"data\": {}\n}",
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
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"message\": \"Request accepted.\",\n      \"data\":{}",
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
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Request id missing.\",\n \"data\": {}\n}",
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
    "filename": "app/Http/Controllers/Api/ServiceController.php",
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Service request found.\",\n\"data\":[\n{\n\"id\": 1,\n\"service_name\": \"Air conditioner\",\n\"service_type\": \"Housekeeping\",\n\"comment\": \"hi test\",\n\"user_info\":{\n\"id\": 1,\n\"salutation_id\": 0,\n\"user_name\": \"Admin\",\n\"password\": \"$2y$10$kPpsYwT0fw2mB4F9.cI1AeSBSi1XTndcCH3PLptRtjDebQZDShibK\",\n\"first_name\": \"Admin\",\n\"mid_name\": null,\n\"last_name\": null,\n\"booking_source_name\": null,\n\"booking_id\": null,\n\"resort_id\": 0,\n\"total_room\": null,\n\"package_detail_id\": 0,\n\"gender\": \"M\",\n\"email_id\": \"admin@mail.com\",\n\"alternate_email_id\": null,\n\"user_type_id\": 1,\n\"designation_id\": 0,\n\"department_id\": 0,\n\"city_id\": 0,\n\"language_id\": 0,\n\"screen_name\": null,\n\"date_of_joining\": \"2018-10-25 19:53:22\",\n\"authority_id\": \"0\",\n\"date_of_birth\": \"2018-10-25 19:53:22\",\n\"is_user_loked\": 0,\n\"profile_pic_path\": null,\n\"aadhar_id\": null,\n\"voter_id\": null,\n\"check_in_date\": null,\n\"check_out_date\": null,\n\"mobile_number\": null,\n\"other_contact_number\": null,\n\"address1\": null,\n\"address2\": null,\n\"address3\": null,\n\"pincode\": null,\n\"secuity_question\": null,\n\"secuity_questio_answer\": null,\n\"ref_time_zone_id\": null,\n\"login_expiry_date\": null,\n\"other_info\": null,\n\"user_id_RA\": null,\n\"is_active\": 1,\n\"domain_id\": 0,\n\"remember_token\": null,\n\"otp\": null,\n\"created_by\": \"0\",\n\"updated_by\": \"0\",\n\"created_at\": \"2018-10-25 19:53:22\",\n\"updated_at\": null\n}",
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
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"resort id missing.\",\n \"data\": {}\n}",
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
    "filename": "app/Http/Controllers/Api/ServiceController.php",
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

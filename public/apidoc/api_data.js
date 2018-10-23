define({ "api": [
  {
    "type": "get",
    "url": "/api/logout",
    "title": "Logout User",
    "header": {
      "fields": {
        "Header": [
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
    "name": "GetLogoutUser",
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
            "field": "message",
            "description": "<p>Success message</p>"
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
          "content": "HTTP/1.1 200 OK\n\n{\n  \"status\": true,\n  \"message\": \"User successfully logged out.\",\n  \"data\": []\n}",
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
            "description": "<p>User unique mobile number.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>User type (Customer =&gt; 3 or Staff member =&gt; 2).</p>"
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
            "field": "message",
            "description": "<p>for the User.</p>"
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
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Mobile number missing.\",\n \"data\": {}\n}",
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
            "description": "<p>Users mobile number.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "otp",
            "description": "<p>OTP.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>User type (Customer =&gt; 3 or Staff member =&gt; 2).</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n      \"status\": true,\n      \"message\": \"OTP verified successfully.\",\n      \"data\": {\n      \"id\": 3,\n      \"salutation_id\": 0,\n      \"user_name\": null,\n      \"password\": \"$2y$10$9Q4IrH1lk21oNaeZ5R7UtOxQv7mn9Rodg6HNyrgn5lS.XSeFNQdUq\",\n      \"first_name\": null,\n      \"mid_name\": null,\n      \"last_name\": null,\n      \"gender\": null,\n      \"email_id\": null,\n      \"alternate_email_id\": null,\n      \"user_type_id\": 0,\n      \"designation_id\": 0,\n      \"department_id\": 0,\n      \"city_id\": 0,\n      \"language_id\": 0,\n      \"screen_name\": null,\n      \"date_of_joining\": null,\n      \"authority_id\": \"0\",\n      \"date_of_birth\": null,\n      \"is_user_loked\": 0,\n      \"profile_pic_path\": null,\n      \"mobile_number\": \"8077575835\",\n      \"other_contact_number\": null,\n      \"address1\": null,\n      \"address2\": null,\n      \"address3\": null,\n      \"pincode\": null,\n      \"secuity_question\": null,\n      \"secuity_questio_answer\": null,\n      \"ref_time_zone_id\": null,\n      \"login_expiry_date\": null,\n      \"other_info\": null,\n      \"user_id_RA\": null,\n      \"is_active\": 1,\n      \"domain_id\": 0,\n      \"remember_token\": null,\n      \"otp\": \"9999\",\n      \"createdBy\": \"0\",\n      \"updatedBy\": \"0\",\n      \"created_at\": \"2018-10-12 07:02:45\",\n      \"updated_at\": \"2018-10-12 07:02:45\",\n      \"access_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjM5YjczODZiM2FlZjQxMmRmZWFiMzgwZjliZTE5YjgwNWZhZTJkYTA0OTk1ZDMxYjEzMDBmYzkzYmQ2NGFmNGU3MGNhODQ5OGZjMDI1MzQwIn0.eyJhdWQiOiIxIiwianRpIjoiMzliNzM4NmIzYWVmNDEyZGZlYWIzODBmOWJlMTliODA1ZmFlMmRhMDQ5OTVkMzFiMTMwMGZjOTNiZDY0YWY0ZTcwY2E4NDk4ZmMwMjUzNDAiLCJpYXQiOjE1MzkzMjg2OTcsIm5iZiI6MTUzOTMyODY5NywiZXhwIjoxNTcwODY0Njk3LCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.TXVDzonROY7nW3YLIaPnAFywYjiNskNrpwcM5pprcL99lrKwtplNuiq0S4Ad2Pjt84YTI9hbDhm24hG_ROJx8IZqRsCWtY9YUk4719Hf-tW3P6FIs4eUxWQKGTPncB3h95VsREuIqFe1FuwWcoCVlpwreGttiJk-8ciuZTec8alpowZ-m4EObtaOt4uCI3vntZnc4J_fUyUTjlRAsiebvTpPPcDL-NvmRaJ_luu81Mm3iD0L1ieoPLG2oy79cNtgzsHwYoA9ebtzCPR-zoRRzbI5jL7M1JdtHdsaD1xp2RSXN27BG9X3Isy_dq0IGLGKb698UdqccYlSupDZ1pnSzsUBkOm847wEIPBOtonkNNGFH7OKONpUKWaIkYJ38AUkR4hRQK92x_5TrNaz1eSn6iuqQG-2J_c8d9wRh6QRST_bhNseMIotSGIKX6ZFqx7OaqqUrK_KPlYqULzXPeXEWEbGoSs6-knQ9cwdXFAXd1vm4f6VzVGZUwwP8z33olrSN-MQklNGs9rw_kPnXhxMMPX4Pn5Ii7UdmNgjiRZNzhu6DpsxHuk9oKrASox4O1BhpiHRBfToyqfA3XJW2b0MQdfE4CCmx61wnmittVeO6hAGFmxn0_xPYLfKrm2jny6WVUGh1A7lxUJNJSRVotA3bd20yJTabcn2SZ0XiI25Z6E\",\n      \"token_type\": \"Bearer\",\n      \"expires_at\": \"2018-10-19 07:18:18\"\n      }\n      }",
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
            "field": "OTPMissing",
            "description": "<p>The OTP was missing.</p>"
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
            "field": "IncorrectOTP",
            "description": "<p>The OTP was incorrect.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Mobile number missing.\",\n \"data\": {}\n}",
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
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Incorrect OTP.\",\n \"data\": {}\n}",
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
    "url": "/api/home",
    "title": "Home",
    "header": {
      "fields": {
        "Header": [
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
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"message\": \"service successfully access.\",\n      \"data\": {\n      \"user\": {\n      \"id\": 3,\n      \"salutation_id\": 0,\n      \"user_name\": null,\n      \"password\": \"$2y$10$e/EVCyHax2XGa9db94NY5O2qdBWRlLTnXvR2w5KQPlkOW9a.ocqOu\",\n      \"first_name\": null,\n      \"mid_name\": null,\n      \"last_name\": null,\n      \"booking_source_name\": null,\n      \"booking_id\": null,\n      \"resort_id\": 0,\n      \"total_room\": null,\n      \"package_detail_id\": 0,\n      \"gender\": null,\n      \"email_id\": null,\n      \"alternate_email_id\": null,\n      \"user_type_id\": 3,\n      \"designation_id\": 0,\n      \"department_id\": 0,\n      \"city_id\": 0,\n      \"language_id\": 0,\n      \"screen_name\": null,\n      \"date_of_joining\": null,\n      \"authority_id\": \"0\",\n      \"date_of_birth\": null,\n      \"is_user_loked\": 0,\n      \"profile_pic_path\": null,\n      \"aadhar_id\": null,\n      \"voter_id\": null,\n      \"check_in_date\": null,\n      \"check_out_date\": null,\n      \"mobile_number\": \"9999999999\",\n      \"other_contact_number\": null,\n      \"address1\": null,\n      \"address2\": null,\n      \"address3\": null,\n      \"pincode\": null,\n      \"secuity_question\": null,\n      \"secuity_questio_answer\": null,\n      \"ref_time_zone_id\": null,\n      \"login_expiry_date\": null,\n      \"other_info\": null,\n      \"user_id_RA\": null,\n      \"is_active\": 1,\n      \"domain_id\": 0,\n      \"remember_token\": null,\n      \"otp\": \"9999\",\n      \"created_by\": \"0\",\n      \"updated_by\": \"0\",\n      \"created_at\": \"2018-10-22 10:01:59\",\n      \"updated_at\": \"2018-10-22 10:01:59\"\n      },\n      \"banners\": [\n      {\n      \"id\": 1,\n      \"banner\": \"http://127.0.0.1:8000/storage/Banner/ScMwPfuAF6Yq1570eLzKVNNyLMiWVwdFjKkJywEK.jpeg\"\n      }\n      ]\n      }\n      }",
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
    "filename": "app/Http/Controllers/Api/HomeController.php",
    "groupTitle": "Home"
  },
  {
    "type": "post",
    "url": "/api/resort-detail",
    "title": "Resort detail",
    "header": {
      "fields": {
        "Header": [
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
            "description": "<p>Resort id.</p>"
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
          "content": "HTTP/1.1 200 OK\n      {\n      \"status\": true,\n      \"message\": \"Resort found.\",\n      \"data\":{\n      \"resort\":{\n      \"id\": 1,\n      \"name\": \"Parth Inn\",\n      \"description\": \"resort description\",\n      \"contact_number\": \"9999999999\",\n      \"other_contact_number\": null,\n      \"address_1\": \"Noida\",\n      \"address_2\": null,\n      \"address_3\": null,\n      \"pincode\": 201301,\n      \"city_id\": 1,\n      \"latitude\": 0,\n      \"longitude\": 0,\n      \"is_active\": 1,\n      \"domain_id\": 0,\n      \"created_by\": \"1\",\n      \"updated_by\": \"1\",\n      \"created_at\": \"2018-10-23 18:43:57\",\n      \"updated_at\": \"2018-10-23 18:48:48\"\n      },\n      \"images\":[\n      {\n      \"id\": 1,\n      \"image\": \"http://sanjeevani.dbaquincy.com//storage/Resort/vRjSo14bSmWYs3Iuf3lHLVcItYuR5Ib9wrn8jFny.jpeg\"\n      },\n      {\n      \"id\": 2,\n      \"image\": \"http://sanjeevani.dbaquincy.com//storage/Resort/56aJrFsQGrr2mvw6xEw9B1jwcutzH3SKiSxnSWmP.jpeg\"\n      },\n      {\n      \"id\": 3,\n      \"image\": \"http://sanjeevani.dbaquincy.com//storage/Resort/3HY6kUbXtN4A4HlYHoeqDzri7D1L7E3K04Xm6VxL.jpeg\"\n      },\n      {\n      \"id\": 4,\n      \"image\": \"http://sanjeevani.dbaquincy.com//storage/Resort/SQ2PLNjBNKeGicszxZqApeK0nII1iqi08XPkwWqa.jpeg\"\n      }\n      ]\n      }\n      }",
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
            "field": "ResortIdMissing",
            "description": "<p>The resort id was missing.</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Services listing.\",\n\"data\": {\n\"housekeeping\": [\n{\n\"id\": 1,\n\"name\": \"Room Cleaning\",\n\"type\": \"Housekeeping\",\n\"is_active\": 1,\n\"created_by\": \"1\",\n\"updated_by\": \"1\",\n\"created_at\": \"2018-10-22 09:30:58\",\n\"updated_at\": \"2018-10-22 09:40:52\"\n},\n{\n\"id\": 3,\n\"name\": \"Do Not Disturb\",\n\"type\": \"Housekeeping\",\n\"is_active\": 1,\n\"created_by\": \"1\",\n\"updated_by\": \"1\",\n\"created_at\": \"2018-10-22 09:31:42\",\n\"updated_at\": \"2018-10-22 09:31:42\"\n}\n],\n\"issues\": [\n{\n\"id\": 4,\n\"name\": \"Shower\",\n\"type\": \"Issue\",\n\"is_active\": 1,\n\"created_by\": \"1\",\n\"updated_by\": \"1\",\n\"created_at\": \"2018-10-22 09:31:54\",\n\"updated_at\": \"2018-10-22 09:31:54\"\n}\n]\n}\n}",
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
            "description": "<p>User id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "service_id",
            "description": "<p>Service id.</p>"
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
            "field": "CommentMissing",
            "description": "<p>The comment was missing.</p>"
          },
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
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Comment missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"service id missing.\",\n \"data\": {}\n}",
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
    "groupTitle": "Services"
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
            "description": "<p>User id.</p>"
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
            "field": "OldPasswordMissing",
            "description": "<p>The old password was missing.</p>"
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
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Old Password missing.\",\n \"data\": {}\n}",
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
    "filename": "app/Http/Controllers/Api/ResortController.php",
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
            "field": "email_id",
            "description": "<p>User email id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>User type(Staff=&gt; 2, Customer =&gt; 3).</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Link send successfully. please check your email.\",\n\"data\": {}\n}",
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
            "field": "UserTypeMissing",
            "description": "<p>The user type was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "EmailIdMissing",
            "description": "<p>The email id was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User type missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Email id missing.\",\n \"data\": {}\n}",
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
            "description": "<p>User id.</p>"
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
            "field": "OldPasswordMissing",
            "description": "<p>The old password was missing.</p>"
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
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Old Password missing.\",\n \"data\": {}\n}",
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
            "field": "email_id",
            "description": "<p>User email id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>User type(Staff=&gt; 2, Customer =&gt; 3).</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n\"status\": true,\n\"message\": \"Link send successfully. please check your email.\",\n\"data\": {}\n}",
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
            "field": "UserTypeMissing",
            "description": "<p>The user type was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "EmailIdMissing",
            "description": "<p>The email id was missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"User type missing.\",\n \"data\": {}\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Email id missing.\",\n \"data\": {}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ResortController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/check-in",
    "title": "Check In user",
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
            "description": "<p>The user id of the User was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "AadharIdMissing",
            "description": "<p>The aadhar document was missing.</p>"
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
            "description": "<p>User id.</p>"
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
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  }
] });

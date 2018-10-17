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
          "content": "HTTP/1.1 200 OK\n{\n \"status\": true,\n \"message\": \"OTP send successfully.\",\n \"data\": []\n}",
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
            "field": "MobileNumberRegistered",
            "description": "<p>The mobile number of the User was already registered.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Mobile number missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Your mobile number is already registered.\",\n \"data\": []\n}",
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
            "field": "IncorrectOTP",
            "description": "<p>The OTP was incorrect.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Mobile number missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"OTP missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Incorrect OTP.\",\n \"data\": []\n}",
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
            "type": "String",
            "optional": false,
            "field": "full_name",
            "description": "<p>User full name*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "booking_id",
            "description": "<p>User booking id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email_id",
            "description": "<p>User email address*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "check_in_date",
            "description": "<p>User check in date*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "check_out_date",
            "description": "<p>User check in date*.</p>"
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
            "field": "voter_id",
            "description": "<p>User voter id document*.</p>"
          },
          {
            "group": "Parameter",
            "type": "JSON",
            "optional": false,
            "field": "members",
            "description": "<p>User members detail {&quot;total_member&quot;:2,&quot;members&quot;:{&quot;full_name&quot;: &quot;Ankit&quot;,\t&quot;age&quot;: 20},{&quot;full_name&quot;: &quot;Hariom&quot;,&quot;age&quot;: 20}, }&quot;.</p>"
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
            "field": "FullNameMissing",
            "description": "<p>The full name was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BookingIdMissing",
            "description": "<p>The booking id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "EmailIdMissing",
            "description": "<p>The email id was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "CheckInMissing",
            "description": "<p>The check In date was missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "CheckOutMissing",
            "description": "<p>The check Out date was missing.</p>"
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
            "field": "VoterIdMissing",
            "description": "<p>The voter document was missing.</p>"
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
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Full name missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Booking Id missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Email Id missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Check In date missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Check out date missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Aadhar id missing.\",\n \"data\": []\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"status\": false,\n \"message\": \"Voter id missing.\",\n \"data\": []\n}",
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
  }
] });

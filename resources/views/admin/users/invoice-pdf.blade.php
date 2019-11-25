<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Invoice</title>
        <style>
            .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }

            a {
                color: #5D6975;
                text-decoration: underline;
            }

            body {
                position: relative;
                /*width: 21cm;*/  
                /*height: 29.7cm;*/ 
                margin: 0 auto; 
                color: #001028;
                background: #FFFFFF; 
                font-family: Arial, sans-serif; 
                font-size: 12px; 
                font-family: Arial;
            }

            header {
                padding: 10px 0;
                margin-bottom: 30px;
            }

            #logo {
                text-align: center;
                margin-bottom: 10px;
            }

            #logo img {
                width: 90px;
            }

            h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                color: #5D6975;
                font-size: 2.4em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;

            }

            #project {
                float: left;
            }

            #project span {
                color: #5D6975;
                text-align: right;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
            }

            #company span {
                color: #5D6975;
                text-align: right;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
            }

            #company {
                float: right;
                /*text-align: right;*/
                /*padding-right: 200px;*/ 
            }

            #project div,
            #company div {
                white-space: nowrap;        
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
            }

            table tr:nth-child(2n-1) td {
                background: #F5F5F5;
            }

            table th,
            table td {
                text-align: center;
            }

            table th {
                padding: 5px 20px;
                color: #5D6975;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;        
                font-weight: normal;
            }

            table .service,
            table .desc {
                text-align: left;
            }

            table td {
                padding: 20px;
                text-align: center;
            }

            table td.service,
            table td.desc {
                vertical-align: top;
            }

            table td.unit,
            table td.qty,
            table td.total {
                font-size: 1.2em;
            }

            table td.grand {
                border-top: 1px solid #5D6975;;
            }

            #notices .notice {
                color: #5D6975;
                font-size: 1.2em;
            }

            footer {
                color: #5D6975;
                width: 100%;
                height: 30px;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #C1CED9;
                padding: 8px 0;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header class="clearfix">
            Created At :- {{date("d-M-Y")}}
            <div id="logo">
                <h2>{{$user->userBookingDetail->resort->name}}</h2>
                <p>
                    {{$user->userBookingDetail->resort->address_1}}<br>
                    Phone No. :- {{$user->userBookingDetail->resort->contact_number}}
                </p>
            </div>
            <h1>INVOICE</h1>
            <div id="company" class="clearfix">
                <div><span>Room Type</span> {{$user->userBookingDetail->room_type_name}}</div>
                <div><span>Room No.</span> {{$user->userBookingDetail->resort_room_no}}</div>
                <div><span>Check In</span>{{date('d-M-Y', strtotime($user->userBookingDetail->check_in))}}</div>
                <div><span>Check Out</span> {{date('d-M-Y', strtotime($user->userBookingDetail->check_out))}}</div>
            </div>
            <div id="project">
                <div><span>Name</span> {{$user->user_name}} </div>
                <div><span>Email ID</span> {{$user->email_id}} </div>
                <!--<div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>-->
                <div><span>Mobile No.</span> {{$user->mobile_number}} </div>
<!--                <div><span>DATE</span> August 17, 2015</div>
                <div><span>DUE DATE</span> September 17, 2015</div>-->
            </div>
        </header>
        <main>
            <table>
                <thead>
                    <tr>
                        <th >Invoice ID</th>
<!--                        <th class="desc">DESCRIPTION</th>-->
                        <th>PRICE</th>
                        <th>GST(%)</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @if($user->mealOrders)
                    @foreach($user->mealOrders as $meal_order)
                    <tr>
                        <td>{{$meal_order->invoice_id}}</td>
                        <!--<td class="desc">Creating a recognizable design solution based on the company's existing visual identity</td>-->
                        <td>{{$meal_order->item_total_amount}}</td>
                        <td class="qty">{{$meal_order->gst_amount}}%</td>
                        <td>{{$meal_order->total_amount}}</td>
                    </tr>
                    @endforeach
                    @endif

                    @if($user->userBookingDetail->booking_amount_type == 1)
                    <tr>
                        <td></td>
                        <td></td>
                        <td>BOOKING AMOUNT</td>
                        <td class="total">- {{$user->userBookingDetail->booking_amount}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>TOTAL</td>
                        <td class="total">{{$total}}</td>
                    </tr>
                    @elseif($user->userBookingDetail->booking_amount_type == 2)
                    <tr>
                        <td></td>
                        <td></td>
                        <td>BOOKING AMOUNT</td>
                        <td class="total">{{$user->userBookingDetail->booking_amount}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>TOTAL</td>
                        <td class="total">{{$total}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td></td>
                        <td></td>
                        <td>DISCOUNT ({{$user->discount}}%)</td>
                        <td class="total">- {{$discountAmt}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>PAID</td>
                        <td class="total">- {{$paid}}</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td class="grand total">Outstanding</td>
                        <td class="grand total">{{$outstanding}}</td>
                    </tr>
                </tbody>
            </table>
            <!--            <div id="notices">
                            <div>NOTICE:</div>
                            <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                        </div>-->
        </main>
        <footer>
            Invoice was created on a computer and is valid without the signature and seal.
        </footer>
    </body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Customer Service Form</title>
	<style type="text/css">
		 @page {
            size: A4 portrait;
            margin: 1cm 1.5cm ;
        }

        body {
            font-family: "URW Gothic L", "Gotham Narrow", "Andrew Samuels";
            font-size: 0.8em;
        }

        h2 {
            text-align: center;
            margin: 5px;
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        .right {
            text-align: right
        }

        .left {
            text-align: left
        }

        td {
        {#border: 1px solid black;#} vertical-align: top;
        }

        .btgrey {
            border-top: 1px solid grey
        }

        .bbgrey {
            border-bottom: 1px solid grey;
        }

        h3 {
            margin: 3px
        }

        .double {
            border-bottom: 3px double black;
        }

        .logo {
            width: 100%;
        }

        .picha {
            width: 15%;
            float: left;
            text-align: right;

        {#border: 1px solid black;#}
        }

        .jina {
            float: left;
            width: 70%;
        {#border: 1px solid black;#}
        }

        .jina > h1 {
            color: darkgreen;
            font-family: "Times New Roman";
            margin-top: 5px;
            margin-bottom: 0;
            text-align: center;
        {#border: 1px solid black;#}
        }

        .jina > h1 > span {
        {#font-size: 0.9em; Todo Adjust if page font sizes change#}
        }

        .jina > h5 {
            margin: 0;
            text-align: center;
        {#border: 1px solid black;#}
        }

        .header {
            clear: both;
        }

        .page-header {
            clear: both;
        }

        tr:nth-of-type(even):not(.dont) > td {
            background-color: #f9f9f9;
        }

        .red {
            color: red
        }

        .green {
            color: green
        }

        h1 {
            text-align: center
        }

        th {
            text-align: unset;
        }

        table {
            page-break-inside: auto
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto
        }

        tr.page-break {
            display: block;
            page-break-before: always;
        }
        pre > * {
            font-size: 1.5em;
        }
		/* on-screen styles */
 @page {
            size: A4 portrait;
            margin: 1cm 1.5cm ;
        }

        body {
            font-size: 0.7em;
        }

        table {
            table-layout: fixed;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        tr:nth-of-type(even):not(.dont) > td {
            background-color: #FFFFFF;
        }
        th{
        	color: skyblue;
        }
  
	</style>
</head>
<body>
<center>
	<h4><u>HOME AND BUSINESS INTERNET SERVICES<br>SERVICE COMMISSIONING FORM</u></h4>
</center>
<table>
	<thead>
		<tr>
			<th colspan="4"><center>PHYSICAL LOCATION</center></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>CUSTOMER NAME</b></td>
			<td>{{strtoupper($owner_info->name)}}</td>
			<td><b>BUILDING/FLOOR</b></td>
			<td>{{strtoupper($account_info->building??'')}}</td>
		</tr>
		<tr>
			<td><b>ROAD/STREET</b></td>
			<td>{{strtoupper($account_info->address??'')}}</td>
			<td><b>TOWN</b></td>
			<td>{{strtoupper($account_info->town??'')}}</td>
		</tr>
		<tr>
			<td><b>GPS CORDINATES</b></td>
			<td>{{strtoupper($account_info->coordinates??'')}}</td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>
<br>
<table>
	<thead>
		<tr>
			<th colspan="4"><center>CONTACT DETAILS-PRIMARY CONTACT</center></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>NAME</b></td>
			<td>{{strtoupper($owner_info->name)}}</td>
			<td><b>CELL</b></td>
			<td>{{strtoupper($owner_info->phone??'')}}</td>
		</tr>
		<tr>
			<td><b>DESIGNATION</b></td>
			<td>{{strtoupper('')}}</td>
			<td><b>EMAIL</b></td>
			<td>{{strtoupper($owner_info->email??'')}}</td>
		</tr>
	</tbody>
</table>
<br>
<!-- company contact -->
<table>
	<thead>
		<tr>
			<th colspan="4"><center>CONTACT DETAILS-NOTIFICATIONS FOR SERVICE FAULTS & ISSUES</center></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>NAME</b></td>
			<td></td>
			<td><b>CELL</b></td>
			<td></td>
		</tr>
		<tr>
			<td><b>DESIGNATION</b></td>
			<td></td>
			<td><b>EMAIL</b></td>
			<td></td>
		</tr>
	</tbody>
</table>
<br>
<!-- company technical contact -->
<table>
	<thead>
		<tr>
			<th colspan="4"><center>TECHNICAL CONTACT PERSON</center></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>NAME</b></td>
			<td></td>
			<td><b>CELL</b></td>
			<td></td>
		</tr>
		
	</tbody>
</table>
<br>
<!-- service details -->
<table>
	<thead>
		<tr>
			<th colspan="4"><center>SERVICE DETAILS</center></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>CIRCUIT ID</b></td>
			<td></td>
			<td><b>SERVICE DESCRIPTION</b></td>
			<td>{{$service_info->packagename??''}}</td>
		</tr>
		<tr>
			<td><b>TECHNOLOGY/TX</b></td>
			<td></td>
			<td><b>IP ADDRESS</b></td>
			<td>{{$service_info->ipaddress??''}}</td>
		</tr>
		<tr>
			<td><b>TX SIGNAL</b></td>
			<td>{{$service_info->uploadspeed?($service_info->uploadspeed/(1024*1024)):''}} Mbps</td>
			<td><b>RX SIGNAL</b></td>
			<td>{{$service_info->downloadspeed?($service_info->downloadspeed/(1024*1024)):''}} Mbps</td>
		</tr>
		<tr>
			<td><b>EXTRA IPs</b></td>
			<td></td>
			<td><b></b></td>
			<td></td>
		</tr>
		<tr>
			<td><b>PING LATENCY</b></td>
			<td></td>
			<td><b>THROUGHPUT AVERAGE</b></td>
			<td></td>
		</tr>		
	</tbody>
</table>
<br>
<!-- equipment details -->
<table>
	<thead>
		<tr>
			<th colspan="5"><center>EQUIPMENT DETAILS (ROUTERS,SWITCHES...)</center></th>
		</tr>
		<tr>
			<th></th>
			<th>EQUIPMENT NAME</th>
			<th>MAKE AND MODEL</th>
			<th>SERIAL NUMBER</th>
			<th>QUANTITY</th>
		</tr>
	</thead>
	<tbody>
		@forelse($account_items as $item)
		<tr>
			<td><b>EQUIPMENT</b></td>
			<td>{{$item->name}}</td>
			<td>{{$item->model_number??''}}</td>
			<td>{{$item->serial_number??''}}</td>
			<td>{{$item->quantity??''}}</td>
		</tr>
		@empty
		<tr><td colspan="5">No allocated equipments</td></tr>

		@endforelse
		
	</tbody>
</table>
<br>
<!-- equipment details -->
<table>
	<thead>
		<tr>
			<th colspan="2"><center>FOR AND ON BEHALF OF COMPANY NAME</center></th>
			<th colspan="2"><center>FOR AND ON BEHALF OF THE CLIENT</center></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>NAME</b></td>
			<td>{{ CompanyHelper::companyInfo()->name??'' }}</td>
			<td><b>NAME</b></td>
			<td></td>
		</tr>
		<tr>
			<td><b>PARTNER COMPANY</b></td>
			<td></td>
			<td><b>DESIGNATION</b></td>
			<td></td>
		</tr>
		<tr>
			<td><b>TELEPHONE</b></td>
			<td>{{ CompanyHelper::companyInfo()->phone??'' }}</td>
			<td><b>TELEPHONE</b></td>
			<td></td>
		</tr>
		<tr>
			<td><b>DATE</b></td>
			<td>{{ date("d/m/Y") }}</td>
			<td><b>SIGNATURE/STAMP</b></td>
			<td></td>
		</tr>
	</tbody>
</table>
<br>
<p><b>TERMS AND CONDITION APPLIED:</b> The equipment’s rendered shall be strictly for {{ CompanyHelper::companyInfo()->name??'' }} company and failure to submit payment beyond 2 months the equipment’s shall be
collected by the ISP.<br><br><br> <b>FOR AND ON BEHALF OF CLIENT. &nbsp;&nbsp;SIGN:..............................................................................................................................................................</b>.<br><br><br><b>FOR AND ON BEHALF OF {{ CompanyHelper::companyInfo()->name??'' }}.&nbsp;&nbsp;SIGN.....................................................................................................................................................</b>.</p>
</body>
</html>
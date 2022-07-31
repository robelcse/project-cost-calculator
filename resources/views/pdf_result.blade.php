<!DOCTYPE html>
<html lang="en">
<style></style>

<head>
    <title>Cost Calculator</title>
    <meta charset="utf-8">
    <style>
        .container {
            width: 80%;
            margin: auto;
            background: hsl(240deg 2% 32%);
            padding: 20px;
            color: #000;
        }

        .form-group {
            flex-wrap: wrap;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="company">
            @if(!is_null($imagename))
            <h3>
                Company Logo:
                <img src="{{ public_path('uploads/images/'.$imagename) }}" height="100px" />
            </h3>
            @endif

            @if(!is_null($company_address))
            <p>Company Address: {{ $company_address }}</p>
            @endif
        </div>
        <div class="client">
            @if(!is_null($client_name))
            <h3>Client name: {{ $client_name }}</h3>
            @endif
            @if(!is_null($client_address))
            <p>Client Address: {{ $client_address }}</p>
            @endif

        </div>
        <div class="table">
            <table>
                @if(!is_null($frontend_dev))
                <tr>
                    <td>Frontend Developer : {{ $frontend_dev == null ? 0:$frontend_dev }}</td>
                    <td>Cost per dev: {{ $frontend_dev_cost == null ? 0: $frontend_dev_cost }} $</td>
                </tr>
                @endif
                @if(!is_null($backend_dev))
                <tr>
                    <td>Backend Developer : {{ $backend_dev == null ? 0:$backend_dev }}</td>
                    <td>Cost per dev: {{ $backend_dev_cost == null ? 0:$backend_dev_cost }} $</td>
                </tr>
                @endif
                @if(!is_null($mobile_app_dev))
                <tr>
                    <td>Mobile App Developer : {{ $mobile_app_dev == null ? 0:$mobile_app_dev }}</td>
                    <td>Cost per dev: {{ $mobile_app_dev_cost == null ? 0:$mobile_app_dev_cost }} $</td>
                </tr>
                @endif
                @if(!is_null($total_hour_of_work))
                <tr>
                    <td>Number of hours to do work : {{ $total_hour_of_work == null ? 0:$total_hour_of_work }}</td>
                    <td>Cost per hour: {{ $cost_per_hour == null ? 0:$cost_per_hour }} $</td>
                </tr>
                @endif
                @if(!is_null($server_cost))
                <tr>
                    <td>Server Cost : {{ $server_cost == null ? 0:$server_cost }} $</td>
                </tr>
                @endif
                @if(!is_null($domain_cost))
                <tr>
                    <td>Domain Cost : {{ $domain_cost == null ? 0:$domain_cost }} $</td>
                </tr>
                @endif
                @if(!is_null($vat))
                <tr>
                    <td>Vat : {{ $vat == null ? 0:$vat }} %</td>
                </tr>
                @endif
                @foreach ($arr_of_items as $items)
                @if(!is_null($items[0]) && !is_null($items[1]))
                <tr>
                    <td>{{ $items[0] }}</td>
                    <td>{{ $items[1] }} $</td>
                </tr>
                @endif
                @endforeach
            </table>
            <div>
                <h3>Total Cost: {{ $total_cost_of_project }} $</h3>
            </div>


        </div>
    </div>

</body>

</html>
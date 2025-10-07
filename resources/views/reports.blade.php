<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analytics Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        h2 {
            color: #666;
            margin-top: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .single-value {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <h1>Analytics Reports</h1>

    <!-- 1. Top 5 Most Bought Products -->
    <h2>1. Top 5 Most Bought Products</h2>
    @if ($data['top_products'] && count($data['top_products']) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Total Quantity Sold</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['top_products'] as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->total_quantity_sold }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data available</p>
    @endif

    <!-- 2. Top 1 Most Bought Category -->
    <h2>2. Top Most Bought Category</h2>
    @if ($data['top_category'])
        <div class="single-value">
            <strong>Category:</strong> {{ $data['top_category']->name }}<br>
            <strong>Total Quantity Sold:</strong> {{ $data['top_category']->total_quantity_sold }}
        </div>
    @else
        <p>No data available</p>
    @endif

    <!-- 3. Top 3 Spenders -->
    <h2>3. Top 3 Spenders (Customers with Highest Total Purchase Amount)</h2>
    @if ($data['top_spenders'] && count($data['top_spenders']) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Gender</th>
                    <th>City</th>
                    <th>Total Spent</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['top_spenders'] as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ ucfirst($customer->sex) }}</td>
                        <td>{{ $customer->city }}</td>
                        <td>${{ number_format($customer->total_spent, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data available</p>
    @endif

    <!-- 4. Top Buyer by Quantity -->
    <h2>4. Top Buyer with Highest Total Number of Purchased Items</h2>
    @if ($data['top_buyer_quantity'])
        <div class="single-value">
            <strong>Customer:</strong> {{ $data['top_buyer_quantity']->name }}<br>
            <strong>Gender:</strong> {{ ucfirst($data['top_buyer_quantity']->sex) }}<br>
            <strong>City:</strong> {{ $data['top_buyer_quantity']->city }}<br>
            <strong>Total Items Bought:</strong> {{ $data['top_buyer_quantity']->total_items_bought }}
        </div>
    @else
        <p>No data available</p>
    @endif

    <!-- 5. Customers Above Monthly Average -->
    <h2>5. Customers with Purchases Above Monthly Average</h2>
    @if ($data['customers_above_monthly_avg'] && count($data['customers_above_monthly_avg']) > 0)
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['customers_above_monthly_avg'] as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data available</p>
    @endif

    <!-- 6. Average Total Purchases Last 3 Months -->
    <h2>6. Average Total Purchases from Last 3 Months</h2>
    <div class="single-value">
        <strong>Average Amount:</strong> ${{ number_format($data['avg_purchases_3_months'], 2) }}
    </div>

    <!-- 7. Largest Purchase by Female Customers -->
    <h2>7. Largest Total Purchase from Each Female Customer</h2>
    @if ($data['female_largest_purchases'] && count($data['female_largest_purchases']) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Largest Purchase</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['female_largest_purchases'] as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>${{ number_format($customer->largest_purchase, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data available</p>
    @endif

    <!-- 8. Product with Smallest Average Sales -->
    <h2>8. Product with Smallest Average Sales</h2>
    @if ($data['smallest_avg_product'])
        <div class="single-value">
            <strong>Product:</strong> {{ $data['smallest_avg_product']->name }}<br>
            <strong>Price:</strong> ${{ number_format($data['smallest_avg_product']->price, 2) }}<br>
            <strong>Average Sales Quantity:</strong> {{ round($data['smallest_avg_product']->avg_sales_quantity, 2) }}
        </div>
    @else
        <p>No data available</p>
    @endif

    <!-- 9. Employee with Largest Monthly Average -->
    <h2>9. Employees with Largest Average Sales Every Month</h2>
    @if ($data['employee_monthly_average'] && count($data['employee_monthly_average']) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Role</th>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Average Monthly Sales</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['employee_monthly_average'] as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ ucfirst($employee->role) }}</td>
                        <td>{{ $employee->year }}</td>
                        <td>{{ $employee->month }}</td>
                        <td>${{ number_format($employee->avg_monthly_sales, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data available</p>
    @endif

    <!-- 10. Employees Eligible for Annual Bonus -->
    <h2>10. Employees Eligible for Annual Bonus</h2>
    @if ($data['employees_bonus_eligible'] && count($data['employees_bonus_eligible']) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Role</th>
                    <th>Highest Monthly Sales</th>
                    <th>Total Yearly Sales</th>
                    <th>Base Bonus (10%)</th>
                    <th>Excess Bonus (5%)</th>
                    <th>Total Annual Bonus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['employees_bonus_eligible'] as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ ucfirst($employee->role) }}</td>
                        <td>${{ number_format($employee->highest_monthly_sales, 2) }}</td>
                        <td>${{ number_format($employee->total_yearly_sales, 2) }}</td>
                        <td>${{ number_format($employee->base_bonus, 2) }}</td>
                        <td>${{ number_format($employee->excess_bonus, 2) }}</td>
                        <td><strong>${{ number_format($employee->total_annual_bonus, 2) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No employees eligible for bonus</p>
    @endif

</body>

</html>
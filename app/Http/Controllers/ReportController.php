<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\CustomerService;
use App\Services\EmployeeService;
use App\Services\InvoiceService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $customerService;
    protected $employeeService;
    protected $invoiceService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        CustomerService $customerService,
        EmployeeService $employeeService,
        InvoiceService $invoiceService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->customerService = $customerService;
        $this->employeeService = $employeeService;
        $this->invoiceService = $invoiceService;
    }

    function reports()
    {
        // Get all analytics data
        $data = [
            'top_products' => $this->productService->getTopMostBoughtProducts(),
            'smallest_avg_product' => $this->productService->getProductWithSmallestAverageSales(),
            'top_category' => $this->categoryService->getTopMostBoughtCategory(),
            'top_spenders' => $this->customerService->getTopSpenders(),
            'top_buyer_quantity' => $this->customerService->getTopBuyerByQuantity(),
            'customers_above_monthly_avg' => $this->customerService->getCustomersAboveMonthlyAverage(),
            'female_largest_purchases' => $this->customerService->getLargestPurchaseByFemaleCustomers(),
            'employee_monthly_average' => $this->employeeService->getEmployeeWithLargestMonthlyAverage(),
            'employees_bonus_eligible' => $this->employeeService->getEmployeesEligibleForAnnualBonus(),
            'avg_purchases_3_months' => $this->invoiceService->getAverageTotalPurchasesLast3Months(),
        ];

        return view("reports", compact('data'));
    }
}
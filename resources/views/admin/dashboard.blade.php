@extends('layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Dashboard</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium d-flex align-items-center gap-1">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </li>
        </ul>
    </div>

    {{-- ===== PRODUCT COUNTS ONLY ===== --}}
    <div class="row row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-4">

        {{-- Total Products --}}
        <div class="col">
            <div class="card shadow-none border h-100">
                <div class="card-body p-20">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-secondary-light mb-1">Total Products</p>
                            <h3 class="mb-0">{{ number_format($productCount) }}</h3>
                        </div>
                        <div class="w-50-px h-50-px bg-primary-600 rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="mdi:cube-outline" class="text-white text-2xl"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Products --}}
        <div class="col">
            <div class="card shadow-none border h-100">
                <div class="card-body p-20">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-secondary-light mb-1">Active</p>
                            <h3 class="mb-0">{{ number_format($activeCount) }}</h3>
                        </div>
                        <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="mdi:checkbox-marked-circle-outline" class="text-white text-2xl"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Out of Stock --}}
        <div class="col">
            <div class="card shadow-none border h-100">
                <div class="card-body p-20">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-secondary-light mb-1">Out of Stock</p>
                            <h3 class="mb-0">{{ number_format($outOfStock) }}</h3>
                        </div>
                        <div class="w-50-px h-50-px bg-danger-main rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="mdi:alert-circle-outline" class="text-white text-2xl"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="col">
            <div class="card shadow-none border h-100">
                <div class="card-body p-20">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-secondary-light mb-1">Low Stock (≤ 5)</p>
                            <h3 class="mb-0">{{ number_format($lowStockCount) }}</h3>
                        </div>
                        <div class="w-50-px h-50-px bg-warning-main rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="mdi:package-variant" class="text-white text-2xl"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- (Optional) Remove everything else on the page:
         charts/tables/cards you had before. Keep the section above only. --}}
</div>
@endsection

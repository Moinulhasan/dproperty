@extends('admin.master')

@section('content')
    <div class="row">
        <!-- Statistics Tiles -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-home ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ number_format($stats['total_properties']) }}</h4>
                    </div>
                    <p class="mb-1">Total Properties</p>
                    <p class="mb-0 text-success">
                        <small>Listed & managed</small>
                    </p>
                </div>
            </div>
        </div>

        @if(auth()->user()->hasRole('Super Admin'))
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-info"><i class="ti ti-building ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ number_format($stats['total_companies']) }}</h4>
                    </div>
                    <p class="mb-1">Total Companies</p>
                    <p class="mb-0 text-muted"> <small>Partners on platform</small></p>
                </div>
            </div>
        </div>
        @endif

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-users ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ number_format($stats['total_users']) }}</h4>
                    </div>
                    <p class="mb-1">{{ auth()->user()->hasRole('Super Admin') ? 'Total Users' : 'Company Agents' }}</p>
                    <p class="mb-0 text-muted"> <small>Active accounts</small></p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success"><i class="ti ti-trending-up ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ count($chartData['trends']['series']) > 0 ? end($chartData['trends']['series']) : 0 }}</h4>
                    </div>
                    <p class="mb-1">New Lists (Month)</p>
                    <p class="mb-0 text-success"> <small>Gaining momentum</small></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Property Status Chart -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Property Status</h5>
                </div>
                <div class="card-body">
                    <div id="statusDonutChart"></div>
                </div>
            </div>
        </div>

        <!-- Property Trend Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Property Upload Trends</h5>
                </div>
                <div class="card-body">
                    <div id="trendBarChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Properties Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recently Added Properties</h5>
            <a href="{{ route('admin.property.list') }}" class="btn btn-sm btn-label-primary">View All</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($stats['recent_properties'] as $prop)
                    <tr>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar-wrapper">
                                    <div class="avatar me-2">
                                        @if($prop->feature_image)
                                            <img src="{{ asset($prop->feature_image) }}" alt="Avatar" class="rounded">
                                        @else
                                            <span class="avatar-initial rounded bg-label-secondary"><i class="ti ti-home"></i></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ Str::limit($prop->title, 30) }}</span>
                                    <small class="text-muted text-capitalize">{{ $prop->property_type }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ number_format($prop->price) }} BDT</td>
                        <td>
                            <span class="badge bg-label-{{ $prop->property_status == 'Buy' ? 'primary' : ($prop->property_status == 'Rent' ? 'info' : 'success') }}">
                                {{ $prop->property_status }}
                            </span>
                        </td>
                        <td>{{ $prop->created_at->format('d M, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No properties found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Status Donut Chart
            var statusOptions = {
                chart: {
                    height: 300,
                    type: 'donut'
                },
                labels: {!! json_encode($chartData['status']['labels']) !!},
                series: {!! json_encode($chartData['status']['series']) !!},
                colors: ['#7367f0', '#00cfe8', '#28c76f'],
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    fontSize: '1rem',
                                    fontFamily: 'Public Sans'
                                },
                                value: {
                                    fontSize: '1.2rem',
                                    fontFamily: 'Public Sans',
                                    formatter: function(val) {
                                        return parseInt(val);
                                    }
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                }
            };
            new ApexCharts(document.querySelector("#statusDonutChart"), statusOptions).render();

            // Trend Bar Chart
            var trendOptions = {
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                series: [{
                    name: 'Properties',
                    data: {!! json_encode($chartData['trends']['series']) !!}
                }],
                xaxis: {
                    categories: {!! json_encode($chartData['trends']['labels']) !!}
                },
                colors: ['#7367f0'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.9,
                        stops: [0, 90, 100]
                    }
                }
            };
            new ApexCharts(document.querySelector("#trendBarChart"), trendOptions).render();
        });
    </script>
@endsection

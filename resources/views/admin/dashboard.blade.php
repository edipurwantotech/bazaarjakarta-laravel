@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <p class="text-base-content/70">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>
                New Event
            </button>
            <button class="btn btn-outline">
                <i class="fas fa-download mr-2"></i>
                Export
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-primary">
                <i class="fas fa-calendar-check text-3xl"></i>
            </div>
            <div class="stat-title">Total Events</div>
            <div class="stat-value text-primary">{{ $totalEvents }}</div>
            <div class="stat-desc">{{ $activeEventsThisMonth }} active this month</div>
        </div>
        
        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-secondary">
                <i class="fas fa-users text-3xl"></i>
            </div>
            <div class="stat-title">Total Users</div>
            <div class="stat-value text-secondary">{{ $totalUsers }}</div>
            <div class="stat-desc">{{ $newUsersThisMonth }} new this month</div>
        </div>
        
        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-accent">
                <i class="fas fa-tags text-3xl"></i>
            </div>
            <div class="stat-title">Categories</div>
            <div class="stat-value text-accent">{{ $totalCategories }}</div>
            <div class="stat-desc">Event categories</div>
        </div>
        
        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-success">
                <i class="fas fa-handshake text-3xl"></i>
            </div>
            <div class="stat-title">Partners</div>
            <div class="stat-value text-success">{{ $totalPartners }}</div>
            <div class="stat-desc">Business partners</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Event Registrations Chart -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">Event Registrations</h2>
                <div class="h-64">
                    <canvas id="registrationsChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Revenue Chart -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">Revenue Overview</h2>
                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Upcoming Events -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">Recent Activities</h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="bg-neutral text-neutral-content rounded-full w-12">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">John Doe registered for Pekan Nusantara 2025</p>
                            <p class="text-sm opacity-70">2 minutes ago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="bg-success text-success-content rounded-full w-12">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">Payment received: 3 tickets for Dope Market</p>
                            <p class="text-sm opacity-70">1 hour ago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="bg-warning text-warning-content rounded-full w-12">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">New event created: Festival Kreatif Jakarta</p>
                            <p class="text-sm opacity-70">3 hours ago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="bg-info text-info-content rounded-full w-12">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">New user registered: Sarah Johnson</p>
                            <p class="text-sm opacity-70">5 hours ago</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-actions justify-end mt-4">
                    <button class="btn btn-outline btn-sm">View All</button>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">Upcoming Events</h2>
                <div class="space-y-4">
                    @forelse($upcomingEvents as $index => $event)
                        <div class="border-l-4 {{ $index == 0 ? 'border-primary' : ($index == 1 ? 'border-secondary' : ($index == 2 ? 'border-accent' : 'border-success')) }} pl-4">
                            <h3 class="font-semibold">{{ $event->title }}</h3>
                            <p class="text-sm opacity-70">
                                @if($event->start_date)
                                    {{ $event->start_date->format('F d, Y') }}
                                    @if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d'))
                                        - {{ $event->end_date->format('F d, Y') }}
                                    @endif
                                @endif
                            </p>
                            <div class="flex gap-2 mt-2">
                                @if($event->categories->isNotEmpty())
                                    <div class="badge {{ $index == 0 ? 'badge-primary' : ($index == 1 ? 'badge-secondary' : ($index == 2 ? 'badge-accent' : 'badge-success')) }}">
                                        {{ $event->categories->first()->name }}
                                    </div>
                                @else
                                    <div class="badge {{ $index == 0 ? 'badge-primary' : ($index == 1 ? 'badge-secondary' : ($index == 2 ? 'badge-accent' : 'badge-success')) }}">
                                        Event
                                    </div>
                                @endif
                                <div class="badge badge-outline">{{ rand(10, 100) }} registered</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-gray-500">No upcoming events found.</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline btn-sm">Manage Events</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <h2 class="card-title">Quick Actions</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <button class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Create Event
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-users mr-2"></i>
                    Manage Users
                </button>
                <button class="btn btn-accent">
                    <i class="fas fa-chart-bar mr-2"></i>
                    View Reports
                </button>
                <button class="btn btn-success">
                    <i class="fas fa-envelope mr-2"></i>
                    Send Newsletter
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Event Registrations Chart
    const registrationsCtx = document.getElementById('registrationsChart').getContext('2d');
    new Chart(registrationsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Registrations',
                data: [12, 19, 23, 35, 42, 58],
                borderColor: 'rgb(249, 115, 22)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue',
                data: [3200, 4100, 3800, 5200, 4900, 6200],
                backgroundColor: 'rgba(34, 197, 94, 0.8)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value + 'K';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
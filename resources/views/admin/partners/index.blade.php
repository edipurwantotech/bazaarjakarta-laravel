@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-orange-600">Partners</h1>
            <p class="text-base-content/70">Manage event partners and sponsors</p>
        </div>
        <a href="{{ route('admin.partners.create') }}" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
            <i class="fas fa-plus mr-2"></i>
            Add New Partner
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success mb-6 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Partners Table -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-base-200">
                            <th class="rounded-tl-lg">No</th>
                            <th>Name</th>
                            <th>Logo</th>
                            <th>Website</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th class="rounded-tr-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partners as $index => $partner)
                        <tr class="hover">
                            <td>{{ ($partners->currentpage() - 1) * $partners->perpage() + $index + 1 }}</td>
                            <td>
                                <div class="font-bold">{{ $partner->name }}</div>
                                @if($partner->description)
                                <div class="text-sm opacity-70 truncate max-w-xs">{{ $partner->description }}</div>
                                @endif
                            </td>
                            <td>
                                @if($partner->logo)
                                <div class="avatar">
                                    <div class="w-12 rounded">
                                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" />
                                    </div>
                                </div>
                                @else
                                <div class="text-sm opacity-50">No logo</div>
                                @endif
                            </td>
                            <td>
                                @if($partner->website)
                                <a href="{{ $partner->website }}" target="_blank" class="text-blue-500 hover:underline">
                                    Visit Website
                                </a>
                                @else
                                <div class="text-sm opacity-50">No website</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $partner->is_active ? 'badge-success' : 'badge-warning' }} badge-sm">
                                    {{ $partner->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $partner->order_number }}</td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.partners.show', $partner) }}" 
                                       class="btn btn-sm btn-ghost btn-circle" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.partners.edit', $partner) }}" 
                                       class="btn btn-sm btn-info btn-circle" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this partner?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error btn-circle" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fas fa-handshake text-6xl mb-4 opacity-50"></i>
                                    <h3 class="text-xl font-semibold mb-2">No Partners Found</h3>
                                    <p class="text-sm mb-4">Start by adding your first partner</p>
                                    <a href="{{ route('admin.partners.create') }}" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none btn-sm">
                                        <i class="fas fa-plus mr-2"></i>
                                        Add First Partner
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($partners->hasPages())
            <div class="flex justify-center mt-6 p-4 border-t">
                {{ $partners->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
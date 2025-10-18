@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Menu Management</h1>
            <p class="text-base-content/70">Manage your website navigation menus</p>
        </div>
        <button onclick="openAddMenuModal()" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
            <i class="fas fa-plus mr-2"></i>
            Add Menu
        </button>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Frontend Menus Card -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <h2 class="card-title text-orange-600">Frontend Navigation</h2>
            
            <div id="menu-list" class="space-y-2">
                @forelse($frontendMenus as $menu)
                <div class="menu-item" data-id="{{ $menu->id }}">
                    <div class="flex items-center justify-between p-4 bg-base-100 border rounded-lg cursor-move hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-grip-vertical text-gray-400"></i>
                            <i class="fas fa-globe text-blue-500"></i>
                            <span class="font-medium">{{ $menu->title }}</span>
                            <span class="badge badge-sm badge-ghost">{{ $menu->url }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="swap swap-rotate">
                                <input type="checkbox" {{ $menu->is_active ? 'checked' : '' }} onchange="toggleMenu({{ $menu->id }})">
                                <div class="swap-on text-xs">ON</div>
                                <div class="swap-off text-xs">OFF</div>
                            </label>
                            <button onclick="editMenu({{ $menu->id }})" class="btn btn-sm btn-ghost">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteMenu({{ $menu->id }})" class="btn btn-sm btn-ghost text-error">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    
                    @if($menu->children->count() > 0)
                    <div class="ml-8 mt-2 space-y-2">
                        @foreach($menu->children as $child)
                        <div class="menu-item" data-id="{{ $child->id }}">
                            <div class="flex items-center justify-between p-3 bg-base-200 border rounded-lg cursor-move hover:shadow-md transition-shadow">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-grip-vertical text-gray-400"></i>
                                    <i class="fas fa-link text-gray-500"></i>
                                    <span class="text-sm">{{ $child->title }}</span>
                                    <span class="badge badge-xs badge-ghost">{{ $child->url }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="swap swap-rotate swap-sm">
                                        <input type="checkbox" {{ $child->is_active ? 'checked' : '' }} onchange="toggleMenu({{ $child->id }})">
                                        <div class="swap-on text-xs">ON</div>
                                        <div class="swap-off text-xs">OFF</div>
                                    </label>
                                    <button onclick="editMenu({{ $child->id }})" class="btn btn-xs btn-ghost">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteMenu({{ $child->id }})" class="btn btn-xs btn-ghost text-error">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-globe text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-500 mb-2">No Menus Found</h3>
                    <p class="text-gray-400 mb-4">Create your first frontend menu</p>
                    <button onclick="openAddMenuModal()" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                        <i class="fas fa-plus mr-2"></i>
                        Add Your First Menu
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Menu Modal -->
<div id="menuModal" class="modal modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4" id="modalTitle">Add Menu</h3>
        <form id="menuForm">
            @csrf
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden" id="menuId" name="menuId">
            <input type="hidden" id="menuType" name="type" value="frontend">
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-semibold">Menu Title</span>
                </label>
                <input type="text" id="menuTitle" name="title" class="input input-bordered w-full" required>
            </div>
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-semibold">Menu Type</span>
                </label>
                <select id="menuOptionType" name="menuOptionType" class="select select-bordered w-full" onchange="updateMenuOptions()">
                    <option value="custom">Custom URL</option>
                    <option value="pages">Page</option>
                    <option value="categories">Event Category</option>
                </select>
            </div>
            
            <div class="form-control mb-4" id="customUrlContainer">
                <label class="label">
                    <span class="label-text font-semibold">URL</span>
                </label>
                <input type="text" id="menuUrl" name="url" class="input input-bordered w-full" placeholder="/your-custom-url">
            </div>
            
            <div class="form-control mb-4" id="pageUrlContainer" style="display:none;">
                <label class="label">
                    <span class="label-text font-semibold">Select Page</span>
                </label>
                <select id="pageSelect" class="select select-bordered w-full" onchange="setPageUrl()">
                    <option value="">-- Select a page --</option>
                    @foreach($pages as $page)
                    <option value="{{ $page->slug }}">{{ $page->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-control mb-4" id="categoryUrlContainer" style="display:none;">
                <label class="label">
                    <span class="label-text font-semibold">Select Category</span>
                </label>
                <select id="categorySelect" class="select select-bordered w-full" onchange="setCategoryUrl()">
                    <option value="">-- Select a category --</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-semibold">Parent Menu</span>
                </label>
                <select id="parentId" name="parent_id" class="select select-bordered w-full">
                    <option value="">None (Parent Menu)</option>
                    @foreach($frontendMenus as $menu)
                    <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-semibold">Target</span>
                </label>
                <select id="menuTarget" name="target" class="select select-bordered w-full">
                    <option value="_self">Same Window</option>
                    <option value="_blank">New Window</option>
                </select>
            </div>
            
            <div class="modal-action">
                <button type="button" onclick="closeMenuModal()" class="btn">Cancel</button>
                <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white">Save</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Initialize drag and drop
function initializeDragAndDrop() {
    const menuList = document.getElementById('menu-list');
    
    if (menuList) {
        new Sortable(menuList, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            handle: '.fa-grip-vertical',
            onEnd: function(evt) {
                updateMenuOrder();
            }
        });
    }
}

// Update menu order
function updateMenuOrder() {
    const menuItems = document.querySelectorAll('#menu-list .menu-item');
    const menuOrder = Array.from(menuItems).map(item => item.dataset.id);
    
    fetch('{{ route("admin.menus.updateOrder") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ menuOrder: menuOrder })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Menu order updated successfully');
        }
    })
    .catch(error => {
        console.error('Error updating menu order:', error);
    });
}

// Open add menu modal
function openAddMenuModal() {
    document.getElementById('modalTitle').textContent = 'Add Menu';
    document.getElementById('menuId').value = '';
    document.getElementById('menuTitle').value = '';
    document.getElementById('menuUrl').value = '';
    document.getElementById('menuOptionType').value = 'custom';
    document.getElementById('menuTarget').value = '_self';
    
    // Reset URL containers
    document.getElementById('customUrlContainer').style.display = 'block';
    document.getElementById('pageUrlContainer').style.display = 'none';
    document.getElementById('categoryUrlContainer').style.display = 'none';
    
    document.getElementById('menuModal').classList.add('modal-open');
}

// Edit menu
function editMenu(menuId) {
    fetch('{{ route("admin.menus.show", ":id") }}'.replace(':id', menuId))
    .then(response => response.json())
    .then(data => {
        document.getElementById('modalTitle').textContent = 'Edit Menu';
        document.getElementById('menuId').value = data.menu.id;
        document.getElementById('menuTitle').value = data.menu.title;
        document.getElementById('menuUrl').value = data.menu.url;
        document.getElementById('menuTarget').value = data.menu.target;
        document.getElementById('parentId').value = data.menu.parent_id || '';
        
        // Determine menu option type based on URL
        if (data.menu.url.startsWith('/page/')) {
            document.getElementById('menuOptionType').value = 'pages';
            document.getElementById('pageSelect').value = data.menu.url.replace('/page/', '');
            updateMenuOptions();
        } else if (data.menu.url.startsWith('/events/category/')) {
            document.getElementById('menuOptionType').value = 'categories';
            document.getElementById('categorySelect').value = data.menu.url.replace('/events/category/', '');
            updateMenuOptions();
        } else {
            document.getElementById('menuOptionType').value = 'custom';
            updateMenuOptions();
        }
        
        document.getElementById('menuModal').classList.add('modal-open');
    })
    .catch(error => {
        console.error('Error fetching menu:', error);
    });
}

// Close menu modal
function closeMenuModal() {
    document.getElementById('menuModal').classList.remove('modal-open');
}

// Update menu options based on selected type
function updateMenuOptions() {
    const menuType = document.getElementById('menuOptionType').value;
    const customUrlContainer = document.getElementById('customUrlContainer');
    const pageUrlContainer = document.getElementById('pageUrlContainer');
    const categoryUrlContainer = document.getElementById('categoryUrlContainer');
    
    // Hide all containers
    customUrlContainer.style.display = 'none';
    pageUrlContainer.style.display = 'none';
    categoryUrlContainer.style.display = 'none';
    
    // Show the appropriate container
    if (menuType === 'custom') {
        customUrlContainer.style.display = 'block';
    } else if (menuType === 'pages') {
        pageUrlContainer.style.display = 'block';
    } else if (menuType === 'categories') {
        categoryUrlContainer.style.display = 'block';
    }
}

// Set page URL
function setPageUrl() {
    const pageSelect = document.getElementById('pageSelect');
    const urlInput = document.getElementById('menuUrl');
    
    if (pageSelect.value) {
        urlInput.value = '/page/' + pageSelect.value;
    } else {
        urlInput.value = '';
    }
}

// Set category URL
function setCategoryUrl() {
    const categorySelect = document.getElementById('categorySelect');
    const urlInput = document.getElementById('menuUrl');
    
    if (categorySelect.value) {
        urlInput.value = '/events/category/' + categorySelect.value;
    } else {
        urlInput.value = '';
    }
}

// Toggle menu status
function toggleMenu(menuId) {
    fetch('{{ route("admin.menus.toggle", ":id") }}'.replace(':id', menuId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Status already toggled in the UI
        }
    })
    .catch(error => {
        console.error('Error toggling menu:', error);
    });
}

// Delete menu
function deleteMenu(menuId) {
    if (confirm('Are you sure you want to delete this menu?')) {
        fetch('{{ route("admin.menus.destroy", ":id") }}'.replace(':id', menuId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.error || 'Failed to delete menu');
            }
        })
        .catch(error => {
            console.error('Error deleting menu:', error);
            alert('Failed to delete menu');
        });
    }
}

// Handle form submission
document.getElementById('menuForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const menuId = document.getElementById('menuId').value;
    const isEditing = menuId !== '';
    
    const url = isEditing 
        ? '{{ route("admin.menus.update", ":id") }}'.replace(':id', menuId)
        : '{{ route("admin.menus.store") }}';
    
    const method = isEditing ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeMenuModal();
            location.reload();
        } else {
            alert('Error saving menu: ' + (data.errors ? Object.values(data.errors).join(', ') : 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error saving menu:', error);
        alert('Failed to save menu');
    });
});

// Initialize drag and drop on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeDragAndDrop();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
@endpush
@endsection
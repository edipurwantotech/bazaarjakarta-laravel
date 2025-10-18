@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-4xl">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-cog text-3xl text-orange-600"></i>
        </div>
        <h1 class="text-3xl font-bold text-orange-600">Settings</h1>
        <p class="text-base-content/70">Manage your bazaar configuration</p>
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

    <!-- Settings Form -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <!-- Tabs -->
            <div class="tabs tabs-boxed bg-base-200 border-b">
                <a href="#general" class="tab tab-active flex items-center gap-2" onclick="switchTab('general', this)">
                    <i class="fas fa-building"></i>
                    Umum
                </a>
                <a href="#seo" class="tab flex items-center gap-2" onclick="switchTab('seo', this)">
                    <i class="fas fa-search"></i>
                    SEO
                </a>
                <a href="#homepage" class="tab flex items-center gap-2" onclick="switchTab('homepage', this)">
                    <i class="fas fa-home"></i>
                    Homepage
                </a>
            </div>

            <!-- General Tab Form -->
            <form id="general-form" action="{{ route('admin.settings.update.general') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- General Tab Content -->
                <div id="general-tab" class="tab-content p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Name -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-building text-orange-500"></i>
                                    Nama Perusahaan
                                </span>
                            </label>
                            <input type="text"
                                   name="company_name"
                                   value="{{ $generalSettings->get('company_name')?->value ?? '' }}"
                                   class="input input-bordered w-full"
                                   placeholder="Nama perusahaan">
                        </div>

                        <!-- Phone Number -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-phone text-orange-500"></i>
                                    No HP
                                </span>
                            </label>
                            <input type="tel"
                                   name="phone_number"
                                   value="{{ $generalSettings->get('phone_number')?->value ?? '' }}"
                                   class="input input-bordered w-full"
                                   placeholder="No HP">
                        </div>

                        <!-- WhatsApp Number -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fab fa-whatsapp text-orange-500"></i>
                                    No WhatsApp
                                </span>
                            </label>
                            <input type="tel"
                                   name="whatsapp_number"
                                   value="{{ $generalSettings->get('whatsapp_number')?->value ?? '' }}"
                                   class="input input-bordered w-full"
                                   placeholder="No WhatsApp">
                        </div>
                    </div>

                    <!-- Address and Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Address -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-orange-500"></i>
                                    Alamat
                                </span>
                            </label>
                            <input type="text"
                                   name="address"
                                   value="{{ $generalSettings->get('address')?->value ?? '' }}"
                                   class="input input-bordered w-full"
                                   placeholder="Alamat perusahaan">
                        </div>

                        <!-- Email -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-envelope text-orange-500"></i>
                                    Email
                                </span>
                            </label>
                            <input type="email"
                                   name="email"
                                   value="{{ $generalSettings->get('email')?->value ?? '' }}"
                                   class="input input-bordered w-full"
                                   placeholder="Email perusahaan">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-control mt-6">
                        <label class="label">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="fas fa-align-left text-orange-500"></i>
                                Deskripsi
                            </span>
                        </label>
                        <textarea name="description"
                                  class="textarea textarea-bordered h-24 w-full"
                                  placeholder="Deskripsi perusahaan">{{ $generalSettings->get('description')?->value ?? '' }}</textarea>
                    </div>

                    <!-- Vision and Mission -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Vision -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-eye text-orange-500"></i>
                                    Visi
                                </span>
                            </label>
                            <textarea name="vision"
                                      class="textarea textarea-bordered h-24 w-full"
                                      placeholder="Visi perusahaan">{{ $generalSettings->get('vision')?->value ?? '' }}</textarea>
                        </div>

                        <!-- Mission -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-bullseye text-orange-500"></i>
                                    Misi
                                </span>
                            </label>
                            <textarea name="mission"
                                      class="textarea textarea-bordered h-24 w-full"
                                      placeholder="Misi perusahaan">{{ $generalSettings->get('mission')?->value ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                            <i class="fas fa-share-alt text-orange-500"></i>
                            Media Sosial
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Facebook -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="fab fa-facebook text-orange-500"></i>
                                        Facebook
                                    </span>
                                </label>
                                <input type="url"
                                       name="facebook"
                                       value="{{ $generalSettings->get('facebook')?->value ?? '' }}"
                                       class="input input-bordered w-full"
                                       placeholder="https://facebook.com/username">
                            </div>

                            <!-- Instagram -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="fab fa-instagram text-orange-500"></i>
                                        Instagram
                                    </span>
                                </label>
                                <input type="url"
                                       name="instagram"
                                       value="{{ $generalSettings->get('instagram')?->value ?? '' }}"
                                       class="input input-bordered w-full"
                                       placeholder="https://instagram.com/username">
                            </div>

                            <!-- TikTok -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="fab fa-tiktok text-orange-500"></i>
                                        TikTok
                                    </span>
                                </label>
                                <input type="url"
                                       name="tiktok"
                                       value="{{ $generalSettings->get('tiktok')?->value ?? '' }}"
                                       class="input input-bordered w-full"
                                       placeholder="https://tiktok.com/@username">
                            </div>

                            <!-- YouTube -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="fab fa-youtube text-orange-500"></i>
                                        YouTube
                                    </span>
                                </label>
                                <input type="url"
                                       name="youtube"
                                       value="{{ $generalSettings->get('youtube')?->value ?? '' }}"
                                       class="input input-bordered w-full"
                                       placeholder="https://youtube.com/channel/ID">
                            </div>

                            <!-- Twitter -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="fab fa-twitter text-orange-500"></i>
                                        Twitter
                                    </span>
                                </label>
                                <input type="url"
                                       name="twitter"
                                       value="{{ $generalSettings->get('twitter')?->value ?? '' }}"
                                       class="input input-bordered w-full"
                                       placeholder="https://twitter.com/username">
                            </div>
                        </div>
                    </div>

                    <!-- General Tab Save Button -->
                    <div class="card-actions justify-end mt-6">
                        <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none" id="general-save-btn">
                            <i class="fas fa-save mr-2"></i>
                            <span>Simpan Pengaturan Umum</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- SEO Tab Form -->
            <form id="seo-form" action="{{ route('admin.settings.update.seo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- SEO Tab Content -->
                <div id="seo-tab" class="tab-content p-6 hidden">
                    <!-- Google Site Verification -->
                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="fab fa-google text-orange-500"></i>
                                Google Site Verification
                            </span>
                        </label>
                        <input type="text"
                               name="google_site_verification"
                               value="{{ $seoSettings->get('google_site_verification')?->value ?? '' }}"
                               class="input input-bordered w-full"
                               placeholder="Google Site Verification Code">
                        <label class="label">
                            <span class="label-text-alt text-xs">Kode verifikasi dari Google Search Console</span>
                        </label>
                    </div>

                    <!-- Home Image -->
                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="fas fa-image text-orange-500"></i>
                                Image Home
                            </span>
                        </label>
                        @if($seoSettings->get('home_image')?->value)
                        <div class="mb-2">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $seoSettings->get('home_image')?->value) }}" alt="Home Image" class="w-32 h-32 object-cover rounded">
                                <div>
                                    <p class="text-sm">Current image</p>
                                    <p class="text-xs opacity-70">Upload a new image to replace</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        <input type="file"
                               name="home_image"
                               class="file-input file-input-bordered w-full"
                               accept="image/*">
                        <label class="label">
                            <span class="label-text-alt text-xs">Gambar untuk halaman utama (JPEG, PNG, JPG, GIF - Max 2MB)</span>
                        </label>
                    </div>

                    <!-- SEO Keywords -->
                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="fas fa-key text-orange-500"></i>
                                SEO Keywords
                            </span>
                        </label>
                        <input type="text"
                               name="seo_keywords"
                               value="{{ $seoSettings->get('seo_keywords')?->value ?? '' }}"
                               class="input input-bordered w-full"
                               placeholder="Bazaar Jakarta, Event Bazaar, Jual Beli">
                        <label class="label">
                            <span class="label-text-alt text-xs">Kata kunci SEO (pisahkan dengan koma)</span>
                        </label>
                    </div>

                    <!-- SEO Description -->
                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="fas fa-align-left text-orange-500"></i>
                                SEO Description
                            </span>
                        </label>
                        <textarea name="seo_description"
                                  class="textarea textarea-bordered h-24 w-full"
                                  placeholder="Deskripsi SEO untuk mesin pencari">{{ $seoSettings->get('seo_description')?->value ?? '' }}</textarea>
                        <label class="label">
                            <span class="label-text-alt text-xs">Deskripsi SEO untuk mesin pencari (rekomendasi: 150-160 karakter)</span>
                        </label>
                    </div>

                    <!-- SEO Tab Save Button -->
                    <div class="card-actions justify-end">
                        <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none" id="seo-save-btn">
                            <i class="fas fa-save mr-2"></i>
                            <span>Simpan Pengaturan SEO</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Homepage Tab Form -->
            <form id="homepage-form" action="{{ route('admin.settings.update.homepage') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Homepage Tab Content -->
                <div id="homepage-tab" class="tab-content p-6 hidden">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                            <i class="fas fa-chart-bar text-orange-500"></i>
                            Statistik Homepage
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Atur nilai statistik yang akan ditampilkan di halaman utama website
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Event Sukses -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-calendar-check text-orange-500"></i>
                                    Event Sukses
                                </span>
                            </label>
                            <input type="text"
                                   name="stat_event_sukses"
                                   value="{{ $homepageSettings->get('stat_event_sukses')?->value ?? '200+' }}"
                                   class="input input-bordered w-full"
                                   placeholder="Contoh: 200+">
                            <label class="label">
                                <span class="label-text-alt text-xs">Jumlah event sukses yang telah diselenggarakan</span>
                            </label>
                        </div>

                        <!-- Peserta -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-users text-orange-500"></i>
                                    Peserta
                                </span>
                            </label>
                            <input type="text"
                                   name="stat_peserta"
                                   value="{{ $homepageSettings->get('stat_peserta')?->value ?? '50K+' }}"
                                   class="input input-bordered w-full"
                                   placeholder="Contoh: 50K+">
                            <label class="label">
                                <span class="label-text-alt text-xs">Total jumlah peserta yang telah bergabung</span>
                            </label>
                        </div>

                        <!-- Partner Bisnis -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-handshake text-orange-500"></i>
                                    Partner Bisnis
                                </span>
                            </label>
                            <input type="text"
                                   name="stat_partner_bisnis"
                                   value="{{ $homepageSettings->get('stat_partner_bisnis')?->value ?? '100+' }}"
                                   class="input input-bordered w-full"
                                   placeholder="Contoh: 100+">
                            <label class="label">
                                <span class="label-text-alt text-xs">Jumlah partner bisnis yang bekerja sama</span>
                            </label>
                        </div>

                        <!-- Penghargaan -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-award text-orange-500"></i>
                                    Penghargaan
                                </span>
                            </label>
                            <input type="text"
                                   name="stat_penghargaan"
                                   value="{{ $homepageSettings->get('stat_penghargaan')?->value ?? '15' }}"
                                   class="input input-bordered w-full"
                                   placeholder="Contoh: 15">
                            <label class="label">
                                <span class="label-text-alt text-xs">Jumlah penghargaan yang telah diraih</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Preview Section -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                            <i class="fas fa-eye text-orange-500"></i>
                            Preview Tampilan
                        </h3>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="grid md:grid-cols-4 gap-4">
                                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-4 text-white text-center">
                                    <i class="fas fa-calendar-check text-3xl mb-2"></i>
                                    <div class="text-2xl font-bold mb-1 preview-event-sukses">{{ $homepageSettings->get('stat_event_sukses')?->value ?? '200+' }}</div>
                                    <div class="text-xs opacity-90">Event Sukses</div>
                                </div>
                                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-4 text-white text-center">
                                    <i class="fas fa-users text-3xl mb-2"></i>
                                    <div class="text-2xl font-bold mb-1 preview-peserta">{{ $homepageSettings->get('stat_peserta')?->value ?? '50K+' }}</div>
                                    <div class="text-xs opacity-90">Peserta</div>
                                </div>
                                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-4 text-white text-center">
                                    <i class="fas fa-handshake text-3xl mb-2"></i>
                                    <div class="text-2xl font-bold mb-1 preview-partner-bisnis">{{ $homepageSettings->get('stat_partner_bisnis')?->value ?? '100+' }}</div>
                                    <div class="text-xs opacity-90">Partner Bisnis</div>
                                </div>
                                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-4 text-white text-center">
                                    <i class="fas fa-award text-3xl mb-2"></i>
                                    <div class="text-2xl font-bold mb-1 preview-penghargaan">{{ $homepageSettings->get('stat_penghargaan')?->value ?? '15' }}</div>
                                    <div class="text-xs opacity-90">Penghargaan</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Homepage Tab Save Button -->
                    <div class="card-actions justify-end">
                        <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none" id="homepage-save-btn">
                            <i class="fas fa-save mr-2"></i>
                            <span>Simpan Pengaturan Homepage</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.tab-content {
    display: block;
}
.tab-content.hidden {
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check for hash in URL and switch to that tab
    const hash = window.location.hash.substring(1); // Remove the #
    const tabName = hash || 'general';
    
    // Find the tab element
    const tabElement = document.querySelector(`a[href="#${tabName}"]`);
    
    if (tabElement) {
        switchTab(tabName, tabElement);
    } else {
        // Default to general tab if hash doesn't match any tab
        const generalTab = document.querySelector('a[href="#general"]');
        if (generalTab) {
            switchTab('general', generalTab);
        }
    }
    
    // Handle AJAX form submissions
    setupAjaxForm('general-form', 'general-save-btn');
    setupAjaxForm('seo-form', 'seo-save-btn');
    setupAjaxForm('homepage-form', 'homepage-save-btn');
});

function setupAjaxForm(formId, buttonId) {
    const form = document.getElementById(formId);
    const button = document.getElementById(buttonId);
    
    if (form && button) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const originalContent = button.innerHTML;
            button.innerHTML = '<span class="loading loading-spinner loading-sm"></span> Menyimpan...';
            button.disabled = true;
            
            // Create FormData for file uploads
            const formData = new FormData(form);
            
            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification(data.message, 'success');
                } else {
                    // Show error message
                    if (data.errors) {
                        // Handle validation errors
                        Object.keys(data.errors).forEach(field => {
                            const input = document.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('input-error');
                                // Remove error on focus
                                input.addEventListener('focus', function() {
                                    this.classList.remove('input-error');
                                });
                            }
                        });
                        showNotification('Please correct the errors below.', 'error');
                    } else {
                        showNotification(data.message || 'An error occurred.', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while saving.', 'error');
            })
            .finally(() => {
                // Restore button state
                button.innerHTML = originalContent;
                button.disabled = false;
            });
        });
    }
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} mb-6 shadow-lg fixed top-4 right-4 z-50 max-w-sm`;
    notification.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            ${type === 'success'
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />'
            }
        </svg>
        <span>${message}</span>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function switchTab(tabName, tabElement) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('tab-active');
    });
    
    // Show selected tab
    const selectedTab = document.getElementById(tabName + '-tab');
    if (selectedTab) {
        selectedTab.classList.remove('hidden');
    }
    
    // Add active class to selected tab
    if (tabElement) {
        tabElement.classList.add('tab-active');
    }
    
    // Update URL hash
    history.pushState(null, null, '#' + tabName);
}

// Live preview update for homepage statistics
document.addEventListener('DOMContentLoaded', function() {
    const statInputs = {
        'stat_event_sukses': '.preview-event-sukses',
        'stat_peserta': '.preview-peserta',
        'stat_partner_bisnis': '.preview-partner-bisnis',
        'stat_penghargaan': '.preview-penghargaan'
    };
    
    Object.keys(statInputs).forEach(inputName => {
        const input = document.querySelector(`input[name="${inputName}"]`);
        const previewElement = document.querySelector(statInputs[inputName]);
        
        if (input && previewElement) {
            input.addEventListener('input', function() {
                previewElement.textContent = this.value || '0';
            });
        }
    });
});
</script>
@endsection
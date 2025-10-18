<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SettingsController extends BaseAdminController
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        // Get all settings
        $allSettings = Setting::all();
        
        // Group settings by category
        $generalSettings = $allSettings->where('category', 'general')->keyBy('key');
        $seoSettings = $allSettings->where('category', 'seo')->keyBy('key');
        $homepageSettings = $allSettings->where('category', 'homepage')->keyBy('key');
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.settings.index', compact('generalSettings', 'seoSettings', 'homepageSettings', 'adminMenus'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $data = $request->all();
        
        // Get the active tab from the request or default to general
        $activeTab = 'general'; // Default to general tab
        
        // Check if there's a current_tab in the request
        if (isset($data['current_tab'])) {
            $activeTab = $data['current_tab'];
            unset($data['current_tab']); // Remove it from data so it doesn't get saved as a setting
        }
        
        // Remove the CSRF token from data
        unset($data['_token']);
        
        // Validate and update each setting
        foreach ($data as $key => $value) {
            // Find the setting by key
            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                // Validate based on setting type
                $validationRules = [];
                $validationMessages = [];
                
                switch ($setting->type) {
                    case 'text':
                        // Make SEO fields optional
                        if ($setting->category === 'seo') {
                            $validationRules[$key] = 'nullable|string|max:255';
                        } else {
                            $validationRules[$key] = 'required|string|max:255';
                            $validationMessages["{$key}.required"] = "The {$setting->name} field is required.";
                        }
                        break;
                    case 'textarea':
                        // Make SEO fields optional
                        if ($setting->category === 'seo') {
                            $validationRules[$key] = 'nullable|string';
                        } else {
                            $validationRules[$key] = 'required|string';
                            $validationMessages["{$key}.required"] = "The {$setting->name} field is required.";
                        }
                        break;
                    case 'email':
                        $validationRules[$key] = 'required|email|max:255';
                        $validationMessages["{$key}.required"] = "The {$setting->name} field is required.";
                        $validationMessages["{$key}.email"] = "The {$setting->name} must be a valid email address.";
                        break;
                    case 'tel':
                        $validationRules[$key] = 'required|string|max:20';
                        $validationMessages["{$key}.required"] = "The {$setting->name} field is required.";
                        break;
                    case 'url':
                        $validationRules[$key] = 'required|url|max:255';
                        $validationMessages["{$key}.required"] = "The {$setting->name} field is required.";
                        $validationMessages["{$key}.url"] = "The {$setting->name} must be a valid URL.";
                        break;
                    case 'image':
                        $validationRules[$key] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
                        break;
                }
                
                // Only validate if there are validation rules
                if (!empty($validationRules)) {
                    $validator = Validator::make($data, $validationRules, $validationMessages);
                    
                    if ($validator->fails()) {
                        if ($request->ajax() || $request->wantsJson()) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Validation failed',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                        
                        return redirect()
                            ->route('admin.settings.index')
                            ->withFragment($activeTab)
                            ->withErrors($validator)
                            ->withInput();
                    }
                }
                
                // Handle file uploads
                if ($setting->type === 'image' && $request->hasFile($key)) {
                    // Delete old image if exists
                    if ($setting->value) {
                        $oldImagePath = public_path('storage/' . $setting->value);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    
                    // Upload new image
                    $imagePath = $request->file($key)->store('settings', 'public');
                    Setting::where('key', $key)->update(['value' => $imagePath]);
                } elseif ($setting->type !== 'image') {
                    // Update text-based settings
                    Setting::where('key', $key)->update(['value' => $value]);
                }
            }
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully.'
            ]);
        }
        
        return redirect()
            ->route('admin.settings.index')
            ->withFragment($activeTab)
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Update general settings via AJAX.
     */
    public function updateGeneral(Request $request)
    {
        return $this->updateSettingsByCategory($request, 'general');
    }

    /**
     * Update SEO settings via AJAX.
     */
    public function updateSeo(Request $request)
    {
        return $this->updateSettingsByCategory($request, 'seo');
    }

    /**
     * Update Homepage settings via AJAX.
     */
    public function updateHomepage(Request $request)
    {
        return $this->updateSettingsByCategory($request, 'homepage');
    }

    /**
     * Update settings by category.
     */
    private function updateSettingsByCategory(Request $request, $category)
    {
        $data = $request->all();
        
        // Remove the CSRF token from data
        unset($data['_token']);
        
        // Get all settings for this category
        $settings = Setting::where('category', $category)->get();
        
        // Validate and update each setting
        foreach ($data as $key => $value) {
            // Find the setting by key
            $setting = $settings->where('key', $key)->first();
            
            if ($setting) {
                // Validate based on setting type
                $validationRules = [];
                $validationMessages = [];
                
                switch ($setting->type) {
                    case 'text':
                        // Make SEO fields optional
                        if ($category === 'seo') {
                            $validationRules[$key] = 'nullable|string|max:255';
                        } else {
                            $validationRules[$key] = 'required|string|max:255';
                            $validationMessages["{$key}.required"] = "The {$setting->name} field is required.";
                        }
                        break;
                    case 'textarea':
                        // Make SEO fields optional
                        if ($category === 'seo') {
                            $validationRules[$key] = 'nullable|string';
                        } else {
                            $validationRules[$key] = 'required|string';
                            $validationMessages["{$key}.required"] = "The {$setting->name} field is required.";
                        }
                        break;
                    case 'email':
                        $validationRules[$key] = 'required|email|max:255';
                        $validationMessages["{$key}.required"] = "The {$setting->name} field is required.";
                        $validationMessages["{$key}.email"] = "The {$setting->name} must be a valid email address.";
                        break;
                    case 'tel':
                        $validationRules[$key] = 'required|string|max:20';
                        $validationMessages["{$key}.required"] = "The {$setting->name} field is required.";
                        break;
                    case 'url':
                        $validationRules[$key] = 'required|url|max:255';
                        $validationMessages["{$key}.required"] = "The {$setting->name} field is required.";
                        $validationMessages["{$key}.url"] = "The {$setting->name} must be a valid URL.";
                        break;
                    case 'image':
                        $validationRules[$key] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
                        break;
                }
                
                // Only validate if there are validation rules
                if (!empty($validationRules)) {
                    $validator = Validator::make($data, $validationRules, $validationMessages);
                    
                    if ($validator->fails()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Validation failed',
                            'errors' => $validator->errors()
                        ], 422);
                    }
                }
                
                // Handle file uploads
                if ($setting->type === 'image' && $request->hasFile($key)) {
                    // Delete old image if exists
                    if ($setting->value) {
                        $oldImagePath = public_path('storage/' . $setting->value);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    
                    // Upload new image
                    $imagePath = $request->file($key)->store('settings', 'public');
                    Setting::where('key', $key)->update(['value' => $imagePath]);
                } elseif ($setting->type !== 'image') {
                    // Update text-based settings
                    Setting::where('key', $key)->update(['value' => $value]);
                }
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => ucfirst($category) . ' settings updated successfully.'
        ]);
    }
}
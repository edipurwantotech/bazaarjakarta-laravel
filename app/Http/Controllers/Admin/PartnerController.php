<?php

namespace App\Http\Controllers\Admin;

use App\Models\Partner;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PartnerController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = Partner::ordered()->paginate(10);
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.partners.index', compact('partners', 'adminMenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.partners.create', compact('adminMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=3000,max_height=3000'
            ],
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'order_number' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle logo upload with security enhancements
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            
            // Additional security checks
            if (!$file->isValid() || $file->getSize() > 2048 * 1024) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['logo' => 'Invalid file or file too large.']);
            }
            
            // Generate safe filename
            $safeFilename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $logoPath = $file->storeAs('partners', $safeFilename, 'public');
            $validated['logo'] = $logoPath;
        }

        // Set default values
        $validated['order_number'] = $validated['order_number'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        Partner::create($validated);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.partners.show', compact('partner', 'adminMenus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.partners.edit', compact('partner', 'adminMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('partners')->ignore($partner->id),
            ],
            'logo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=3000,max_height=3000'
            ],
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'order_number' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle logo upload with security enhancements
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            
            // Additional security checks
            if (!$file->isValid() || $file->getSize() > 2048 * 1024) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['logo' => 'Invalid file or file too large.']);
            }
            
            // Delete old logo if exists
            if ($partner->logo) {
                $oldLogoPath = public_path('storage/' . $partner->logo);
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }
            
            // Generate safe filename
            $safeFilename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $logoPath = $file->storeAs('partners', $safeFilename, 'public');
            $validated['logo'] = $logoPath;
        }

        // Set default values
        $validated['order_number'] = $validated['order_number'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        $partner->update($validated);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        // Delete logo if exists
        if ($partner->logo) {
            $logoPath = public_path('storage/' . $partner->logo);
            if (file_exists($logoPath)) {
                unlink($logoPath);
            }
        }
        
        $partner->delete();

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()->orderBy('sort_order')->latest('id')->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateService($request);
        $data['slug'] = Str::slug($data['name_en']) . '-' . Str::lower(Str::random(5));
        $data['excerpt'] = $data['excerpt_ja'];
        $data['icon_image'] = $this->storeImage($request, 'icon_image');
        $data['excerpt_image'] = $this->storeImage($request, 'excerpt_image');

        Service::create($data);

        return redirect()->route('admin.services.index')->with('status', 'Service created.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validateService($request, $service);
        $data['slug'] = $request->filled('slug')
            ? Str::slug((string) $request->string('slug'))
            : $service->slug;
        $data['excerpt'] = $data['excerpt_ja'];

        if ($request->hasFile('icon_image')) {
            $this->deleteImage($service->icon_image);
            $data['icon_image'] = $this->storeImage($request, 'icon_image');
        }

        if ($request->hasFile('excerpt_image')) {
            $this->deleteImage($service->excerpt_image);
            $data['excerpt_image'] = $this->storeImage($request, 'excerpt_image');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $this->deleteImage($service->icon_image);
        $this->deleteImage($service->excerpt_image);
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Service deleted.');
    }

    private function validateService(Request $request, ?Service $service = null): array
    {
        return $request->validate([
            'name_en' => ['required', 'string', 'max:255'],
            'name_ja' => ['required', 'string', 'max:255'],
            'excerpt_en' => ['required', 'string'],
            'excerpt_ja' => ['required', 'string'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::notIn(['admin']),
                Rule::unique('services', 'slug')->ignore($service?->id),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'icon_image' => ['nullable', 'image', 'max:2048'],
            'excerpt_image' => ['nullable', 'image', 'max:4096'],
        ]) + [
            'sort_order' => (int) $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active'),
        ];
    }

    private function storeImage(Request $request, string $field): ?string
    {
        if (!$request->hasFile($field)) {
            return null;
        }

        $folder = public_path('uploads/services');
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $file = $request->file($field);
        $filename = now()->timestamp . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($folder, $filename);

        return 'uploads/services/' . $filename;
    }

    private function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $absolutePath = public_path($path);
        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }
    }
}

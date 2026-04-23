<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminServiceMenuController extends Controller
{
    public function index(Service $service)
    {
        $menus = $service->menus()->get();

        return view('admin.service-menus.index', compact('service', 'menus'));
    }

    public function create(Service $service)
    {
        return view('admin.service-menus.create', compact('service'));
    }

    public function store(Request $request, Service $service)
    {
        $data = $this->validateMenu($request);
        $data['service_id'] = $service->id;
        $data['title'] = $data['title_ja'];
        $data['description'] = $data['description_ja'];
        $data['poster_image'] = $this->storeImage($request);

        ServiceMenu::create($data);

        return redirect()->route('admin.services.menus.index', $service)->with('status', 'Service menu created.');
    }

    public function edit(Service $service, ServiceMenu $menu)
    {
        abort_unless($menu->service_id === $service->id, 404);

        return view('admin.service-menus.edit', compact('service', 'menu'));
    }

    public function update(Request $request, Service $service, ServiceMenu $menu)
    {
        abort_unless($menu->service_id === $service->id, 404);

        $data = $this->validateMenu($request);
        $data['title'] = $data['title_ja'];
        $data['description'] = $data['description_ja'];
        if ($request->hasFile('poster_image')) {
            $this->deleteImage($menu->poster_image);
            $data['poster_image'] = $this->storeImage($request);
        }

        $menu->update($data);

        return redirect()->route('admin.services.menus.index', $service)->with('status', 'Service menu updated.');
    }

    public function destroy(Service $service, ServiceMenu $menu)
    {
        abort_unless($menu->service_id === $service->id, 404);

        $this->deleteImage($menu->poster_image);
        $menu->delete();

        return redirect()->route('admin.services.menus.index', $service)->with('status', 'Service menu deleted.');
    }

    private function validateMenu(Request $request): array
    {
        return $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'title_ja' => ['required', 'string', 'max:255'],
            'description_en' => ['required', 'string'],
            'description_ja' => ['required', 'string'],
            'duration' => ['nullable', 'string', 'max:120'],
            'price' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'poster_image' => ['nullable', 'image', 'max:4096'],
        ]) + [
            'sort_order' => (int) $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active'),
        ];
    }

    private function storeImage(Request $request): ?string
    {
        if (!$request->hasFile('poster_image')) {
            return null;
        }

        $folder = public_path('uploads/service-menus');
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $file = $request->file('poster_image');
        $filename = now()->timestamp . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($folder, $filename);

        return 'uploads/service-menus/' . $filename;
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

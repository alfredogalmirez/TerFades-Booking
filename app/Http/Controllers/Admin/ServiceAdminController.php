<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceAdminController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('is_active', 'desc')
            ->orderBy('name')
            ->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration_minutes' => ['required', 'integer', 'min:5', 'max:480'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->has('is_active');

        Service::create($data);

        return redirect('/admin/services')->with('success', 'Service created.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration_minutes' => ['required', 'integer', 'min:5', 'max:480'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->has('is_active');

        $service->update($data);

        return redirect('/admin/services')->with('success', 'Service updated.');
    }

    public function delete(Service $service){
        $service->delete();

        return redirect('/admin/services')->with('success', 'Service deleted.');
    }
}

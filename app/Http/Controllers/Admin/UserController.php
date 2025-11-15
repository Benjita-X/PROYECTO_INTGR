<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol; // Necesitamos los Roles para el formulario de edición
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        // Obtenemos todos los usuarios CON su rol cargado para evitar N+1 queries
        $users = User::with('rol')->latest()->paginate(10); // Paginar de 10 en 10
        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Rol::all(); // Necesitamos pasar los roles a la vista
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol_id' => ['required', 'exists:roles,id'], // Valida que el rol_id exista en la tabla roles
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado con éxito.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     * Pasamos el User gracias al Route Model Binding
     */
    public function edit(User $user)
    {
        $roles = Rol::all(); // Necesitamos todos los roles para el dropdown
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     * Pasamos el User gracias al Route Model Binding
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Validamos email único EXCEPTO para el usuario actual
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'rol_id' => ['required', 'exists:roles,id'],
            // Hacemos la contraseña opcional en la edición
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // Preparamos los datos a actualizar
        $data = $request->only('name', 'email', 'rol_id');

        // Si se proporcionó una nueva contraseña, la hasheamos y la añadimos
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado con éxito.');
    }

    /**
     * Elimina un usuario de la base de datos.
     * Pasamos el User gracias al Route Model Binding
     */
    public function destroy(User $user)
    {
        // Opcional: Añadir validación para no poder borrar el propio usuario admin logueado
        if ($user->id === auth()->id()) {
             return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar tu propia cuenta.');
        }
        
        // Opcional: Añadir validación para no borrar al último administrador
        if ($user->rol?->nombre_rol === 'Administrador') {
            $adminCount = User::whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'Administrador');
            })->count();
            if ($adminCount <= 1) {
                return redirect()->route('admin.users.index')->with('error', 'No se puede eliminar al último administrador.');
            }
        }


        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado con éxito.');
    }
}

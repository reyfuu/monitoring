<?php 

namespace Database\Seeders;

Use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder{
    public function run(): void{

    

        $npm= User::where('npm','like','dsad2')->first()->npm;
        $npm->assignRole('mahasiswa');
    }
}
?>
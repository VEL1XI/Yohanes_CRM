<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\Project;
use App\Models\ProjectDetail;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\Service;
use App\Models\User;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil users
        $admin = User::where('email', 'admin@isp.com')->first();
        $sales = User::where('email', 'sales@isp.com')->first();

        // Ambil services
        $service50 = Service::where('speed', 50)->first();
        $service75 = Service::where('speed', 75)->first();
        $service100 = Service::where('speed', 100)->first();

        // ========== LEAD 1 (Sudah jadi customer) ==========
        $lead1 = Lead::create([
            'company_name' => 'PT Maju Jaya',
            'pic' => 'Budi Santoso',
            'email' => 'budi@majujaya.com',
            'address' => 'Jl. Raya Darmo No. 123, Surabaya',
            'company_name_alias' => 'Maju Jaya',
            'status' => 'deal',
            'created_by' => $sales->id
        ]);

        // Project untuk Lead 1 (APPROVED)
        $project1 = Project::create([
            'lead_id' => $lead1->lead_id,
            'sales_id' => $sales->id,
            'status' => 'approved',
            'notes' => 'Project approved untuk kantor pusat',
            'created_by' => $sales->id
        ]);

        // Detail layanan project 1
        ProjectDetail::create([
            'project_id' => $project1->project_id,
            'service_id' => $service100->service_id,
            'qty' => 1,
            'price' => $service100->price,
            'subtotal' => $service100->price * 1
        ]);

        // Customer dari Lead 1
        $customer1 = Customer::create([
            'lead_id' => $lead1->lead_id,
            'name' => 'PT Maju Jaya',
            'phone' => '081234567890',
            'email' => 'budi@majujaya.com',
            'address' => 'Jl. Raya Darmo No. 123, Surabaya',
            'status' => 'aktif'
        ]);

        // Layanan customer 1
        CustomerService::create([
            'customer_id' => $customer1->customer_id,
            'service_id' => $service100->service_id,
            'start_date' => now(),
            'end_date' => null,
            'status' => 'aktif'
        ]);

        // ========== LEAD 2 (Sudah jadi customer dengan 2 layanan) ==========
        $lead2 = Lead::create([
            'company_name' => 'CV Sejahtera Abadi',
            'pic' => 'Siti Aminah',
            'email' => 'siti@sejahtera.com',
            'address' => 'Jl. Pemuda No. 45, Surabaya',
            'company_name_alias' => 'Sejahtera',
            'status' => 'deal',
            'created_by' => $sales->id
        ]);

        $project2 = Project::create([
            'lead_id' => $lead2->lead_id,
            'sales_id' => $sales->id,
            'status' => 'approved',
            'notes' => 'Project untuk kantor dan gudang',
            'created_by' => $sales->id
        ]);

        // Detail layanan project 2 (2 layanan)
        ProjectDetail::create([
            'project_id' => $project2->project_id,
            'service_id' => $service75->service_id,
            'qty' => 1,
            'price' => $service75->price,
            'subtotal' => $service75->price * 1
        ]);

        ProjectDetail::create([
            'project_id' => $project2->project_id,
            'service_id' => $service50->service_id,
            'qty' => 1,
            'price' => $service50->price,
            'subtotal' => $service50->price * 1
        ]);

        $customer2 = Customer::create([
            'lead_id' => $lead2->lead_id,
            'name' => 'CV Sejahtera Abadi',
            'phone' => '082345678901',
            'email' => 'siti@sejahtera.com',
            'address' => 'Jl. Pemuda No. 45, Surabaya',
            'status' => 'aktif'
        ]);

        // 2 Layanan untuk customer 2
        CustomerService::create([
            'customer_id' => $customer2->customer_id,
            'service_id' => $service75->service_id,
            'start_date' => now(),
            'end_date' => null,
            'status' => 'aktif'
        ]);

        CustomerService::create([
            'customer_id' => $customer2->customer_id,
            'service_id' => $service50->service_id,
            'start_date' => now(),
            'end_date' => null,
            'status' => 'aktif'
        ]);

        // ========== LEAD 3 (Project pending approval) ==========
        $lead3 = Lead::create([
            'company_name' => 'Toko Elektronik Jaya',
            'pic' => 'Ahmad Yusuf',
            'email' => 'ahmad@elektronikjaya.com',
            'address' => 'Jl. Basuki Rahmat No. 88, Surabaya',
            'company_name_alias' => 'Elektronik Jaya',
            'status' => 'menunggu',
            'created_by' => $sales->id
        ]);

        $project3 = Project::create([
            'lead_id' => $lead3->lead_id,
            'sales_id' => $sales->id,
            'status' => 'pending',
            'notes' => 'Menunggu approval untuk toko cabang baru',
            'created_by' => $sales->id
        ]);

        ProjectDetail::create([
            'project_id' => $project3->project_id,
            'service_id' => $service75->service_id,
            'qty' => 1,
            'price' => $service75->price,
            'subtotal' => $service75->price * 1
        ]);

        // ========== LEAD 4 (Baru follow-up, belum ada project) ==========
        Lead::create([
            'company_name' => 'Restoran Sedap Malam',
            'pic' => 'Dewi Lestari',
            'email' => 'dewi@sedapmalam.com',
            'address' => 'Jl. Diponegoro No. 234, Surabaya',
            'company_name_alias' => 'Sedap Malam',
            'status' => 'follow-up',
            'created_by' => $sales->id
        ]);

        // ========== LEAD 5 (Project rejected) ==========
        $lead5 = Lead::create([
            'company_name' => 'Warnet Cepat',
            'pic' => 'Eko Prasetyo',
            'email' => 'eko@warnetcepat.com',
            'address' => 'Jl. Kertajaya No. 56, Surabaya',
            'status' => 'baru',
            'created_by' => $sales->id
        ]);

        $project5 = Project::create([
            'lead_id' => $lead5->lead_id,
            'sales_id' => $sales->id,
            'status' => 'rejected',
            'notes' => 'Ditolak karena lokasi belum tercover',
            'created_by' => $sales->id
        ]);

        ProjectDetail::create([
            'project_id' => $project5->project_id,
            'service_id' => $service100->service_id,
            'qty' => 1,
            'price' => $service100->price,
            'subtotal' => $service100->price * 1
        ]);
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_requests', function (Blueprint $table) {
            $table->id();

            // --- Account information (mirrors the public reg form sections) ---
            $table->string('company_name');
            $table->string('contact_person_name');
            $table->string('designation')->nullable();
            $table->string('email');
            $table->string('mobile_number');
            $table->string('whatsapp_number')->nullable();

            // --- Company information ---
            $table->string('company_type')->nullable();
            $table->string('trade_license_number')->nullable();
            $table->date('trade_license_expiry')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('company_website')->nullable();
            $table->string('years_in_business')->nullable();

            // --- Company address ---
            $table->text('office_address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('postal_code')->nullable();

            // --- Document uploads (paths stored relative to public/) ---
            $table->string('trade_license_copy')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('national_id_passport')->nullable();
            $table->string('tin_certificate')->nullable();
            $table->string('incorporation_certificate')->nullable();
            $table->string('utility_bill')->nullable();

            // --- Property listing intent ---
            $table->string('property_category')->nullable();
            $table->string('number_of_properties')->nullable();
            $table->string('service_required')->nullable(); // Sale | Rent | Lease

            // --- Workflow ---
            // pending → admin reviews → approved (creates Company) or rejected
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            // Foreign key to the Company created on approval (so the admin
            // can navigate from a request to its resulting company).
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_requests');
    }
};

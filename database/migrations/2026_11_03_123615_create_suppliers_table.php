public function up(): void
{
    Schema::create('suppliers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('phone')->nullable();
        $table->text('address')->nullable();
        $table->timestamps();
    });
}
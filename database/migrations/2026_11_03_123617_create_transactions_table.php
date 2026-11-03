public function up(): void
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->enum('type', ['in', 'out']); 
        $table->integer('quantity');
        $table->date('date');
        $table->text('note')->nullable(); 
        $table->timestamps();
    });
}
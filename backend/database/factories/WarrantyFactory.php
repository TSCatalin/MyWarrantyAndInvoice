<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warranty>
 */
class WarrantyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileContent = $this->generateRandomFileInBase64();

        return [
            'user_id' => 5,
            'warranty_id' => $this->faker->uuid(),
            'invoice_number' => $this->faker->numerify('INV-####'),
            'product_name' => $this->faker->word(),
            'seller' => $this->faker->randomElement(['EMAG', 'ALTEX', 'VEXIO', 'FLANCO', 'ITGALAXY', 'IPON']),
            'customer_name' => $this->faker->name(),
            'date_purchase' => $this->faker->date(),
            'warranty_end_date' => $this->faker->date(),
            'status' => $this->faker->randomElement([true, false]),
            'warranty_file' => $fileContent,
            'created_at' => time(),
            'updated_at' => time()
        ];
    }

    private function generateRandomFileInBase64()
    {
        $fileType = $this->faker->randomElement(['jpg', 'png', 'pdf', 'docx']);
        $fileName = 'warranty_file_' . $this->faker->uuid() . '.' . $fileType;
        $filePath = storage_path('' . $fileName);

        switch ($fileType) {
            case 'jpg':
            case 'png':
                $imagePath = $this->faker->image($filePath, 640, 480, null, false);
                $imageContent = file_get_contents($imagePath);
                return base64_encode($imageContent);
            case 'pdf':
                $pdfContent = "Fake warranty PDF content for testing purposes";
                file_put_contents($filePath, $pdfContent);
                $pdfContent = file_get_contents($filePath);
                return base64_encode($pdfContent);
            case 'docx':
                $wordContent = "Fake warranty Word content for testing purposes";
                file_put_contents($filePath, $wordContent);
                $wordContent = file_get_contents($filePath);
                return base64_encode($wordContent);
            default:
                return null;
        }
    }

}

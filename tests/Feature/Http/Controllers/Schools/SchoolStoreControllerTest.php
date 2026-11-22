<?php

namespace Tests\Feature\Http\Controllers\Schools;

use App\Models\User;
use App\UseCases\Contracts\Schools\StoreSchoolsUseCaseInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SchoolStoreControllerTest extends TestCase
{
    public function testStoreSchoolValidationFailsOnEmptyRequest()
    {
        $admin = new User([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'phone' => '1234567',
            'role' => 'Administrator',
            'is_enable' => 1,
        ]);

        $response = $this->actingAs($admin)->post('/schools/store', []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'address', 'city', 'country', 'icon_url']);
    }

    public function testStoreSchoolWithMockedUseCase()
    {
        Storage::fake('public');

        $mockUseCase = $this->createMock(StoreSchoolsUseCaseInterface::class);
        $mockUseCase->expects($this->once())
            ->method('handle')
            ->willReturn(true);

        $this->app->instance(StoreSchoolsUseCaseInterface::class, $mockUseCase);

        $admin = new User([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'phone' => '1234567',
            'role' => 'Administrator',
            'is_enable' => 1,
        ]);

        $file = UploadedFile::fake()->image('school.png');

        $response = $this->actingAs($admin)->post('/schools/store', [
            'name' => 'Gimnasio Moderno Robot',
            'address' => 'Calle 100 # 15-20',
            'city' => 'Bogota',
            'country' => 'Colombia',
            'icon_url' => $file,
        ]);

        $response->assertRedirect('/schools');
        $response->assertSessionHas('createschoolsuccess');
    }
}

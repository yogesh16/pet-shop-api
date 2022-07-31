<?php


namespace Tests\Unit;


use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_file()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->image('pet.png');

        $this->json('POST', '/api/v1/file/upload', ['file' => $file], $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                                      "success",
                                      "data" => [
                                          "uuid",
                                          "name",
                                          "path",
                                          "size",
                                          "type",
                                          "updated_at",
                                          "created_at"
                                      ],
                                      "error",
                                      "errors",
                                      "extra"
                                  ]);

        $this->assertDatabaseCount('files', 1);
    }

    public function test_user_can_not_upload_file_without_login()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->image('pet.png');

        $this->json('POST', '/api/v1/file/upload', ['file' => $file], ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJsonStructure([
                                      "success",
                                      "data",
                                      "error",
                                      "errors",
                                      "trace"
                                  ]);

        $this->assertDatabaseCount('files', 0);
    }

    public function test_user_can_download_file()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->image('pet.png');

        $content = $this->json('POST', '/api/v1/file/upload', ['file' => $file], $this->getHeaders())
            ->assertStatus(200)
            ->decodeResponseJson();

        $this->assertDatabaseCount('files', 1);

        $this->json('GET', '/api/v1/file/' . $content['data']['uuid'], [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertHeader('Content-Disposition', 'attachment; filename='.$file->name);

    }

    //get headers array
    private function getHeaders($user = null)
    {
        if(! isset($user))
        {
            $user = $this->getUser();
        }
        $token = $user->tokens()->first();

        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token->access_token
        ];
    }

    //return user
    private function getUser()
    {
        $user = User::factory()->create();

        $userData = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this->json('POST', '/api/v1/user/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200);

        return $user;
    }
}

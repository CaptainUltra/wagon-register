<?php

namespace Tests\Feature;

use App\Image;
use App\Permission;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    protected $data;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('images');

        $this->user = factory(User::class)->create();
        $image = factory(Image::class)->make();
        $file = UploadedFile::fake()->image('photo.jpg'); //TODO: Should this be included in the factory?
        $this->data = [
            'title' => $image->title,
            'description' => $image->description,
            'file' => $file,
            'api_token' => $this->user->api_token
        ];

        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'image-create']);
        $this->user->roles[0]->permissions()->sync([1]);
    }

    /**
     * Test that a user must be logged in in order to upload an image.
     *
     * @return void
     */
    public function testImageCannotBeUploadedWithoutLogin()
    {
        $response = $this->post('api/images', array_merge($this->data, ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Image::all());
        Storage::disk('images')->assertMissing('photo.jpg');
    }

    /**
     * Test user must have 'image-create' permission to upload images.
     *
     * @return void
     */
    public function testImageCannotBeUploadedWithoutTheRightPermission()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/images', $this->data);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertCount(0, Image::all());
        Storage::disk('images')->assertMissing('photo.jpg');
    }

    /**
     * Test image can be uploaded using the api.
     *
     * @return void
     */

    public function testImageCanBeUploaded()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/images', $this->data);
        $image = Image::first();

        $this->assertCount(1, Image::all());
        $response->assertStatus(Response::HTTP_CREATED);
        Storage::disk('local')->assertExists("images/" . $image->file_name);
        $response->assertJson([
            'data' => [
                'id' => $image->id,
                'file_name' => $image->filename,
                'title' => $image->title,
                'description' => $image->description
            ],
            'links' => [
                'self' => $image->path()
            ]
        ]);
    }

    /**
     * Test image title and the file itself are required when uploading.
     *
     * @return void
     */
    public function testImageTitleAndFileItselfAreRequiredValidationWhenCreating()
    {
        collect(['title', 'file'])
            ->each(function ($field) {
                $response = $this->post('api/images', array_merge($this->data, [$field => null]));
                $response->assertSessionHasErrors($field);
            });
    }

    /**
     * Test image title and description must be strings validation.
     *
     * @return void
     */
    public function testImageTitleAndDescriptionMustBeStringsValidationWhenCreating()
    {
        collect(['title', 'description'])
            ->each(function ($field) {
                $response = $this->post('api/images', array_merge($this->data, [$field => (object)null]));
                $response->assertSessionHasErrors($field);
            });
    }

    /**
     * Test image date must be valid date when uploading.
     *
     * @return void
     */
    public function testImageDateMustBeAValidDateWhenCreating()
    {
        $response = $this->post('api/images', array_merge($this->data, ['date' => "abcdef"]));
        $response->assertSessionHasErrors('date');

        $response = $this->post('api/images', array_merge($this->data, ['date' => "abcdef12"]));
        $response->assertSessionHasErrors('date');

        $response = $this->post('api/images', array_merge($this->data, ['date' => "21313"]));
        $response->assertSessionHasErrors('date');
    }

    /**
     * Test image date is stored properly when uploading. (Date is instance of Carbon)
     *
     * @return void
     */
    public function testImageDateIsStoredProperlyWhenCreating()
    {
        $this->post('api/images', array_merge($this->data, ['date' => "2020-11-21"]));

        $this->assertCount(1, Image::all());
        $this->assertInstanceOf(Carbon::class, Image::first()->date);
    }

    /**
     * Test image can be retrieved.
     *
     * @return void
     */
    public function testImageCanBeRetrieved()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test that a user must be logged in in order to update image details.
     *
     * @return void
     */
    public function testImageDetailsCannotBeUpdatedWithoutLogin()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test image title can be updated by the owner.
     *
     * @return void
     */
    public function testImageTitleCanBeUpdatedByOwner()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test image description can be updated by the owner.
     *
     * @return void
     */
    public function testImageDescriptionCanBeUpdatedByOwner()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test image details can't be updated by other user who is not owner.
     *
     * @return void
     */
    public function testImageDetailsCannotBeUpdatedByOtherUserWhoIsNotOwner()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test image details can be updated by other user with 'image-update' permission.
     *
     * @return void
     */
    public function testImageDetailsCanBeUpdatedByOtherUserWithTheRightPermission()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test that a user must be logged in in order to delete an image.
     *
     * @return void
     */
    public function testImageCannotBeDeletedWithoutLogin()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test image can be deleted by owner.
     *
     * @return void
     */
    public function testImageCanBeDeletedByOwner()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test image can't be deleted by other user who is not owner.
     *
     * @return void
     */
    public function testImageCannotBeDeletedByOtherUserWhoIsNotOwner()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test image can be deleted by other user with 'image-delete' permission.
     *
     * @return void
     */
    public function testImageCanBeDeletedByOtherUserWithTheRightPermission()
    {
        $this->Fail("Test not implemented.");
    }

}
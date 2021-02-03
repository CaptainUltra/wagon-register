<?php

namespace Tests\Feature\Image;

use App\Image;
use App\Permission;
use App\Role;
use App\User;
use App\Wagon;
use App\WagonType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ImageWagonTest extends TestCase
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
        $file = UploadedFile::fake()->image('photo.jpg');

        //Create wagons
        factory(WagonType::class)->create(['name' => '85-97']);
        factory(Wagon::class)->create();
        factory(Wagon::class)->create();
        factory(Wagon::class)->create();

        $this->data = [
            'title' => $image->title,
            'description' => $image->description,
            'date' => "2020-11-21",
            'file' => $file,
            'wagon_ids' => [1, 2, 3],
            'api_token' => $this->user->api_token
        ];

        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'image-create']);
        $this->user->roles[0]->permissions()->sync([1]);
    }

    /**
     * Test wagons can be added to the image.
     *
     * @return void
     */
    public function testWagonsCanBeAddedToImageByOwnerWhenCreating()
    {
        $response = $this->post('api/images', $this->data);
        $image = Image::first();

        $this->assertCount(1, Image::all());
        $this->assertCount(3, $image->wagons);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $image->id,
                'file_name' => $image->file_name,
                'title' => $image->title,
                'description' => $image->description
            ],
            'links' => [
                'self' => $image->path()
            ]
        ]);
        $this->assertCount(3, $response['data']['wagons']);
    }

    /**
     * Test wagons can be removed from the image.
     *
     * @return void
     */
    public function testWagonsCanBeRemovedByOwnerWhenUpdating()
    {
        $image = factory(Image::class)->create(['user_id' => 1]);
        $image->wagons()->sync([1, 2, 3]);

        $response = $this->patch('api/images/' . $image->id, array_merge($this->data, ['wagon_ids' => [1, 2]]));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertCount(2, $response['data']['wagons']);
    }

    /**
     * Test at least one wagon must be associated with the image when creating an image.
     *
     * @return void
     */
    public function testAtLeastOneWagonMustBePresentWhenCreatingAnImageWhenCreating()
    {
        $response = $this->post('api/images', array_merge($this->data, ['wagon_ids' => []]));
        $response->assertSessionHasErrors('wagon_ids');
    }

    /**
     * Test at least one wagon must be associated with the image when updating an image.
     *
     * @return void
     */
    public function testAtLeastOneWagonMustBePresentWhenCreatingAnImageWhenUpdating()
    {
        $image = factory(Image::class)->create(['user_id' => 1]);
        $response = $this->patch('api/images/' . $image->id, array_merge($this->data, ['wagon_ids' => []]));

        $response->assertSessionHasErrors('wagon_ids');
    }

    /**
     * Test 'wagon_ids' in the request must be an array.
     *
     * @return void
     */
    public function testWagonIdsMustBeAnArray()
    {
        $response = $this->post('api/images', array_merge($this->data, ['wagon_ids' => null]));
        $response->assertSessionHasErrors('wagon_ids');
    }

    /**
     * Test wagons can be edited by other user with 'image-update' permission.
     *
     * @return void
     */
    public function testImageWagonsCanBeEditedByOtherUserWithTheRightPermission()
    {
        $image = factory(Image::class)->create();
        $image->wagons()->sync([1, 2, 3]);

        factory(Permission::class)->create(['slug' => 'image-update']);
        $this->user->roles[0]->permissions()->sync([2]);

        $response = $this->patch('api/images/' . $image->id, array_merge($this->data, ['wagon_ids' => [1, 2]]));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertCount(2, $response['data']['wagons']);
    }
}

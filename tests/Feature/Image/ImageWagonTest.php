<?php

namespace Tests\Feature\Image;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImageWagonTest extends TestCase
{

    /**
     * Test wagons can be added to the image.
     *
     * @return void
     */
    public function testWagonsCanBeAddedToImageByOwner()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test wagons can be removed from the image.
     *
     * @return void
     */
    public function testWagonsCanBeRemovedByOwner()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test at least one wagon must be associated with the image when creating an image.
     *
     * @return void
     */
    public function testAtLeastOneWagonMustBePresentWhenCreatingAnImageWhenCreating()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test at least one wagon must be associated with the image when updating an image.
     *
     * @return void
     */
    public function testAtLeastOneWagonMustBePresentWhenCreatingAnImageWhenUpdating()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test wagons cannot be edited by other user.
     *
     * @return void
     */
    public function testImageWagonsCannotBeEditedByOtherUser()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test wagons can be edited by other user with 'image-edit' permission.
     *
     * @return void
     */
    public function testImageWagonsCanBeEditedByOtherUserWithTheRightPermission()
    {
        $this->Fail("Test not implemented.");
    }
}

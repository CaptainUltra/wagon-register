<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user must be logged in in order to upload an image.
     *
     * @return void
     */
    public function testImageCannotBeUploadedWithoutLogin()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test user must have 'image-create' permission to upload images.
     *
     * @return void
     */
    public function testImageCannotBeUploadedWithoutTheRightPermission()
    {
        $this->Fail("Test not implemented.");
    }

    /**
     * Test image can be uploaded using the api.
     *
     * @return void
     */

    public function testImageCanBeUploaded()
    {
        $this->Fail("Test not implemented.");
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

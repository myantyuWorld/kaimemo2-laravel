<?php

namespace Tests\Unit\Repositories\Master;

use App\Models\MCategory;
use App\Models\MHouse;
use App\Models\MUser;
use App\Repositories\Master\MCategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MCategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private MCategoryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new MCategoryRepository(new MCategory);
    }

    public function test_can_create_category(): void
    {
        $house = MHouse::factory()->create();
        $user = MUser::factory()->create();

        $data = [
            'house_id' => $house->id,
            'name' => 'Food Category',
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id,
            'program_code' => 'TEST001',
        ];

        $category = $this->repository->create($data);

        $this->assertInstanceOf(MCategory::class, $category);
        $this->assertEquals($data['name'], $category->name);
        $this->assertEquals($data['house_id'], $category->house_id);
        $this->assertEquals($data['created_user_id'], $category->created_user_id);
        $this->assertEquals($data['updated_user_id'], $category->updated_user_id);
        $this->assertEquals($data['program_code'], $category->program_code);
        $this->assertDatabaseHas('m_categories', $data);
    }

    public function test_can_find_category_by_id(): void
    {
        $house = MHouse::factory()->create();
        $user = MUser::factory()->create();

        $category = MCategory::factory()->create([
            'house_id' => $house->id,
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id,
        ]);

        $foundCategory = $this->repository->find($category->id);

        $this->assertInstanceOf(MCategory::class, $foundCategory);
        $this->assertEquals($category->id, $foundCategory->id);
        $this->assertEquals($category->name, $foundCategory->name);
        $this->assertEquals($category->house_id, $foundCategory->house_id);
    }

    public function test_returns_null_when_category_not_found(): void
    {
        $foundCategory = $this->repository->find(999);

        $this->assertNull($foundCategory);
    }

    public function test_can_get_all_categories(): void
    {
        $house = MHouse::factory()->create();
        $user = MUser::factory()->create();

        MCategory::factory()->count(3)->create([
            'house_id' => $house->id,
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id,
        ]);

        $categories = $this->repository->all();

        $this->assertInstanceOf(Collection::class, $categories);
        $this->assertCount(3, $categories);
    }

    public function test_can_update_category(): void
    {
        $house = MHouse::factory()->create();
        $user = MUser::factory()->create();

        $category = MCategory::factory()->create([
            'house_id' => $house->id,
            'name' => 'Original Name',
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id,
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'updated_user_id' => $user->id,
        ];

        $result = $this->repository->update($category->id, $updateData);

        $this->assertTrue($result);
        $this->assertDatabaseHas('m_categories', [
            'id' => $category->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_update_returns_false_when_category_not_found(): void
    {
        $result = $this->repository->update(999, ['name' => 'Updated Name']);

        $this->assertFalse($result);
    }

    public function test_can_delete_category(): void
    {
        $house = MHouse::factory()->create();
        $user = MUser::factory()->create();

        $category = MCategory::factory()->create([
            'house_id' => $house->id,
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id,
        ]);

        $result = $this->repository->delete($category->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('m_categories', [
            'id' => $category->id,
        ]);
    }

    public function test_delete_returns_false_when_category_not_found(): void
    {
        $result = $this->repository->delete(999);

        $this->assertFalse($result);
    }

    public function test_can_paginate_categories(): void
    {
        $house = MHouse::factory()->create();
        $user = MUser::factory()->create();

        MCategory::factory()->count(25)->create([
            'house_id' => $house->id,
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id,
        ]);

        $paginatedCategories = $this->repository->paginate(10);

        $this->assertEquals(10, $paginatedCategories->perPage());
        $this->assertEquals(25, $paginatedCategories->total());
        $this->assertEquals(3, $paginatedCategories->lastPage());
    }

    public function test_can_find_categories_by_house(): void
    {
        $house1 = MHouse::factory()->create();
        $house2 = MHouse::factory()->create();
        $user = MUser::factory()->create();

        MCategory::factory()->count(2)->create([
            'house_id' => $house1->id,
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id,
        ]);

        MCategory::factory()->count(3)->create([
            'house_id' => $house2->id,
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id,
        ]);

        $house1Categories = $this->repository->findByHouse($house1->id);
        $house2Categories = $this->repository->findByHouse($house2->id);

        $this->assertInstanceOf(Collection::class, $house1Categories);
        $this->assertInstanceOf(Collection::class, $house2Categories);
        $this->assertCount(2, $house1Categories);
        $this->assertCount(3, $house2Categories);

        foreach ($house1Categories as $category) {
            $this->assertEquals($house1->id, $category->house_id);
        }

        foreach ($house2Categories as $category) {
            $this->assertEquals($house2->id, $category->house_id);
        }
    }

    public function test_find_by_house_returns_empty_collection_when_no_categories(): void
    {
        $house = MHouse::factory()->create();

        $categories = $this->repository->findByHouse($house->id);

        $this->assertInstanceOf(Collection::class, $categories);
        $this->assertCount(0, $categories);
    }
}

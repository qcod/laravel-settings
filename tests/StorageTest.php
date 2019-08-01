<?php

namespace QCod\Settings\Tests\Feature;

use QCod\Settings\Tests\TestCase;
use QCod\Settings\Setting\Setting;
use QCod\Settings\Setting\SettingEloquentStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StorageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var SettingEloquentStorage
     */
    protected $settingStorage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->settingStorage = new SettingEloquentStorage();
    }

    /**
     * it sets a new key value in store
     *
     * @test
     */
    public function it_sets_a_new_key_value_in_store()
    {
        $this->assertDatabaseMissing('settings', ['app_name' => 'QCode']);

        $this->settingStorage->set('app_name', 'QCode');

        $this->assertDatabaseHas('settings', ['name' => 'app_name', 'val' => 'QCode']);
    }

    /**
     * it dont set if same key value pair exists in store
     *
     * @test
     */
    public function it_dont_set_if_same_key_value_pair_exists_in_store()
    {
        $this->assertDatabaseMissing('settings', ['app_name' => 'QCode']);

        $this->settingStorage->set('app_name', 'QCode');
        $this->settingStorage->set('app_name', 'QCode');

        $this->assertDatabaseHas('settings', ['name' => 'app_name', 'val' => 'QCode']);
        $this->assertCount(1, $this->settingStorage->all(true));

        $this->settingStorage->set('email_name', 'QCode');
        $this->assertCount(2, $this->settingStorage->all(true));
    }

    /**
     * it updates exisiting setting if already exists
     *
     * @test
     */
    public function it_updates_exisiting_setting_if_already_exists()
    {
        $this->settingStorage->set('app_name', 'QCode');
        $this->assertDatabaseHas('settings', ['name' => 'app_name', 'val' => 'QCode']);

        $this->settingStorage->set('app_name', 'Updated QCode');

        $this->assertDatabaseHas('settings', ['name' => 'app_name', 'val' => 'Updated QCode']);
        $this->assertEquals('Updated QCode', $this->settingStorage->get('app_name'));
    }

    /**
     * it removes a setting from storage
     *
     * @test
     */
    public function it_removes_a_setting_from_storage()
    {
        $this->settingStorage->set('app_name', 'QCode');
        $this->assertDatabaseHas('settings', ['name' => 'app_name', 'val' => 'QCode']);
        $this->assertEquals('QCode', $this->settingStorage->get('app_name'));

        $this->settingStorage->remove('app_name');

        $this->assertDatabaseMissing('settings', ['name' => 'app_name', 'val' => 'QCode']);
        $this->assertNull($this->settingStorage->get('app_name'));
    }

    /**
     * it gives default value if nothing setting not found
     *
     * @test
     */
    public function it_gives_default_value_if_nothing_setting_not_found()
    {
        $this->assertDatabaseMissing('settings', ['app_name' => 'QCode']);

        $this->assertEquals(
            'Default App Name',
            $this->settingStorage->get('app_name', 'Default App Name')
        );
    }

    /**
     * it gives you saved setting value
     *
     * @test
     */
    public function it_gives_you_saved_setting_value()
    {
        $this->settingStorage->set('app_name', 'QCode');

        $this->assertEquals(
            'QCode',
            $this->settingStorage->get('app_name', 'Default App Name')
        );

        // change the setting
        $this->settingStorage->set('app_name', 'Changed QCode');

        $this->assertEquals(
            'Changed QCode',
            $this->settingStorage->get('app_name', 'Default App Name')
        );
    }

    /**
     * it can add multiple settings in if multi array is passed
     *
     * @test
     */
    public function it_can_add_multiple_settings_in_if_multi_array_is_passed()
    {
        $this->settingStorage->set([
            'app_name' => 'QCode',
            'app_email' => 'info@email.com',
            'app_type' => 'SaaS'
        ]);

        $this->assertCount(3, $this->settingStorage->all());
        $this->assertEquals('QCode', $this->settingStorage->get('app_name'));
        $this->assertEquals('info@email.com', $this->settingStorage->get('app_email'));
        $this->assertEquals('SaaS', $this->settingStorage->get('app_type'));
    }

    /**
     * it can use helper function to set and get settings
     *
     * @test
     */
    public function it_can_use_helper_function_to_set_and_get_settings()
    {
        settings()->set('app_name', 'Cool App');

        $this->assertEquals('Cool App', settings()->get('app_name'));

        $this->assertDatabaseHas('settings', ['name' => 'app_name']);
    }

    /**
     * it can access setting via facade
     *
     * @test
     */
    public function it_can_access_setting_via_facade()
    {
        \Settings::set('app_name', 'Cool App');

        $this->assertEquals('Cool App', \Settings::get('app_name'));

        $this->assertDatabaseHas('settings', ['name' => 'app_name']);
    }

    /**
     * it has a default group name for settings
     *
     * @test
     */
    public function it_has_a_default_group_name_for_settings()
    {
        settings()->set('app_name', 'Cool App');

        $this->assertDatabaseHas('settings', [
            'name' => 'app_name',
            'val' => 'Cool App',
            'group' => 'default'
        ]);
    }

    /**
     * it can store setting with a group name
     *
     * @test
     */
    public function it_can_store_setting_with_a_group_name()
    {
        settings()->group('set1')->set('app_name', 'Cool App');

        $this->assertDatabaseHas('settings', [
            'name' => 'app_name',
            'val' => 'Cool App',
            'group' => 'set1'
        ]);
    }

    /**
     * it can get setting from a group
     *
     * @test
     */
    public function it_can_get_setting_from_a_group()
    {
        settings()->group('set1')->set('app_name', 'Cool App');

        $this->assertTrue(settings()->group('set1')->has('app_name'));
        $this->assertEquals('Cool App', settings()->group('set1')->get('app_name'));
        $this->assertFalse(settings()->group('set2')->has('app_name'));
    }

    /**
     * it give you all settings from default group if you dont specify one
     *
     * @test
     */
    public function it_give_you_all_settings_from_default_group_if_you_dont_specify_one()
    {
        settings()->set('app_name', 'Cool App 1');
        settings()->set('app_name', 'Cool App 2');

        $this->assertCount(1, settings()->all(true));
        $this->assertCount(0, settings()->group('unknown')->all(true));
    }

    /**
     * it allows same key to be used in different groups
     *
     * @test
     */
    public function it_allows_same_key_to_be_used_in_different_groups()
    {
        settings()->group('team1')->set('app_name', 'Cool App 1');
        settings()->group('team2')->set('app_name', 'Cool App 2');

        $this->assertCount(2, Setting::all());
        $this->assertEquals('Cool App 1', settings()->group('team1')->get('app_name'));
        $this->assertEquals('Cool App 2', settings()->group('team2')->get('app_name'));
    }

    /**
     * it get group settings using facade
     *
     * @test
     */
    public function it_get_group_settings_using_facade()
    {
        \Settings::group('team1')->set('app_name', 'Cool App');

        $this->assertEquals('Cool App', \Settings::group('team1')->get('app_name'));

        $this->assertDatabaseHas('settings', ['name' => 'app_name', 'group' => 'team1']);
    }
}

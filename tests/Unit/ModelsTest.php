<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Company;
use App\Models\User;
use App\Models\Position;
use App\Models\TrainingModule;
use App\Models\Lesson;
use App\Models\QuizQuestion;
use App\Models\EmployeeTraining;
use App\Models\TrainingAttempt;

class ModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_has_many_users(): void
    {
        $company = Company::factory()->create();
        User::factory(3)->for($company)->employee()->create();

        $this->assertCount(3, $company->users);
    }

    public function test_company_has_many_positions(): void
    {
        $company = Company::factory()->create();
        Position::factory(2)->for($company)->create();

        $this->assertCount(2, $company->positions);
    }

    public function test_company_has_many_training_modules(): void
    {
        $company = Company::factory()->create();
        TrainingModule::factory(2)->for($company)->create();

        $this->assertCount(2, $company->trainingModules);
    }

    public function test_user_belongs_to_company(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->for($company)->employee()->create();

        $this->assertInstanceOf(Company::class, $user->company);
        $this->assertEquals($company->id, $user->company->id);
    }

    public function test_user_has_role_scopes(): void
    {
        $admin = User::factory()->admin()->create();
        $employee = User::factory()->employee()->create();
        $superAdmin = User::factory()->superAdmin()->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($employee->isEmployee());
        $this->assertTrue($superAdmin->isSuperAdmin());
    }

    public function test_position_has_many_employees(): void
    {
        $company = Company::factory()->create();
        $position = Position::factory()->for($company)->create();
        User::factory(3)->employee()->for($company)->create(['position_id' => $position->id]);

        $this->assertCount(3, $position->employees);
    }

    public function test_training_module_has_many_lessons(): void
    {
        $module = TrainingModule::factory()->create();
        Lesson::factory(3)->for($module, 'trainingModule')->create();

        $this->assertCount(3, $module->lessons);
    }

    public function test_lesson_has_many_quiz_questions(): void
    {
        $lesson = Lesson::factory()->create();
        QuizQuestion::factory(4)->for($lesson, 'lesson')->create();

        $this->assertCount(4, $lesson->quizQuestions);
    }

    public function test_employee_training_tracks_progress(): void
    {
        $company = Company::factory()->create();
        $employee = User::factory()->employee()->for($company)->create();
        $module = TrainingModule::factory()->for($company)->create();
        $lesson = Lesson::factory()->for($module, 'trainingModule')->create();

        $training = EmployeeTraining::factory()
            ->for($employee, 'employee')
            ->for($module, 'trainingModule')
            ->create([
                'current_lesson_id' => $lesson->id,
                'status' => 'in_progress',
            ]);

        $this->assertEquals($employee->id, $training->employee->id);
        $this->assertEquals('in_progress', $training->status);
    }

    public function test_training_attempts_track_attempts_per_lesson(): void
    {
        $company = Company::factory()->create();
        $module = TrainingModule::factory()->for($company)->create();
        $lesson = Lesson::factory()->for($module, 'trainingModule')->create();
        $employee = User::factory()->employee()->for($company)->create();
        
        $training = EmployeeTraining::factory()
            ->for($employee, 'employee')
            ->for($module, 'trainingModule')
            ->create(['current_lesson_id' => $lesson->id]);

        TrainingAttempt::factory(3)
            ->for($training, 'training')
            ->for($lesson, 'lesson')
            ->create();

        $this->assertCount(3, $training->attempts);
    }

    public function test_position_training_module_many_to_many(): void
    {
        $company = Company::factory()->create();
        $position = Position::factory()->for($company)->create();
        $module1 = TrainingModule::factory()->for($company)->create();
        $module2 = TrainingModule::factory()->for($company)->create();

        $position->trainingModules()->attach([$module1->id, $module2->id]);

        $this->assertCount(2, $position->trainingModules);
        $this->assertCount(1, $module1->positions);
    }

    public function test_company_settings_returns_config(): void
    {
        $company = Company::factory()->create();
        $this->assertIsArray($company->settings);
        $this->assertArrayHasKey('timezone', $company->settings);
    }

    public function test_soft_deletes_on_company(): void
    {
        $company = Company::factory()->create();
        $company->delete();

        $this->assertNull(Company::find($company->id));
        $this->assertNotNull(Company::withTrashed()->find($company->id));
    }
}

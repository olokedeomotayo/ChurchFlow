<?php

namespace App\Actions\Fortify;

use App\Models\Church;
use App\Models\Plan;
use App\Models\User;
use App\Services\ChurchCodeGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a new church owner.
     *
     * @param  array<string, mixed>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        $validated = Validator::make($input, [
            // Church information
            'church_name' => ['required', 'string', 'max:255'],
            'church_email' => ['nullable', 'email', 'max:255'],
            'church_phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],

            // Church owner information
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($validated): User {
            $church = $this->createChurch($validated);

            $user = $this->createOwner($validated, $church);

            $this->createTrialSubscription($church);

            return $user;
        });
    }

    /**
     * Create the church.
     */
    private function createChurch(array $input): Church
    {
        $codeGenerator = app(ChurchCodeGenerator::class);

        return Church::create([
            'code' => $codeGenerator->generate(),
            'name' => $input['church_name'],
            'slug' => $this->generateUniqueChurchSlug($input['church_name']),
            'email' => $input['church_email'] ?? null,
            'phone' => $input['church_phone'] ?? null,
            'address' => $input['address'] ?? null,
            'city' => $input['city'] ?? null,
            'state' => $input['state'] ?? null,
            'country' => 'Nigeria',
            'timezone' => 'Africa/Lagos',
            'status' => 'active',
        ]);
    }

    /**
     * Create the church owner.
     */
    private function createOwner(array $input, Church $church): User
    {
        $user = User::create([
            'church_id' => $church->id,
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);

        $user->assignRole('church_owner');

        return $user;
    }
    /**
     * Create the church's 30-day trial subscription.
     */
    private function createTrialSubscription(Church $church): void
    {
        $plan = Plan::where('slug', 'free-trial')
            ->where('is_active', true)
            ->firstOrFail();

        $trialStartedAt = now();
        $trialEndsAt = $trialStartedAt->copy()->addDays(30);

        $church->update([
            'trial_started_at' => $trialStartedAt,
            'trial_ends_at' => $trialEndsAt,
        ]);

        $church->subscriptions()->create([
            'plan_id' => $plan->id,
            'status' => 'trial',
            'starts_at' => $trialStartedAt,
            'ends_at' => $trialEndsAt,
            'trial_ends_at' => $trialEndsAt,
        ]);
    }

    /**
     * Generate a unique church slug.
     */
    private function generateUniqueChurchSlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (Church::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update(User $user, array $input): void
    {
        if (request()->hasFile('photo') && request()->file('photo')->isValid()) {
            $input['photo'] = request()->file('photo');
        } else {
            unset($input['photo']);
        }

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nif' => ['nullable', 'digits:9'],
            'morada' => ['nullable', 'string', 'max:255'],

            'paymentMethod' => ['nullable', Rule::in(['MB WAY', 'PayPal', 'Visa'])],

            'paymentRef' => [
                'nullable',
                Rule::requiredIf(isset($input['paymentMethod']) && $input['paymentMethod'] === 'MB WAY'),
                isset($input['paymentMethod']) && $input['paymentMethod'] === 'MB WAY' ? 'regex:/^9[1236][0-9]{7}$/' : '',

                Rule::requiredIf(isset($input['paymentMethod']) && $input['paymentMethod'] === 'PayPal'),
                isset($input['paymentMethod']) && $input['paymentMethod'] === 'PayPal' ? 'email' : '',

                Rule::requiredIf(isset($input['paymentMethod']) && $input['paymentMethod'] === 'Visa'),
                isset($input['paymentMethod']) && $input['paymentMethod'] === 'Visa' ? 'digits:16' : '',
            ],

            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'paymentRef.regex' => 'Para MB WAY, introduza um número de telemóvel português válido.',
            'paymentRef.email' => 'Para PayPal, introduza um endereço de e-mail válido.',
            'paymentRef.digits' => 'Para VISA, introduza o número do cartão com exatamente 16 dígitos.',
            'photo.image' => 'O ficheiro selecionado tem de ser uma imagem.',
            'photo.max' => 'A foto de perfil não pode ter mais do que 2MB.',
        ])->validateWithBag('updateProfileInformation');

        if (request()->hasFile('photo')) {
            if ($user->photo_url && $user->photo_url !== 'anonymous.png') {
                if (Storage::disk('public')->exists('photos/' . $user->photo_url)) {
                    Storage::disk('public')->delete('photos/' . $user->photo_url);
                }
            }
            $extension = request()->file('photo')->getClientOriginalExtension();

            $newFileName = 'profilePicUser' . $user->id . '.' . $extension;

            request()->file('photo')->storeAs('photos', $newFileName, 'public');

            $input['photo_url'] = $newFileName;
        }

        $this->saveCustomerData($user, $input);
    }

    protected function saveCustomerData(User $user, array $input): void
    {
        if (!$user->customer) {
            $user->customer()->create([
                'id' => $user->id
            ]);
            $user->load('customer');
        }

        $paymentType = null;
        if (!empty($input['paymentMethod'])) {
            $methodLower = strtolower(trim($input['paymentMethod']));
            if ($methodLower === 'mbway' || $methodLower === 'mb way') {
                $paymentType = 'MB WAY';
            } elseif ($methodLower === 'paypal') {
                $paymentType = 'PayPal';
            } elseif ($methodLower === 'visa') {
                $paymentType = 'Visa';
            }
        }


        $user->customer->forceFill([
            'nif' => $input['nif'] ?? null,
            'address' => $input['morada'] ?? null,
            'default_payment_type' => $paymentType,
            'default_payment_ref' => $input['paymentRef'] ?? null,
        ])->save();

        $userData = [
            'name' => $input['name'],
        ];

        if (isset($input['photo_url'])) {
            $userData['photo_url'] = $input['photo_url'];
        }

        $user->forceFill($userData)->save();
    }
}
